@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Deposit List</h4>
                        <a href="{{ route('deposit.create')}}" class="btn btn-info"> Make Deposit</a>
                    </div>

                    <div class="card-body">
                        @if (count($deposits) > 0)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Serial No.</th>
                                        <th>Date</th>
                                        <th>User ID</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($deposits as $deposit)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $deposit->date }}</td>
                                            <td>{{ $deposit->user->name }}</td>
                                            <td>{{ $deposit->amount }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No deposits found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
