@extends('Admin.Layout.Master')
@section('Title' , 'Edit')


@section('Css')
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://zhome.com.eg/Front/Css/bd-wizard.css?v=5.1">
@endsection

@section('Content')

@include('Admin.Components.Msg')

<div class="container-fluid py-4">
    <form action="post" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Add New Product</p>
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
                                            <input class="form-control" type="text" id="Name" autocomplete="off" name="Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Quantity In Stock</label>
                                            <input class="form-control" type="number" id="Quantity" inputmode="numeric" name="Quantity" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Price</label>
                                            <input class="form-control" type="number" id="ProductPrice" inputmode="numeric" name="ProductPrice" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="example-text-input" class="form-control-label">Is Bundle</label>
                                        <div class="d-flex justify-content-around">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="IsBundle" id="IsProduct" value="0" checked>
                                                <label class="custom-control-label" for="IsProduct">Product</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio" name="IsBundle" id="IsBundle" value="1">
                                                <label class="custom-control-label" for="IsBundle">Bundle</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check mb-3">
                                            <label>
                                                <input type="checkbox"  class="form-check-input" id="hasInstallments" name="hasInstallments" onchange="togglePriceInput()">
                                                Has Installation Cost ?
                                            </label>
                                        </div>
                                        <div id="priceInput" style="display: none;margin-bottom: 27px;">
                                            <label for="price">Installation Cost:</label>
                                            <input type="number" class="form-control" id="price" name="InstallationCost">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="categorySelect">Categories</label>
                                            <select name="Categories" id="categorySelect" class="form-control" >
                                                <option value=""  selected>Select Category</option>
                                                <?php
                                                    $result = mysqli_query($con, "SELECT DISTINCT category.* FROM `category` LEFT JOIN subcategory ON category.ID = subcategory.MainCategoryID WHERE subcategory.MainCategoryID IS NOT NULL");
                                                    while ($rowCat = mysqli_fetch_assoc($result)) { ?>
                                                        <option value="<?php echo $rowCat['ID'] ?>"><?php echo $rowCat['Category'] ?></option>
                                                   <?php } ?> 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subCategorySelect">SubCategory</label>
                                            <select name="SubCategory" id="subCategorySelect" class="form-control">
                                                <option value=""  selected>Select SubCategory</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Platforms -->
                                    <div class="col-md-12">
                                        <label for="category" class="form-control-label"> Platforms </label>
                                        <div class="cards" id="PlatformsAddProduct" style="gap: 20px;justify-content: center;">
                                            <?php
                                            // Query the subcategories table
                                            $Platform = mysqli_query($con, "SELECT * FROM platform");

                                            while ($PlatformResult = mysqli_fetch_assoc($Platform)) {  ?>
                                                <label class="CatCard" style="--card-width: 165px; --card-height:140px;">
                                                    <input class="card__input PlatformSelect" name="Platform[]" type="checkbox" value="<?php echo $PlatformResult['ID'] ?>" />
                                                    <div class="card__body platform">
                                                        <img src="https://zhome.com.eg/Admin/Images/Uploads/<?php echo $PlatformResult['Logo'] ?>" alt="" style="padding: 5px;">
                                                        <p><?php echo $PlatformResult['Platform'] ?></p>
                                                    </div>
                                                </label>
                                                
                                            <?php  }
                                            ?>
                                        </div>
                                    </div>
                                    <!-- Brands -->
                                    <div class="col-md-12">
                                        <label for="category" class="form-control-label" style="margin-top: 30px;">Brands </label>
                                        <div class="cards" style="gap: 20px;">
                                            <?php
                                            // Query the subcategories table
                                            $Brands = mysqli_query($con, "SELECT * FROM brands");

                                            while ($BrandsResult = mysqli_fetch_assoc($Brands)) {  ?>
                                                <label class="CatCard" style="--card-height: 100px;--card-width: 100px;">
                                                    <input class="card__input BrandSelectBox " name="Brand" type="radio" value="<?php echo $BrandsResult['ID'] ?>" />
                                                    <div class="card__body">
                                                        <div class="ImgDiv" style="background-image: url(https://zhome.com.eg/Admin/Images/Uploads/<?php echo $BrandsResult['Logo'] ?>);">
                                                        </div>
                                                    </div>
                                                </label>
                                            <?php  }
                                            ?>
                                        </div>
                                    </div>
                                    
                                    <hr class="horizontal dark">
                                    <!-- Technologies -->
                                    <div class="row">
                                        <div class="col-md-12 TechnologySelection">
                                            <label for="category" class="form-control-label"> Technologies </label>
                                            <div class="cards" style="gap: 20px;">
                                                <label class="CatCard" style="--card-height: 100px;--card-width: 100px;">
                                                    <input class="card__input TechBoxSelection" name="Technology[]" type="checkbox" value="Wifi" />
                                                    <div class="card__body">
                                                        <header class="card__body-header">
                                                            <h2 style="font-size: 19px;text-align:center;font-family: monospace;padding-top:10px;">Wifi</h2>
                                                        </header>
                                                    </div>
                                                </label>
                                                <label class="CatCard" style="--card-height: 100px;--card-width: 100px;">
                                                    <input class="card__input TechBoxSelection" name="Technology[]" type="checkbox" value="Z-Wave" />
                                                    <div class="card__body">
                                                        <header class="card__body-header">
                                                            <h2 style="font-size: 19px;text-align:center;font-family: monospace;padding-top:10px;">Z-Wave</h2>
                                                        </header>
                                                    </div>
                                                </label>
                                                <label class="CatCard" style="--card-height: 100px;--card-width: 100px;">
                                                    <input class="card__input TechBoxSelection" name="Technology[]" type="checkbox" value="Zigbee" />
                                                    <div class="card__body">
                                                        <header class="card__body-header">
                                                            <h2 style="font-size: 19px;text-align:center;font-family: monospace;padding-top:10px;">Zigbee</h2>
                                                        </header>
                                                    </div>
                                                </label>
                                                <label class="CatCard" style="--card-height: 100px;--card-width: 100px;">
                                                    <input class="card__input TechBoxSelection" name="Technology[]" type="checkbox" value="Bluetooth" />
                                                    <div class="card__body">
                                                        <header class="card__body-header">
                                                            <h2 style="font-size: 19px;text-align:center;font-family: monospace;padding-top:10px;">Bluetooth</h2>
                                                        </header>
                                                    </div>
                                                </label>
                                                <label class="CatCard" style="--card-height: 100px;--card-width: 100px;">
                                                    <input class="card__input TechBoxSelection" name="Technology[]" type="checkbox" value="Matter" />
                                                    <div class="card__body">
                                                        <header class="card__body-header">
                                                            <h2 style="font-size: 19px;text-align:center;font-family: monospace;padding-top:10px;">Matter</h2>
                                                        </header>
                                                    </div>
                                                </label>
                                                <label class="CatCard" style="--card-height: 100px;--card-width: 100px;">
                                                    <input class="card__input TechBoxSelection" name="Technology[]" type="checkbox" value="Thread" />
                                                    <div class="card__body">
                                                        <header class="card__body-header">
                                                            <h2 style="font-size: 19px;text-align:center;font-family: monospace;padding-top:10px;">Thread</h2>
                                                        </header>
                                                    </div>
                                                </label>
                                                <label class="CatCard" style="--card-height: 100px;--card-width: 100px;">
                                                    <input class="card__input" name="CheckAll" type="checkbox" id="checkAll" value="" />
                                                    <div class="card__body">
                                                        <header class="card__body-header">
                                                            <h2 style="font-size: 19px;text-align:center;font-family: monospace;padding-top:10px;">All</h2>
                                                        </header>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <script>
                                    // CheckBox
                                    var checkAll = document.getElementById('checkAll');
                                    var checkboxes = document.getElementsByName('Technology[]');
                            
                                    // Function to update the state of all checkboxes
                                    function updateCheckboxes(checked) {
                                        for (var i = 0; i < checkboxes.length; i++) {
                                            checkboxes[i].checked = checked;
                                        }
                                    }
                            
                                    // Add an event listener to the "Check All" checkbox
                                    checkAll.addEventListener('change', function() {
                                        // Update the state of all other checkboxes
                                        updateCheckboxes(checkAll.checked);
                                    });
                            
                                    // Add an event listener to each checkbox to handle their changes
                                    for (var i = 0; i < checkboxes.length; i++) {
                                        checkboxes[i].addEventListener('change', function() {
                                            var allChecked = true;
                            
                                            // Check if all other checkboxes are checked
                                            for (var j = 0; j < checkboxes.length; j++) {
                                                if (checkboxes[j] !== checkAll && !checkboxes[j].checked) {
                                                    allChecked = false;
                                                    break;
                                                }
                                            }
                            
                                            // Update the state of the "Check All" checkbox
                                            checkAll.checked = allChecked;
                                        });
                                    }
                                </script>
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
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Description" class="form-control-label">Arabic Description</label>
                                            <textarea class="form-control" id="ArabicDescription" name="ArabicDescription" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="DescriptionTwo" class="form-control-label">Other Description (if applicable)</label>
                                            <textarea class="form-control" id="DescriptionTwo" name="OtherDescription"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="DescriptionTwo" class="form-control-label">Other Arabic Description (if applicable)</label>
                                            <textarea class="form-control" id="DescriptionArabicTwo" name="OtherArabicDescription"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Expert" class="form-control-label">Expert Review</label>
                                            <textarea class="form-control" id="Expert" name="Evaluation" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Expert" class="form-control-label">Arabic Expert Review</label>
                                            <textarea class="form-control" id="ArabicExpert" name="ArabicEvaluation" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Title" class="form-control-label">Title</label>
                                            <input class="form-control" type="text" id="Title" name="Title" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="OtherTitle" class="form-control-label">Other Title</label>
                                            <input class="form-control" type="text" id="OtherTitle" name="OtherTitle" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Title" class="form-control-label">Arabic Title</label>
                                            <input class="form-control" type="text" id="ArabicTitle" name="ArabicTitle" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="OtherTitle" class="form-control-label">Other Arabic Title</label>
                                            <input class="form-control" type="text" id="OtherArabicTitle" name="OtherArabicTitle" required>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <p class="text-uppercase text-sm">Dimensions</p>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Width" class="form-control-label">Width</label>
                                            <input type="number" class="form-control" id="Width" name="Width">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Height" class="form-control-label">Height</label>
                                            <input class="form-control" type="number" id="Height" name="Height">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Length" class="form-control-label">Length</label>
                                            <input class="form-control" type="number" id="Length" name="Length">
                                        </div>
                                    </div>
                                    <p class="text-uppercase text-sm">Colors</p>
                                        
                                    <div  id="colorInputs" style="display: flex;">
                                        
                                        <div class="form-group">
                                            <label for="Color" class="form-control-label">Color</label>
                                            <input type="color" class="color-input"  name="Color">
                                        </div>
                                       
                                    </div>
                                    <div id="addRemoveColor" style="margin-bottom: 20px">
                                        <span id="addColorSpan"><i class="fa-solid fa-plus"></i></span>
                                    </div>
                                    
                                    <p class="text-uppercase text-sm">Others</p>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Capacity" class="form-control-label">Capacity</label>
                                            <input class="form-control" type="number" id="Capacity" name="Capacity">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Power" class="form-control-label">Power Consumption</label>
                                            <input class="form-control" type="number" id="Power" name="Power">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Weight" class="form-control-label">Weight</label>
                                            <input class="form-control" type="number" id="Weight" name="Weight">
                                        </div>
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
                                            <input type="file" class="form-control" id="MainImage" name="MainImage" accept=".jpg, .jpeg, .png">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="CoverImage" class="form-control-label">Cover Image</label>
                                            <input type="file" class="form-control" id="CoverImage" name="CoverImage" accept=".jpg, .jpeg, .png">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Other Images</label>
                                            <input type="file" class="form-control" id="OtherImage" multiple name="OtherImages[]" accept=".jpg, .jpeg, .png">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Video" class="form-control-label">Video</label>
                                            <input type="text" class="form-control" id="Video" name="Video">
                                        </div>
                                    </div>
                                </div>
                            </section>
                            
                            <h3>Features and FAQ</h3>
                            <section>
                                <p class="text-uppercase text-sm">Features</p>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="category" class="form-control-label">Select Featrues </label>
                                        <div class="cards FeatureSelections" style="gap:20px;padding-top: 10px;justify-content: center;">
                                            <?php
                                                $SelectFeatures = mysqli_query($con , "SELECT * FROM features");
                                                foreach($SelectFeatures as $Feature){
                                                    ?>
                                                    <label class="CatCard" style="--card-width: 165px; --card-height:140px;">
                                                        <input class="card__input FeatureSelectBox" name="Feature[]" type="checkbox" value="<?php echo $Feature['ID'] ?>" />
                                                        <div class="card__body" style="border: 1px solid #eeee;height:92px !important;">
                                                            <header class="card__body-header" style="padding: 10px;">
                                                                <h2 class="card__body-header-title"><?php echo $Feature['Feature'] ?></h2>
                                                            </header>
                                                        </div>
                                                    </label>
                                                    <?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-sm">FAQ</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Question" class="form-control-label">Question</label>
                                            <textarea class="form-control QuestionsTextarea" id="Question"  name="Question[]" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Answer" class="form-control-label">Answer</label>
                                            <textarea class="form-control AnswersTextarea" name="Answer[]" required></textarea>
                                        </div>
                                    </div>
                                    <a id="add-div-btn" class="btn bg-gradient-light mb-0" style="margin-left: 14px;width: 31%;">Add New FAQ</a>
                                    <div id="div-container" style="margin-top: 20px;"></div>
                                </div>
                                <script>
                                    // Add New QA
                                   
                                    const AddNewFAQ = document.getElementById("add-div-btn");
                                    const FAQContiner = document.getElementById("div-container");
                        
                                    AddNewFAQ.addEventListener("click", function() {
                        
                                        const newDiv = document.createElement("div");
                                        newDiv.classList.add("new-div");
                        
                                        var MaxDivs = 0;
                                        for (var i = 0; i <= MaxDivs; i++) {
                        
                                            newDiv.innerHTML += `
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
                                                    <button class="btn btn-sm btn-danger remove-div-btn" style="margin-left: 14px;width: 10%;">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                        `;
                        
                                            FAQContiner.appendChild(newDiv);
                        
                                            const removeDivBtn = newDiv.querySelector(".remove-div-btn");
                                            removeDivBtn.addEventListener("click", function() {
                                                FAQContiner.removeChild(newDiv);
                                            });
                                        }
                                        MaxDivs += 1;
                                    });
                                </script>
                            </section>
                      </div>
                        
                        <div class="justify-content-center row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <a href="https://zhome.com.eg/Admin/Products.php" class="btn btn-md btn-danger w-100 mt-4 mb-0">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Side Card -->
            <div class="col-md-4" id="Side" style="display: grid; height: max-content; gap: 20px;">
                <div class="card mb-4" style="overflow: hidden;height: 435px; border-radius:23px;display:block;">
                    <h3 class="text-uppercase text-sm" style="text-align: center;font-size:20px;margin-top:20px;">Main information</h3>
                    <p class="text-Img-link">Please Make sure that the product information you are filling now are compitable with the design in the provided photo, tap on the image for a full view.</p>
                    <!-- Here we will put an image for the part one requirment with icon + to zoom in or to open it -->
                    <img id="myImg" src="https://zhome.com.eg/Admin/Images/AllPage.png" alt="Snow" style="display:block;margin:auto;width:100%;max-width:300px">

                    <p id="imgLink" class="btn bg-gradient-info">View Full Image</p>
                    <!-- The Modal -->
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

    <script type="text/javascript">
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById("myImg");
        var imgLink = document.getElementById("imgLink");
        var modalImg = document.getElementById("img01");

        img.onclick = function(){
            modal.style.display = "block";
            modalImg.src = this.src;
        }
        imgLink.onclick = function(){
            modal.style.display = "block";
            modalImg.src = img.src;
        }

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() { 
        modal.style.display = "none";
        }


    </script>

@endsection
