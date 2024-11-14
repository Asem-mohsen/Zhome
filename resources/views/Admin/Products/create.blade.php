@extends('Admin.Layout.Master')

@section('Title', 'Add Product')

@section('Css')

    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    
    <link rel="stylesheet" href="{{ asset('Admin/dist/css/wizard.css') }}">

@endsection

@section('Content')

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
                                                <label for="name" class="form-control-label">Name</label>
                                                <input class="form-control" type="text" id="name" autocomplete="off" name="name" value="{{ old('name') }}" required>
                                            </div>
                                            @error('name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ar_name" class="form-control-label">Arabic Name</label>
                                                <input class="form-control" type="text" id="ar_name" autocomplete="off" name="ar_name" value="{{ old('ar_name') }}" required>
                                            </div>
                                            @error('ar_name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="quantity" class="form-control-label">Quantity In Stock</label>
                                                <input class="form-control" type="number" id="quantity" inputmode="numeric" name="quantity" value="{{ old('quantity') }}" autocomplete="off">
                                            </div>
                                            @error('quantity')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="price" class="form-control-label">Price</label>
                                                <input class="form-control" type="number" id="price" inputmode="numeric" name="price" value="{{ old('price') }}" autocomplete="off">
                                            </div>
                                            @error('price')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-check mb-3">
                                                <label>
                                                    <input type="checkbox" class="form-check-input" id="hasInstallments" name="hasInstallments" onchange="togglePriceInput()">
                                                    Has Installation Cost ?
                                                </label>
                                            </div>
                                            <div id="priceInput" class="mb-4" style="display: none;">
                                                <label for="price">Installation Cost:</label>
                                                <input type="number" class="form-control" id="price" value="{{ old('installation_cost') }}" name="installation_cost">
                                            </div>
                                            @error('installation_cost')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="input-group mb-4">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <input type="radio" name="is_bundle" id="IsProduct" value="0" checked>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" value="Is Product" disabled>
                                            </div>
                                            @error('is_bundle')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="input-group mb-4">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <input type="radio" name="is_bundle" id="IsBundle" value="1">
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" value="Is Bundle" disabled>
                                            </div>
                                            @error('is_bundle')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="categorySelect">Categories</label>
                                                <select name="category_id" id="categorySelect" class="form-control">
                                                    <option hidden disabled selected>Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"> {{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('category_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="subCategorySelect">SubCategory</label>
                                                <select name="subcategory_id" id="subCategorySelect" class="form-control" disabled>
                                                    <option value="" hidden selected>Select SubCategory</option>
                                                </select>
                                            </div>
                                            @error('subcategory_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Platforms -->
                                        <div class="col-md-12">
                                            <label for="PlatformsAddProduct" class="form-control-label"> Platforms </label>
                                            <div class="cards" id="PlatformsAddProduct">
                                                @foreach ($platforms as $platform)
                                                    <label class="CatCard" style="--card-width: 165px; --card-height:140px;">
                                                        <input class="card__input PlatformSelect" name="platform_id[]" type="checkbox" value="{{$platform->id }}" />
                                                        <div class="card__body platform">
                                                            <img src="{{ $platform->getFirstMediaUrl('platform-image') }}" alt="{{ $platform->name }}">
                                                            <p>{{ $platform->name }}</p>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                            @error('platform_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!-- Brands -->
                                        <div class="col-md-12">
                                            <label for="category" class="form-control-label mt-5">Brands </label>
                                            <div class="cards brands-card">
                                                @foreach ($brands as $brand)
                                                    <label class="CatCard" style="--card-height: 100px;--card-width: 100px;">
                                                        <input class="card__input BrandSelectBox" name="brand_id" type="radio" value="{{$brand->id }}" />
                                                        <div class="card__body">
                                                            <div class="ImgDiv" style="background-image: url({{$brand->getFirstMediaUrl('brand-image') }});">
                                                            </div>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                            @error('brand_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <hr class="horizontal dark">
                                        <!-- Technologies -->
                                        <div class="row">
                                            <div class="col-md-12 TechnologySelection">
                                                <label for="" class="form-control-label"> Technologies </label>
                                                <div class="cards tech-card">
                                                    @foreach ($technologies as $technology)
                                                        <label class="CatCard"  style="--card-height: 100px;--card-width: 100px;">
                                                            <input class="card__input TechBoxSelection" name="technology_id[]" type="checkbox" value="{{$technology->id}}" />
                                                            <div class="card__body">
                                                                <header class="card__body-header">
                                                                    <h2>{{$technology->name}}</h2>
                                                                </header>
                                                            </div>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </section>

                                <h3>Product Details</h3>
                                <section>
                                    <p class="text-uppercase text-sm">Product Details</p>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description" class="form-control-label">Description</label>
                                                <textarea class="form-control" id="description" name="description"  data-maxlength="1000" required >{{ old('description') }}</textarea>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <p class="generate-link" onclick="generateLoremIpsum(30, 'description')">Generate Lorem Ipsum Words</p>
                                                <p class="remaining" data-for="description">1000 Characters Remaining</p>
                                            </div>
                                            @error('description')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="ArabicDescription" class="form-control-label">Arabic Description</label>
                                                <textarea class="form-control" id="ar_description" data-maxlength="1000" name="ar_description" required>{{ old('ar_description') }}</textarea>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <p class="generate-link" onclick="generateArabicLoremIpsum(30, 'ar_description')">Generate Lorem Ipsum Words</p>
                                                <p class="remaining" data-for="ar_description">1000 Characters Remaining</p>
                                            </div>
                                            @error('ar_description')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="comment" class="form-control-label">Expert Review</label>
                                                <textarea class="form-control" id="comment" data-maxlength="700" name="comment" required>{{ old('comment') }}</textarea>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <p class="generate-link" onclick="generateLoremIpsum(30, 'comment')">Generate Lorem Ipsum Words</p>
                                                <p class="remaining" data-for="comment">700 Characters Remaining</p>
                                            </div>
                                            @error('comment')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="ar_comment" class="form-control-label">Arabic Expert Review</label>
                                                <textarea class="form-control" id="ar_comment" data-maxlength="700" name="ar_comment" required>{{ old('ar_comment') }}</textarea>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <p class="generate-link" onclick="generateArabicLoremIpsum(30, 'ar_comment')">Generate Lorem Ipsum Words</p>
                                                <p class="remaining" data-for="ar_comment">700 Characters Remaining</p>
                                            </div>
                                            @error('ar_comment')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="title" class="form-control-label">Title</label>
                                                <input class="form-control" type="text" id="title" name="title" value="{{ old('title') }}" required>
                                            </div>
                                            <p class="generate-link" onclick="generateLoremIpsum(10, 'title')">Generate Lorem Ipsum Words</p>
                                            @error('title')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="second_title" class="form-control-label">Other Title</label>
                                                <input class="form-control" type="text" id="second_title" value="{{ old('second_title') }}" name="second_title" required>
                                            </div>
                                            <p class="generate-link" onclick="generateLoremIpsum(10, 'second_title')">Generate Lorem Ipsum Words</p>
                                            @error('second_title')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ar_title" class="form-control-label">Arabic Title</label>
                                                <input class="form-control" type="text" id="ar_title" name="ar_title" required>
                                            </div>
                                            <p class="generate-link" onclick="generateArabicLoremIpsum(10, 'ar_title')">Generate Lorem Ipsum Words</p>
                                            @error('ar_title')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ar_second_title" class="form-control-label">Other Arabic Title</label>
                                                <input class="form-control" type="text" id="ar_second_title" name="ar_second_title" required>
                                            </div>
                                            <p class="generate-link" onclick="generateArabicLoremIpsum(10, 'ar_second_title')">Generate Lorem Ipsum Words</p>
                                            @error('ar_second_title')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <br>

                                    <p class="text-uppercase text-sm">Dimensions</p>
                                    <table class="table" id="dimensions-table">
                                        <thead>
                                            <tr>
                                                <th>Key</th>
                                                <th>Value</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="text" name="dimension_keys[]" class="form-control" placeholder="Enter Key"></td>
                                                <td><input type="text" name="dimension_values[]" class="form-control" placeholder="Enter Value"></td>
                                                <td>
                                                    <button type="button" class="btn btn-danger remove-row">Remove</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-primary" id="add-row">Add Dimension</button>

                                    <br>
                                    <p class="text-uppercase text-sm pt-5">Colors</p>
                                    <div class="row flex-column m-2">
                                        <div id="colorInputs" class="d-grid align-items-baseline" style="gap:20px">
                                            <div class="color-inputs">
                                                <input type="color" class="color-input" name="color[]">
                                            </div>
                                        </div>
                                        <div id="addRemoveColor" class="mt-2">
                                            <span id="addColorSpan" onclick="addColorInput()"><i class="fa-solid fa-plus"></i></span>
                                        </div>
                                    </div>
                                    <br>

                                </section>

                                <h3>Images</h3>
                                <section>
                                    <p class="text-uppercase text-sm">Media</p>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="image" class="form-control-label">Main Image</label>
                                                <input type="file" class="form-control" id="image" name="image" accept=".jpg, .jpeg, .png">
                                            </div>
                                            @error('image')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cover_image" class="form-control-label">Cover Image</label>
                                                <input type="file" class="form-control" id="cover_image" name="cover_image" accept=".jpg, .jpeg, .png">
                                            </div>
                                            @error('cover_image')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Other Images</label>
                                                <input type="file" class="form-control" id="other_images" multiple name="other_images[]" accept=".jpg, .jpeg, .png">
                                            </div>
                                            @error('other_images')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="video_url" class="form-control-label">Video</label>
                                                <input type="text" class="form-control" id="video_url" name="video_url">
                                            </div>
                                            @error('video_url')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </section>

                                <h3>Features and FAQ</h3>
                                <section>
                                    <p class="text-uppercase text-sm">Features</p>
                                    <div class="row">
                                        <div class="col-md-12" style="overflow-x:scroll;">
                                            <label for="Feature" class="form-control-label">Select Featrues </label>
                                            <div class="cards FeatureSelections features-cards">
                                                @foreach ($features as $feature)
                                                    <label class="CatCard"  style="--card-width: 165px; --card-height:140px;">
                                                        <input class="card__input FeatureSelectBox" name="feature_id" type="checkbox" value="{{ $feature->id }}" />
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
                                    <hr class="horizontal dark">
                                    <p class="text-uppercase text-sm">FAQ</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Question</label>
                                                <textarea class="form-control QuestionsTextarea" name="question[]"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Answer</label>
                                                <textarea class="form-control AnswersTextarea" name="answer[]"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Arabic Question</label>
                                                <textarea class="form-control QuestionsTextarea" name="ar_question[]"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Answer" class="form-control-label">Arabic Answer</label>
                                                <textarea class="form-control AnswersTextarea" name="ar_answer[]"></textarea>
                                            </div>
                                        </div>
                                        <div id="div-container" class="mt-5"></div>
                                        <a id="add-div-btn" class="btn bg-gradient-light mb-0 ml-2" onclick="addFAQ()" style="width: 31%;">Add New FAQ</a>

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
                        <h3 class="text-uppercase text-sm pt-3 text-center heading">Main information</h3>
                        <p class="text-Img-link p-2">Please Make sure that the product information you are filling now are
                            compitable with the design in the provided photo, tap on the image for a full view.</p>
                        <img id="myImg" src="{{asset('Admin/dist/img/web/Products/AllPage.webp')}}" alt="All the Page">
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
                                $('#subCategorySelect').append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
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
        function addFAQ() {
            const divContainer = document.getElementById('div-container');
            const newDiv = document.createElement('div');
            newDiv.classList.add('row', 'mb-3');
            newDiv.innerHTML = `
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Question" class="form-control-label">Question</label>
                        <textarea class="form-control QuestionsTextarea" name="question[]"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Answer" class="form-control-label">Answer</label>
                        <textarea class="form-control AnswersTextarea" name="answer[]"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Question" class="form-control-label">Arabic Question</label>
                        <textarea class="form-control QuestionsTextarea" name="ar_question[]"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Answer" class="form-control-label">Arabic Answer</label>
                        <textarea class="form-control AnswersTextarea" name="ar_answer[]"></textarea>
                    </div>
                </div>
                <button class="btn btn-danger remove-div-btn pl-1 pr-1" type="button">x</button>
            `;
            divContainer.appendChild(newDiv);

            // Add event listener to the remove button
            newDiv.querySelector('.remove-div-btn').addEventListener('click', function() {
                newDiv.remove();
            });
        }
    </script>

    {{-- Color Input --}}
    <script>
        let colorInputCount = 1;

        function addColorInput() {
            const addColorSpan = document.getElementById('addColorSpan');
            const colorInputs = document.getElementById('colorInputs');

            if (colorInputCount < 3) {
                const newColorDiv = document.createElement('div');
                newColorDiv.classList.add('color-inputs');
                newColorDiv.innerHTML = `
                    <input type="color" class="color-input" name="color[]">
                    <button class="btn btn-danger remove-color-btn" type="button">x</button>
                `;
                colorInputs.appendChild(newColorDiv);
                colorInputCount++;

                if (colorInputCount === 3) {
                    addColorSpan.style.display = 'none';
                }

                // Add event listener to the remove button
                newColorDiv.querySelector('.remove-color-btn').addEventListener('click', function() {
                    newColorDiv.remove();
                    colorInputCount--;
                    if (colorInputCount < 3) {
                        addColorSpan.style.display = 'inline';
                    }
                });
            }
        }
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

    {{-- count text wrote --}}
    <script>
        $(document).ready(function(){
            $('textarea').each(function(){
                const maxLength = $(this).data('maxlength');
                const textareaId = $(this).attr('id');

                $(this).on('input', function() {
                    updateCharacterCount(textareaId, maxLength);
                });

                // Initial update on page load
                updateCharacterCount(textareaId, maxLength);
            });
        });
    </script>

    {{-- Add new deminsion --}}
    <script>
        $(document).ready(function () {
            $('#add-row').on('click', function () {
                const newRow = `
                    <tr>
                        <td><input type="text" name="dimension_keys[]" class="form-control" placeholder="Enter Key"></td>
                        <td><input type="text" name="dimension_values[]" class="form-control" placeholder="Enter Value"></td>
                        <td><button type="button" class="btn btn-danger remove-row">Remove</button></td>
                    </tr>
                `;
                $('#dimensions-table tbody').append(newRow);
            });

            $(document).on('click', '.remove-row', function () {
                $(this).closest('tr').remove();
            });
        });
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

