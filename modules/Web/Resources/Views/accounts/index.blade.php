@extends('web::layouts.app')

@section('content')
    <div class="container">
        <h3>资产账户</h3>
        <a href="{{route('web.exchange')}}">货币兑换</a>
        <div>
            <table class="table">
                <thead>
                <th>Number</th>
                <th>Currency</th>
                <th>Balance</th>
                <th>Frozen Balance</th>
                </thead>
                <tbody>
                @foreach($cash_accounts as $cash_account)
                    <tr>
                        <td>
                            <a href="{{route('web.accounts.cash.show', $cash_account->currency)}}">{{$cash_account->number}}</a>
                        </td>
                        <td>{{$cash_account->currency}}</td>
                        <td>{{$cash_account->balance}}</td>
                        <td>{{$cash_account->frozen_balance}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <h3>卡片账户</h3>
        <div>
        </div>
    </div>
@endsection
