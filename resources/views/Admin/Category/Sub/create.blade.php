@extends('Admin.Layout.Master')
@section('Title' , 'Add Sub-Category')

@section('Content')

@include('Admin.Components.Msg')

    <form action="{{ route('Category.Subcategory.store' , $category->ID) }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Add New Subcategory</p>
                            <button class="btn btn-primary btn-sm ms-auto m-2">Add</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-uppercase text-sm">Subcategroy Information</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Subcategory-name" class="form-control-label">Subcategory Name -EN-</label>
                                    <input class="form-control" type="text" id="Subcategory-name" name="SubName" required>
                                </div>
                                @error('SubName')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ArabicName" class="form-control-label">Subcategory Name -AR-</label>
                                    <input class="form-control" type="text" id="ArabicName" name="SubArabicName" required>
                                </div>
                                @error('SubArabicName')
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
                                    <label for="Description">Description</label>
                                    <textarea class="form-control" rows="3" name="SubDescription" id="Description" placeholder="Enter ..." ></textarea>
                                </div>
                                <p class="generate-link" onclick="generateLoremIpsum(400, 'Description')">Generate Lorem Ipsum Words</p>
                                @error('SubDescription')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Main-Description-AR">Description -AR-</label>
                                    <textarea class="form-control" rows="3" name="ArabicDescription" id="Main-Description-AR" placeholder="Enter ..."></textarea>
                                </div>
                                <p class="generate-link" onclick="generateArabicLoremIpsum(100, 'Main-Description-AR')">Generate Lorem Ipsum Words</p>
                                @error('ArabicDescription')
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
                                    <a href="{{ route('Category.show', $category->ID ) }}" class="btn btn-md btn-danger w-100 mt-4 mb-0">Cancel</a>
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
