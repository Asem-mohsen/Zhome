    <style>
        .slider-OnlineShop .owl-carousel .owl-stage-outer {
            border-radius: 0;
        }
        .product-one__single{
            border: 1px solid rgb(240, 240, 240);
            border-radius: 6px; height: 379px;
            visibility: visible;
            animation-delay: 0.2s;
            animation-name: fadeInUpBig;
            padding: 10px;
        }

        /*Shop Container*/
        @media (max-width: 767px){
            .header-navigation.ShopNav {
                display: none;
            }
            .FilterTransform{
                width: -webkit-fill-available;
                flex: 100% !important;
                max-width: 100% !important;
            }
            .shop_sidebar_area{
                display: flex;
                flex-wrap: wrap;
                width: 100%;
            }
            .shop_grid_area a.btn.btn-info { 
                display: none;
            }
            .widget {
                    width: 50%;
                padding: 20px 0;
            }
            .FilterTransform {
                 transform: translateY(0px) !important; 
            }
            .widget:last-child {
                display: none;
            }
            .nav-side-menu{
                 width: 100%;
            }
            .icon.icon-shape.icon-sm.border-radius-md.text-center.me-2.d-flex.align-items-center{
                display: block !important;
            }
            .shop_grid_product_area{
                 width: 100%;
            }
            .shop_grid_product_area .row{
                width: -webkit-fill-available;
                padding: 16px;
            }
            .shop_grid_product_area .row .item {
                width: 100%;
            }
            .shop_grid_product_area .row .item .product-one__single {
                width: 100%;
            }
            .shop_grid_product_area .row .item .product-one__image > img {
                width: 100%;
                object-fit: contain;
            }
            .Plaforms-flex a{
                 width: 50px;
            }
            section.shop-background {
                /*transform: translateY(-50px)!important;*/
            }
            .BrandDescriptionShop{
                display:none !important;
            }
            #filterOverlay.overlay{
                display:none;
            }
            #FilterShopButton {
                text-align: center;
                display: flex !important;
                border: 1px solid #d4d4d4;
                padding: 9px 4px;
                align-items: center;
                gap: 8px;
                width: -webkit-fill-available;
                border-radius: 4px;
                background-color: white;
                margin: auto;
                justify-content: center;
                font-size: 17px;
                color: #525252;
            }
            #FilterShopButton:foucs{
                outline: 0px auto -webkit-focus-ring-color;
                border: 1px solid #1c839a;
            }
            #FilterShopButton:hover{
                outline: 0px auto -webkit-focus-ring-color;
                border: 1px solid #1c839a;
            }
            .FilterTransform.MainFilter{
                display:none!important;
            }
        }
        .SubCategory-OnlineShop a.ToTheSubPage{
            display: grid;
            justify-content: center;
            align-items: center;
            justify-items: center;
        }
        /*@media (min-width: 1200px){*/
        @media screen and (min-width: 1500px) {
            .container {
                max-width: 1763px !important;
            }
            .shop_sidebar_area{
                width: 193px;
            }

            .shop_grid_product_area .row{
                padding-left: 0px !important;
                gap: 55px !important;
            }
            
            .product-one__single {
                width: 241px !important;
            }
            .col-lg-3 {
                flex: 0 0 18% !important;
            }
            #filterOverlay .FilterTransform{
                padding:0px !important;
            }
        }
    </style>

    <?php $do = isset($_GET['action']) ?  $_GET['action'] : "Manage"; 
    

                    
     if($do == "Manage"){ ?>
        <!-- Header -->
            <section class="shop-background site-banner jarallax" style="padding-bottom: 0px;min-height:100px;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="page-title"><?php echo lang('Shop') ?></h1>
                            <div class="breadcrumbs">
                            <span class="item">
                                <a href="https://zhome.com.eg/Front/OnlineShop.php" style="color: #d1d1d1;"><?php echo lang('Home') ?> /</a>
                            </span>
                                <span class="item" style="color: black;"><?php echo lang('Shop') ?></span>
                            </div>
                        </div>
                    </div>
                    <button id="FilterShopButton" style="margin-top:35px"><i class="fa-solid fa-filter"></i><span><?php echo lang('Filters') ?></span></button>
                </div>
            </section>

        <!-- Filter and Products -->
        <section class="shop_grid_area">
            <div class="container" style="max-width: 1220px;">
                <div class="row Page-flex">
                    
                    <?php  $Button=''; ?>
                    <?php include("./FilterShopSideNav.php"); ?>

                    <!-- Products -->
                    <div class="col-12 col-md-8 col-lg-10">
                        <div class="shop_grid_product_area">
                            <div class="row" style="justify-content: flex-start;gap: 23px;padding-left: 16px;">

                                <!-- Single gallery Item -->
                                <?php
                                    $SelectProduct ="SELECT product.* , brands.* , subcategory.* , 
                                                    product.Name AS Name , product.ID AS ProductID, product.Price AS ProductPrice
                                                    FROM product                                              
                                                    LEFT JOIN subcategory ON subcategory.ID = product.SubCategoryID
                                                    LEFT JOIN brands ON brands.ID = product.BrandID
                                                    ";
                                    $Products = mysqli_query($con , $SelectProduct);
                                    $fetch = mysqli_fetch_assoc($Products);
                                    $count_products = mysqli_num_rows($Products); 
                                    $i = 2;
                                    foreach($Products as $Product){  
                                
                                    $ProductID = $Product['ProductID'];
                                    ?>
    
                                    <div class="item">
                                        <?php  generateProductCard($Product , $ProductID)   ?> 
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <!-- <div class="shop_pagination_area wow fadeInUp" data-wow-delay="1.1s" style="display: flex;justify-content:center;">
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-sm">
                                    <li class="page-item active"><a class="page-link" href="#">01</a></li>
                                    <li class="page-item"><a class="page-link" href="#">02</a></li>
                                    <li class="page-item"><a class="page-link" href="#">03</a></li>
                                </ul>
                            </nav>
                        </div> -->

                    </div>

                </div>
            </div>
        </section>

    <?php }elseif($do == "CategoryFilter"){
            $CategoryID = $_GET['CategoryID'];
            if(isset($CategoryID) && !empty($CategoryID)){
                    $FilterByCategory = "SELECT * FROM category WHERE ID = $CategoryID LIMIT 1";
                    $Filterd = mysqli_query($con , $FilterByCategory);
                    $Category = mysqli_fetch_assoc($Filterd);
                    $CategoryExistID = $Category['ID'];
                    if($CategoryExistID){
                        ?>
                        <!-- Header -->
                        <section class="shop-background site-banner jarallax" style="padding-bottom: 0px;min-height:100px;">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h1 class="page-title">
                                            <?php 
                                                if ($initialLanguage == 'ar') { 
                                                    echo $Category['ArabicName']; 
                                                }else{
                                                     echo $Category['Category'];
                                                }
                                            ?>
                                        </h1>
                                        <div class="breadcrumbs">
                                        <span class="item">
                                            <a href="https://zhome.com.eg/Front/OnlineShop.php" style="color: #d1d1d1;"><?php echo lang('Shop') ?> /</a>
                                        </span>
                                            <span class="item" style="color: black;"><?php echo lang('Category') ?></span>
                                        </div>
                                    </div>
                                </div>
                                <button id="FilterShopButton" style="margin-top:35px"><i class="fa-solid fa-filter"></i><span><?php echo lang('Filters') ?></span></button>
                            </div>
                        </section>
            
                        <!-- Filter and Products -->
                        <section class="shop_grid_area">
                            <div class="container" style="max-width: 1220px;">
                                <div class="row Page-flex">
                                    
                                    <!-- Filter -->
                                    <?php  $Button=''; ?>

                                    <?php include("./FilterShopSideNav.php"); ?>
            
                                    <!-- Products -->
                                    <div class="col-12 col-md-10 col-lg-10" style="margin-top: 20px;">
                                        <div class="boxes-shop box-shop-sub SubCategory-OnlineShop">
                                            <?php 
                                                $Subs = mysqli_query($con , "SELECT subcategory.* , subcategoryimages.* , subcategory.ID AS SubcategoryID FROM subcategory LEFT JOIN subcategoryimages ON subcategoryimages.SubID = subcategory.ID WHERE MainCategoryID = $CategoryID AND Status !=0");
                                                $FetchSubs = mysqli_fetch_assoc($Subs);
                                                $count_subofCategory = mysqli_num_rows($Subs);
                                                if($count_subofCategory > 0){
                                                    foreach ($Subs as $SubOfCategory){
                                                        ?>
                                                            <a class="ToTheSubPage" href="https://zhome.com.eg/Front/Shop.php?action=SubFilter&SubID=<?php echo $SubOfCategory['SubcategoryID'] ?>">
                                                                <!--<div class="box-shop SubCategory-onlineshop" style="background-image: url(../Admin/Images/Uploads/<?php // echo $SubOfCategory['Image'] ?>);">-->
                                                                <!--</div>-->
                                                                <p style="font-size: 17px !important;">
                                                                    <?php 
                                                                        if ($initialLanguage == 'ar') { 
                                                                            echo $SubOfCategory['SubArabicName']; 
                                                                        }else{
                                                                             echo $SubOfCategory['SubName'];
                                                                        }
                                                                    ?>
                                                                </p>
                                                            </a>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </div>
                                        <div class="shop_grid_product_area">
                                            <div class="row" style="justify-content: flex-start;gap: 23px;padding-left: 16px;">
            
                                                <!-- Single gallery Item -->
                                                <?php
                                                $SelectProductFiltered ="SELECT product.* , brands.* , subcategory.* , 
                                                                product.Name AS Name , product.ID AS ProductID, product.Price AS ProductPrice
                                                                FROM product                                            
                                                                LEFT JOIN subcategory ON subcategory.ID = product.SubCategoryID
                                                                LEFT JOIN brands ON brands.ID = product.BrandID
                                                                WHERE subcategory.MainCategoryID = $CategoryID
                                                                LIMIT 12
                                                                ";
                                                $Products = mysqli_query($con , $SelectProductFiltered);
                                                $fetch = mysqli_fetch_assoc($Products);
                                                $count_products = mysqli_num_rows($Products); 
                                                $i = 2;
                                                foreach($Products as $Product){  
                                                    $ProductID = $Product['ProductID'];
                                                    ?>
                    
                                                    <div class="item">
                                                        <?php  generateProductCard($Product , $ProductID)   ?> 
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
            
                                        <!-- Pagination -->
                                        <!-- <div class="shop_pagination_area wow fadeInUp" data-wow-delay="1.1s" style="display: flex;justify-content:center;">
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination pagination-sm">
                                                    <li class="page-item active"><a class="page-link" href="#">01</a></li>
                                                    <li class="page-item"><a class="page-link" href="#">02</a></li>
                                                    <li class="page-item"><a class="page-link" href="#">03</a></li>
                                                </ul>
                                            </nav>
                                        </div> -->
            
                                    </div>
            

                                </div>
                            </div>
                        </section>
            
                        <!-- Selling Product Two Separated -->
                        <section>
                            <div class="SellingProduct-Separated">
                                <div class="ShopNowInCart" style="background-image: url(../Admin/Images/sebastian-scholz-nuki-Fh3Dtg6QX4Q-unsplash3.png);height:285px;align-content: space-evenly;border-radius:4px;width: 751px;">
                                    <h4>
                                        <?php echo lang('Bundles') ?>
                                    </h4>
                                    <a href="https://zhome.com.eg/Front/OnlineShop.php" class="btn btn-secondary" style="height: 41px;"><?php echo lang('MoreInfo') ?></a>
                                </div>
                                <div class="ShopNowInCart" style="background-image: url(../Admin/Images/bence-boros-anapPhJFRhM-unsplash-2.png);height:285px;align-content: space-evenly;border-radius:4px;width: 400px">
                                    <h4>
                                        <?php echo lang('BuildToolShop') ?>
                                    </h4>
                                    <a href="https://zhome.com.eg/Front/OnlineShop.php" class="btn btn-secondary" style="height: 41px;"><?php echo lang('DiscoverNow') ?></a>
                                </div>
                            </div>
                        </section>
        
                        <!-- More About Category -->
                         <div class="container">
                            <div class="text-center" style="margin-bottom: 44px;">
                                <p class="block-title__tag-line text-center"><?php echo lang('MoreAbout'); ?></p>
                                <h2>
                                    <?php 
                                        if ($initialLanguage == 'ar') { 
                                            echo $Category['ArabicName'];
                                        }else{
                                             echo $Category['Category'];
                                        }
                                    ?>
                                </h2>
                            </div>
                        </div>
                        <section class="shop-category">
                            <div class="container">
                                <div class="CatInfo">
                                    <div class="CatInfo-Desc">
                                        <div class="CategoryInMobile" style="display: flex;gap: 20px;width:auto;">
                                            <img class="CategoryImg" src="../Admin/Images/Uploads/<?php echo $Category['MainImage'] ?>" alt="<?php echo $Category['Category'] ?>">
                                            <div style="display: grid;align-self: center;"> 
                                                <p class="Desc">
                                                     <?php 
                                                        if ($initialLanguage == 'ar') { 
                                                            echo $Category['ArabicDescription'];
                                                        }else{
                                                             echo $Category['Description'];
                                                        }
                                                    ?>
                                                </p>
                                                <?php 
                                                    if(isset($Category['OtherDescripition'])){
                                                        if ($initialLanguage == 'ar') { 
                                                             echo "<p class='Desc'>" . $Category['ArabicOtherDescripition'] . "</p>";
                                                        }else{
                                                            echo "<p class='Desc'>" . $Category['OtherDescripition'] . "</p>";
                                                        }
                                                    } 
                                                ?>
                                                <h6><?php echo lang('Brands') ?></h6>
                                                <div class="customer-logos Brands-Categories slider">
                                                    <?php
                                                        $Brands = mysqli_query($con ,"SELECT brands.*, product.* ,subcategory.* FROM product LEFT JOIN brands ON product.BrandID = brands.ID LEFT JOIN subcategory ON subcategory.ID = product.SubCategoryID WHERE subcategory.MainCategoryID = $CategoryID");
                                                        $row = mysqli_fetch_assoc($Brands);
                                                        $CountBrands = mysqli_num_rows($Brands);
                                                        if($CountBrands > 0 ){
                                                            foreach($Brands as $Brand){ ?>
                                                                <div class="slide Brand" style="width: 48px !important;">
                                                                    <img src="../Admin/Images/Uploads/<?php echo $Brand['Logo'] ?>" alt="<?php echo $Brand['Brand'] ?>">
                                                                </div>
                                                            <?php }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </section>
                    <?php
                    }else{
                        header("Location: https://zhome.com.eg/Front/OnlineShop.php");
                    }
                
            }else{
                header("Location: https://zhome.com.eg/Front/OnlineShop.php");
            } ?>

    <?php }elseif($do == "SubFilter"){
            $SubID = $_GET['SubID'];
            if(isset($SubID) && !empty($SubID) ){
                $FilterBySub = "SELECT subcategory.* , subcategoryimages.*, category.* ,category.ID AS CategoryID , category.ArabicName AS CategoryArabicName ,subcategoryimages.Image AS SubImage
                                FROM subcategory                                            
                                LEFT JOIN subcategoryimages ON subcategory.ID = subcategoryimages.SubID
                                LEFT JOIN category ON category.ID = subcategory.MainCategoryID
                                WHERE subcategory.ID = $SubID
                                ";
                $Filterd = mysqli_query($con , $FilterBySub);
                $SubCategory = mysqli_fetch_assoc($Filterd);
                $SubCategoryExistID = $SubCategory['ID'];
                if($SubCategoryExistID){
                        ?>
                            <!-- Header -->
                            <section class="shop-background site-banner jarallax" style="padding-bottom: 0px;min-height:100px;">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h1 class="page-title">
                                             <?php 
                                                if ($initialLanguage == 'ar') { 
                                                    echo $SubCatgoery['SubArabicName'] ;
                                                }else{
                                                    echo $SubCatgoery['SubName'];
                                                }
                                            ?>
                                            </h1>
                                            <div class="breadcrumbs">
                                            <span class="item">
                                                <a href="https://zhome.com.eg/Front/Shop.php?action=CategoryFilter&CategoryID=<?php echo $SubCategory['CategoryID'] ?>" style="color: #d1d1d1;">
                                                    <?php 
                                                        if ($initialLanguage == 'ar') { 
                                                            echo $SubCatgoery['CategoryArabicName'] ;
                                                        }else{
                                                            echo $SubCatgoery['Category'];
                                                        }
                                                    ?>
                                                    /
                                                </a>
                                            </span>
                                                <span class="item" style="color: black;">
                                                <?php 
                                                    if ($initialLanguage == 'ar') { 
                                                        echo $SubCatgoery['SubArabicName'] ;
                                                    }else{
                                                        echo $SubCatgoery['SubName'];
                                                    }
                                                ?>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <button id="FilterShopButton" style="margin-top: 35px;"><i class="fa-solid fa-filter"></i><span><?php echo lang('Filters') ?></span></button>
                                </div>
                            </section>
                            
                            <!-- Filter and Products -->
                            <section class="shop_grid_area">
                                <div class="container" style="max-width: 1220px;">
                                    <div class="row Page-flex">
                                        
                                        <!-- Filter -->
                                       <?php  $Button=''; 
                                       include("./FilterShopSideNav.php"); ?>
                
                                        
                                        <!-- Products -->
                                        <div class="col-12 col-md-10 col-lg-10">
                                            <div class="shop_grid_product_area">
                                                <div class="row" style="justify-content: flex-start;gap: 23px;padding-left: 23px;">
                
                                                    <!-- Single gallery Item -->
                                                    <?php
                                                    $SelectProductFiltered ="SELECT product.* , brands.* , subcategory.* , 
                                                                    product.Name AS Name , product.ID AS ProductID, product.Price AS ProductPrice
                                                                    FROM product                                            
                                                                    LEFT JOIN subcategory ON subcategory.ID = product.SubCategoryID
                                                                    LEFT JOIN brands ON brands.ID = product.BrandID
                                                                    WHERE product.SubCategoryID = $SubID
                                                                    LIMIT 12
                                                                    ";
                                                    $Products = mysqli_query($con , $SelectProductFiltered);
                                                    $fetch = mysqli_fetch_assoc($Products);
                                                    $count_products = mysqli_num_rows($Products); 
                                                    $i = 2;
                                                    foreach($Products as $Product){  
                                                
                                                        $ProductID = $Product['ProductID'];
                                                        $PriceSale = mysqli_query($con  , "SELECT * FROM sale WHERE ProductID = $ProductID"); 
                                                        $Sale = mysqli_fetch_assoc($PriceSale);
                                                        $Count_Sale = mysqli_num_rows($PriceSale);
                        
                                                        ?>
                        
                                                        <div class="item">
                                                            <?php  generateProductCard($Product , $ProductID)   ?> 
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                
                            <!-- Selling Product Two Separated -->
                            <section>
                                <div class="SellingProduct-Separated">
                                    <div class="ShopNowInCart" style="background-image: url(../Admin/Images/sebastian-scholz-nuki-Fh3Dtg6QX4Q-unsplash3.png);height:285px;align-content: space-evenly;border-radius:4px;width: 751px;">
                                        <h4>
                                            <?php echo lang('Bundles') ?>
                                        </h4>
                                        <a href="https://zhome.com.eg/Front/OnlineShop.php" class="btn btn-secondary" style="height: 41px;"><?php echo lang('MoreInfo') ?></a>
                                    </div>
                                    <div class="ShopNowInCart" style="background-image: url(../Admin/Images/bence-boros-anapPhJFRhM-unsplash-2.png);height:285px;align-content: space-evenly;border-radius:4px;width: 400px">
                                        <h4>
                                            <?php echo lang('BuildToolShop') ?>
                                        </h4>
                                        <a href="https://zhome.com.eg/Front/OnlineShop.php" class="btn btn-secondary" style="height: 41px;"><?php echo lang('DiscoverNow') ?></a>
                                    </div>
                                </div>
                            </section>
                         <?php 
                }else{
                        header("Location: https://zhome.com.eg/Front/OnlineShop.php");
                }
            }else{
                header("Location: https://zhome.com.eg/Front/OnlineShop.php");
            } ?>

    <?php }elseif($do == "BrandFilter"){
        $BrandID = $_GET['BrandID'];
        if(isset($BrandID) && !empty($BrandID) ){
            $FilterByBrands = "SELECT brands.* , brandsimages.*, brands.ID AS BrandID
                                    FROM brands                                            
                                    LEFT JOIN brandsimages ON brands.ID = brandsimages.BrandID
                                    WHERE brands.ID = $BrandID
                                    ";
            $Filterd = mysqli_query($con , $FilterByBrands);
            $Brands = mysqli_fetch_assoc($Filterd);
            $BrandsExistID = $Brands['BrandID'];
            if($BrandsExistID){
                ?>
                    <!-- Header -->
                    <section class="shop-background site-banner jarallax" style="padding-bottom: 0px;min-height:100px;">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="../Admin/Images/Uploads/<?php echo $Brands['Logo'] ?>" class="Brand-Logo" alt="<?php echo $Brands['Brand'] ?>">
                                    <div class="breadcrumbs">
                                        <span class="item">
                                            <a href="https://zhome.com.eg/Front/Brands.php" style="color: #d1d1d1;"><?php echo lang('Brands') ?> /</a>
                                        </span>
                                            <span class="item" style="color: black;"><?php echo $Brands['Brand'] ?></span>
                                            <br>
                                            <br>
                                            <!--<span class="item BrandDescriptionShop">-->
                                                <?php // echo $Brands['MainDescription']  ?>
                                            <!--</span>-->
                                    </div>
                                </div>
                            </div>
                            <button id="FilterShopButton"><i class="fa-solid fa-filter"></i><span><?php echo lang('Filters') ?></span></button>
                        </div>
                    </section>
            
                    <!-- Filter and Products -->
                    <section class="shop_grid_area">
                        <div class="container" style="max-width: 1220px;">
                            <div class="row Page-flex">
                                
                                <!-- Filter -->
                                <?php  $Button=''; ?>
            
                                <?php include("./FilterShopSideNav.php"); ?>
            
                                <!-- Products -->
                                <div class="col-12 col-md-10 col-lg-10">
                                    <div class="shop_grid_product_area">
                                        <div class="row" style="justify-content: flex-start;gap: 23px;padding-left: 21px;">
            
                                            <!-- Single gallery Item -->
                                            <?php
                                            $SelectProductFiltered ="SELECT product.* , brands.* , subcategory.* , 
                                                            product.Name AS Name , product.ID AS ProductID, product.Price AS ProductPrice
                                                            FROM product                                            
                                                            LEFT JOIN subcategory ON subcategory.ID = product.SubCategoryID
                                                            LEFT JOIN brands ON brands.ID = product.BrandID
                                                            WHERE product.BrandID = $BrandID
                                                            LIMIT 12
                                                            ";
                                            $Products = mysqli_query($con , $SelectProductFiltered);
                                            $fetch = mysqli_fetch_assoc($Products);
                                            $count_products = mysqli_num_rows($Products); 
                                            $i = 2;
                                            foreach($Products as $Product){  
                                            
                                                $ProductID = $Product['ProductID'];
                                                ?>
                
                                                <div class="item">
                                                    <?php  generateProductCard($Product , $ProductID) ?>
                                                </div>
                                        <?php } ?>
                                        </div>
                                    </div>
                                    <!-- Pagination -->
                                    <!-- <div class="shop_pagination_area wow fadeInUp" data-wow-delay="1.1s" style="display: flex;justify-content:center;">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination pagination-sm">
                                                <li class="page-item active"><a class="page-link" href="#">01</a></li>
                                                <li class="page-item"><a class="page-link" href="#">02</a></li>
                                                <li class="page-item"><a class="page-link" href="#">03</a></li>
                                            </ul>
                                        </nav>
                                    </div> -->
            
                                </div>
                            </div>
                        </div>
                    </section>
            
                    <!-- Selling Product Two Separated -->
                    <section>
                        <div class="SellingProduct-Separated">
                            <div class="ShopNowInCart" style="background-image: url(../Admin/Images/sebastian-scholz-nuki-Fh3Dtg6QX4Q-unsplash3.png);height:285px;align-content: space-evenly;border-radius:4px;width: 751px;">
                                <h4>
                                    <?php echo lang('Bundles') ?>
                                </h4>
                                <a href="https://zhome.com.eg/Front/OnlineShop.php" class="btn btn-secondary" style="height: 41px;"><?php echo lang('MoreInfo') ?></a>
                            </div>
                            <div class="ShopNowInCart" style="background-image: url(../Admin/Images/bence-boros-anapPhJFRhM-unsplash-2.png);height:285px;align-content: space-evenly;border-radius:4px;width: 400px">
                                <h4>
                                    <?php echo lang('BuildToolShop') ?>
                                </h4>
                                <a href="https://zhome.com.eg/Front/OnlineShop.php" class="btn btn-secondary" style="height: 41px;"><?php echo lang('DiscoverNow') ?></a>
                            </div>
                        </div>
                    </section>
            
                    <!-- More Brands -->
                    <section class="shop-category">
                        <div class="container">
                            <div class="text-center" style="margin-bottom: 44px;">
                                <p class="block-title__tag-line text-center">Zhome</p>
                                <h2><?php echo lang('MoreBrands') ?></h2>
                            </div>
                        </div>
                        <div class="Product-Platforms" style="margin-bottom: 0px;">
                            <?php 
                                $SelectBrands = "SELECT * FROM brands WHERE brands.ID != $BrandID";
                                $BrandsMore = mysqli_query($con , $SelectBrands);
                                $count_BrandsMore = mysqli_num_rows($BrandsMore);
                                if($count_BrandsMore > 0){
                                    foreach($BrandsMore as $BrandMore){ ?>
                                        <a href="https://zhome.com.eg/Front/Shop.php?action=BrandFilter&BrandID=<?php echo $BrandMore['ID'] ?>">
                                            <div class="Brand-Shop">
                                                <img src="../Admin/Images/Uploads/<?php echo $BrandMore['Logo'] ?>" style="padding: 6px;" alt="<?php echo $BrandMore['Brand'] ?>">
                                            </div>
                                        </a>
            
                                        <?php 
                                    }
                                }
                            ?>
                        </div>
                    </section>

                <?php
            }else{
                header("Location: https://zhome.com.eg/Front/OnlineShop.php");
            }
        }else{
            header("Location: https://zhome.com.eg/Front/OnlineShop.php");
        } ?>

    <?php }elseif($do == "PlatformFilter"){

            $PlatformID = $_GET['PlatformID'];
            if(isset($PlatformID) && !empty($PlatformID)){
                $FilterByPlatforms = "SELECT * FROM platform WHERE ID = $PlatformID ";
                $Filterd = mysqli_query($con , $FilterByPlatforms);
                $Platforms = mysqli_fetch_assoc($Filterd);
                $PlatformsExistID = $Platforms['ID'];
                 if($PlatformsExistID){
                        ?>
                            <!-- Header -->
                            <section class="shop-background site-banner jarallax" style="padding-bottom: 0px;min-height:100px;">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <img src="../Admin/Images/Uploads/<?php echo $Platforms['Logo'] ?>" class="Brand-Logo" alt="<?php echo $Platforms['Platform'] ?>o">
                                            <div class="breadcrumbs">
                                                <span class="item">
                                                    <a href="https://zhome.com.eg/Front/Platforms.php" style="color: #d1d1d1;"><?php echo lang('Platforms') ?> /</a>
                                                </span>
                                                    <span class="item" style="color: black;"><?php echo $Platforms['Platform'] ?></span>
                                                    <br>
                                                    <br>
                                                    <!--<span class="item BrandDescriptionShop">-->
                                                        <?php //  echo $Platforms['MainDescription']  ?>
                                                    <!--</span>-->
                                            </div>
                                        </div>
                                    </div>
                                    <button id="FilterShopButton"><i class="fa-solid fa-filter"></i><span><?php echo lang('Filters') ?></span></button>
                                </div>
                            </section>
                    
                            <!-- Filter and Products -->
                            <section class="shop_grid_area">
                                <div class="container" style="max-width: 1220px;">
                                    <div class="row Page-flex">
                                    
                                        <!-- Filter -->
                                        <?php  $Button=''; ?>
                    
                                        <?php include("./FilterShopSideNav.php"); ?>
                    
                    
                                        <!-- Products -->
                                        <div class="col-12 col-md-10 col-lg-10">
                                            <div class="shop_grid_product_area">
                                                <div class="row" style="justify-content: flex-start;gap: 23px;padding-left: 21px;">
                    
                                                    <!-- Single gallery Item -->
                                                    <?php
                                                    $SelectProductFiltered ="SELECT product.* , brands.* , subcategory.* , productplatfrom.*,
                                                                            product.Name AS Name , product.ID AS ProductID, product.Price AS ProductPrice
                                                                            FROM product                                            
                                                                            LEFT JOIN subcategory ON subcategory.ID = product.SubCategoryID
                                                                            LEFT JOIN brands ON brands.ID = product.BrandID
                                                                            LEFT JOIN productplatfrom ON productplatfrom.ProductID = product.ID
                                                                            WHERE productplatfrom.PlatformID = $PlatformID
                                                                            LIMIT 12
                                                                            ";
                                                    $Products = mysqli_query($con , $SelectProductFiltered);
                                                    $fetch = mysqli_fetch_assoc($Products);
                                                    $count_products = mysqli_num_rows($Products); 
                                                    $i = 2;
                                                    foreach($Products as $Product){  
                                                    
                                                        $SaleProductID = $Product['ProductID'];
                                                        ?>
                        
                                                        <div class="item">
                                                            <?php  generateProductCard($Product , $SaleProductID) ?>
                                                        </div>
                                                <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                    
                            <!-- Selling Product Two Separated -->
                            <section>
                                <div class="SellingProduct-Separated">
                                    <div class="ShopNowInCart" style="background-image: url(../Admin/Images/sebastian-scholz-nuki-Fh3Dtg6QX4Q-unsplash3.png);height:285px;align-content: space-evenly;border-radius:4px;width: 751px;">
                                        <h4>
                                            <?php echo lang('Bundles') ?>
                                        </h4>
                                        <a href="https://zhome.com.eg/Front/OnlineShop.php" class="btn btn-secondary" style="height: 41px;"><?php echo lang('MoreInfo') ?></a>
                                    </div>
                                    <div class="ShopNowInCart" style="background-image: url(../Admin/Images/bence-boros-anapPhJFRhM-unsplash-2.png);height:285px;align-content: space-evenly;border-radius:4px;width: 400px">
                                        <h4>
                                           <?php echo lang('BuildToolShop') ?>
                                        </h4>
                                        <a href="https://zhome.com.eg/Front/OnlineShop.php" class="btn btn-secondary" style="height: 41px;"><?php echo lang('DiscoverNow') ?></a>
                                    </div>
                                </div>
                            </section>
                    
                            <!-- More Platforms -->
                            <section class="shop-category">
                                <div class="container">
                                    <div class="text-center" style="margin-bottom: 44px;">
                                        <p class="block-title__tag-line text-center">Zhome</p>
                                        <h2> <?php echo lang('MorePlatforms') ?></h2>
                                    </div>
                                </div>
                                <div class="Product-Platforms" style="margin-bottom: 0px;">
                                    <?php 
                                        $SelectPlatfroms = "SELECT * FROM platform WHERE platform.ID != $PlatformID";
                                        $Platfroms = mysqli_query($con , $SelectPlatfroms);
                                        $count_Platfroms = mysqli_num_rows($Platfroms);
                                        if($count_Platfroms > 0){
                                            foreach($Platfroms as $Platform){ ?>
                                                <a href="https://zhome.com.eg/Front/Shop.php?action=PlatformFilter&PlatformID=<?php echo $Platform['ID'] ?>">
                                                    <div class="platform">
                                                        <img src="../Admin/Images/Uploads/<?php echo $Platform['Logo'] ?>" style="padding: 6px;" alt="<?php echo $Platform['Platform'] ?>">
                                                        <p><?php echo $Platform['Platform'] ?></p>
                                                    </div>
                                                </a>
                    
                                                <?php 
                                            }
                                        }
                                    ?>
                                </div>
                            </section>
                        <?php
                                        
                     
                 }else{
                    header("Location: https://zhome.com.eg/Front/OnlineShop.php");
                }
                    
            }else{
                header("Location: https://zhome.com.eg/Front/OnlineShop.php");
            }
        ?>

    <?php }elseif($do == "InstallationFilter"){ ?>
            <!-- Header -->
            <section class="shop-background site-banner jarallax" style="padding-bottom: 0px;min-height:100px;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="page-title"><?php echo lang('InstallationProducts') ?></h1>
                            <div class="breadcrumbs">
                            <span class="item">
                                <a href="https://zhome.com.eg/Front/Services.php" style="color: #d1d1d1;"><?php echo lang('Services') ?> / <?php echo lang('InstallationProducts') ?></a>
                            </span>
                                <span class="item" style="color: black;"><?php echo lang('Installation') ?></span>
                            </div>
                        </div>
                    </div>
                    <button id="FilterShopButton"><i class="fa-solid fa-filter"></i><span><?php echo lang('Filters') ?></span></button>
                </div>
            </section>

            <!-- Filter and Products -->
            <section class="shop_grid_area">
                <div class="container" style="max-width: 1220px;">
                    <div class="row Page-flex"> 
                        
                        <!-- Filter -->
                        
                        <?php include("./FilterShopSideNav.php"); ?>

                        <!-- Products -->
                        <div class="col-12 col-md-8 col-lg-10">
                            <div class="shop_grid_product_area">
                                <div class="row" style="justify-content: flex-start;gap: 23px;">

                                    <!-- Single gallery Item -->
                                    <?php
                                    $SelectProductFiltered ="SELECT product.* , brands.* , subcategory.* , 
                                                    product.Name AS Name , product.ID AS ProductID, product.Price AS ProductPrice
                                                    FROM product                                            
                                                    LEFT JOIN subcategory ON subcategory.ID = product.SubCategoryID
                                                    LEFT JOIN brands ON brands.ID = product.BrandID
                                                    WHERE product.InstallationCost != NULL || product.InstallationCost != 0
                                                    LIMIT 12
                                                    ";
                                    $Products = mysqli_query($con , $SelectProductFiltered);
                                    $fetch = mysqli_fetch_assoc($Products);
                                    $count_products = mysqli_num_rows($Products); 
                                    $i = 2;
                                    foreach($Products as $Product){  
                                
                                        $ProductID = $Product['ProductID'];
                                        $PriceSale = mysqli_query($con  , "SELECT * FROM sale WHERE ProductID = $ProductID"); 
                                        $Sale = mysqli_fetch_assoc($PriceSale);
                                        $Count_Sale = mysqli_num_rows($PriceSale);
        
                                        ?>
        
                                        <div class="item">
                                            <?php  generateProductCard($Product , $ProductID) ?>
                                        </div>
                                <?php } ?>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <!-- <div class="shop_pagination_area wow fadeInUp" data-wow-delay="1.1s" style="display: flex;justify-content:center;">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination pagination-sm">
                                        <li class="page-item active"><a class="page-link" href="#">01</a></li>
                                        <li class="page-item"><a class="page-link" href="#">02</a></li>
                                        <li class="page-item"><a class="page-link" href="#">03</a></li>
                                    </ul>
                                </nav>
                            </div> -->

                        </div>
                    </div>
                </div>
            </section>

            <!-- Selling Product Two Separated -->
            <section>
                <div class="SellingProduct-Separated">
                    <div class="ShopNowInCart" style="background-image: url(../Admin/Images/sebastian-scholz-nuki-Fh3Dtg6QX4Q-unsplash3.png);height:285px;align-content: space-evenly;border-radius:4px;width: 751px;">
                        <h4>
                            <?php echo lang('Bundles') ?>
                        </h4>
                        <a href="https://zhome.com.eg/Front/OnlineShop.php" class="btn btn-secondary" style="height: 41px;"><?php echo lang('MoreInfo') ?></a>
                    </div>
                    <div class="ShopNowInCart" style="background-image: url(../Admin/Images/bence-boros-anapPhJFRhM-unsplash-2.png);height:285px;align-content: space-evenly;border-radius:4px;width: 400px">
                        <h4>
                            <?php echo lang('BuildToolShop') ?>
                        </h4>
                        <a href="https://zhome.com.eg/Front/Proposal.php" class="btn btn-secondary" style="height: 41px;"><?php echo lang('DiscoverNow') ?></a>
                    </div>
                </div>
            </section>

            <!-- More About Installation -->
            <section class="shop-category">
                <?php 
                    $Link = "https://zhome.com.eg/" . $_SERVER['REQUEST_URI'];
                    $SelectService = "SELECT * FROM services WHERE Link = '$Link'";
                    $Services = mysqli_query($con , $SelectService);
                    $Service= mysqli_fetch_assoc($Services);
                    $count_Services =mysqli_num_rows($Services);
                    if($count_Services > 0){ ?>

                        <div class="container">
                            <div class="text-center" style="margin-bottom: 44px;">
                                <p class="block-title__tag-line text-center">Zhome</p>
                                <h2><?php echo $Service['Name'] ?></h2>
                            </div>
                        </div>
                        <div class="CatInfo" style="align-items: center;">
                            <img class="CategoryImg" src="../Admin/Images/<?php echo $Service['Image'] ?>" style="height: 400px;" alt="<?php echo $Service['Name'] ?>">
                            <div class="CatInfo-Desc">
                                <p class="Desc"><?php echo $Service['Description'] ?></p>
                            </div>
                        </div>
                        <?php
                    }
                ?>
            </section>
            
    <?php }elseif($do == "Sale"){ ?>
        <style>
        @media (min-width: 992px){
            .shop_grid_product_area .row {
                gap: 12px !important;
            }
        }
        </style>
            <!-- Header -->
            <section class="shop-background site-banner jarallax" style="padding-bottom: 0px;min-height:100px;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="page-title"><?php echo lang('Sales') ?></h1>
                            <div class="breadcrumbs">
                            <span class="item">
                                <a href="https://zhome.com.eg/Front/OnlineShop.php" style="color: #d1d1d1;"><?php echo lang('Shop') ?> /</a>
                            </span>
                                <span class="item" style="color: black;"><?php echo lang('Sales') ?></span>
                            </div>
                        </div>
                    </div>
                    <button id="FilterShopButton"><i class="fa-solid fa-filter"></i><span><?php echo lang('Filters') ?></span></button>
                </div>
            </section>

            <!-- Filter and Products -->
            <section class="shop_grid_area">
                <div class="container" style="max-width: 1220px;">
                    <div class="row Page-flex">
                        
                        <!-- Filters -->
                        <?php include("./FilterShopSideNav.php"); ?>

                        <!-- Products -->
                        <div class="col-12 col-md-8 col-lg-10" style="margin-top: 40px;">
                            <div class="shop_grid_product_area">
                                <div class="row" style="justify-content: flex-start;gap: 23px;">

                                    <!-- Single gallery Item -->
                                    <?php
                                    $SelectProductFiltered ="SELECT product.* , brands.* , subcategory.* , sale.*, 
                                                    product.Name AS Name , product.ID AS ProductID, product.Price AS ProductPrice
                                                    FROM product                                            
                                                    LEFT JOIN subcategory ON subcategory.ID = product.SubCategoryID
                                                    LEFT JOIN brands ON brands.ID = product.BrandID
                                                    JOIN sale ON sale.ProductID = product.ID
                                                    
                                                    LIMIT 12
                                                    ";
                                    $SaleOnProduct = mysqli_query($con , $SelectProductFiltered);
                                    $fetch = mysqli_fetch_assoc($SaleOnProduct);
                                    $count_products = mysqli_num_rows($SaleOnProduct); 
                                    $i = 2;
                                    foreach($SaleOnProduct as $Product){
                                        $ProductID = $Product['ProductID'];
                                        ?>
                                        
                                        <div class="col-lg-3 col-md-6 wow fadeInUpBig" style="height: 379px;"  data-wow-delay="0.<?php echo $i++ ?>s">
                                            <div class="item">
                                                <a href="https://zhome.com.eg/Front/ProductDetails.php?ProductID=<?php echo $Product['ProductID'] ?>">
                                                    <?php generateSaleProductCard($Product , $ProductID)  ?> 
                                                </a>
                                            </div>
                                        </div>

                                    <?php } ?>
                                </div>
                            </div>
                            <!-- Pagination -->
                            <!-- <div class="shop_pagination_area wow fadeInUp" data-wow-delay="1.1s" style="display: flex;justify-content:center;">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination pagination-sm">
                                        <li class="page-item active"><a class="page-link" href="#">01</a></li>
                                        <li class="page-item"><a class="page-link" href="#">02</a></li>
                                        <li class="page-item"><a class="page-link" href="#">03</a></li>
                                    </ul>
                                </nav>
                            </div> -->

                        </div>
                    </div>
                </div>
            </section>

            <!-- Selling Product Two Separated -->
            <section>
                <div class="SellingProduct-Separated">
                    <div class="ShopNowInCart" style="background-image: url(../Admin/Images/sebastian-scholz-nuki-Fh3Dtg6QX4Q-unsplash3.png);height:285px;align-content: space-evenly;border-radius:4px;width: 751px;">
                        <h4>
                            <?php echo lang('Bundles') ?>
                        </h4>
                        <a href="https://zhome.com.eg/Front/OnlineShop.php" class="btn btn-secondary" style="height: 41px;"><?php echo lang('MoreInfo') ?></a>
                    </div>
                    <div class="ShopNowInCart" style="background-image: url(../Admin/Images/bence-boros-anapPhJFRhM-unsplash-2.png);height:285px;align-content: space-evenly;border-radius:4px;width: 400px">
                        <h4>
                            <?php echo lang('BuildToolShop') ?>
                        </h4>
                        <a href="https://zhome.com.eg/Front/OnlineShop.php" class="btn btn-secondary" style="height: 41px;"><?php echo lang('DiscoverNow') ?></a>
                    </div>
                </div>
            </section>

    <?php }elseif($do == "ApplyFilter"){ ?>
            <?php 
            
            // Function to get products based on selected filters
            function getFilteredProducts($con, $categoryIDs, $brandIDs, $platformIDs, $technologyIDs, $PriceRange) {
                $sql = "SELECT
                            product.ID AS ProductID,
                            product.Name AS Name,
                            product.Price AS ProductPrice,
                            GROUP_CONCAT(DISTINCT producttechnology.Technology) AS Technologies,
                            subcategory.*, brands.*,
                             GROUP_CONCAT(DISTINCT productplatfrom.PlatformID) AS PlatformsColumn,
                             GROUP_CONCAT(DISTINCT productplatfrom.ProductID) AS ProductsPlatformColumn,
                            product.*
                        FROM product
                        LEFT JOIN subcategory ON subcategory.ID = product.SubCategoryID
                        LEFT JOIN brands ON brands.ID = product.BrandID
                        LEFT JOIN productplatfrom ON productplatfrom.ProductID = product.ID
                        LEFT JOIN producttechnology ON producttechnology.ProductID = product.ID
                        WHERE 1
                        ";
            
                // Check if CategoryIDs are provided
                if (!empty($categoryIDs)) {
                    $categoryIDs = implode(',', $categoryIDs);
                    $sql .= " AND subcategory.MainCategoryID IN ($categoryIDs)";
                }
                
                // Check if BrandIDs are provided
                if (!empty($brandIDs)) {
                    $brandIDs = implode(',', $brandIDs);
                    $sql .= " AND brands.ID IN ($brandIDs)";
                }
            
                // Check if PlatformIDs are provided
                if (!empty($platformIDs)) {
                    $platformIDs = implode(',', $platformIDs);
                    $sql .= " AND productplatfrom.PlatformID IN ($platformIDs)";
                }
            
                // Check if TechnologyIDs are provided
                if (!empty($technologyIDs)) {
                    $technologyIDs = "'" . implode("','", $technologyIDs) . "'";
                    $sql .= " AND producttechnology.Technology IN ($technologyIDs)";
                }
                
                // Check if PriceRange is provided
                if (!empty($PriceRange) && count($PriceRange) === 2) {
                    $minValue = $PriceRange[0];
                    $maxValue = $PriceRange[1];
                    if (is_numeric($minValue) && is_numeric($maxValue)) {
                        $sql .= " AND product.Price BETWEEN $minValue AND $maxValue";
                    }
                }
                
                 $sql .= " GROUP BY product.ID"; 
                 $Products = mysqli_query($con, $sql);
                 
                // Check if there are no products
                if (!$Products || mysqli_num_rows($Products) === 0) {
                    return [];
                }
            return $Products;
            }
            // Get values from URL parameters
            $categoryIDs = isset($_GET['CategoryIDs']) ? explode(',', $_GET['CategoryIDs']) : [];
            $brandIDs = isset($_GET['BrandIDs']) ? explode(',', $_GET['BrandIDs']) : [];
            $platformIDs = isset($_GET['PlatformIDs']) ? explode(',', $_GET['PlatformIDs']) : [];
            $technologyIDs = isset($_GET['TechnologyIDs']) ? explode(',', $_GET['TechnologyIDs']) : [];
            $PriceRange = isset($_GET['PriceBetween']) ? explode(',', $_GET['PriceBetween']) : [];

            
            $filteredProducts = getFilteredProducts($con, $categoryIDs ,$brandIDs, $platformIDs, $technologyIDs , $PriceRange);

            ?>

            <!-- Header -->
            <section class="shop-background site-banner jarallax" style="padding-bottom: 0px;min-height:100px;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="page-title"><?php echo lang('Shop') ?></h1>
                            <div class="breadcrumbs">
                            <span class="item">
                                <a href="https://zhome.com.eg/Front/OnlineShop.php" style="color: #d1d1d1;"><?php echo lang('Home') ?> /</a>
                            </span>
                                <span class="item" style="color: black;"><?php echo lang('Shop') ?></span>
                            </div>
                        </div>
                    </div>
                    <button id="FilterShopButton" style="margin-top: 35px;"><i class="fa-solid fa-filter"></i><span><?php echo lang('Filters') ?></span></button>
                </div>
            </section>
            
            
            
            <!-- Filter and Products -->
            <section class="shop_grid_area">
                <div class="container" style="max-width: 1220px;">
                    <div class="row Page-flex">
                        
                        <?php  $Button=''; ?>
    
    
                        <?php include("./FilterShopSideNav.php"); ?>
    
                        <!-- Products -->
                        <div class="col-12 col-md-8 col-lg-10">
                            <div class="shop_grid_product_area">
                                <div class="row" style="justify-content: flex-start;gap: 23px;padding-left: 16px;">
    
                                    <!-- Single gallery Item -->
                                    <?php
                                    if (empty($filteredProducts)) {
                                        echo '<div class="no-products-message">
                                        <img src="../Admin/Images/Uploads/no-product-found.png" alt="No Products Found">
                                                </div>';
                                    } else {
                                        $i = 2;
                                        foreach($filteredProducts as $Product){  
                                            $ProductID = $Product['ProductID'];
                                        ?>
        
                                        <div class="item">
                                            <?php  generateProductCard($Product , $ProductID)   ?> 
                                        </div>
                                    <?php } 
                                    }?>
                                </div>
                            </div>
    
                        </div>
    
                    </div>
                </div>
            </section>
            
            
        <?php
    }else{
        header("Location: ./OnlineShop.php");
    } ?>
<?php include "./Footer.php"; ?>

    <!-- Add to Cart -->
    <script>
        updateCartCount();
    </script>

    <!-- Logo Brands Slider -->
    <script>
        $(document).ready(function(){
            $('.customer-logos').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 1500,
                arrows: false,
                dots: false,
                variableWidth: true,
                pauseOnHover: false,
                responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 4
                    }
                }, {
                    breakpoint: 520,
                    settings: {
                        slidesToShow: 3
                    }
                }]
            });
        });
    </script>
    
    <script>
  $(document).ready(function () {
    setupCollapseBehaviorTechnologies();
    setupCollapseBehaviorCategories();
    setupCollapseBehaviorBrands();
    setupCollapseBehaviorPlatforms();

  });
    </script>