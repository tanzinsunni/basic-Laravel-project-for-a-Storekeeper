@extends('layout.app')
@section('content')
<div class="container px-4">
    <div class="card rounded-lg mt-5">
        <div class="card-header"><h3 class="font-weight-light my-4">All Products</h3></div>
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
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                @foreach($getProducts as $products)
                    <tr>
                        <td>{{ $products->name }}</td>
                        <td>{{ $products->unit_price." Tk" }}</td>
                        <td>{{ $products->quantity." Pices" }}</td>
                        <td>
                            <a href="{{ url('sell-product/'.$products->id) }}" class="btn btn-success">Sale</a>
                            <a href="{{ url('edit-product/'.$products->id) }}" class="btn btn-primary">Update</a>
                            <a onclick="return confirm('Are you sure to delete?')" href="{{ url('remove-product/'.$products->id) }}" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection