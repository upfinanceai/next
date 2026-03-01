@extends('web::layouts.app')

@section('content')
    <div class="container">
        <h3>资产账户 {{$account->number}}</h3>
        <p>币种: {{$account->currency}}</p>
        <p>可用余额: {{$account->balance}}</p>
        <p>冻结余额: {{$account->frozen_balance}}</p>
        <div>
            <table class="table">
                <thead>
                <th>Number</th>
                <th>Direction</th>
                <th>Amount</th>
                <th>Balance type</th>
                <th>Transaction</th>
                <th>Date</th>
                </thead>
                <tbody>
                @foreach($ledger_entries as $ledger_entry)
                    <tr>
                        <td>{{ $ledger_entry->number }}</td>
                        <td>{{ $ledger_entry->direction }}</td>
                        <td>{{ $ledger_entry->amount }}</td>
                        <td>{{ $ledger_entry->balance_type }}</td>
                        <td>{{ $ledger_entry->transaction->type }}</td>
                        <td>{{ $ledger_entry->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
