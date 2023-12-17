@extends('layout.app')
@section('content')
<div class="container px-4">
    <div class="card rounded-lg mt-5">
        <div class="card-header"><h3 class="font-weight-light my-4">All Transaction</h3></div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Date</th>
                    </tr>
                </tfoot>
                <tbody>
                @foreach ($getTransaction as $transaction)
                    <tr>
                        <td>{{ $transaction->name }}</td>
                        <td>{{ $transaction->price }}</td>
                        <td>{{ $transaction->quantity }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('F j, Y, H:i A') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection