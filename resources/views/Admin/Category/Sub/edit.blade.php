@extends('Admin.Layout.Master')
@section('Title' , 'Edit ' . $subcategory->name)

@section('Content')

    <form action="{{ route('Category.Subcategory.update' , $subcategory->id) }}" enctype="multipart/form-data" method="post">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Edit {{$subcategory->name}} </p>
                            <button class="btn btn-primary btn-sm ms-auto m-2">Edit</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-uppercase text-sm">Subcategroy Information</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Subcategory-name" class="form-control-label">Subcategory Name -EN-</label>
                                    <input class="form-control" type="text" id="Subcategory-name" name="name" value="{{$subcategory->name}}" required>
                                </div>
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ar_name" class="form-control-label">Subcategory Name -AR-</label>
                                    <input class="form-control" type="text" id="ar_name" name="ar_name" value="{{$subcategory->ar_name}}" required>
                                </div>
                                @error('ar_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="Brand-logo">Subcategory Image</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="image" class="custom-file-input" id="Subcategory-logo">
                                            <label class="custom-file-label" for="Subcategory-logo">Choose file</label>
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

                        <p class="text-uppercase text-sm">Subcategory Descriptions</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" rows="3" name="description" id="description" placeholder="Enter ..." >{{$subcategory->description}}</textarea>
                                </div>
                                <p class="generate-link" onclick="generateLoremIpsum(40, 'description')">Generate Lorem Ipsum Words</p>
                                @error('description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ar_description">Description -AR-</label>
                                    <textarea class="form-control" rows="3" name="ar_description" id="ar_description" placeholder="Enter ...">{{$subcategory->ar_description}}</textarea>
                                </div>
                                <p class="generate-link" onclick="generateArabicLoremIpsum(100, 'ar_description')">Generate Lorem Ipsum Words</p>
                                @error('ar_description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
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
                                    <a href="{{ route('Category.show', $subcategory->category_id ) }}" class="btn btn-md btn-danger w-100 mt-4 mb-0">Cancel</a>
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