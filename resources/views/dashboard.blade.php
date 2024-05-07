@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <h2>Welcome {{ auth()->user()->name }}, to dashboard!</h2>
    </div>
    <div class="row d-flex align-items-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Current Balance</div>
                <div class="card-body">
                    <p>Your current balance is: {{ auth()->user()->balance }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Transactions</div>
                <div class="card-body">
                    @if(count($transactions) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Serial No.</th>
                                <th>Date</th>
                                <th>User</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Fee</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transaction->date }}</td>
                                <td>{{ $transaction->user->name }}</td>
                                <td>{{ $transaction->transaction_type }}</td>
                                <td>{{ $transaction->amount }}</td>
                                <td>{{ $transaction->fee }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>No transactions found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
