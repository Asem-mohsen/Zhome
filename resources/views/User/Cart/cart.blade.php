if(isset($_SESSION['UserID'])){
        $UserID = $_SESSION['UserID'];
        $SessionID = session_id();
        $UserCart = "SELECT orders.*, product.*, user.* ,
                    product.Quantity AS MaxQuantity , orders.Quantity AS OrderedQuantity , product.ID AS ProductRealID, product.Name AS ProductName, orders.Price AS OrderPrice , product.Price AS ProductPrice , user.Name AS UserName
                    FROM orders 
                    LEFT JOIN user ON orders.UserID = user.ID 
                    LEFT JOIN product ON orders.ProductID = product.ID
                    WHERE UserID = $UserID AND user.SessionID = '$SessionID' AND orders.Status = 2 
                    ";
        $CartRun = mysqli_query($con , $UserCart);
        $fetch = mysqli_fetch_assoc($CartRun);
        $CountCart = mysqli_num_rows($CartRun);
    }else{
        $UserID = session_id();
        $UserCart = "SELECT orders.*, product.*, user.* ,
                    product.Quantity AS MaxQuantity, orders.Quantity AS OrderedQuantity , product.ID AS ProductRealID, product.Name AS ProductName ,orders.Price AS OrderPrice , product.Price AS ProductPrice
                    FROM orders 
                    LEFT JOIN user ON orders.UserID = user.ID 
                    LEFT JOIN product ON orders.ProductID = product.ID
                    WHERE CartID = '$UserID' AND orders.Status = 2 
                    ";
        $CartRun = mysqli_query($con , $UserCart);
        $fetch = mysqli_fetch_assoc($CartRun);
        $CountCart = mysqli_num_rows($CartRun);
    }
    ?>
    <link rel="stylesheet" href="../Admin/assets/css/argon-dashboard.css?v=1">
    <!-- Nav style -->
    <style>
        .slider-OnlineShop .owl-carousel .owl-stage-outer {
        border-radius: 0;
        }
       .Userform .row {
            padding-right: 15px;
            padding-left: 15px;
       }
       div.Checkout .Userform .form-group {
            display: grid;
            align-items: center;
            gap: 4px;
            padding:0;
        }
        div.Checkout .Userform .form-group label {
            margin: 0;
            width: 83px;
        }
         @media (max-width: 767px) {
            .related-product__carousel .owl-item {
                width: 225px !important;
            }
            .col-lg-12 .ShopNowInCart#ShopNowInCheckout {
                height: auto;
               margin-top: 22px !important;
            }   
            .CardCarouselCart{
               height: 400px;
                padding: 0;
                margin: 25px 0;
             }
             .Splitted div.Image-One {
                padding: 20px 0 !important;
            }
            .topping{
                display: grid;
                justify-content: center;
                text-align: center;
            }
            div.Checkout .Summery ul:nth-child(odd) {
                width: 100%;
            }
            div.Checkout .Summery ul {
                width: 100%;
            }
                #wizard .content.clearfix .row .col-md-4 , #wizard .content.clearfix .row .col-md-12,  .row .col-md-6 {
                    padding:0 !important;
                }
                .wizard .actions > ul {
                    gap: 20px;
                } 
                 .wizard .actions li a  {
                    width: 150px  !important;
                    text-align: center;
                    font-style: 15px;
                    font-weight: bold;
                    text-decoration: none;
                    text-align: center;
                }
               .wizard .actions li:not(.disabled) + li, .wizard .actions li:not(:first-child):last-child {
                     margin-left: 0px !important; 
                }
                .PromocodeInput .form-group{
                    display:grid !important;
                }
                .PayWithCardButton .card-line {
                    width: 65px !important;
                    height: 13px !important;
                }
                .PayWithCardButton .left-side {
                    background-color: #5de2a3;
                    width: 100px !important;
                }
                .PayWithCardButton .new {
                    font-size: 17px;
                    color: #67748e;
                    padding: 9px;
                    margin:0 !important;
                }
                .PayWithCardButton {
                    display: flex;
                    width: auto !important;
                    height: 47px !important;

                }
        }
    </style>

    <!-- Header -->
    <div class="container">
        <ul class="list-unstyled thm-breadcrumb thm-breadcrumb__two">
            <li><a href="https://zhome.com.eg/Front/index.php"><?php echo lang('Home') ?></a></li>
            <li><a href="https://zhome.com.eg/Front/Shop.php"><?php echo lang('Shop') ?></a></li>
            <li class="active"><a href="https://zhome.com.eg/Front/Shop.php"><?php echo lang('Cart') ?></a></li>
        </ul>
    </div>
    <input type="hidden" name="UserID" id="UserID" class="UserID" value="<?php if(isset($_SESSION['UserID'])){ echo $_SESSION['UserID'] ; }else{ echo session_id() ;}  ?>" readonly>
    <input type="hidden" name="CartID" id="CartID" value="<?php echo session_id() ;  ?>" readonly>
    <?php $do = isset($_GET['action']) ?  $_GET['action'] : "Manage"; ?>
    
    <?php if($do == "Manage"){ ?>
        <?php $_SESSION['return_to_Checkout'] = $_SERVER['REQUEST_URI']; ?>
        <!-- Cart -> Checkout -> Payment -->
        <section>
            <div class="container">
                <div class="CartHeader">
                    <p class="active">
                        <?php echo lang('Cart') ?>
                    </p>
                    >
                    <p>
                        <?php echo lang('Checkout') ?>
                    </p>
                    >
                    <p>
                        <?php echo lang('Payment') ?>
                    </p>
                </div>
            </div>
        </section>

        <!-- Cart -->
        <section>
            <div class="container">
                <div class="CartContainer">
                    <div class="col-lg-12 CartProducts">
                        <div class="topping">
                            <div class="CartandCount">
                                <h3><?php echo lang('Cart') ?></h3> 
                                <span id="TotalItems"> </span>
                            </div>

                            <?php  if($CountCart > 0){ ?>
                                <div class="ClearAll">
                                    <a class="remove-All-btn">
                                        <i class="fa fa-x"></i> 
                                         <?php echo lang('ClearCart') ?>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="cart-main">
                            <div class="table-outer table-responsive">
                                <table class="cart-table" id="myTable">
                                    <thead class="cart-header">
                                        <tr>
                                            <th class="prod-column"><?php echo lang('Product') ?></th>
                                            <th><?php echo lang('Quantity') ?></th>
                                            <th><?php echo lang('installation') ?></th>
                                            <th><?php echo lang('Total') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            if($CountCart > 0){
                                                foreach($CartRun as $Cart){
                                                    $SaleProductID = $Cart['ProductID'];
                                                    $PriceSale = mysqli_query($con  , "SELECT * FROM sale WHERE ProductID = $SaleProductID"); 
                                                    $Sale = mysqli_fetch_assoc($PriceSale);
                                                    $Count_Sale = mysqli_num_rows($PriceSale);
                                                        ?>
                                                    <tr data-product-id="<?php echo $Cart['ProductRealID'] ?>">
                                                        <td class="prod-column price">
                                                                <input type="hidden" name="ProductID" class="ProductID" value="<?php echo $Cart['ProductRealID'] ; ?>">
                                                            <div class="d-flex px-2 py-1">
                                                                <div>
                                                                    <figure class="prod-thumb">
                                                                        <a href="https://zhome.com.eg/Front/ProductDetails.php?ProductID=<?php echo $Cart['ProductID'] ?>">
                                                                            <img src="../Admin/Images/Uploads/<?php echo $Cart['MainImage'] ?>" class="ProductCartImage" alt="<?php echo ucfirst(strtolower($Cart['ProductName'])) ?>">
                                                                        </a>
                                                                    </figure>
                                                                </div>
                                                                <div class="d-flex flex-column justify-content-center" style="margin-left: 10px;">
                                                                    <h3 class="prod-title padd-top-20"><?php echo ucfirst(strtolower($Cart['ProductName'])) ?></h3>
                                                                    <?php if($Count_Sale > 0){  ?>
                                                                        <div class="d-flex" style="gap:20px;">
                                                                            <p class="text-xs text-secondary mb-0" style="font-weight:bold;font-size:17px"><?php echo $Sale['PriceAfter'] . " EGP"?></p>
                                                                            <p class="text-xs text-secondary mb-0 BeforeSale" style="text-decoration: line-through; font-size:14px"><?php echo $Cart['ProductPrice'] . " EGP"?></p>
                                                                            <input type="hidden" class="OldProductPrice" value="<?php echo $Cart['ProductPrice']  ?>">
                                                                        </div>
                                                                        
                                                                        <?php }else{ ?>
                                                                            <p class="text-xs text-secondary mb-0 BeforeSale" ><?php echo $Cart['ProductPrice'] . " EGP"?></p>
                                                                            <input type="hidden" class="OldProductPrice" value="<?php echo $Cart['ProductPrice']  ?>">
                                                                    <?php } ?>
                                                                        <input type="hidden" name="Price[]" class="ProductPrice" value="<?php echo $Cart['OrderPrice'] ?>">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="qty">
                                                            <input class="quantity-spinner Quantity" onchange="updateTotalPrice()" type="number" min="1" max="<?php echo $Cart['MaxQuantity'] ?>"  value="<?php echo $Cart['OrderedQuantity'] ?>" name="Quantity[]">
                                                        </td>
                                                        <td for="installmentPriceCheckbox">
                                                            <?php if(isset($Cart['InstallationCost']) && $Cart['InstallationCost'] != NULL && $Cart['InstallationCost'] != 0  && !empty($Cart['InstallationCost']) && $Cart['InstallationCost'] != "NULL" ){ ?>
                                                                <div style="display:flex;justify-content: center;gap: 20px;">
                                                                    <p class="text-secondary mb-0"><?php echo $Cart['InstallationCost'] . " EGP"?></p>
                                                                    <input type="hidden" class="installmentsPrice"  name="Installments" value="<?php echo $Cart['InstallationCost'] ?>">
                                                                    <input type="checkbox" id="installmentPriceCheckbox" class="installments installmentPriceCheckbox" name="Installments" value="<?php echo $Cart['InstallationCost'] ?>">
                                                                </div>
                                                            <?php }else{
                                                                echo '<p class="text-secondary mb-0">'.lang("NoInstallationCost").'</p>';
                                                                echo '<input type="hidden"   class="installments installmentPriceCheckbox" name="Installments" value="0">';
                                                            } ?>
                                                        </td>
                                                        <td class="sub-total SubTotal" style="padding: 0;"></td>
                                                        <td class="remove" style="padding: 10px;">
                                                            <a class="remove-btn">
                                                                <span class="fa fa-x"></span> 
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                } ?>

                                                <!-- Count Items In Tables And inserting it to page -->
                                                <script>
                                                    var TotalItems = document.getElementById('TotalItems');
                                                    var table = document.getElementById("myTable");
                                                    var totalRowCount = table.rows.length;
                                                    var tbodyRowCount = table.tBodies[0].rows.length;
                                                        TotalItems.innerText = tbodyRowCount + ' Products';
                                                </script>

                                                <?php
                                            }else{ ?>
                                                <tr>
                                                    <td colspan="4" style="text-align: center;padding-top: 34px;border: none;border-top: 1px solid #eeee;border-radius: 0;">
                                                         <a href="https://zhome.com.eg/Front/OnlineShop.php"class="cta ShopNowButton">
                                                            <span class="hover-underline-animation"> <?php echo lang('ShopNowButton') ?> </span>
                                                            <svg viewBox="0 0 46 16" height="10" width="30" xmlns="http://www.w3.org/2000/svg" id="arrow-horizontal">
                                                                <path transform="translate(30)" d="M8,0,6.545,1.455l5.506,5.506H-30V9.039H12.052L6.545,14.545,8,16l8-8Z" data-name="Path 10" id="Path_10"></path>
                                                            </svg>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Total and Promocode -->
        <section>
            <div class="container">
                <div class="row" style="margin: 0;justify-content: space-evenly;">
                    <?php if($CountCart > 0){ ?>
                        <div class="col-lg-6 CartPrices">
                            <h5 style="margin-bottom: 34px;"><?php echo lang('Total') ?></h5>
                                <div class="PromocodeInput">
                                    <!-- Line -->
                                    <div class="Totals">
                                        <ul>
                                            <li><?php echo lang('SubTotal') ?> <span id='TotalPriceOne'> </span></li>
                                            <input type="hidden" name="TotalPriceAjax" id="TotalPriceAjax">
                                            <li class="Saved"><?php echo lang('YouSaved') ?> <span id="discountDiv2"> </span></li>
                                            <input type="hidden" name="SavedAjax" id="SavedAjax">
                                            <li class="total"><?php echo lang('Total') ?> <span id='FinalTotal'> </span></li>
                                        </ul>
                                    </div>
                                    <div class="buttons-in-cart">
                                        <?php if(!isset($_SESSION['UserID']) && !isset($_SESSION['AdminID'])){ ?>
                                            <a href="https://zhome.com.eg/Common/SignIn.php" class="Signincart"><i class="fa-solid fa-user-plus"></i></a>
                                        <?php } ?>
                                        <button type="submit" id="Checkout" class="cta ShopNowButton">
                                            <span class="hover-underline-animation"><?php echo lang('ContinuetoCheckout'); ?></span>
                                            <svg viewBox="0 0 46 16" height="10" width="30" xmlns="http://www.w3.org/2000/svg" id="arrow-horizontal">
                                                <path transform="translate(30)" d="M8,0,6.545,1.455l5.506,5.506H-30V9.039H12.052L6.545,14.545,8,16l8-8Z" data-name="Path 10" id="Path_10"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                        </div>
                    <?php }else{ ?>
                        <div class="col-lg-6">
                            <div class="Splitted Images-Home">
                                <div class="SplittedProduct_1 Image-One ">
                                    <img src="../Admin/Images/r-architecture-rOk4VSMS3Ck-unsplash.jpg" class="BigWidth" alt="Bundles">
                                    <div class="overlay-button" style="width: 85%;">
                                        <div class="Info-bundle">
                                            <h3>Bundle Name</h3>
                                            <p>Apple</p>
                                        </div>
                                        <a href="https://zhome.com.eg/Front/ProductDetails.php?ProductID=1" class="btn btn-info">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-lg-5 CardCarouselCart">
                        <div class="card card-carousel overflow-hidden h-100 p-0" style="border-radius:10px">
                            <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
                                <div class="carousel-inner border-radius-lg h-100">
                                    <div class="carousel-item h-100 active" style="background-image: url('../Admin/Images/james-yarema-zdjZ4kCaJaY-unsplash.jpg');background-size: cover;">
                                        <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                            <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                                <i class="fa fa-camera text-dark opacity-10"></i>
                                            </div>
                                            <h5 class="text-white mb-1"><?php echo lang('BuildyourDreamHome') ?> </h5>
                                            <p style="color: white;"<?php echo lang('BuildyourDreamHomeText') ?></p>
                                            <a class="btn btn-xs bg-gradient-info" href="https://zhome.com.eg/Front/Proposal.php" target="_blank"><i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="carousel-item h-100" style="background-image: url('../Admin/Images/darryl-low-uqk9RAzm6lk-unsplash.jpg'); background-size: cover;">
                                        <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                            <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                            <i class="fa fa-lightbulb text-dark opacity-10"></i>
                                            </div>
                                            <h5 class="text-white mb-1"><?php echo lang('DiscoverourProducts') ?></h5>
                                            <p style="color: white;"><?php echo lang('DiscoverourProductsText') ?></p>
                                            <a class="btn btn-xs bg-gradient-info" href="https://zhome.com.eg/Front/OnlineShop.php" target="_blank"><i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <button class="carousel-control-prev w-5 me-3" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden"><?php echo lang('Previous') ?></span>
                                </button>
                                <button class="carousel-control-next w-5 me-3" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden"><?php echo lang('Next') ?></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Selling Product -->
        <section>
            <div class="container">
                <div class="col-lg-12" style="padding: 0;">
                    <div class="ShopNowInCart" id="ShopNowInCheckout" style="background-image: url(../Admin/Images/bence-boros-anapPhJFRhM-unsplash.jpg);">
                        <h4>
                            <?php echo lang('CheckTheNewest') ?> <br>
                            Apple Products
                        </h4>
                        <a href="https://zhome.com.eg/Front/OnlineShop.php" class="btn btn-secondary"> <?php echo lang('ShopNowButton') ?></a>
                    </div>
                </div>
            </div>
        </section>

        <!-- You may also like -->
        <section>
                <div class="container">
                    <h3 class="related-product__title"> <?php echo lang('YouMayAlsoLike') ?></h3>
                    <div class="related-product__carousel owl-carousel owl-theme">
                            <?php
                                $SelectProduct ="SELECT product.* , brands.* , subcategory.* , 
                                                product.Name AS Name , product.ID AS ProductID , product.Price AS ProductPrice
                                                FROM product                                            
                                                LEFT JOIN subcategory ON subcategory.ID = product.SubCategoryID
                                                LEFT JOIN brands ON brands.ID = product.BrandID
                                                ";
                                $Products = mysqli_query($con , $SelectProduct);
                                $fetch = mysqli_fetch_assoc($Products);
                                $count_products = mysqli_num_rows($Products); 
                                foreach($Products as $Product){ 
                                    $ProductID = $Product['ProductID'];
                                    ?>
                                    <div class="item">
                                        <a href="https://zhome.com.eg/Front/ProductDetails.php?ProductID=<?php echo $Product['ProductID'] ?>">
                                            <?php  generateProductCard($Product , $ProductID)   ?> 
                                        </a>
                                    </div>
                            <?php } ?>
                    </div>
                </div>
            </section>
    <?php }elseif($do == "Checkout"){ 
    
        if($CountCart == 0 || $CountCart < 0 ){
                if(isset($_SESSION['UserID'])){
                    $SessionID = session_id();
                    $UserID = $_SESSION['UserID'];
                    $SelectOrder = mysqli_query($con , "SELECT orders.*,user.*, orders.TransactionID AS UserTransactionID
                                        FROM orders 
                                        LEFT JOIN transactions ON transactions.ID = orders.TransactionID 
                                        LEFT JOIN user ON user.ID = orders.UserID 
                                        WHERE orders.TransactionID IS NOT NULL AND orders.Status = 1 AND UserID = $UserID
                                         ORDER BY orders.ID DESC LIMIT 1");
                    $Orders = mysqli_fetch_assoc($SelectOrder);

                    $TransactionIDofuser = $Orders['UserTransactionID'] ;

                        header("Location: https://zhome.com.eg/Front/Cart.php?action=Success&TransactionID=".$TransactionIDofuser."");
                        exit();

                }else{
                    $UserID = session_id();
                    $SelectOrder = mysqli_query($con , "SELECT orders.*, orders.TransactionID AS UserTransactionID
                                                        FROM orders 
                                                        LEFT JOIN transactions ON transactions.ID = orders.TransactionID 
                                                        WHERE orders.TransactionID != 'NULL' AND orders.Status = 1 AND orders.CartID = '$UserID' 
                                                        ORDER BY orders.ID DESC LIMIT 1");
                    $Orders = mysqli_fetch_assoc($SelectOrder);
                    
                    $TransactionIDofuser = $Orders['UserTransactionID'] ;

                    if($TransactionIDofuser){
                        header("Location: https://zhome.com.eg/Front/Cart.php?action=Success&TransactionID=".$TransactionIDofuser."");
                    }
                }
        }elseif($CountCart > 0 && $CountCart != 0){  
        
                $_SESSION['return_to_Checkout'] = $_SERVER['REQUEST_URI'];
            ?>
        
              <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
              <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
              <link rel="stylesheet" href="https://zhome.com.eg/Front/Css/bd-wizard.css?v=5.1">
            <!-- Cart -> Checkout -> Payment -->
            <section>
                <div class="container">
                    <div class="CartHeader">
                        <p class="Passed">
                          <?php echo lang('Cart') ?>
                        </p>
                        >
                        <p class="active">
                           <?php echo lang('Checkout') ?>
                        </p>
                        >
                        <p>
                            <?php echo lang('Payment') ?>
                        </p>
                    </div>
                </div>
            </section>
            
            <!--Error Msg-->
            <?php if(isset($_GET['Failer'])){ ?>
                <div class="alert alert-danger" style="text-align: center;border-radius: 0;background-image: linear-gradient(323deg, #ff5778 0%, #653123 100%);!important">
                    <p style="color: white;font-size: 25px;">Apologies, your transaction was not successfully processed. Kindly attempt the transaction again.</p>
                </div>
            <?php } ?>
            
            <!-- Checkout form -->
            <section>
                <div class="container">
                    <style>
                        a{
                            text-decoration: none !important;
                        }
                        .select2-selection__rendered {
                                display: none;
                        }
                    </style>
                        <div class="Checkout" style="display: block;">
                            <!--Total Summary -->
                            <div class="Summery">
                                    <?php if(isset($_SESSION['UserID'])){ 
                                                $UserID = $_SESSION['UserID'];
                                                $SessionID = session_id();
                                                $SelectOrder = mysqli_query($con , "SELECT orders.* ,orders.Price AS SavedPrice, product.MainImage AS MainImage  , product.Name AS ProductName , product.InstallationCost AS InstallationCost , user.SessionID, product.Price AS ProductRealPrice FROM orders LEFT JOIN product ON orders.ProductID = product.ID LEFT JOIN user ON user.ID = orders.UserID WHERE UserID = $UserID AND ( orders.SessionID = '$SessionID' OR user.SessionID = orders.SessionID) AND orders.Status = 2");
                                                $Orders = mysqli_fetch_assoc($SelectOrder);
                                                
                                                $SelectInstallation = mysqli_query($con,"SELECT SUM(Total + WithInstallation) AS Total FROM orders LEFT JOIN user ON user.ID = orders.UserID WHERE UserID = $UserID  AND (orders.SessionID = '$SessionID' OR user.SessionID = orders.SessionID) AND orders.Status = 2");
                                                $TotalSum= mysqli_fetch_assoc($SelectInstallation);
                                            }else{
                                                $UserID = session_id();
                                                $SelectOrder = mysqli_query($con , "SELECT orders.* ,orders.Price AS SavedPrice, product.MainImage AS MainImage  , product.Name AS ProductName , product.InstallationCost AS InstallationCost , product.Price AS ProductRealPrice FROM orders LEFT JOIN product ON orders.ProductID = product.ID WHERE CartID = '$UserID' AND Status = 2");
                                                $Orders = mysqli_fetch_assoc($SelectOrder);
                                                
                                                $SelectTotalSum = mysqli_query($con,"SELECT SUM(Total + WithInstallation) AS Total FROM orders WHERE CartID = '$UserID' AND Status = 2");
                                                $TotalSum= mysqli_fetch_assoc($SelectTotalSum);
                                            }
                                        ?>
                                        <div class="Receipt">
                                            <h4><?php echo lang('ReceiptSummary') ?></h4>
                                            <!-- Product One -->
                                            <div class="smallSummary">
                                                <?php foreach($SelectOrder as $Order){ ?>
                                                    <?php 
                                                        $SaleProductID = $Order['ProductID'];
                                                        $PriceSale = mysqli_query($con  , "SELECT * FROM sale WHERE ProductID = $SaleProductID"); 
                                                        $Sale = mysqli_fetch_assoc($PriceSale);
                                                        $Count_Sale = mysqli_num_rows($PriceSale);
                                                    ?>
                                                
                                                    <ul>
                                                        <!--Hidden Data-->
                                                        <form class="product-form">
                                                             <?php
                                                              echo '<input class="OrdersID"         type="hidden" name="OrdersID"         value="'. $Order['ID'] .'">';
                                                              echo '<input class="product-name"     type="hidden" name="product-name"     value="'. $Order['ProductName'].'">';
                                                              echo '<input class="product-quantity" type="hidden" name="product-quantity" value="'. $Order['Quantity'] .'">';
                                                              echo '<input class="product-price"    type="hidden" name="product-price"    value="'. $Order['SavedPrice'] .'">';
                                                              ?>
                                                        </form>
                                                        <div class="product-checkout-page">
                                                            <img src="../Admin/Images/Uploads/<?php echo $Order['MainImage'] ?>" alt="<?php echo $Order['ProductName'] ?>">       
                                                            <div>
                                                                <li><?php echo $Order['ProductName'] ?></li>
                                                                <li>x<?php echo $Order['Quantity'] ?></li>
                                                                <li><?php echo lang('Price') ?> <?php echo $Order['Price'] . " EGP"?></li>
                                                                <?php if($Order['WithInstallation'] != 0){ ?>
                                                                    <li><?php echo lang('InstallationPrice') ?><?php echo $Order['InstallationCost'] . " EGP" ?></li>
                                                                <?php } ?>
                                                                <?php if($Count_Sale > 0){ 
                                                                    $SalePrice = $Order['ProductRealPrice'] - $Sale['PriceAfter'] ;
                                                                    ?>
                                                                    <li><?php echo lang('Saved') ?> <?php echo $SalePrice . " EGP" ?></li>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        
                                                    </ul>                                    
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php if(isset($Order['DeliveryFees']) && $Order['DeliveryFees'] != NULL && !empty($Order['DeliveryFees']) && $Order['DeliveryFees'] != 0 ){ ?>
                                            <p id="deliveryFees"><?php echo lang('DeliveryFees') ."  " .  $Order['DeliveryFees']. lang('EGP') ; ?></p>
                                        <?php }else{ ?>
                                            <p id="deliveryFees"></p>
                                        <?php } ?>
                                        <p id="deliveryFees"></p>
                                        <h6 id="promocode-div" style="display:none;"><?php echo lang('Promocode') ?> <span id="promocode"></span></h6>
                                        <h6 id="FinalBeforePromoHide"><?php echo lang('Total') ?> <?php echo $TotalSum['Total'] . lang('EGP') ?> </h6>
                                        <h6 id="TotalWithDelivery"></h6>
                                        <h6 id="FinalCheckoutHide" style="display:none;"><?php echo lang('Total') ?> <span id="FinalCheckout"></span></h6>
                                        <input type="hidden" name="TotalCheckout" id="TotalCheckout" value="<?php echo $TotalSum['Total'] ?>" readonly>
                                        <input type="hidden" name="TotalCheckoutAfterPromo" id="TotalCheckoutAfterPromo" value="" readonly>
                                        <input type="hidden" name="deliveryFeesValue" id="deliveryFeesValue" readonly>
                            </div>
                                 
                             <div id="wizard">
                                     <input type="hidden" id="SessionExists" value="<?php if(isset($_SESSION['UserID'])){ echo 1 ;}else{ echo 0 ;} ?>" >
                                    <!--User Info-->
                                    <h3>Step 1 Title</h3>
                                    <section>
                                        <div class="Userform">
                                    
                                            <h4><?php echo lang('ContactInformation') ?></h4>
                                            <?php if(isset($_SESSION['UserID'])){ 
                                                    $UserID = $_SESSION['UserID'];
                                                    $Users = mysqli_query($con , "SELECT user.* , orders.Country AS Country, orders.Address AS UserShippingAddress , orders.Building AS Building , orders.Floor AS Floor , orders.Apartment AS Apartment ,user.Name AS UserName, orders.City AS City FROM user LEFT JOIN orders ON user.ID = orders.UserID WHERE user.ID = $UserID");
                                                    $User = mysqli_fetch_assoc($Users);
                                                    $fullName = $User['UserName'];
                                                    $nameParts = explode(' ', $fullName);
                                                    $lastName = end($nameParts);
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="UserName" class="form-control-label"><?php echo lang('CheckoutName') ?></label>
                                                             <?php if(isset($User['is_verified']) && $User['is_verified'] == 0 ){ ?>
                                                                <input class="form-control"  id="UserName"  type="text" name="Name" value="<?php if(isset($User['UserName'])){echo $User['UserName'] ; }?>" autocomplete="off" >
                                                            <?php }else{ ?>
                                                                <input class="form-control"  id="UserName"  type="text" name="Name" value="<?php if(isset($User['UserName'])){echo $User['UserName'] ; }?>" autocomplete="off" disabled>
                                                            <?php } ?>
                                                            <input class="form-control"  id="FirstName"  type="hidden" name="FirstName" value="<?php echo $nameParts[0] ?>">
                                                            <input class="form-control"  id="LastName"  type="hidden" name="LastName" value="<?php echo $lastName ?>" >
                                    
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="UserEmail" class="form-control-label"><?php echo lang('CheckoutEmail') ?></label>
                                                            <?php if(isset($User['is_verified']) && $User['is_verified'] == 0 ){ ?>
                                                                <input class="form-control" id="UserEmail" type="email"  name="Email" value="<?php if(isset($User['Email'])){echo $User['Email'] ; } ?>" autocomplete="off">
                                                            <?php }else{ ?>
                                                                <input class="form-control" id="UserEmail" type="email"   value="<?php if(isset($User['Email'])){echo $User['Email'] ; } ?>" autocomplete="off" disabled>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="UserMainAddress" class="form-control-label"> <?php echo lang('CheckoutAddress') ?></label>
                                                            <textarea class="form-control" id="UserMainAddress" name="Address" ><?php if(isset($User['Address'])){ echo $User['Address']; } ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="UserPhone" class="form-control-label"><?php echo lang('CheckoutPhone') ?></label>
                                                            <input class="form-control" id="UserPhone" type="number"  name="Phone" value="<?php if(isset($User['Phone']) && !empty($User['Phone']) && $User['Phone'] != NULL){ echo "0" . $User['Phone']; } ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                            <?php }else{ 
                                            
                                              $UserID = session_id();
                                                $Users = mysqli_query($con , "SELECT * FROM orders WHERE CartID = '$UserID'");
                                                $User = mysqli_fetch_assoc($Users);
                                                if(isset($User['Name'])){
                                                     $fullName = $User['Name'];
                                                    $nameParts = explode(' ', $fullName);
                                                    $lastName = end($nameParts);
                                                }
                                                ?>
                                                <div class="DarkShadow">
                                                    <div id="signInOverlay" class="overlaySignIn">
                                                        <div class="cardOverlay" id="signInCard">
                                                            <h2><?php echo lang('ZhomeCommunity') ?></h2>
                                                            <p style="font-size: 13px;"><?php echo lang('ZhomeCommunityText') ?></p>
                                                            <div class="Div-Overlay-Sign">
                                                                <div class="InnerDiv-Overlay">
                                                                    <a href="https://zhome.com.eg/Common/SignIn.php" class="ButtonSignInOverlay"><img src="../Admin/Images/Uploads/refer.png" alt="Sign In"></a>
                                                                    <p class="small-txt"><?php echo lang('HaveAccount') ?></p>
                                                                </div>
                                                                 <div class="InnerDiv-Overlay">
                                                                    <a href="https://zhome.com.eg/Common/SignUp.php" class="ButtonSignUpOverlay"><img src="../Admin/Images/Uploads/add-user.png" alt="Sign Up"></a>
                                                                    <p class="small-txt"><?php echo lang('ZhomeCommunityNewUser') ?> </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-top: 15px;">
                                                        <div class="col-md-6">
                                                            <input class="form-control" id="UserName" type="hidden" name="Name" value="<?php if(isset($fullName)){ echo $fullName ; } ?>" >
                                                            <div class="form-group">
                                                                <label for="FirstName" class="form-control-label"> <?php echo lang('FirstName') ?></label>
                                                                <input class="form-control" id="FirstName" type="text" name="FirstName" autocomplete="off" value="<?php if(isset($nameParts[0])){ echo $nameParts[0] ; } ?>"  disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="LastName" class="form-control-label"><?php echo lang('LastName') ?></label>
                                                                <input class="form-control" id="LastName" type="text" name="LastName" autocomplete="off" value="<?php if(isset($lastName)){ echo $lastName ; } ?>"  disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                    
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="UserEmail" class="form-control-label"><?php echo lang('CheckoutEmail') ?></label>
                                                                <input class="form-control" id="UserEmail" type="email"  name="Email" autocomplete="off" value="<?php if(isset($User['Email'])){ echo $User['Email']; } ?>" disabled >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="UserPhone" class="form-control-label"><?php echo lang('CheckoutPhone') ?></label>
                                                                <input class="form-control" id="UserPhone" type="number"  name="Phone" autocomplete="off" value="<?php if(isset($User['Phone'])){ echo $User['Phone']; } ?>" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                    
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="UserCity" class="form-control-label"><?php echo lang('City') ?></label>
                                                                <input class="form-control" id="UserCity" type="text"  name="City" value="<?php if(isset($User['City'])){ echo $User['City']; } ?>" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="UserCountry" class="form-control-label"><?php echo lang('Country') ?></label>
                                                                <input class="form-control" id="UserCountry" type="text"  name="Country" value="<?php if(isset($User['Country'])){ echo $User['Country']; } ?>"  disabled>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="UserAddress" class="form-control-label"><?php echo lang('CheckoutAddress') ?></label>
                                                                <textarea class="form-control" id="UserAddress" name="Address" disabled><?php if(isset($User['Address'])){ echo $User['Address']; } ?></textarea>
                                                            </div>
                                                        </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="UserBuilding" class="form-control-label"><?php echo lang('Building') ?></label>
                                                                <input class="form-control" id="UserBuilding" type="text"  name="Building" value="<?php if(isset($User['Building'])){ echo $User['Building']; } ?>" disabled >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="UserFloor" class="form-control-label"><?php echo lang('Floor') ?></label>
                                                                <input class="form-control" id="UserFloor" type="number"  name="Floor" value="<?php if(isset($User['Floor'])){ echo $User['Floor']; } ?>" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="UserApartment" class="form-control-label"><?php echo lang('Apartment') ?></label>
                                                                <input class="form-control" id="UserApartment" type="number"  name="Apartment" value="<?php if(isset($User['Apartment'])){ echo $User['Apartment']; } ?>" disabled>
                                                            </div>
                                                        </div>
                                                                                        
                                                    </div>
                                                    
                                    
                                                </div>
                                                
                                    
                                            <?php } ?>
                                            
                                        </div>
                                    </section>
                                    
                                    <!--Address-->
                                    <h3>Step 2 Title</h3>
                                    <section>
                                        <div class="Userform">
                                            <h4><?php echo lang('ShippingInformation') ?></h4>
                                            <?php
                                                if(isset($_SESSION['UserID'])){ 
                                                    $UserID = $_SESSION['UserID'];
                                                    $Users = mysqli_query($con , "SELECT user.* , orders.Country AS Country, orders.Address AS UserShippingAddress , orders.Building AS Building , orders.Floor AS Floor , orders.Apartment AS Apartment ,user.Name AS UserName, orders.City AS City FROM user LEFT JOIN orders ON user.ID = orders.UserID WHERE user.ID = $UserID");
                                                    $User = mysqli_fetch_assoc($Users);
                                                    $fullName = $User['UserName'];
                                                    $nameParts = explode(' ', $fullName);
                                                    $lastName = end($nameParts);
                                                }
                                                ?>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="UserShippingAddress" class="form-control-label"><?php echo lang('CheckoutAddress') ?></label>
                                                            <textarea class="form-control" id="UserShippingAddress" name="UserShippingAddress"data-original-value="<?php if(isset($User['UserShippingAddress'])){ echo $User['UserShippingAddress']; } ?>"><?php if(isset($User['UserShippingAddress'])){ echo $User['UserShippingAddress']; } ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>  
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="UserCountry">Country</label>
                                                            <select name="Country" id="UserCountry" class="form-control">
                                                                 <?php if(isset($User['Country'])){ ?>
                                                                      <option value="<?php echo $User['Country']; ?>" selected><?php echo $User['Country']; ?></option>
                                                                 <?php }else{ ?>
                                                                      <option disabled selected hidden><?php echo lang('SelectCountry') ?></option>
                                                                 <?php } ?>
                                                                    <!--<option value="United Kingdom" >United Kingdom</option>-->
                                                                    <option value="United Arab Emarits">United Arab Emarits</option>
                                                                    <option value="Egypt">Egypt</option>
                                                                    <!--<option value="France">France</option>-->
                                                                    <!--<option value="Australia">Australia</option>-->
                                                                    <!--<option value="United States of America">United States of America</option>-->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="UserCity">City</label>
                                                            <select name="City" id="UserCity" class="form-control">
                                                                <?php if(isset($User['City'])){ ?>
                                                                    <option value="<?php echo $User['City']; ?>" selected><?php echo $User['City']; ?></option>
                                                                <?php }else{ ?>
                                                                    <option disabled selected hidden><?php echo lang('SelectCity') ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="UserBuilding" class="form-control-label"><?php echo lang('Building') ?></label>
                                                            <input class="form-control" id="UserBuilding" type="text"  name="Building" data-original-value="<?php if(isset($User['Building'])){ echo $User['Building']; } ?>" value="<?php if(isset($User['Building'])){ echo $User['Building']; } ?>" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="UserFloor" class="form-control-label"><?php echo lang('Floor') ?></label>
                                                            <input class="form-control" id="UserFloor" type="text"  name="Floor" data-original-value="<?php if(isset($User['Floor'])){ echo $User['Floor']; } ?>" value="<?php if(isset($User['Floor'])){ echo $User['Floor']; } ?>" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="UserApartment" class="form-control-label"><?php echo lang('Apartment') ?></label>
                                                            <input class="form-control" id="UserApartment" type="text"  name="Apartment" data-original-value="<?php if(isset($User['Apartment'])){ echo $User['Apartment']; } ?>" value="<?php if(isset($User['Apartment'])){ echo $User['Apartment']; } ?>" >
                                                        </div>
                                                    </div>
                                                </div>

                                        </div>

                                    </section>
                                    
                                    <!--Promocode-->
                                    <h3>Step 3 Title</h3>
                                    <section>
                                      <h4 style="text-align:center;font-size: 30px;font-weight: 400;margin-bottom: 40px;"><?php echo lang('Promocode') ?></h4>
                                        <div class="PromocodeInput">
                                            <div class="form-group" style="display: flex;align-items: center;">
                                                <input class="form-control" type="text" id="promoCodeInput"  name="Promocode" placeholder="<?php echo lang('Promocode') ?>" autocomplete="off">
                                                <button class="btn btn-primary" type="submit" id="checkPromoCodeButton" onclick="applyPromocode()" style="padding: 15px;"><?php echo lang('Check') ?></button>
                                            </div>
                                            <div id="successPopup" class="popup">
                                                <img src="../Admin/Images/check.png" alt="Success">
                                                <p><?php echo lang('PromocodeApplied') ?></p>
                                            </div>
                                        </div>
                                    </section>
                                    
                                    <!--Payment-->
                                    <h3>Step 4 Title</h3>
                                     <section>
                                           <h4 style="text-align:center;font-size: 30px;font-weight: 400;margin-bottom: 40px;"><?php echo lang('PaymentOptions') ?></h4>
                                            <form  method="post">

                                                <?php
                                                    echo '<input type="hidden" id="user_id" name="UserID" value="'. (isset($_SESSION["UserID"]) ? $_SESSION["UserID"] : session_id()  ).'">';
                                                     echo '<input type="hidden" name="order_amount" id="order_amount" value="'. $TotalSum["Total"] .'">';
                                                 ?>
                                                 
                                                 <?php if(isset($_SESSION['UserID'])){ ?>
                                                    <div class="PayNow">
                                                        <div class="PayWithCardButton" onclick="checkout()" id="checkoutButton">
                                                            <div class="left-side">
                                                                <div class="card">
                                                                    <div class="card-line"></div>
                                                                    <div class="buttons"></div>
                                                                </div>
                                                                <div class="post">
                                                                    <div class="post-line"></div>
                                                                    <div class="screen">
                                                                        <div class="dollar">$</div>
                                                                    </div>
                                                                    <div class="numbers"></div>
                                                                    <div class="numbers-line2"></div>
                                                                </div>
                                                            </div>
                                                            <div class="right-side">
                                                                <div class="new"><?php echo lang('PaywithCard') ?></div>
                                                            </div>
                                                        </div>
                                                        <button class="button-COD" style="--clr: #00ad54;" onclick="COD()"  id="CODButton">
                                                            <span class="button-decor"></span>
                                                            <div class="button-content">
                                                                <div class="button__icon">
                                                                    <img src="../Admin/Images/cash-on-delivery.png" alt="Cash on Delivery">
                                                                </div>
                                                                <span class="button__text"><?php echo lang('CashOnDelivery') ?></span>
                                                            </div>
                                                        </button>
                                                    </div>
                                                <?php } ?>
                                            </form>
                                    </section>
                                </div>
                            <div class="ZhomeLogoCheckout">
                                <p>Zhome</p>
                            </div>
        
                        </div>
                </div>
            </section>
            <!-- Selling Product -->
            <section>
                <div class="container">
                    <div class="col-lg-12" style="padding: 0;">
                        <div class="ShopNowInCart" style="background-image: url(../Admin/Images/bence-boros-anapPhJFRhM-unsplash.jpg);">
                            <h4>
                                <?php echo lang('CheckTheNewest') ?> <br>
                                Apple Products
                            </h4>
                            <a href="https://zhome.com.eg/Front/OnlineShop.php" class="btn btn-secondary"><?php echo lang('ShopNowButton') ?></a>
                        </div>
                    </div>
                </div>
            </section>
            
            <!--Script to combine the first and last name-->
            <script>
              var firstNameInput = document.getElementById('FirstName');
              var lastNameInput = document.getElementById('LastName');
              var userNameInput = document.getElementById('UserName');
            
              firstNameInput.addEventListener('input', updateUserName);
              lastNameInput.addEventListener('input', updateUserName);
            
              function updateUserName() {
                var firstName = firstNameInput.value.trim();
                var lastName = lastNameInput.value.trim();
            
                var fullName = firstName + ' ' + lastName;
            
                userNameInput.value = fullName;
              }
              
                
                
            </script>

        <?php 
        }else{
            header("Location: ./Cart.php");
        } ?>
        
    <?php }elseif($do == "Success"){ ?>
        <?php
            $TransactionID = $_GET['TransactionID'] ; 
            if(!empty($TransactionID) && isset($TransactionID)){
                if(isset($_SESSION['UserID'])){
                    $SessionID = session_id();
                                                            // LEFT JOIN user ON user.ID = orders.UserID 

                    $SelectOrder = mysqli_query($con , "SELECT orders.* , product.* ,transactions.*, product.Name AS ProductName , orders.Quantity AS QuantityBought , orders.Address AS ShippingAddress, orders.Price AS ItemPrice, orders.TransactionID AS UserTransactionID , user.Email AS UserEmail
                                        FROM orders 
                                        LEFT JOIN transactions ON transactions.ID = orders.TransactionID 
                                        LEFT JOIN product ON product.ID = orders.ProductID
                                        LEFT JOIN user ON user.ID = orders.UserID 
                                        WHERE orders.TransactionID = $TransactionID AND orders.Status = 1 AND UserID = $UserID ");
                    $Orders = mysqli_fetch_assoc($SelectOrder);
                    if(isset($Orders['UserID'])){
                        $UserID = $Orders['UserID'];
                    }
                    $TransactionIDofuser = $Orders['UserTransactionID'];
                    
                    $UserSuccess = mysqli_query($con , "SELECT * FROM user WHERE ID = $UserID AND SessionID = '$SessionID'");
                    $UserSuccessResult = mysqli_fetch_assoc($UserSuccess);
                    
                    // Check if Promocode is NULL or Not 
                    if(isset($Orders['PromoCodeID'])){
                        $PromoCodeID = $Orders['PromoCodeID'];
                        $SelectPromoCode = mysqli_query($con,"SELECT promocode.* FROM promocode LEFT JOIN orders ON promocode.ID = orders.PromoCodeID WHERE PromoCodeID = $PromoCodeID AND UserID = $UserID AND TransactionID = '$TransactionID' GROUP BY promocode.ID");
                        $PromocodeUsed= mysqli_fetch_assoc($SelectPromoCode);
                        $CountPromocode = mysqli_num_rows($SelectPromoCode);
                        if($CountPromocode > 0 ){
                            $Discount = $PromocodeUsed['Save'] ; 
                            $SelectInstallation = mysqli_query($con,"SELECT SUM(Total + WithInstallation) AS Total FROM orders WHERE UserID = $UserID AND Status = 1 AND TransactionID = '$TransactionID'");
                            $TotalSum= mysqli_fetch_assoc($SelectInstallation);
                            $DiscountAmount = $TotalSum['Total']  * ($Discount / 100);
                            $Total = $TotalSum['Total'] - $DiscountAmount;
                             
                        }
                    }else{
                        $SelectInstallation = mysqli_query($con,"SELECT SUM(Total + WithInstallation) AS Total FROM orders WHERE UserID = $UserID AND Status = 1 AND TransactionID = '$TransactionID'");
                        $TotalSum= mysqli_fetch_assoc($SelectInstallation);
    
                    }

                }else{
                    // We cancelled the option for non user to buy so he should be a user to buy and therefour to see this page
                    // $UserID = session_id();
                    // $SelectOrder = mysqli_query($con , "SELECT orders.* , product.* ,transactions.*, product.Name AS ProductName , orders.Quantity AS QuantityBought , orders.Price AS ItemPrice, orders.TransactionID AS UserTransactionID,orders.Email AS UserEmail
                    //     FROM orders 
                    //     LEFT JOIN transactions ON transactions.ID = orders.TransactionID 
                    //     LEFT JOIN product ON product.ID = orders.ProductID 
                    //     WHERE orders.TransactionID = $TransactionID AND orders.Status = 1 AND orders.CartID = '$UserID' ");
                    // $Orders = mysqli_fetch_assoc($SelectOrder);
                    // $CartID = $Orders['CartID'];
                    // $PromoCodeID = $Orders['PromoCodeID'];
                    // $TransactionIDofuser = $Orders['UserTransactionID'];

                    // $UserSuccess = mysqli_query($con , "SELECT * FROM orders WHERE CartID = '$CartID'");
                    // $UserSuccessResult = mysqli_fetch_assoc($UserSuccess);
                    
                    // // Check if Promocode is NULL or Not 
                    // if(isset($PromoCodeID)){
                    //     $SelectPromoCode = mysqli_query($con,"SELECT promocode.* FROM promocode LEFT JOIN orders ON promocode.ID = orders.PromoCodeID WHERE PromoCodeID = $PromoCodeID AND CartID = '$CartID' AND TransactionID = '$TransactionID' GROUP BY promocode.ID");
                    //     $PromocodeUsed= mysqli_fetch_assoc($SelectPromoCode);
                    //     $CountPromocode = mysqli_num_rows($SelectPromoCode);
                    //     if($CountPromocode > 0 ){
                    //         $Discount = $PromocodeUsed['Save'] ; 
                    //         $SelectInstallation = mysqli_query($con,"SELECT SUM(Total + WithInstallation) AS Total FROM orders WHERE CartID = '$CartID' AND Status = 1 AND TransactionID = '$TransactionID'");
                    //         $TotalSum= mysqli_fetch_assoc($SelectInstallation);
                    //         $DiscountAmount = $TotalSum['Total']  * ($Discount / 100);
                    //         $Total = $TotalSum['Total'] - $DiscountAmount;
                             
                    //     }
                    // }else{
                    //     $SelectInstallation = mysqli_query($con,"SELECT SUM(Total + WithInstallation) AS Total FROM orders WHERE CartID = '$CartID' AND Status = 1 AND TransactionID = '$TransactionID'");
                    //     $TotalSum= mysqli_fetch_assoc($SelectInstallation);
    
                    // }
                    header("Location: https://zhome.com.eg/Front/Cart.php");
                    exit();
    
                }
        
            ?>
            <!--Security -->
            <?php if($TransactionIDofuser == $TransactionID){  ?>
                                                    

                <style>
                    .CartHeader p.active::before {
                        content: "";
                        border: 1px solid #154352;
                        background-color: #154352;
                    }
        
                </style>
                
                <!-- Cart -> Checkout -> Payment -->
                <section>
                    <div class="container">
                        <div class="CartHeader">
                            <p class="Passed">
                                 <?php echo lang('Cart') ?>
                            </p>
                            >
                            <p class="Passed">
                                 <?php echo lang('Checkout') ?>
                            </p>
                            >
                            <p class="active">
                                 <?php echo lang('Payment') ?>
                            </p>
                        </div>
                    </div>
                </section>
            
                <!-- Success Form -->
                <section>
                    <div class="container">
                        <div class="Success-div">
                            <div class="Success-img">
                                <img src="../Admin/Images/check.png" alt="Success">
                             </div>
                             <h2><?php echo lang('OrderPlaced') ?></h2>
                             
                             <div class="Success-invoice">
                                  <div style="text-align: right;margin-right: 40px;margin-top: 40px;">
                                     <button class="btn btn-success" id="downloadButton" onclick="downloadImage()"><i class="fa-solid fa-download"></i></button>
                                 </div>
                                 <h3><?php echo isset($UserSuccessResult['Name']) ? $UserSuccessResult['Name'] : 'Unkown'  ?></h3>
                                 <h4>Zhome</h4>
                                 <div class="invoice">
                                         <p>Order ID [<?php echo $Orders['OrderID'] ?>]</p>
                                          <p><?php echo date('d-M Y', strtotime($Orders['CreatedAt'])) ; ?> </p>
                                     <div class="Invoice-items">
                                         <?php 
                                         $UserEmail = $Orders['UserEmail'];
                                         sendInvoiceEmail($UserEmail, $SelectOrder); ?>
                                         <?php foreach($SelectOrder as $Invoice){ ?>
                                             <div style="display: flex;align-items: center;">
                                                 <img src="https://zhome.com.eg/Admin/Images/Uploads/<?php echo $Invoice['MainImage'] ?>" class="InvoiceProductImg" alt="<?php echo ucfirst(strtolower($Invoice['ProductName'])) ?>">
                                                    <ul>
                                                               
                                                            <li><?php echo ucfirst(strtolower($Invoice['ProductName'])) ?></li>
                                                            <li>x<?php echo $Invoice['QuantityBought'] ?></li>
                                                            <li><?php echo lang('Price') ."  ". $Invoice['Total'] . lang('EGP')?></li>
                                                            <?php if($Invoice['WithInstallation'] != 0){ ?>
                                                                <li><?php echo lang('InstallationPrice') ."  ". $Invoice['InstallationCost'] . lang('EGP') ?></li>
                                                            <?php } ?>
                                                    </ul>    
                                             </div>
                                         <?php } ?>
                                     </div>
                                     <div class="Invoice-totals">
                                         <!--the user used a promocode-->
                                         <?php if($Orders['PromoCodeID'] != NULL && !empty($Orders['PromoCodeID']) && isset($Orders['PromoCodeID'])){ ?>
                                               <p><?php echo lang('PromoUsed') . "  ". $PromocodeUsed['Promocode'] ?> </p>
                                              <p><?php echo lang('Total') . "  ".  $Total . lang('EGP') ?> </p>
                                         <?php }else{ ?>
                                             <p><?php echo lang('Total') . "  ". $TotalSum['Total'] . lang('EGP') ?></p>
                                         <?php }
                                         
                                          if(isset($Orders['DeliveryFees']) && $Orders['DeliveryFees'] != NULL && !empty($Orders['DeliveryFees']) && $Orders['DeliveryFees'] != 0 ){ ?>
                                            <p><?php echo lang('DeliveryFees') ."  " .  $Orders['DeliveryFees']. lang('EGP') ; ?></p>
                                        <?php }else{ ?>
                                            <p>Free Delivery</p>
                                        <?php } ?>
                                         
                                     </div>
                                     <div class="User-Location">
                                             <p><?php echo isset($UserSuccessResult['Phone']) ? "0" . $UserSuccessResult['Phone'] : '-'  ?></p>
                                              <p><?php echo isset($UserSuccessResult['Email']) ? $UserSuccessResult['Email'] : '-'  ?></p>
                                            <p><?php echo isset($Orders['ShippingAddress']) ? $Orders['ShippingAddress'] : '-'  ?></p>
                                     </div>
                                 </div>
                             </div>
                        </div>
                         <a href="https://zhome.com.eg/Front/OnlineShop.php"class="cta ShopNowButton" style="margin-top:40px;">
                            <span class="hover-underline-animation"><?php echo lang('ContinueShopping') ?></span>
                            <svg viewBox="0 0 46 16" height="10" width="30" xmlns="http://www.w3.org/2000/svg" id="arrow-horizontal">
                                <path transform="translate(30)" d="M8,0,6.545,1.455l5.506,5.506H-30V9.039H12.052L6.545,14.545,8,16l8-8Z" data-name="Path 10" id="Path_10"></path>
                            </svg>
                        </a>
                    </div>
                </section>
            <?php 
                }else{
                    header("Location: ./Cart.php");
                     exit(); 
                }
            
            }else{
                header("Location: ./Cart.php");
                 exit();
                
        } ?>


    <?php } ?>

    <?php include "./Footer.php";  ?>

        <script>
            updateCartCount();
            
            
            // Format for money
            function formatSubtotal(subtotal) {
                var subtotalString = subtotal.toString();

                var characters = subtotalString.split('');

                characters.reverse();

                for (var i = 3; i < characters.length; i += 3) {
                    characters.splice(i, 0, ',');
                }

                characters.reverse();

                var formattedSubtotal = characters.join('');

                formattedSubtotal += ' EGP';

                return formattedSubtotal;
            }
            
            // Remove a product and Empty Cart
            $(document).ready(function() {

                // Remove one product
                $('.remove-btn').click(function() {
                    var ProductID = $(this).closest('tr').find('[name="ProductID"]').val();
                    removeProduct(ProductID);
                });
            
                // Empty Cart
                $('.remove-All-btn').click(function() {
                    emptyCart();
                });
            });
             
            //  Code to update inputs ontime
             document.addEventListener('DOMContentLoaded', function () {
                var formControls = document.querySelectorAll(".Checkout #wizard .form-control");
            
                formControls.forEach(function (inputElement) {
                    inputElement.addEventListener('input', function () {
                        clearTimeout(inputElement.timeout);
                        inputElement.timeout = setTimeout(function () {
                            sendDataToPHP(inputElement);
                        }, 500);
                    });
                });

             }); 
             
            //  Hide success of promocode
            function hideSuccessPopup() {
                $('#successPopup').hide();
            }

            // Define variables for Price, Quantity, and SubTotal using getElementsByClassName
            var ProductID = document.getElementsByClassName('ProductID');
            var FinalTotal = document.getElementById('FinalTotal');
            var TotalPriceAjax = document.getElementById('TotalPriceAjax');
            var SavedAjax = document.getElementById('SavedAjax');
            var OldProductPrice = document.getElementsByClassName('OldProductPrice');
            var Price = document.getElementsByClassName('ProductPrice');
            var Quantity = document.getElementsByClassName('Quantity');
            var SubTotal = document.getElementsByClassName('SubTotal');
            var Installments = document.getElementsByClassName('installmentsPrice');
            var FullTotalOne = document.getElementById('TotalPriceOne');
            var TotalSaved = document.getElementById('discountDiv2');
            var InstallationLi = document.getElementById('InstallationLi');
            var installmentPriceCheckbox = document.getElementsByClassName('installmentPriceCheckbox');
            var priceBeforeSale = document.getElementsByClassName('BeforeSale');
        
            var TotalPrice = 0;

            function updateTotalPrice() {

                var total = 0;
                var totalSaved = 0;
                
                for (var i = 0; i < Price.length; i++) {
                    var price = parseFloat(Price[i].value);
                    var quantity = parseFloat(Quantity[i].value);
                    var hasInstallment = typeof installmentPriceCheckbox[i] !== "undefined" && installmentPriceCheckbox[i].checked;
                    var itemTotal = price * quantity;
            
                    if (hasInstallment) {
                        var installmentAmount = parseFloat(installmentPriceCheckbox[i].value);
                        itemTotal += installmentAmount;
                    }
            
                    SubTotal[i].innerText = itemTotal.toFixed(1) + " EGP";
                    total += itemTotal;
            
                    if (typeof priceBeforeSale[i] !== "undefined" && !isNaN(price)) {
                        var oldPrice = parseFloat(priceBeforeSale[i].innerText);
                        if (!isNaN(oldPrice)) {
                            var discount = oldPrice - price;
                            totalSaved += discount * quantity;
                        }
                    }
                }
            
                // Update the total price on the page
                FinalTotal.innerText = formatSubtotal(total);
                FullTotalOne.innerText = formatSubtotal(total);
                TotalPriceAjax.value = total;
            
                TotalSaved.innerText = "(" + totalSaved.toFixed(1) + " EGP)";
                SavedAjax.value = totalSaved;
            }
            updateTotalPrice();
            
            // Attach change event to the quantity, price, and installment fields
            for (var i = 0; i < Price.length; i++) {
                Price[i].addEventListener("change", updateTotalPrice);
                Quantity[i].addEventListener("change", updateTotalPrice);
            }
            for (var i = 0; i < installmentPriceCheckbox.length; i++) {
                installmentPriceCheckbox[i].addEventListener("change", updateTotalPrice);
            }


            document.getElementById('Checkout').addEventListener('click', handleCheckout);


        </script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
            <script src="https://zhome.com.eg/Front/JS/jquery.steps.min.js?v=2"></script>
            <script src="https://zhome.com.eg/Front/JS/bd-wizard-cart.js?v=1.6"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
            <script>
            
                $(document).ready(function () {
                    var manualCities = {
                        // "United States of America": ["New York", "Los Angeles", "Chicago", "Houston", "Phoenix"],
                        "United Arab Emarits": ["Abu Dhabi", "Dubai", "Sharjah", "Ras Al-Khaimah", "Ajman"],
                        "Egypt": ["Cairo", "Giza", "Alexandria", "Redsea", "South Sinai", "North Sinai", "Marsa Alm"],
                        // "United Kingdom": ["London", "Birmingham", "Manchester", "Leeds", "Glasgow"],
                        // "France": ["Paris", "Marseille", "Bordeaux", "Lyon", "Nice"],
                        // "Canada": ["Toronto", "Vancouver", "Montreal", "Ottawa", "Calgary"],
                        // "Italy": ["Florence", "Milan", "Naples", "Rome", "Venice", "Genoa", "Verona"],
                        // "Australia": ["Sydney", "Melbourne", "Brisbane", "Perth", "Canberra", 'Darwin'],
                        // "Spain": ["Madrid", "Seville", "Barcelona", "Valencia", "Malaga"],
                        // "Germany": ["Berlin", "Hamburg", "Munich", "Cologne", "Frankfurt"],
                    };
                    $('#UserCountry').change(function () {
                        var selectedCountry = $(this).val();
                        var cities = manualCities[selectedCountry] || [];
                
                        $('#UserCity').html('<option value="">Select City</option>' + cities.map(city => `<option value="${city}">${city}</option>`).join(''));
                    });
                
                    $('#UserCity').change(function () {
                        var selectedCountry = $('#UserCountry').val();
                        var selectedCity = $(this).val();
                        var UserID = $('#UserID').val();
                        var CartID = $('#CartID').val();
                        // AJAX request to fetch delivery fees
                        $.ajax({
                            url: 'https://zhome.com.eg/Front/GetDeliveryFees.php',
                            method: 'POST',
                            data: { country: selectedCountry, city: selectedCity },
                            success: function (response) {
                                if (response.trim() === 'Free Delivery') {
                                    $('#deliveryFees').text('<?php echo lang('FreeDelivery') ?>');
                                    $('#deliveryFeesValue').val('0');
                                    // Additional AJAX request to add the response value to the database
                                    $.ajax({
                                        url: 'https://zhome.com.eg/Front/AddDeliveryToChekoutPrice.php',
                                        method: 'POST',
                                        data: {
                                            deliveryFee: response ,
                                            UserID: UserID,
                                            CartID: CartID
                                        },
                                        success: function (response) {
                                            $('#FinalBeforePromoHide').hide();
                                            $('#TotalWithDelivery').text('<?php echo lang('Total') ?> ' + response + ' <?php echo lang('EGP') ?>');
                                            console.log(response);
                                        },
                                        error: function (xhr, status, error) {
                                        }
                                    });
                                    
                                } else {
                                    $('#deliveryFees').text('<?php echo lang('DeliveryFees') ?> ' + response + ' <?php echo lang('EGP') ?>');
                                    $('#deliveryFeesValue').val(response);
                                    // Additional AJAX request to add the response value to the database
                                    $.ajax({
                                        url: 'https://zhome.com.eg/Front/AddDeliveryToChekoutPrice.php',
                                        method: 'POST',
                                        data: {
                                            deliveryFee: response ,
                                            UserID: UserID,
                                            CartID: CartID
                                        },
                                        success: function (response) {
                                            $('#FinalBeforePromoHide').hide();
                                            $('#TotalWithDelivery').text('<?php echo lang('Total') ?> ' + response + ' <?php echo lang('EGP') ?>');
                                            console.log(response);
                                        },
                                        error: function (xhr, status, error) {
                                        }
                                    });
                                }
                            }
                        });
                    });
    
                    $('#UserCountry').trigger('change');

                });
            </script>