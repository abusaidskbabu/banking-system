@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Withdrawal List</h4>
                        <a href="{{ route('withdrawal.create')}}" class="btn btn-info"> Make Withdrawal</a>
                    </div>

                    <div class="card-body">
                        @if (count($withdrawals) > 0)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Serial No.</th>
                                        <th>Date</th>
                                        <th>User ID</th>
                                        <th>Amount</th>
                                        <th>Fee</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($withdrawals as $withdrawal)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $withdrawal->date }}</td>
                                            <td>{{ $withdrawal->user->name }}</td>
                                            <td>{{ $withdrawal->amount }}</td>
                                            <td>{{ $withdrawal->fee }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No withdrawal found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
