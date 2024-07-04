@extends('Admin.Layout.Master')
@section('Title', 'Add Product')

@section('Css')

    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ asset('Admin/dist/css/wizard.css') }}">

@endsection

@section('Content')

    @include('Admin.Components.Msg')

    <div class="container-fluid py-4">
        <form id="productForm" action="{{ route('Products.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Add New Product</p>
                                <button class="btn btn-primary btn-sm ms-auto m-2">Add</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="wizard">
                                <h3>Add Product Main Info</h3>
                                <section>
                                    <p class="text-uppercase text-sm">Product Information</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Name</label>
                                                <input class="form-control" type="text" id="Name" autocomplete="off"
                                                    name="Name" required>
                                            </div>
                                            @error('Name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Arabic Name</label>
                                                <input class="form-control" type="text" id="Name" autocomplete="off"
                                                    name="ArabicName">
                                            </div>
                                            @error('ArabicName')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Quantity In
                                                    Stock</label>
                                                <input class="form-control" type="number" id="Quantity"
                                                    inputmode="numeric" name="Quantity" autocomplete="off">
                                            </div>
                                            @error('Quantity')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Price</label>
                                                <input class="form-control" type="number" id="ProductPrice"
                                                    inputmode="numeric" name="Price" autocomplete="off">
                                            </div>
                                            @error('Price')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-check mb-3">
                                                <label>
                                                    <input type="checkbox" class="form-check-input" id="hasInstallments"
                                                        name="hasInstallments" onchange="togglePriceInput()">
                                                    Has Installation Cost ?
                                                </label>
                                            </div>
                                            <div id="priceInput" style="display: none;margin-bottom: 27px;">
                                                <label for="price">Installation Cost:</label>
                                                <input type="number" class="form-control" id="price"
                                                    name="InstallationCost">
                                            </div>
                                            @error('InstallationCost')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="input-group mb-4">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <input type="radio" name="IsBundle" id="IsProduct" value="0" checked>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" value="Is Product" disabled>
                                            </div>
                                            @error('IsBundle')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="input-group mb-4">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <input type="radio" name="IsBundle" id="IsBundle" value="1">
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" value="Is Bundle" disabled>
                                            </div>
                                            @error('IsBundle')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="categorySelect">Categories</label>
                                                <select name="Categories" id="categorySelect" class="form-control">
                                                    <option hidden disabled selected>Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->ID }}"> {{ $category->Category }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('Categories')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="subCategorySelect">SubCategory</label>
                                                <select name="SubCategoryID" id="subCategorySelect" class="form-control" disabled>
                                                    <option value="" hidden selected>Select SubCategory</option>
                                                </select>
                                            </div>
                                            @error('SubCategoryID')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!-- Platforms -->
                                        <div class="col-md-12">
                                            <label for="PlatformsAddProduct" class="form-control-label"> Platforms </label>
                                            <div class="cards" id="PlatformsAddProduct">
                                                @foreach ($platforms as $platform)
                                                    <label class="CatCard" style="--card-width: 165px; --card-height:140px;">
                                                        <input class="card__input PlatformSelect" name="PlatformID[]"
                                                            type="checkbox" value="{{ $platform->ID }}" />
                                                        <div class="card__body platform">
                                                            <img src="{{ asset('Admin/dist/img/web/Platforms/' . $platform->Logo) }}"
                                                                alt="{{ $platform->Platform }}">
                                                            <p>{{ $platform->Platform }}</p>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                            @error('PlatformID')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!-- Brands -->
                                        <div class="col-md-12">
                                            <label for="category" class="form-control-label"
                                                style="margin-top: 30px;">Brands </label>
                                            <div class="cards brands-card">
                                                @foreach ($brands as $brand)
                                                    <label class="CatCard"
                                                        style="--card-height: 100px;--card-width: 100px;">
                                                        <input class="card__input BrandSelectBox" name="BrandID"
                                                            type="radio" value="{{ $brand->ID }}" />
                                                        <div class="card__body">
                                                            <div class="ImgDiv"
                                                                style="background-image: url({{ asset('Admin/dist/img/web/Brands/' . $brand->Logo) }});">
                                                            </div>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                            @error('BrandID')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <hr class="horizontal dark">
                                        <!-- Technologies -->
                                        <div class="row">
                                            <div class="col-md-12 TechnologySelection">
                                                <label for="" class="form-control-label"> Technologies </label>
                                                <div class="cards tech-card">
                                                    <label class="CatCard"
                                                        style="--card-height: 100px;--card-width: 100px;">
                                                        <input class="card__input TechBoxSelection" name="Technology[]"
                                                            type="checkbox" value="Wifi" />
                                                        <div class="card__body">
                                                            <header class="card__body-header">
                                                                <h2>Wifi</h2>
                                                            </header>
                                                        </div>
                                                    </label>
                                                    <label class="CatCard"
                                                        style="--card-height: 100px;--card-width: 100px;">
                                                        <input class="card__input TechBoxSelection" name="Technology[]"
                                                            type="checkbox" value="Z-Wave" />
                                                        <div class="card__body">
                                                            <header class="card__body-header">
                                                                <h2>Z-Wave</h2>
                                                            </header>
                                                        </div>
                                                    </label>
                                                    <label class="CatCard"
                                                        style="--card-height: 100px;--card-width: 100px;">
                                                        <input class="card__input TechBoxSelection" name="Technology[]"
                                                            type="checkbox" value="Zigbee" />
                                                        <div class="card__body">
                                                            <header class="card__body-header">
                                                                <h2>Zigbee</h2>
                                                            </header>
                                                        </div>
                                                    </label>
                                                    <label class="CatCard"
                                                        style="--card-height: 100px;--card-width: 100px;">
                                                        <input class="card__input TechBoxSelection" name="Technology[]"
                                                            type="checkbox" value="Bluetooth" />
                                                        <div class="card__body">
                                                            <header class="card__body-header">
                                                                <h2>Bluetooth</h2>
                                                            </header>
                                                        </div>
                                                    </label>
                                                    <label class="CatCard"
                                                        style="--card-height: 100px;--card-width: 100px;">
                                                        <input class="card__input TechBoxSelection" name="Technology[]"
                                                            type="checkbox" value="Matter" />
                                                        <div class="card__body">
                                                            <header class="card__body-header">
                                                                <h2>Matter</h2>
                                                            </header>
                                                        </div>
                                                    </label>
                                                    <label class="CatCard"
                                                        style="--card-height: 100px;--card-width: 100px;">
                                                        <input class="card__input TechBoxSelection" name="Technology[]"
                                                            type="checkbox" value="Thread" />
                                                        <div class="card__body">
                                                            <header class="card__body-header">
                                                                <h2>Thread</h2>
                                                            </header>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            @error('Technology')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </section>

                                <h3>Product Details</h3>
                                <section>
                                    <p class="text-uppercase text-sm">Product Details</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Description" class="form-control-label">Description</label>
                                                <textarea class="form-control" id="Description" name="Description" required></textarea>
                                            </div>
                                            @error('Description')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ArabicDescription" class="form-control-label">Arabic
                                                    Description</label>
                                                <textarea class="form-control" id="ArabicDescription" name="ArabicDescription" required></textarea>
                                            </div>
                                            @error('ArabicDescription')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Expert" class="form-control-label">Expert Review</label>
                                                <textarea class="form-control" id="Expert" name="Evaluation" required></textarea>
                                            </div>
                                            @error('Evaluation')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Expert" class="form-control-label">Arabic Expert
                                                    Review</label>
                                                <textarea class="form-control" id="ArabicExpert" name="ArabicEvaluation" required></textarea>
                                            </div>
                                            @error('ArabicEvaluation')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Title" class="form-control-label">Title</label>
                                                <input class="form-control" type="text" id="Title" name="Title"
                                                    required>
                                            </div>
                                            @error('Title')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="OtherTitle" class="form-control-label">Other Title</label>
                                                <input class="form-control" type="text" id="OtherTitle"
                                                    name="Title2" required>
                                            </div>
                                            @error('Title2')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Title" class="form-control-label">Arabic Title</label>
                                                <input class="form-control" type="text" id="ArabicTitle"
                                                    name="ArabicTitle" required>
                                            </div>
                                            @error('ArabicTitle')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="OtherArabicTitle" class="form-control-label">Other Arabic
                                                    Title</label>
                                                <input class="form-control" type="text" id="OtherArabicTitle"
                                                    name="ArabicTitle2" required>
                                            </div>
                                            @error('ArabicTitle2')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <br>

                                    <p class="text-uppercase text-sm">Dimensions</p>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Width" class="form-control-label">Width</label>
                                                <input type="number" class="form-control" id="Width"
                                                    name="Width">
                                            </div>
                                            @error('Width')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Height" class="form-control-label">Height</label>
                                                <input class="form-control" type="number" id="Height"
                                                    name="Height">
                                            </div>
                                            @error('Height')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Length" class="form-control-label">Length</label>
                                                <input class="form-control" type="number" id="Length"
                                                    name="Length">
                                            </div>
                                            @error('Length')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <br>
                                    <p class="text-uppercase text-sm">Colors</p>
                                    <div class="row flex-column">
                                        <div id="colorInputs" class="d-flex">
                                            <div class="form-group">
                                                <label for="Color" class="form-control-label">Color</label>
                                                <input type="color" class="color-input" name="Color">
                                            </div>
                                            @error('Color')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div id="addRemoveColor" class="mb-5">
                                            <span id="addColorSpan"><i class="fa-solid fa-plus"></i></span>
                                        </div>
                                    </div>
                                    <br>
                                    <p class="text-uppercase text-sm">Others</p>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Capacity" class="form-control-label">Capacity</label>
                                                <input class="form-control" type="text" id="Capacity"
                                                    name="Capacity">
                                            </div>
                                            @error('Capacity')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Power" class="form-control-label">Power Consumption</label>
                                                <input class="form-control" type="text" id="Power"
                                                    name="PowerConsumption">
                                            </div>
                                            @error('PowerConsumption')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="Weight" class="form-control-label">Weight</label>
                                                <input class="form-control" type="text" id="Weight"
                                                    name="Weight">
                                            </div>
                                            @error('Weight')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </section>

                                <h3>Images</h3>
                                <section>
                                    <p class="text-uppercase text-sm">Media</p>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="MainImage" class="form-control-label">Main Image</label>
                                                <input type="file" class="form-control" id="MainImage"
                                                    name="MainImage" accept=".jpg, .jpeg, .png">
                                            </div>
                                            @error('MainImage')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="CoverImage" class="form-control-label">Cover Image</label>
                                                <input type="file" class="form-control" id="CoverImage"
                                                    name="CoverImage" accept=".jpg, .jpeg, .png">
                                            </div>
                                            @error('CoverImage')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Other Images</label>
                                                <input type="file" class="form-control" id="OtherImage" multiple
                                                    name="OtherImages[]" accept=".jpg, .jpeg, .png">
                                            </div>
                                            @error('OtherImage')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Video" class="form-control-label">Video</label>
                                                <input type="text" class="form-control" id="Video"
                                                    name="Video">
                                            </div>
                                            @error('Video')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </section>

                                <h3>Features and FAQ</h3>
                                <section>
                                    <p class="text-uppercase text-sm">Features</p>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="Feature" class="form-control-label">Select Featrues </label>
                                            <div class="cards FeatureSelections features-cards">
                                                @foreach ($features as $feature)
                                                    <label class="CatCard"
                                                        style="--card-width: 165px; --card-height:140px;">
                                                        <input class="card__input FeatureSelectBox" name="FeatureID[]"
                                                            type="checkbox" value="{{ $feature->ID }}" />
                                                        <div class="card__body"
                                                            style="border: 1px solid #eeee;height:92px !important;">
                                                            <header class="card__body-header p-1">
                                                                <h2 class="card__body-header-title">
                                                                    {{ $feature->Feature }}</h2>
                                                            </header>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                            @error('FeatureID')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr class="horizontal dark">
                                    <p class="text-uppercase text-sm">FAQ</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Question" class="form-control-label">Question</label>
                                                <textarea class="form-control QuestionsTextarea" id="Question" name="Question[]" required></textarea>
                                            </div>
                                            @error('Question')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Answer" class="form-control-label">Answer</label>
                                                <textarea class="form-control AnswersTextarea" name="Answer[]" required></textarea>
                                            </div>
                                            @error('Answer')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Question" class="form-control-label">Arabic Question</label>
                                                <textarea class="form-control QuestionsTextarea" id="ArabicQuestion" name="ArabicQuestion[]" required></textarea>
                                            </div>
                                            @error('ArabicQuestion')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Answer" class="form-control-label">Arabic Answer</label>
                                                <textarea class="form-control AnswersTextarea" name="ArabicAnswer[]" required></textarea>
                                            </div>
                                            @error('ArabicAnswer')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div id="div-container" class="mt-5"></div>
                                        <a id="add-div-btn" class="btn bg-gradient-light mb-0" style="margin-left: 14px;width: 31%;">Add New FAQ</a>
                                        
                                    </div>
                                </section>
                            </div>

                            <div class="justify-content-center row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <a href="{{ route('Products.index') }}"
                                            class="btn btn-md btn-danger w-100 mt-4 mb-0">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Side Card -->
                <div class="col-md-4" id="Side">
                    <div class="card mb-4">
                        <h3 class="text-uppercase text-sm heading">Main information</h3>
                        <p class="text-Img-link">Please Make sure that the product information you are filling now are
                            compitable with the design in the provided photo, tap on the image for a full view.</p>
                        <img id="myImg" src="https://zhome.com.eg/Admin/Images/AllPage.png" alt="Snow">
                        <p id="imgLink" class="btn bg-gradient-info">View Full Image</p>
                        <div id="myModal" class="modal">
                            <span class="close">&times;</span>
                            <img class="modal-content" id="img01">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('Js')

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="{{ asset('Admin/dist/js/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('Admin/dist/js/wiard-addProduct.js') }} "></script>

    {{-- Get Subcategories --}}
    <script>
        $(document).ready(function () {
            $('#categorySelect').change(function () {
                var categoryId = $(this).val();

                if (categoryId) {
                    // Enable the subcategory select
                    $('#subCategorySelect').prop('disabled', false);

                    // Fetch subcategories
                    $.ajax({
                        url: '/Products/subcategories/' + categoryId,
                        type: 'GET',
                        success: function (data) {
                            
                            $('#subCategorySelect').empty();
                            $('#subCategorySelect').append('<option hidden selected>Select SubCategory</option>');
                            $.each(data, function (key, subcategory) {
                                $('#subCategorySelect').append('<option value="' + subcategory.ID + '">' + subcategory.SubName + '</option>');
                            });
                        },
                        error: function () {
                            $('#subCategorySelect').empty();
                            $('#subCategorySelect').append('<option hidden selected>Error loading subcategories</option>');
                        }
                    });
                } else {
                    // Disable and reset the subcategory select if no category is selected
                    $('#subCategorySelect').prop('disabled', true);
                    $('#subCategorySelect').empty();
                    $('#subCategorySelect').append('<option hidden selected>Select SubCategory</option>');
                }
            });
        });
    </script>

    {{-- Add New FAQ --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const AddNewFAQ = document.getElementById("add-div-btn");
            const FAQContainer = document.getElementById("div-container");

            AddNewFAQ.addEventListener("click", function() {
                const newDiv = document.createElement("div");
                newDiv.classList.add("new-div");

                newDiv.innerHTML = `
                    <hr class="horizontal dark">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Question" class="form-control-label">Question</label>
                                <textarea class="form-control QuestionsTextarea" name="Question[]" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Answer" class="form-control-label">Answer</label>
                                <textarea class="form-control AnswersTextarea" name="Answer[]" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ArabicQuestion" class="form-control-label">Arabic Question</label>
                                <textarea class="form-control QuestionsTextarea" name="ArabicQuestion[]" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ArabicAnswer" class="form-control-label">Arabic Answer</label>
                                <textarea class="form-control AnswersTextarea" name="ArabicAnswer[]" required></textarea>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-danger remove-div-btn" style="margin-left: 14px;width: 10%;">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                `;

                // FAQContainer.appendChild(newDiv);

                const removeDivBtn = newDiv.querySelector(".remove-div-btn");
                    removeDivBtn.addEventListener("click", function() {
                        FAQContainer.removeChild(newDiv);
                    });
            });
        });
    </script>

    {{-- hasInstallments --}}
    <script type="text/javascript">
        function togglePriceInput() {
            var checkbox = document.getElementById("hasInstallments");
            var priceInput = document.getElementById("priceInput");

            // If the checkbox is checked, show the price input field
            if (checkbox.checked) {
                priceInput.style.display = "block";
            } else {
                priceInput.style.display = "none";
            }
        }
    </script>

    {{-- Model --}}
    <script type="text/javascript">
        var modal = document.getElementById("myModal");

        var img = document.getElementById("myImg");
        var imgLink = document.getElementById("imgLink");
        var modalImg = document.getElementById("img01");

        img.onclick = function() {
            modal.style.display = "block";
            modalImg.src = this.src;
        }
        imgLink.onclick = function() {
            modal.style.display = "block";
            modalImg.src = img.src;
        }
        var span = document.getElementsByClassName("close")[0];

        span.onclick = function() {
            modal.style.display = "none";
        }
    </script>

    {{-- Finish Button --}}
    <script>
        $(document).ready(function() {
            $('a[role="menuitem"][href="#finish"]').on('click', function(event) {
                event.preventDefault(); 
                $('#productForm').submit();
            });
        });
    </script>
@endsection

