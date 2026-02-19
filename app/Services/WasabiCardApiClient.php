<?php

namespace App\Services;

use App\Modules\Card\Data\WasabiB2BCardHolderData;
use App\Modules\Card\Data\WasabiB2CCardHolderData;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class WasabiCardApiClient
{
    const RESPONSE_CODE_SUCCESS = 200;

    const KEY_ALGORITHM       = 'RSA';
    const SIGNATURE_ALGORITHM = 'SHA256';
    const MAX_DECRYPT_BLOCK   = 128;

    public static function make(): static
    {
        return new static();
    }

    public function getCountryList()
    {
        return $this->post('/merchant/core/mcb/common/region');
    }

    public function getCityList($regionCode = null)
    {
        return $this->post('/merchant/core/mcb/common/city', [
            'regionCode' => $regionCode,
        ]);
    }

    public function getCityListV2($regionCode = null)
    {
        return $this->post('/merchant/core/mcb/common/v2/city', [
            'regionCode' => $regionCode,
        ]);
    }

    public function getMobileCodeList()
    {
        return $this->post('/merchant/core/mcb/common/mobileAreaCode');
    }

    public function getAccountInfo()
    {
        return $this->post('/merchant/core/mcb/account/info');
    }

    public function getAccountList()
    {
        return $this->post('/merchant/core/mcb/account/list');
    }

    public function getTransactions($params = [])
    {
        return $this->post('/merchant/core/mcb/account/transaction', $params);
    }

    public function getCardTypes()
    {
        return $this->post('/merchant/core/mcb/card/v2/cardTypes');
    }

    /**
     * @see https://wsb.gitbook.io/wasabicard-doc/api/card/card-holder#cardholder-create-v2
     */
    public function createCardHolder(WasabiB2BCardHolderData|WasabiB2CCardHolderData $data)
    {
        return $this->post('/merchant/core/mcb/card/holder/v2/create', $data->toArray());
    }

    public function getCardHolderList($params = [])
    {
        return $this->post('/merchant/core/mcb/card/holder/query', $params);
    }

    public function createCard($param)
    {
        return $this->post('/merchant/core/mcb/card/v2/createCard', $param);
    }

    public function getCardInfo($params = [])
    {
        return $this->post('/merchant/core/mcb/card/info', $params);
    }

    public function getCardInfoSensitive($cardNo)
    {
        return $this->post('/merchant/core/mcb/card/sensitive', [
            'cardNo' => $cardNo,
        ]);
    }

    public function uploadFile(string $filePath, string $category = 'globalTransfer'): array
    {
        $signature = $this->generateSignature();
        $headers   = [
            'X-WSB-API-KEY'   => config('services.wasabi.api_key'),
            'X-WSB-SIGNATURE' => $signature,
        ];

        $response = Http::withHeaders($headers)
            ->attach('file', Storage::disk('r2')->get($filePath), basename($filePath))
            ->baseUrl(config('wasabi.base_url'))
            ->post('/merchant/core/mcb/common/file/upload', [
                'category' => $category,
            ]);

        $responseBody      = $response->body();
        $responseSignature = $response->header('X-WSB-SIGNATURE', '');
        if (!$this->verifySignature($responseBody, $responseSignature)) {
            throw new Exception('Signature verification failed');
        }

        return $this->parseResponse($response->json());
    }

    protected function generateSignature(array $body = []): string
    {
        $privateKey = config('services.wasabi.merchant_private_key');
        if (!$privateKey) {
            throw new Exception('Merchant private key not configured');
        }
        $json          = empty($body) ? '{}' : json_encode($body, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $privateKeyPem = "-----BEGIN PRIVATE KEY-----\n"
            . wordwrap($privateKey, 64, "\n", true)
            . "\n-----END PRIVATE KEY-----\n";

        openssl_sign($json, $rawSignature, $privateKeyPem, OPENSSL_ALGO_SHA256);

        return base64_encode($rawSignature);
    }

    protected function post(string $uri, array $body = []): array
    {
        // 生成签名
        $signature = $this->generateSignature($body);

        // 准备请求头
        $headers = [
            'Content-Type'    => 'application/json',
            'X-WSB-API-KEY'   => config('services.wasabi.api_key'),
            'X-WSB-SIGNATURE' => $signature,
        ];

        // 准备请求体
        $jsonBody = empty($body) ? '{}' : json_encode($body, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // 发送请求
        $response = Http::withHeaders($headers)
            ->withBody($jsonBody)
            ->baseUrl(config('services.wasabi.base_url'))
            ->post($uri);

        // 获取响应体
        $responseBody = $response->body();

        // 获取响应签名
        $responseSignature = $response->header('X-WSB-SIGNATURE', '');

        if (!$responseSignature) {
            throw new Exception('Response missing signature, response:' . $responseBody);
        }
        // 验签
        if (!$this->verifySignature($responseBody, $responseSignature)) {
            throw new Exception('Signature verification failed');
        }

        // 解析响应
        return $this->parseResponse($response->json());
    }

    protected function verifySignature(string $responseBody, string $signature): bool
    {
        if (empty($signature)) {
            return false;
        }

        $publicKeyPem = "-----BEGIN PUBLIC KEY-----\n"
            . wordwrap(config('services.wasabi.wsb_public_key'), 64, "\n", true)
            . "\n-----END PUBLIC KEY-----\n";

        return openssl_verify($responseBody, base64_decode($signature), $publicKeyPem, OPENSSL_ALGO_SHA256) === 1;
    }

    protected function parseResponse(array $response): array
    {
        if (!isset($response['code'])) {
            throw new Exception('Invalid response format');
        }

        $code = $response['code'];

        if ($code != static::RESPONSE_CODE_SUCCESS) {
            // TODO 暂时先原样返回, 后续优化.
            throw new Exception($response['msg'], $code);
        }

        return $response['data'];
    }

    /**
     * 使用私钥解密数据（RSA 分段解密）
     *
     * @param  string  $encryptedData  Base64 或 URL 编码的密文
     * @return string 解密后的明文
     * @throws Exception
     */
    public function decryptPrivateKey(string $encryptedData): string
    {
        $privateKey = config('services.wasabi.merchant_private_key');
        // 如果是 URL 编码，先解码
        if (str_contains($encryptedData, '%')) {
            $encryptedData = urldecode($encryptedData);
        }

        $encryptedBytes = base64_decode($encryptedData);
        $pem            = $this->formatPem($privateKey);
        $key            = openssl_pkey_get_private($pem);

        if (!$key) {
            throw new Exception('Invalid private key: ' . openssl_error_string());
        }

        $decrypted = '';
        $offset    = 0;
        $inputLen  = strlen($encryptedBytes);

        // 分段解密（每段 128 字节）
        while ($offset < $inputLen) {
            $chunkSize = min(self::MAX_DECRYPT_BLOCK, $inputLen - $offset);
            $chunk     = substr($encryptedBytes, $offset, $chunkSize);
            $decChunk  = '';

            if (!openssl_private_decrypt($chunk, $decChunk, $key, OPENSSL_PKCS1_PADDING)) {
                throw new Exception('Decryption failed: ' . openssl_error_string());
            }

            $decrypted .= $decChunk;
            $offset    += $chunkSize;
        }

        return $decrypted;
    }

    /**
     * 将 Base64 裸密钥格式化为 PEM 格式
     *
     * @param  string  $base64Key  不含 PEM 头尾的 Base64 密钥
     * @return string PEM 格式字符串
     */
    private function formatPem(string $base64Key): string
    {
        $key = chunk_split($base64Key, 64);
        return "-----BEGIN PRIVATE KEY-----\n{$key}-----END PRIVATE KEY-----\n";
    }
}
