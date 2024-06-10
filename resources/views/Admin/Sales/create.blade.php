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
                                    <select class="form-control" id="product-select" onchange="getProductPrice()" name="ProductID">
                                        @foreach ( $products as $product )
                                            <option value='{{$product->ID}}'>{{$product->Name}}</option>
                                        @endforeach
                                    </select>
                                    @error('ProductID')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label w-100 text-center">End Date</label>
                                        <input class="form-control" type="date" name="EndDate" required>
                                        @error('EndDate')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label text-center w-100">Sale Amount (%)</label>
                                        <input class="form-control" type="number" name="Amount" id="percentage-input" oninput="calculatePrice()" min="0" step="any" required>
                                        @error('Amount')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Price Before</label>
                                        <input class="form-control" type="number" disabled id="price-before" name="PriceBefore">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label w-100 text-center">Price After Sale</label>
                                        <input class="form-control" type="number" disabled id="price-after" >
                                        <input class="form-control" type="hidden" name="PriceAfter" id="price-after-Database" >
                                        @error('PriceAfter')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
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

    <script>
        $(document).ready(function() {
            getProductPrice();
            calculatePrice();
        });
        
        
        function getProductPrice() {
            var productId = $('#product-select').val();
            if (productId !== '') {
            $.ajax({
                url: '/Sales/getProductPrice/' + productId,
                method: 'GET',
                success: function(response) {
                    var priceBefore = parseFloat(response.Price);
                    $('#price-before').val(priceBefore.toFixed(2));
                }
            });
            } else {
                $('#price-before').val('');
            }
        }
        function calculatePrice() {
            var priceBefore = parseFloat($('#price-before').val());
            var percentage = parseFloat($('#percentage-input').val());
            if (!isNaN(priceBefore) && !isNaN(percentage)) {
                var priceAfter = priceBefore - (priceBefore * percentage / 100);
                $('#price-after').val(priceAfter.toFixed(2)); // Display the calculated price with 2 decimal places
                $('#price-after-Database').val(priceAfter); // Display the calculated price with 2 decimal places
            } else {
                $('#price-after').val('');
            }
        }
    </script>

@stop