@extends('Admin.Layout.Master')
@section('Title' , 'Edit')

@section('Content')

    <form action="{{ route('Brands.update', $brand->id) }}" enctype="multipart/form-data" method="post">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <img src="{{ $brand->getFirstMediaUrl('brand-image') }}" class="avatar mr-2" alt="{{ $brand->name }}">
                            <p class="mb-0">Edit {{$brand->name}}</p>
                            <button class="btn btn-primary btn-sm ms-auto m-2">Edit</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-uppercase text-sm">Brand Information</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="brand-name" class="form-control-label">Brand Name</label>
                                    <input class="form-control" type="text" id="brand-name" name="name" required value="{{$brand->name}}">
                                </div>
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Brand-logo">Brand Logo</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="image" class="custom-file-input" id="Brand-logo">
                                            <label class="custom-file-label" for="Brand-logo">Choose file</label>
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

                        <p class="text-uppercase text-sm">Brand Descriptions</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Main-Description">Main Description</label>
                                    <textarea class="form-control" rows="3" name="description" id="Main-Description" placeholder="Enter ..."> {{$brand->description}}</textarea>
                                </div>
                                @error('description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Other-Description">Other Description</label>
                                    <textarea class="form-control" rows="3" name="additional_description" id="Other-Description" placeholder="Enter ...">{{$brand->additional_description}}</textarea>
                                </div>
                                @error('additionl_description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Main-Description-AR">Main Description -ar-</label>
                                    <textarea class="form-control" rows="3" name="ar_description" id="Main-Description-AR" placeholder="Enter ...">{{$brand->ar_description}}</textarea>
                                </div>
                                @error('ar_description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Other-Description-AR">Other Description -ar-</label>
                                    <textarea class="form-control" rows="3" name="ar_additional_description" id="Other-Description-AR" placeholder="Enter ...">{{$brand->ar_additional_description}}</textarea>
                                </div>
                                @error('ar_additional_description')
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
                                    <a href="{{ route('Brands.index')}}" class="btn btn-md btn-danger w-100 mt-4 mb-0">Cancel</a>
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
    <script>
        $(function () {
            bsCustomFileInput.init();
        });
    </script>
@stop
