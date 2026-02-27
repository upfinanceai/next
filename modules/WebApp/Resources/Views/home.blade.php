@extends('webapp::layouts.app')

@section('content')
    <h1>Hi {{auth()->user()->name}}</h1>

    <h2>我的资产账户</h2>
    <div>
        @php
        $cash_accounts =
        @endphp
    </div>

    <h2>我的卡片账户</h2>
    <div>
    </div>
@endsection
