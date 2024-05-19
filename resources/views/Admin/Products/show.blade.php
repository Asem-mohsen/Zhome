@extends('Admin.Layout.Master')
@section('Title' , 'Product')

@section('Content')

@include('Admin.Components.Msg')


    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4" style="overflow: hidden; height: auto;">
                    <!-- Details -->
                    <section class="product-details">
                        <form method="post">
                            <div class="control-buttons">
                                <p>Control</p>
                                <input type="hidden" name="ProductID" value="<?php echo $Product['ProductID'] ?>">
                                <?php if($Access['EditProducts'] == 1 ){ ?>
                                    <a href="./Product.php?action=Edit&ProductID=<?php echo $ProductID ?>" class="btn bg-gradient-success"> Edit </a>
                                <?php }else{ ?>
                                    <button type="submit" class="btn bg-gradient-danger" disabled> Edit </button>
                                <?php } ?>
                                <?php if($Access['DeleteProducts'] == 1 ){ ?>
                                    <button name="DeleteProduct" type="submit" class="btn bg-gradient-danger"> Delete </button>
                                <?php }else{ ?>
                                    <button type="submit" class="btn bg-gradient-danger" disabled> Delete </button>
                                <?php } ?>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="product-details__image" style="display: flex;justify-content: center;">
                                    <img class="img-fluid" src="https://zhome.com.eg/Admin/Images/Uploads/<?php echo $Product['MainImage'] ?>" width="500px" style="max-height: 493px;" alt="Awesome Image" />
                                    <a href="#" class="product-details__img-popup img-popup" style="position: revert;">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </div>

                                <div class="additional-images" style="margin-left: 20px;">
                                    <?php
                                        // Fetch additional images from the database
                                        $additionalImages = "SELECT * FROM productimages WHERE ProductID = $ProductID";
                                        $additionalImages = mysqli_query($con , $additionalImages);
                                        foreach ($additionalImages as $image) {
                                        $imageUrl = $image['Image'];
                                        
                                        echo '<div class="additional-image">';
                                            echo '<img class="img-fluid" src="./Images/Uploads/' . $imageUrl . '" style="width:130px; height:130px;object-fit: cover;" alt="Additional Image" />';
                                        echo '</div>';
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="product-details__content">
                                    <!-- Product With Sale -->
                                    <?php 
                                        $PriceSale = mysqli_query($con  , "SELECT * FROM sale WHERE ProductID = $ProductID"); 
                                        $Sale = mysqli_fetch_assoc($PriceSale);
                                        $Count_Sale = mysqli_num_rows($PriceSale);
                                    ?>
                                    <form method="post" action="?ProductID=<?php echo $Product['ID'] ?>" enctype="multipart/form-data">
                                        <h3 class="product-details__title"><?php echo $Product['Name'] ?></h3>
                                        <?php if($Count_Sale > 0){  ?>
                                            <p class="product-details__price"><?php echo $Sale['PriceAfter']  . " EGP" ; ?> </p>
                                            <p class="product-details__price" style="text-decoration: line-through; font-size:19px"><?php echo $Product['Price']  . " EGP"  ?> </p>
                                        <?php }else{ ?>
                                            <p class="product-details__price"> <?php  echo $Product['Price']  . " EGP" ;  ?></p>
                                        <?php } ?>
                                        <p class="product-details__text" style="margin-right: 55px;">
                                            <?php echo $Product['Description'] ?> 
                                        </p>
                                        <p class="product-details__categories">
                                            <span class="text-uppercase">Category : </span>
                                            <a href=""><?php echo $Product['CategoryName'] ?></a>
                                                            </br>
                                            <span class="text-uppercase">Sub Category : </span>
                                            <a href=""><?php echo $Product['SubName'] ?></a>
                                                            </br>
                                            <span class="text-uppercase">Brand : </span>
                                            <a href=""><?php echo $Product['Brand'] ?></a>
                                        </p>
                                        <p class="product-details__availabelity">
                                            <span>Availability:</span>
                                            <?php echo $Product['Quantity'] . " In Stock" ; ?>
                                        </p>
                                        <h4  style="margin-top:70px;margin-bottom:30px;">Platforms</h4>
                                        <div class="Product-Platforms">
                                            <?php 
                                                $SelectPlatfroms = "SELECT productplatfrom.* , platform.* FROM productplatfrom LEFT JOIN platform ON platform.ID = productplatfrom.PlatformID WHERE ProductID = $ProductID";
                                                $Platfroms = mysqli_query($con , $SelectPlatfroms);
                                                $count_Platfroms = mysqli_num_rows($Platfroms);
                                                if($count_Platfroms > 0){
                                                    foreach($Platfroms as $Platform){ ?>
                                                        <a href="">
                                                            <div class="platform">
                                                                <img src="../Admin/Images/Uploads/<?php echo $Platform['Logo'] ?>" alt="">
                                                                <p><?php echo $Platform['Platform'] ?></p>
                                                            </div>
                                                        </a>

                                                        <?php 
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <hr class="separator">

                            <div class="col-lg-12">
                                <div class="container">
                                    <h2 class="ProductDetails-Text">
                                        <?php echo $Product['Title'] ?>
                                    </h2>
                                    <div class="Images-ProductsDetails">
                                        <div class="Image-One-ProductDetails fadeInUp">
                                            <img src="../Admin/Images/Uploads/<?php echo $Product['CoverImage'] ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="Text-under-images-ProductDetails">
                                        <div class="text-one-ProductDetails">
                                            <div class="top-text">
                                                <img src="../Admin/Images/Uploads/<?php echo $Product['BrandLogo'] ?>" alt="">
                                                <h3>Brand</h3>
                                            </div>
                                            <div class="bottom-text">
                                                <p>
                                                    <?php echo $Product['Name'] ?> is a <?php echo $Product['Brand'] ?> Brand 
                                                </p>
                                            </div>
                                            
                                        </div>
                                        <div class="text-one-ProductDetails">
                                            <div class="top-text">
                                            <i class="fa-solid fa-folder"></i>
                                            <h3>Platform</h3>
                                            </div>
                                            <div class="bottom-text">
                                                <div class="Product-Platforms" style="display: grid;gap: 10px;flex-wrap: wrap;margin-bottom: 0;">
                                                    <?php
                                                        foreach($Platfroms as $Platform){ ?>
                                                            <a href="">
                                                                <div class="platform">
                                                                    <img src="../Admin/Images/Uploads/<?php echo $Platform['Logo'] ?>" alt="">
                                                                    <p style="padding-right: 0;width: 139px !important;"><?php echo $Platform['Platform'] ?></p>
                                                                </div>
                                                            </a>

                                                            <?php 
                                                        }
                                                        ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($Product['InstallationCost'] != NULL || $Product['InstallationCost'] != 0 ){ ?>
                                            <div class="text-one-ProductDetails">
                                                <div class="top-text">
                                                    <i class="fa-solid fa-gears"></i>
                                                    <h3>Professional installation</h3>
                                                </div>
                                                <div class="bottom-text">
                                                    <p>
                                                        Available for the professional installation with only <?php echo $Product['InstallationCost'] ?> EGP.
                                                    </p>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="text-one-ProductDetails">
                                            <div class="top-text">
                                                <i class="fa-solid fa-house-signal"></i>
                                                <h3>Technology</h3>
                                            </div>
                                            <div class="bottom-text">
                                                <p>
                                                    <?php
                                                    $Technologies = mysqli_query($con , "SELECT * FROM producttechnology WHERE ProductID = $ProductID");
                                                    $count_technology = mysqli_num_rows($Technologies);
                                                    $technologyArray = array();
                                                    while ($row = mysqli_fetch_assoc($Technologies)) {
                                                        $technologyArray[] = $row['Technology'];
                                                    }
                                                    
                                                    $technologyCount = count($technologyArray);
                                                    
                                                    for ($i = 0; $i < $technologyCount; $i++) {
                                                        echo $technologyArray[$i];
                                                        if ($i < $technologyCount - 1) {
                                                            echo " - ";
                                                        }
                                                    }
                                                    
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                        <?php 
                                            $SelectCollections = mysqli_query($con , "SELECT * FROM collectionproducts LEFT JOIN collections ON collectionproducts.CollectionID = collections.ID WHERE ProductID = $ProductID");
                                            $fetchCollections = mysqli_fetch_assoc($SelectCollections);
                                            $CountCollections = mysqli_num_rows($SelectCollections);
                                            if($CountCollections > 0){
                                                foreach($SelectCollections as $Collection){
                                                    ?>
                                                        <div class="text-one-ProductDetails">
                                                            <div class="top-text">
                                                                <img src="./Images/Uploads/Collections-icon.png" alt="Collections icon">
                                                                <h3><?php echo $Collection['Name'] ?></h3>
                                                            </div>
                                                            <div class="bottom-text">
                                                                <p>
                                                                    <?php echo $Collection['Description']  ;?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    <?php 
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Expert Review -->
                            <div style="border-bottom:1px solid #eeee; margin-top: 40px;">
                                <div class="product-details__review-form">
                                    <h2 style="margin-bottom: 40px;text-align: center;">Expert Review</h2>
                                    <!-- Reviews -->
                                    <div class="product-details__review" style="margin-bottom: 40px;width: 80%;margin: auto;">
                                        <?php 
                                            $SelectReviews = "SELECT expertevaluation.* , admin.Name AS AdminName FROM expertevaluation
                                                                LEFT JOIN admin ON admin.ID = expertevaluation.ExpertID
                                                                WHERE ProductID = $ProductID
                                                                ORDER BY expertevaluation.ID DESC
                                                                ";
                                            $Reviews = mysqli_query($con , $SelectReviews);
                                            $fetch = mysqli_fetch_assoc($Reviews);
                                            foreach($Reviews as $Review){ 
                                                // $Date = date('M d, Y' ,strtotime($UserComment['Date'])) ?>
                                                <form action="" method="post" style='margin-bottom: 27px;'>
                                                    <div class="product-details__review-single">
                                                        <input type="hidden" name="ReviewID" value="<?php echo $Review['ID'] ?>">
                                                        <input type="hidden" name="UserID" value="<?php echo $Review['ExpertID'] ?>">
                                                        <div class="product-details__review-left">
                                                            <img src="../Admin/Images/avatar.png" width="70px" height="70px" alt="Image" />
                                                        </div>
                                                        <div class="product-details__review-right">
                                                            <div class="product-details__review-top">
                                                                <div class="product-details__review-top-left">
                                                                    <h3 class="product-details__review-title"><?php echo $Review['AdminName'] ?></h3>
                                                                    <span class="product-details__review-sep">-</span>
                                                                    <span class="product-details__review-date"><?php // echo $Date
                                                                                                                        echo "Expert engineer"    ?></span>
                                                                </div>
                                                                <?php if(isset($_SESSION['UserID'])){
                                                                        if($UserComment['UserID'] == $UserID ){ ?>
                                                                            <div class="product-details__review-top-right" style="position:absolute; right:37px">
                                                                                <button name='DeleteComment'style="background-color: #d99578; border:none ; color:white ; border-radius: 7px; padding: 5px 14px;"> 
                                                                                    Remove
                                                                                </button>
                                                                            </div>
                                                                        <?php }
                                                                } ?>
                                                            </div>
                                                            <p class="product-details__review-text"><?php echo $Review['Evaluation'] ?></p>
                                                        </div>
                                                    </div>
                                                </form>
                                            <?php }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Product Part 2 -->
                        <div class="row" style="margin-top: 116px;">
                            <div class="col-lg-6">
                                <div class="product-details__content ProductDetails_Section_last">
                                    <h3 class="product-details__title"><?php echo $Product['Title2'] ?></h3>
                                    <ul>
                                        <li>
                                            <span><i class="fa-solid fa-check"></i></span>
                                            <p><?php echo $Product['Brand'] ?> Brand</p>
                                        </li>
                                        <li>
                                            <span><i class="fa-solid fa-check"></i></span>
                                            <p>
                                                Compitable with
                                                    <?php 
                                                        foreach($Platfroms as $Platform){ ?>

                                                                <?php echo $Platform['Platform'] ?>

                                                            <?php 
                                                        }
                                                    ?>
                                                Platfrom
                                            </p>
                                        </li>
                                        <?php
                                            $SelectFeature = mysqli_query($con , "SELECT * FROM productfeature LEFT JOIN features ON productfeature.FeatureID = features.ID WHERE ProductID = $ProductID");
                                            $fetchFeature = mysqli_fetch_assoc($SelectFeature);
                                            $CountFeature = mysqli_num_rows($SelectFeature);
                                            foreach($SelectFeature as $Feature){
                                        ?>
                                            <li>
                                                <span><i class="fa-solid fa-check"></i></span>
                                                <p><?php echo $Feature['Feature'] ?></p>
                                            </li>
                                        <?php } ?>
                                        <li>
                                            <span><i class="fa-solid fa-check"></i></span>
                                            <p>Free Transportation</p>
                                        </li>
                                        <?php if(isset($Product['InstallationCost']) && $Product['InstallationCost'] == 0){ ?>
                                            <li>
                                                <span><i class="fa-solid fa-check"></i></span>
                                                <p>Available for installation with only <?php echo $Product['InstallationCost'] ?> EGP</p>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="product-details__image LastProductDetails">
                                    <img class="img-fluid" src="../Admin/Images/Uploads/<?php echo $Product['MainImage'] ?>" alt="Awesome Image" />
                                </div>
                            </div>
                        </div>
                    </section>

                    <!--FAQ , Video and Description-->
                    <section class="product-details">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="product-details__content">
                                        <div class="accrodion-grp" data-grp-name="product-details__accrodion">
                                            <div class="accrodion">
                                                <div class="accrodion-title">
                                                    <a href="#Description">Product Description</a>
                                                </div>
                                                <div id="Description">
                                                    <div class="inner">
                                                        <div class="product-details__review-form">
                                                            <!-- Description -->
                                                            <div class="Product-spacification">
                                                                <div class="container">
                                                                    <div class="Details">
                                                                        <h5>Capacity</h5>
                                                                        <div class="Details-info">
                                                                            <p>Capacity(m)</p>
                                                                            <span><?php echo $Product['Capacity'] ?> m</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="Details">
                                                                        <h5>Noise Level</h5>
                                                                        <div class="Details-info">
                                                                            <p>Noise(dBA)</p>
                                                                            <span>50 dBA</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="Details">
                                                                        <h5>Physical Specification</h5>
                                                                        <div class="many-details">
                                                                            <div class="Details-info">
                                                                                <p>Net Dimension(WxHxD)</p>
                                                                                <span><?php echo $Product['Width'] ?>  x <?php echo $Product['Height'] ?> x <?php echo $Product['Length'] ?>mm</span>
                                                                            </div>
                                                                            <div class="Details-info">
                                                                                <p>Net Weight(kg)</p>
                                                                                <span><?php echo $Product['Weight'] ?>KG</span>
                                                                            </div>
                                                                            <div class="Details-info">
                                                                                <p>Color</p>
                                                                                <div class="Colorsdiv">
                                                                                    <?php if(isset($Product['Color'])){ ?>
                                                                                        <span class="color" style="background-color:<?php echo $Product['Color'] ?>">
                                                                                        </span>
                                                                                    <?php }
                                                                                        if(isset($Product['Color2'])){ ?>
                                                                                        <span class="color" style="background-color:<?php echo $Product['Color2'] ?>">
                                                                                        </span>
                                                                                    <?php }
                                                                                        if(isset($Product['Color3'])){ ?>
                                                                                        <span class="color" style="background-color:<?php echo $Product['Color3'] ?>">
                                                                                        </span>
                                                                                    <?php } ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="Details">
                                                                        <h5>Air Purification</h5>
                                                                        <div class="many-details">
                                                                            <div class="Details-info">
                                                                                <p>Indcator(cleanliness)</p>
                                                                                <span><?php echo $Product['AirPurification'] ?></span>
                                                                            </div>
                                                                            <div class="Details-info">
                                                                                <p>Pre Filter</p>
                                                                                <span><?php if(isset($Product['PreFilter']) == 1 ){ echo "Yes" ; }else{ echo "No" ; }?></span>
                                                                            </div>
                                                                            <div class="Details-info">
                                                                                <p>Dust Collecting</p>
                                                                                <span><?php if(isset($Product['DustCollecting']) == 1 ){ echo "Yes" ; }else{ echo "No" ; }?></span>
                                                                            </div>
                                                                            <div class="Details-info">
                                                                                <p>Deodorizing Filter</p>
                                                                                <span><?php if(isset($Product['DeodorizingFilter']) == 1 ){ echo "Yes" ; }else{ echo "No" ; }?></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="Details">
                                                                        <h5>Electrical Date</h5>
                                                                        <div class="Details-info">
                                                                            <p>Power Consumption(W)</p>
                                                                            <span><?php echo $Product['PowerConsumption'] ?> W</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Tech details -->
                                            <div class="accrodion">
                                                <div class="accrodion-title">
                                                    <a href="#FAQ">Technical Details</a>
                                                </div>
                                                <div  id="FAQ">
                                                    <div class="inner">
                                                        <div class="product-details__review-form" style="margin-top: 33px;">
                                                            <!-- FAQ -->
                                                            <div class="product-details__review" style="margin-bottom: 40px;">
                                                                <?php 
                                                                    $SelectFAQ = "SELECT * FROM productfaq
                                                                                        WHERE ProductID = $ProductID
                                                                                        ORDER BY ID DESC
                                                                                        ";
                                                                    $FAQs = mysqli_query($con , $SelectFAQ);
                                                                    $fetch = mysqli_fetch_assoc($FAQs);
                                                                    foreach($FAQs as $FAQ){ ?>
                                                                        
                                                                            <div class="product-details__review-single" style="padding: 1px 30px;border:none;justify-content: left;">
                                                                                <input type="hidden" name="ReviewID" value="<?php echo $FAQ['ID'] ?>">
                                                                                <input type="hidden" name="ProductID" value="<?php echo $FAQ['ProductID'] ?>">
                                                                                <div class="product-details__review-right">
                                                                                    <!--<div class="product-details__review-top">-->
                                                                                    <!--</div>-->
                                                                                    <div class="FAQ"  style="gap: 0px;">
                                                                                        <div class="Question">
                                                                                            <?php echo  ucfirst(strtolower($FAQ['Question']))  ?>
                                                                                        </div>
                                                                                        <div class="Answer">
                                                                                            <p class="product-details__review-text" style="margin-bottom: 20px;"><?php echo ucfirst(strtolower($FAQ['Answer']))  ?></p>
                                                                                        </div>
                                                                                    </div>
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                    
                                                                    <?php }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Video -->
                                            <div class="accrodion">
                                                <div class="accrodion-title">
                                                    <a href="#Video">Video</a>
                                                </div>
                                                <div id="Video">
                                                    <div class="inner">
                                                        <div class="product-details__review-form" style="text-align-last: center;">
                                                            <!-- Video -->
                                                            <div class="product-details__review" style="margin-bottom: 40px;">
                                                                    <video style="width: 70%;align-self: center;height: 390px;" controls>
                                                                        <source src="<?php echo $Feature['Video'] ?>" type="video/mp4">
                                                                    </video>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

@endsection