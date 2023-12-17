@extends('layout.app')
@section('content')
<div class="container px-4">
    <div class="card rounded-lg mt-5">
        <div class="card-header"><h3 class="font-weight-light my-4">Add Product</h3></div>
        <div class="card-body">
            <!-- ERROR/SUCCESS MESSAGE START -->
            @if(Session::has('errormsg'))
                <div class="alert alert-danger text-center">
                    <p><i class="fa-solid fa-circle-exclamation"></i> {{ Session::get('errormsg') }}</p>
                </div>
            @endif
            
            @if(Session::has('successmsg'))
                <div class="alert alert-success text-center">
                    <p><i class="fa-solid fa-circle-check"></i> {{ Session::get('successmsg') }}</p>
                </div>
            @endif
            <!-- ERROR/SUCCESS MESSAGE END -->

            <form method="POST" action="{{ url('/productAdd') }}">
                @csrf
                <div class="form-floating mb-3">
                    <input class="form-control" id="productName" name="name" type="text" placeholder="Product Name" />
                    <label for="productName">Product Name</label>
    
                    @error('name')
                        <div class="alert alert-danger">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" id="Price" name="price" type="text" placeholder="Unit Price" />
                    <label for="Price">Price</label>
    
                    @error('price')
                        <div class="alert alert-danger">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" id="Quantity" name="quantity" type="number" placeholder="Quantity" />
                    <label for="Quantity">Quantity</label>
    
                    @error('quantity')
                        <div class="alert alert-danger">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <button class="btn btn-primary float-end" type="submit">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection