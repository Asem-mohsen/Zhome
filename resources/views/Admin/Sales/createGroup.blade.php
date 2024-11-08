@extends('Admin.Layout.Master')
@section('Title' , 'Add New Group Sale')


@section('Content')

    @section('Css')
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('Admin/plugins/select2/css/select2.min.css')}}">
        <link rel="stylesheet" href="{{ asset('Admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    @endsection


    <div class="container-fluid py-4">
        <form action="{{ route('Sales.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header pb-2">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Add Discount for group of products</p>
                                <a class="btn btn-success btn-sm ml-2">Add</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Products</label>
                                        <select class="select2bs4 w-100" name="product_id[]" multiple="multiple" id="product-select" data-placeholder="Select Products">
                                            @foreach ( $products as $product )
                                                <option value='{{$product->id}}'>{{$product->translations->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
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
                                        <button type="submit" class="btn btn-md btn-success w-100 mt-4 mb-0">Add</button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <a href="{{ route('Sales.index') }}" class="btn btn-md btn-primary w-100 mt-4 mb-0">Cancel</a>
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
    <!-- Select2 -->
    <script src="{{asset('Admin/plugins/select2/js/select2.full.min.js')}}"></script>
    <script>
        $(function () {

            //Initialize Multible Select Elements
            $('.select2bs4').select2({
            theme: 'bootstrap4'
            })
        });
    </script>


@stop
