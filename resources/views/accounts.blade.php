<div>
    系统总余额:
    {{\App\Models\Account::where('owner_type','system')->first()->balance}}
</div>
<hr>
<div>
    <h2>SAVO 账户余额</h2>
    <ul>
        @foreach(['USD', 'USDT'] as $currency)
            <li>{{$currency}}
            : {{\App\Models\Account::where('owner_type','system')->where('currency', $currency)->where('owner_id','savo')->first()->balance}}
            </li>
        @endforeach
    </ul>
</div>

