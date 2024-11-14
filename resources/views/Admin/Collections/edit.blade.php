@extends('Admin.Layout.Master')
@section('Title' , 'Edit ' . $collection->name)

@section('Content')

    @section('Css')
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('Admin/plugins/select2/css/select2.min.css')}}">
        <link rel="stylesheet" href="{{ asset('Admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    @endsection


    <form action="{{ route('Collections.update', $collection->id) }}" enctype="multipart/form-data" method="post">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Edit New Collection</p>
                            <button class="btn btn-success btn-sm ms-auto m-2">Edit</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-uppercase text-sm">Collection Information</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">Name</label>
                                    <input class="form-control" type="text" id="name" name="name" value="{{$collection->name}}" required>
                                </div>
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ar_name" class="form-control-label">Arabic Name</label>
                                    <input class="form-control" type="text" id="ar_name" name="ar_name" value="{{$collection->ar_name}}" required>
                                </div>
                                @error('ar_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="Brand-logo">Image</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="image" class="custom-file-input" id="logo">
                                            <label class="custom-file-label" for="logo">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                    </div>
                                </div>
                                @error('image')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <p class="text-uppercase text-sm">Descriptions</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">escription</label>
                                    <textarea class="form-control" rows="3" name="description" id="description" placeholder="Enter ..." >{{$collection->description}}</textarea>
                                </div>
                                @error('description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ar_description">Description -AR-</label>
                                    <textarea class="form-control" rows="3" name="ar_description" id="ar_description" placeholder="Enter ...">{{$collection->ar_description}}</textarea>
                                </div>
                                @error('ar_description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <p class="text-uppercase text-sm">Products</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Select Products to be added to this collection</label>
                                    <select class="select2bs4 w-100" name="product_id[]" multiple="multiple" id="product-select" data-placeholder="Select Products">
                                        @foreach ( $products as $product )
                                            <option value='{{$product->id}}'  @if(in_array($product->id, $collection->products->pluck('id')->toArray())) selected @endif >{{$product->translations->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('product_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <p class="text-uppercase text-sm">What does this collection offer</p>
                        <div id="div-container" class="mt-3">
                            <div class="row feature-form position-relative">
                                <div class="col-md-12" style="overflow-x:scroll;">
                                    <div class="cards FeatureSelections features-cards">
                                        @foreach ($features as $feature)
                                            <label class="CatCard"  style="--card-width: 165px; --card-height:140px;">
                                                <input class="card__input FeatureSelectBox"  name="feature_id[]" 
                                                        type="checkbox" 
                                                        value="{{ $feature->id }}" 
                                                        @if(in_array($feature->id, $selectedFeatures)) checked @endif />
                                                <div class="card__body" style="border: 1px solid #eeee;height:92px !important;">
                                                    <header class="card__body-header p-1">
                                                        <h2 class="card__body-header-title"> {{ $feature->name }}</h2>
                                                    </header>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="text-uppercase text-sm">Control</p>
                        <div class="justify-content-center row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-md btn-success w-100 mt-4 mb-0">Update</button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <a href="{{ route('Collections.index')}}" class="btn btn-md btn-danger w-100 mt-4 mb-0">Cancel</a>
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

    <script>
        $(function () {
            bsCustomFileInput.init();
        });
    </script>

@stop
