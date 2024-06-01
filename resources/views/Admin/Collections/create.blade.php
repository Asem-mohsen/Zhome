@extends('Admin.Layout.Master')
@section('Title' , 'Add Collection')

@section('Content')

    @include('Admin.Components.Msg')

    @section('Css')
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('Admin/plugins/select2/css/select2.min.css')}}">
        <link rel="stylesheet" href="{{ asset('Admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    @endsection


    <form action="{{ route('Collections.store') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Add New Collection</p>
                            <button class="btn btn-primary btn-sm ms-auto m-2">Add</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-uppercase text-sm">Collection Information</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Name" class="form-control-label">Name</label>
                                    <input class="form-control" type="text" id="Name" name="Name" required>
                                </div>
                                @error('Name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ArabicName" class="form-control-label">Arabic Name</label>
                                    <input class="form-control" type="text" id="ArabicName" name="ArabicName" required>
                                </div>
                                @error('ArabicName')
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
                                    <label for="Description">Description</label>
                                    <textarea class="form-control" rows="3" name="Description" id="Description" placeholder="Enter ..." ></textarea>
                                </div>
                                @error('Description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Main-Description-AR">Description -AR-</label>
                                    <textarea class="form-control" rows="3" name="ArabicDescription" id="Main-Description-AR" placeholder="Enter ..."></textarea>
                                </div>
                                @error('ArabicDescription')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <p class="text-uppercase text-sm">Products</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Select Products to be added to this collection</label>
                                    <select class="select2bs4 w-100" name="ProductID[]" multiple="multiple" id="product-select" data-placeholder="Select Products">
                                        @foreach ( $products as $product )
                                            <option value='{{$product->ID}}'>{{$product->Name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('ProductID')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <p class="text-uppercase text-sm">What does this collection offer</p>
                        <a id="add-feature-btn" class="btn btn-light mb-0" style="margin-left: 14px;width: 31%;">Add New Feature</a>
                        <div id="div-container" class="mt-3">
                            <div class="row feature-form position-relative">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Feature" class="form-control-label">Feature</label>
                                        <input class="form-control" type="text" id="Feature" name="features[0][Feature]" required>
                                    </div>
                                    @error('Feature')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Brand-logo">Image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="features[0][Feature-Image]" class="custom-file-input" id="Feature-Image">
                                                <label class="custom-file-label" for="Feature-Image">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                        </div>
                                    </div>
                                    @error('Feature-Image')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Feature-Description">Description</label>
                                        <textarea class="form-control" rows="3" name="features[0][Feature-Description]" placeholder="Enter ..." ></textarea>
                                    </div>
                                    @error('Feature-Description')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="EndDate">Ends In</label>
                                        <input class="form-control" type="date" name="s" id="EndDate" >
                                    </div>
                                    @error('EndDate')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <span class="delete-icon">&times;</span>
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

    <script>
        document.getElementById('add-feature-btn').addEventListener('click', function() {
            var container = document.getElementById('div-container');
            var index = container.getElementsByClassName('feature-form').length;
            var newForm = document.querySelector('.feature-form').cloneNode(true);

            newForm.querySelectorAll('input, textarea').forEach(function(input) {
                var name = input.name;
                if (name) {
                    input.name = name.replace(/\d+/, index);
                }
                input.value = '';
            });

            newForm.querySelector('.delete-icon').addEventListener('click', function() {
                newForm.remove();
            });

            container.appendChild(newForm);
        });
        // document.getElementById('add-div-btn').addEventListener('click', function() {
        //     // Clone the feature form
        //     var originalForm = document.querySelector('.feature-form');
        //     var newForm = originalForm.cloneNode(true);

        //     // Clear the input fields in the cloned form
        //     newForm.querySelectorAll('input, textarea').forEach(function(input) {
        //         input.value = '';
        //     });

        //     // Create a delete icon and attach it to the cloned form
        //     var deleteIcon = document.createElement('span');
        //     deleteIcon.className = 'delete-icon';
        //     deleteIcon.innerHTML = '&times;';
        //     deleteIcon.addEventListener('click', function() {
        //         newForm.remove();
        //     });
        //     newForm.appendChild(deleteIcon);

        //     // Append the cloned form to the container
        //     document.getElementById('div-container').appendChild(newForm);
        // });
    </script>
@stop
