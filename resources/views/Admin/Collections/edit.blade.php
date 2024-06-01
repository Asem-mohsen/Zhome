@extends('Admin.Layout.Master')
@section('Title' , 'Edit ' . $collection->Name)

@section('Content')


    @include('Admin.Components.Msg')

    @section('Css')
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('Admin/plugins/select2/css/select2.min.css')}}">
        <link rel="stylesheet" href="{{ asset('Admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    @endsection


    <form action="{{ route('Collections.update', $collection->ID) }}" enctype="multipart/form-data" method="post">
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
                                    <label for="Name" class="form-control-label">Name</label>
                                    <input class="form-control" type="text" id="Name" name="Name" value="{{$collection->Name}}" required>
                                </div>
                                @error('Name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ArabicName" class="form-control-label">Arabic Name</label>
                                    <input class="form-control" type="text" id="ArabicName" name="ArabicName" value="{{$collection->ArabicName}}" required>
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
                                    <textarea class="form-control" rows="3" name="Description" id="Description" placeholder="Enter ..." >{{$collection->Description}}</textarea>
                                </div>
                                @error('Description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Main-Description-AR">Description -AR-</label>
                                    <textarea class="form-control" rows="3" name="ArabicDescription" id="Main-Description-AR" placeholder="Enter ...">{{$collection->ArabicDescription}}</textarea>
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
                                            <option value='{{$product->ID}}'  @if(in_array($product->ID, $collection->products->pluck('ID')->toArray())) selected @endif >{{$product->Name}}</option>
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
                            @forelse ($collection->features as $feature)
                                @include('Admin.Collections.collection_feature_form', ['index' => $loop->index, 'feature' => $feature])
                            @empty
                                @include('Admin.Collections.collection_feature_form', ['index' => 0, 'feature' => null])
                            @endforelse
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

    <script>
        document.getElementById('add-feature-btn').addEventListener('click', function() {
            var container = document.getElementById('div-container');
            var index = container.getElementsByClassName('feature-form').length;
            var newForm = document.querySelector('.feature-form').cloneNode(true);

            newForm.querySelectorAll('input, textarea').forEach(function(input) {
                // Update the name attribute to have a unique index
                var name = input.name;
                if (name) {
                    input.name = name.replace(/\d+/, index);
                }

                // Reset input values
                if (input.type === 'file') {
                    input.value = ''; // For file input, resetting it to an empty value
                } else {
                    input.value = '';
                }
            });

            // Reset the labels for file inputs
            newForm.querySelectorAll('.custom-file-label').forEach(function(label) {
                label.textContent = 'Choose file';
            });

            // Add delete event listener
            newForm.querySelector('.delete-icon').addEventListener('click', function() {
                newForm.remove();
            });
            
            container.appendChild(newForm);
        });
        document.querySelectorAll('.delete-icon').forEach(function(icon) {
            icon.addEventListener('click', function() {
                this.closest('.feature-form').remove();
            });
        });
    </script>
@stop
