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
                                    <input class="form-control" type="text" id="Platform-name" name="name" value="{{ old('name') }}" required>
                                </div>
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="VideoURL" class="form-control-label">Video URL</label>
                                    <input class="form-control" type="text" id="VideoURL" name="video_url" value="{{ old('video_url') }}" required>
                                </div>
                                @error('video_url')
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
                                    <textarea class="form-control" rows="3" name="description" id="Main-Description" placeholder="Enter ...">{{ old('description') }}</textarea>
                                </div>
                                @error('description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Main-Description-AR">Main Description -ar-</label>
                                    <textarea class="form-control" rows="3" name="ar_description" id="Main-Description-AR" placeholder="Enter ...">{{ old('description') }}</textarea>
                                </div>
                                @error('ar_description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <p class="text-uppercase text-sm">Platform FAQ</p>
                        <hr class="horizontal dark">
                        <div id="faq-section">
                            <div class="faq-item">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Question">Question</label>
                                            <textarea class="form-control" rows="3" name="question[]" id="Question" placeholder="Enter ...">{{ old('question') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Answer">Answer</label>
                                            <textarea class="form-control" rows="3" name="answer[]" id="Answer" placeholder="Enter ...">{{ old('answer') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-faq-btn" class="btn btn-primary">Add Another FAQ</button>

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

    <script>
        document.getElementById('add-faq-btn').addEventListener('click', function() {
            const faqSection = document.getElementById('faq-section');
            const newFaqItem = document.createElement('div');
            newFaqItem.classList.add('faq-item');
            newFaqItem.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <label>Question</label>
                        <textarea class="form-control" rows="3" name="question[]" placeholder="Enter question"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label>Answer</label>
                        <textarea class="form-control" rows="3" name="answer[]" placeholder="Enter answer"></textarea>
                    </div>
                </div>
                <hr>
            `;
            faqSection.appendChild(newFaqItem);
        });
    </script>
@stop
