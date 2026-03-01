<?php

namespace Modules\Core\Exceptions;

use Exception;
use Throwable;

class LogicException extends Exception
{
    protected array $payload = [];

    public function __construct(string $message = "", int $code = 400, ?Throwable $previous = null, array $payload = [])
    {

        parent::__construct($message, $code, $previous);
        $this->payload($payload);
    }

    public function payload($data)
    {
        $this->payload = array_merge($this->payload, $data);
    }

    public function render($request)
    {
        if ($request->ajax()) {
            return response()->json([
                'message' => $this->getMessage(),
                'payload' => $this->payload,
            ], $this->getCode());
        }
        if (!app()->hasDebugModeEnabled()) {
            return $this->getMessage();
        }
    }
}
