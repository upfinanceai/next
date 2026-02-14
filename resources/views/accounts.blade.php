<div>
    系统总余额:
    {{\App\Models\Account::where('owner_type','system')->first()->balance}}
</div>
<hr>
<div>
    <h2>SAVO
        账户余额 {{\App\Models\Account::where('owner_type','system')->where('owner_id','savo')->sum('balance')}}</h2>
    <ul>
        @foreach(['USD', 'USDT'] as $currency)
            <li>{{$currency}}
                : {{\App\Models\Account::where('owner_type','system')->where('currency', $currency)->where('owner_id','savo')->sum('balance')}}
            </li>
        @endforeach
    </ul>
</div>
<div>
    <h2>Cregis
        账户余额 {{\App\Models\Account::where('owner_type','system')->where('owner_id','cregis')->sum('balance')}}</h2>
    <ul>
        @foreach(['USD', 'USDT'] as $currency)
            <li>{{$currency}}
                : {{\App\Models\Account::where('owner_type','system')->where('currency', $currency)->where('owner_id','cregis')->sum('balance')}}
            </li>
        @endforeach
    </ul>
</div>
<hr>

<div>
    <h2>
        系统收入账户余额 {{\App\Models\Account::where('owner_type','system')->where('owner_id', 'income')->sum('balance')}} ( {{\App\Models\Account::where('owner_type','system')->where('owner_id', 'income')->sum('frozen_balance')}})</h2>
    <ul>
        @foreach(['USD', 'USDT'] as $currency)
            <li>{{$currency}}
                : {{\App\Models\Account::where('owner_type','system')->where('owner_id', 'income')->where('currency', $currency)->sum('balance')}}
            </li>
        @endforeach
    </ul>
</div>

<div>
    <h2>用户现金账户余额 {{\App\Models\Account::where('owner_type','user')->sum('balance')}}({{\App\Models\Account::where('owner_type','user')->sum('frozen_balance')}})</h2>
    <ul>
        @foreach(['USD', 'USDT'] as $currency)
            <li>{{$currency}}
                : {{\App\Models\Account::where('owner_type','user')->where('currency', $currency)->sum('balance')}}
            </li>
        @endforeach
    </ul>
</div>

<div>
    <h2>用户卡账户余额 {{\App\Models\Account::where('owner_type','card')->sum('balance')}} ({{\App\Models\Account::where('owner_type','card')->sum('frozen_balance')}})</h2>
    <ul>
        @foreach(['USD', 'USDT'] as $currency)
            <li>{{$currency}}
                : {{\App\Models\Account::where('owner_type','card')->where('currency', $currency)->sum('balance')}}
            </li>
        @endforeach
    </ul>
</div>
