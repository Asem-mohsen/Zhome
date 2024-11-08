@extends('Admin.Layout.Master')
@section('Title' , 'Add New Sale')

@section('Content')
    <div class="container-fluid py-4">
        <form action="{{ route('Sales.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header pb-2">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Add Discount</p>
                                <a class="btn btn-success btn-sm ml-2">Add</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="product-select" class="form-control-label">Product</label>
                                    <select class="form-control" id="product-select" name="product_id">
                                        @foreach ( $products as $product )
                                            <option value='{{$product->id}}'>{{$product->translations->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label text-center w-100">New Price</label>
                                        <input class="form-control" type="number" name="sale_price" id="percentage-input" min="0" step="any" required>
                                    </div>
                                    @error('sale_price')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label w-100 text-center">Start date</label>
                                        <input class="form-control" type="date" name="start_date" required>
                                    </div>
                                    @error('start_date')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label w-100 text-center">End date</label>
                                        <input class="form-control" type="date" name="end_date" required>
                                    </div>
                                    @error('end_date')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <hr class="horizontal dark">

                            <p class="text-uppercase text-sm">Control</p>
                            <div class="justify-content-center row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-md bg-success w-100 mt-4 mb-0">Add</button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <a href="{{ route('Sales.index') }}" class="btn btn-md bg-primary w-100 mt-4 mb-0">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
        </form>
    </div>
@endsection


@section('Js')

@stop