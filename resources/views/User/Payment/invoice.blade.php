
        <?php
            // $TransactionID = $_GET['TransactionID'] ;
            // if(!empty($TransactionID) && isset($TransactionID)){
            //     if(isset($_SESSION['UserID'])){
            //         $SessionID = session_id();
            //                                                 // LEFT JOIN user ON user.ID = orders.UserID

            //         $SelectOrder = mysqli_query($con , "SELECT orders.* , product.* ,transactions.*, product.Name AS ProductName , orders.Quantity AS QuantityBought , orders.Address AS ShippingAddress, orders.Price AS ItemPrice, orders.TransactionID AS UserTransactionID , user.Email AS UserEmail
            //                             FROM orders
            //                             LEFT JOIN transactions ON transactions.ID = orders.TransactionID
            //                             LEFT JOIN product ON product.ID = orders.ProductID
            //                             LEFT JOIN user ON user.ID = orders.UserID
            //                             WHERE orders.TransactionID = $TransactionID AND orders.Status = 1 AND UserID = $UserID ");
            //         $Orders = mysqli_fetch_assoc($SelectOrder);
            //         if(isset($Orders['UserID'])){
            //             $UserID = $Orders['UserID'];
            //         }
            //         $TransactionIDofuser = $Orders['UserTransactionID'];

            //         $UserSuccess = mysqli_query($con , "SELECT * FROM user WHERE ID = $UserID AND SessionID = '$SessionID'");
            //         $UserSuccessResult = mysqli_fetch_assoc($UserSuccess);

            //         // Check if Promocode is NULL or Not
            //         if(isset($Orders['PromoCodeID'])){
            //             $PromoCodeID = $Orders['PromoCodeID'];
            //             $SelectPromoCode = mysqli_query($con,"SELECT promocode.* FROM promocode LEFT JOIN orders ON promocode.ID = orders.PromoCodeID WHERE PromoCodeID = $PromoCodeID AND UserID = $UserID AND TransactionID = '$TransactionID' GROUP BY promocode.ID");
            //             $PromocodeUsed= mysqli_fetch_assoc($SelectPromoCode);
            //             $CountPromocode = mysqli_num_rows($SelectPromoCode);
            //             if($CountPromocode > 0 ){
            //                 $Discount = $PromocodeUsed['Save'] ;
            //                 $SelectInstallation = mysqli_query($con,"SELECT SUM(Total + WithInstallation) AS Total FROM orders WHERE UserID = $UserID AND Status = 1 AND TransactionID = '$TransactionID'");
            //                 $TotalSum= mysqli_fetch_assoc($SelectInstallation);
            //                 $DiscountAmount = $TotalSum['Total']  * ($Discount / 100);
            //                 $Total = $TotalSum['Total'] - $DiscountAmount;

            //             }
            //         }else{
            //             $SelectInstallation = mysqli_query($con,"SELECT SUM(Total + WithInstallation) AS Total FROM orders WHERE UserID = $UserID AND Status = 1 AND TransactionID = '$TransactionID'");
            //             $TotalSum= mysqli_fetch_assoc($SelectInstallation);

            //         }

            //     }
            //         header("Location: https://zhome.com.eg/Front/Cart.php");
            //         exit();

            //     }

            ?>
            <!--Security -->
            @if($TransactionIDofuser == $TransactionID)


                {{-- <style>
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
                         <a href="{{route('Shop.index')}}"class="cta ShopNowButton" style="margin-top:40px;">
                            <span class="hover-underline-animation"><?php echo lang('ContinueShopping') ?></span>
                            <svg viewBox="0 0 46 16" height="10" width="30" xmlns="http://www.w3.org/2000/svg" id="arrow-horizontal">
                                <path transform="translate(30)" d="M8,0,6.545,1.455l5.506,5.506H-30V9.039H12.052L6.545,14.545,8,16l8-8Z" data-name="Path 10" id="Path_10"></path>
                            </svg>
                        </a>
                    </div>
                </section> --}}
            @endif