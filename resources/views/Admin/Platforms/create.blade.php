@extends('Admin.Layout.Master')
@section('Title', 'Add Platform')

@section('Content')

    @include('Admin.Components.Msg')


    <form action="{{ route('Platform.store') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Add New Platform</p>
                            <button class="btn btn-primary btn-sm ms-auto m-2">Add</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-uppercase text-sm">Platform Information</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Platform-name" class="form-control-label">Platform Name</label>
                                    <input class="form-control" type="text" id="Platform-name" name="Name" required>
                                </div>
                                @error('Name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="VideoURL" class="form-control-label">Video URL</label>
                                    <input class="form-control" type="text" id="VideoURL" name="VideoURL" required>
                                </div>
                                @error('VideoURL')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="Brand-logo">Platform Logo</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="image" class="custom-file-input"
                                                id="Platform-logo">
                                            <label class="custom-file-label" for="Platform-logo">Choose file</label>
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

                        <p class="text-uppercase text-sm">Platform Descriptions</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Main-Description">Main Description</label>
                                    <textarea class="form-control" rows="3" name="MainDescription" id="Main-Description" placeholder="Enter ..."></textarea>
                                </div>
                                @error('MainDescription')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Main-Description-AR">Main Description -ar-</label>
                                    <textarea class="form-control" rows="3" name="ArabicDescription" id="Main-Description-AR" placeholder="Enter ..."></textarea>
                                </div>
                                @error('ArabicDescription')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <p class="text-uppercase text-sm">Platform FAQ</p>
                        <hr class="horizontal dark">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Question">Question</label>
                                    <textarea class="form-control" rows="3" name="Question" id="Question" placeholder="Enter ..."></textarea>
                                </div>
                                @error('Question')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Answer">Answer</label>
                                    <textarea class="form-control" rows="3" name="Answer" id="Answer" placeholder="Enter ..."></textarea>
                                </div>
                                @error('Answer')
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
                                    <a href="{{ route('Platform.index') }}"
                                        class="btn btn-md btn-danger w-100 mt-4 mb-0">Cancel</a>
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
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
@stop
