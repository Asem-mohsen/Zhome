@extends('Admin.Layout.Master')

@section('Title', 'Product delivery estimation')

@section('Content')

    @section('Css')
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('Admin/plugins/select2/css/select2.min.css')}}">
        <link rel="stylesheet" href="{{ asset('Admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    @endsection

    <form action="{{ route('Shipping.estimations.store') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Add delivery estimation date</p>
                            <button class="btn btn-primary btn-sm ms-auto m-2">Add</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-uppercase text-sm">Estimation details</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Products to be added to the estimation</label>
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
                                    <label for="estimated_delivery_date" class="form-control-label">Date</label>
                                    <input class="form-control" type="date" id="estimated_delivery_date" name="estimated_delivery_date">
                                </div>
                                @error('estimated_delivery_date')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="estimated_delivery_date" class="form-control-label">Estimation Details</label>
                                    <textarea class="form-control" id="estimation_details" name="estimation_details"></textarea>
                                </div>
                                @error('estimation_details')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <p class="text-uppercase text-sm">Control</p>
                        <div class="justify-content-center row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-md btn-success w-100 mt-4 mb-0">Add</button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <a href="{{ route('Shipping.estimations.index') }}" class="btn btn-md btn-danger w-100 mt-4 mb-0">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

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
