@extends('Admin.Layout.Master')
@section('Title', 'Edit ' . $feature->Feature)

@section('Content')

    <div class="container-fluid py-4">
        <div class="card">
            <form action="{{ route('Features.update', $feature->ID) }}" enctype="multipart/form-data" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-header pb-2">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Edit Feature</p>
                                <button class="btn btn-primary btn-sm ml-2">Edit</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Feature" class="form-control-label">Feature Name</label>
                                        <input class="form-control" id="Feature" type="text" name="Feature"
                                            value="{{ $feature->Feature }}" required>
                                    </div>
                                    @error('Feature')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image" class="form-control-label">Image</label>
                                        <input type="file" class="form-control" id="image" name="image"
                                            accept="image/*" style="padding: 4px;">
                                    </div>
                                    @error('image')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Description"
                                            class="form-control-label w-100 text-center">Description</label>
                                        <textarea class="form-control" id="Description" name="Description" required>{{ $feature->Description }}</textarea>
                                        @error('Description')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Description_ar" class="form-control-label w-100 text-center">Arabic
                                            Description</label>
                                        <textarea class="form-control" id="Description_ar" name="Description_ar" required>{{ $feature->Description }}</textarea>
                                        @error('Description_ar')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="justify-content-center row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success w-100 mt-4 mb-0">Update</button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <a href="{{ route('Features.show', $feature->ID) }}"
                                        class="btn btn-danger w-100 mt-4 mb-0">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
