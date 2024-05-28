@extends('Admin.Layout.Master')
@section('Title' , 'Edit Sale')

@section('Content')

    <div class="container-fluid py-4">
        <form action="{{route('Sales.update' , $sale->ID)}}" method="post">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header pb-2">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Edit Discount</p>
                                <a class="btn btn-success btn-sm ml-2">Edit</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="example-text-input" class="form-control-label">Product</label>
                                    <select class="form-control" name="ProductID">
                                        <option value='{{$sale->products->ID}}'>{{$sale->products->Name}}</option>
                                    </select>
                                    @error('ProductID')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label w-100 text-center">End Date</label>
                                        <input class="form-control" type="date" name="EndDate" required value="{{$sale->EndDate}}">
                                    </div>
                                    @error('EndDate')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="percentage-input" class="form-control-label text-center w-100">Sale Amount (%)</label>
                                        <input class="form-control" oninput="calculatePrice()" id="percentage-input" type="text" name="Amount" value="{{$sale->Amount}}" required>
                                    </div>
                                    @error('Amount')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="price-before" class="form-control-label">Price Before</label>
                                        <input class="form-control" type="number" id="price-before"  value="{{$sale->products->Price}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="price-after" class="form-control-label w-100 text-center">Price After Sale</label>
                                        <input class="form-control" type="number" id="price-after" name="PriceAfter" disabled value="{{$sale->PriceAfter}}">
                                    </div>
                                    @error('PriceAfter')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <hr class="horizontal dark">

                            <p class="text-uppercase text-sm">Control</p>
                            <div class="justify-content-center row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-md btn-success w-100 mt-4 mb-0">Update</button>
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
                <!-- Side Card -->
                <div class="col-md-4">
                    <div class="card card-profile" style="height: 485px;">
                    <h5 class='text-center' style="padding-top: 20px;"> Sale on<br> {{$sale->products->Name}}</h5>
                        <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
                            <div class="d-flex justify-content-center">
                                @if( date("Y-m-d", strtotime($sale->EndDate)) > date("Y-m-d") )
                                    <a href="" class="btn btn-sm btn-success mb-0 d-none d-lg-block">On Sale</a>
                                    <a href="" class="btn btn-sm btn-success mb-0 d-block d-lg-none"><i class="ni ni-collection"></i></a>
                                @else
                                    <a href="" class="btn btn-sm btn-danger mb-0 d-none d-lg-block">Out of Sale</a>
                                    <a href="" class="btn btn-sm btn-danger mb-0 d-block d-lg-none"><i class="ni ni-collection"></i></a>
                                @endif
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table id="example2" class="table table-striped table-bordered">
                                    <thead>
                                        <th scope="col" width="10%">#</th>
                                        <th scope="col" width="20%"></th>
                                    </thead>
                                        <tr>
                                            <td>Amount</td>
                                            <td>{{$sale->Amount . "%"}}</td>
                                        </tr>
                                        <tr>
                                            <td>Price</td>
                                            <td style="text-decoration: line-through;">{{$sale->products->Price . " EGP"}}</td>
                                        </tr>
                                        <tr>
                                            <td>New Price</td>
                                            <td>{{$sale->PriceAfter . " EGP"}}</td>
                                        </tr>
                                        <tr>
                                            <td>Started at </td>
                                            <td>{{ date("d-M-Y", strtotime($sale->StartDate)) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Ends at</td>
                                            <td>{{ date("d-M-Y", strtotime($sale->EndDate)) }}</td>
                                        </tr>
                                </table>
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
            calculatePrice();
        });
        
        

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