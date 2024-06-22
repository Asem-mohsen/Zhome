@extends('User.layout.master')

@section('Title', 'Profile')


@section('Css')
    <style>
        @media (max-width: 767px){
            .ControlProfile a {
                width: -webkit-fill-available;
            }
            .ControlProfile button{
                width: -webkit-fill-available;
            }
            .NumbersCard{
                height: -webkit-fill-available !important;
            }
            .related-product__carousel .owl-nav {
                display:none;
            }
            #PastOrders{
                height: auto;
            }
        }
        .card#PastOrders{
                height: auto;
        }
            .shop-background.site-banner.jarallax.min-height300.padding-large{
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .card-body.text-center{
                display: grid;
                justify-items: center;
            }
    </style>
@endsection

@section('Content')

    <section class="shop-background site-banner jarallax min-height300 padding-large" style="background: url({{asset('UI/Imgs/website/Profile/Background.jpg')}}); no-repeat;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-title text-white">{{ __('messages.Profile')}}</h1>
                    <div class="breadcrumbs">
                    <span class="item">
                        <a href="{{route('index')}}" class="text-white">{{ __('messages.Home')}} /</a>
                    </span>
                    <span class="item text-white">{{ __('messages.Profile')}}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--UnVerified Email-->
    @if($user->email_verified_at == NULL)
        <section>
            <div class="container">
                <div class="alert alert-warning text-center">
                    {{ __('messages.ActivationText')}}
                </div>
            </div>
        </section>
    @endif

    <section>
        <div class="container py-5">
            <div class="row RowReverseInArabic">
                <div class="col-lg-4">
                    <!-- Side Card -->
                    <div class="card mb-4" style="border-radius: 14px;">
                        <div class="card-body text-center">
                            <img src="{{asset('Admin/dist/img/avatar.png')}}" alt="User Avatar" class="rounded-circle img-fluid" style="width: 150px;">
                            <h5 class="my-3">{{$user->Name}}</h5>
                            <p class="text-muted mb-1">{{$user->Phone ? "0". $user->Phone : __('messages.EditPhoneNumber') }}</p>
                            <p class="text-muted mb-4">{{$user->Address ? $user->Address : __('messages.EditAddress') }}</p>
                        </div>
                    </div>
                    <!-- Side Nav -->
                    <div class="card mb-4 mb-lg-0"  style="border-radius: 14px;">
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush rounded-3" role="tablist">
                                <li class="list-group-item d-flex justify-content-center align-items-center nav-item p-3" role="presentation">
                                    <a class="nav-link profile-link mb-0 active" data-bs-toggle="tab" href="#Settings" role="tab" aria-selected="true">
                                        {{ __('messages.Settings')}}
                                    </a>
                                </li>
                                <li class="list-group-item d-flex justify-content-center align-items-center nav-item p-3" role="presentation">
                                    <a class="nav-link profile-link mb-0" data-bs-toggle="tab" href="#PastOrders" role="tab" aria-selected="false">
                                        {{ __('messages.Orders')}}
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 tab-content">
                    <!-- Info Card -->
                    <div class="card mb-4 tab-pane fade show active" id="Settings" style="border-radius: 14px;">
                        <form action="" method="post">
                            <div class="card-body">
                                <div class="row RowReverseInArabic">
                                    <div class="col-sm-3">
                                        <p class="mb-0">{{ __('messages.FullName')}}</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{$user->Name}}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row RowReverseInArabic">
                                    <div class="col-sm-3">
                                        <p class="mb-0">{{ __('messages.Email')}}</p>
                                    </div>
                                    <div class="col-sm-9 RowReverseInArabic d-felx align-items-center flex-wrap" style="gap: 29px">
                                        <p class="text-muted mb-0">{{$user->email}}</p>
                                        <?php if($User['is_verified'] == 0 ){ ?>
                                            <span class="badge badge-warning">{{ __('messages.unverified')}}</span>
                                        <?php }else{ ?>
                                            <span class="badge badge-success">{{ __('messages.verified')}}</span>
                                        <?php } ?>

                                    </div>
                                </div>
                                <hr>
                                <div class="row RowReverseInArabic">
                                    <div class="col-sm-3">
                                        <p class="mb-0">{{ __('messages.Phone')}}</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{$user->Phone ? "0". $user->Phone : __('messages.EditPhoneNumber') }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row RowReverseInArabic">
                                    <div class="col-sm-3">
                                        <p class="mb-0">{{ __('messages.Address')}}</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{$user->Address ? $user->Address : __('messages.EditAddress') }}</p>
                                    </div>
                                </div>
                                <hr>
                                <p class="mb-0 text-center">{{ __('messages.ControlyourAccount')}}</p>
                                <div class="row RowReverseInArabic">
                                    <div class="col-sm-12 mt-15 d-flex ControlProfile justify-content-center flex-wrap mt-2 " style="gap: 15px">
                                        <a href="{{route('Profile.edit', $user->id)}}" class="btn btn-success">{{ __('messages.UpdateyourInformation')}}</a>
                                        <button name="Deactivate" onclick="DeactivateAccount()" class="btn btn-danger">{{ __('messages.DeactivateAccount')}}</button>
                                        <button name="Delete" onclick="DeleteAccount() " class="btn btn-danger">{{ __('messages.DeleteAccount')}}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!--  Orders Card-->
                    <div class="card mb-4 tab-pane fade" id="PastOrders" style="border-radius: 14px;height: 107rem;">
                        <div class="card-body">

                            <!-- Statistics for all -->
                            <div class="row">
                                <div class="col-xl-12 col-sm-12 mb-xl-0 mb-4">
                                    <div class="card NumbersCard" style="height: 118px;">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="numbers">
                                                        <p class="text-sm mb-0 text-uppercase font-weight-bold" style="font-size: 25px;"><?php echo $FullName[0] ?>{{ __('messages.Orders')}} </p>
                                                        <h5 class="font-weight-bolder text-center" >
                                                            @if($orderStatistics)
                                                                {{ $orderStatistics->TotalNumberOfOrders }}
                                                            @else
                                                                {{ "0" }}
                                                            @endif
                                                        </h5>
                                                        <p class="mb-0 text-center" style="font-size: 16px;font-weight: 700;">
                                                            @if($orderStatistics)
                                                                {{ __('messages.since') .  date('d-M Y' , strtotime($orderStatistics->MinOrderDate)) }}  
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-4 text-end">
                                                    <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle d-flex justify-content-center w-100 align-items-center h-100">
                                                        <i class="fa fa-box-open text-lg opacity-10" style="font-size: 55px;color: #3a3a3a;" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>

                            <!--Track Order-->

                            <?php
                                //   $UserID = $_SESSION['UserID'];
                                //   $SessionID = session_id();
                                //   $SelectOrder = mysqli_query($con , "SELECT orders.* , product.* , OrderDelivery.* , transactions.* , product.Name AS ProductName , orders.Quantity AS QuantityBought , orders.Address AS ShippingAddress, orders.Price AS ItemPrice, orders.TransactionID AS UserTransactionID , user.Email AS UserEmail
                                //                                         FROM orders
                                //                                         LEFT JOIN transactions ON transactions.ID = orders.TransactionID
                                //                                         LEFT JOIN OrderDelivery ON OrderDelivery.TransactionID = transactions.ID
                                //                                         LEFT JOIN product ON product.ID = orders.ProductID
                                //                                         LEFT JOIN user ON user.ID = orders.UserID
                                //                                         WHERE OrderDelivery.DeliveryStatus != 1 AND orders.Status = 1 AND user.ID = $UserID AND DeliveryEstimatedArrivalTime > CURDATE()");
                                //   $Orders = mysqli_fetch_assoc($SelectOrder);
                                //   $CountRows = mysqli_num_rows($SelectOrder);

                                //   $SelectInstallation = mysqli_query($con,"SELECT SUM(Total + WithInstallation) AS Total FROM orders LEFT JOIN user ON user.ID = orders.UserID WHERE UserID = $UserID  AND (orders.SessionID = '$SessionID' OR user.SessionID = orders.SessionID) AND orders.Status = 1");
                                //     $TotalSum= mysqli_fetch_assoc($SelectInstallation);

                                //     if($CountRows > 0){
                            ?>
                                    <h1 class="sub-header">{{__('messages.TrackOrder')}}</h1>
                                    <div class="card">
                                        <div class="Success-invoice">
                                            <div class="invoice text-center">
                                            <p>Order ID [ {{$order->ID}} ]</p>
                                            <p>Ordered in  {{date('d-M Y', strtotime($order->created_at))}} </p>
                                            <div class="Invoice-items">
                                                @foreach($SelectOrder as $Invoice)
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{asset("Admin/dist/img/webProducts/MainImage/$order->MainImage")}}" class="InvoiceProductImg" alt="Product Image">
                                                            <ul>
                                                                <li>{{ ucfirst(strtolower($order->Name)) }}</li>
                                                                <li>x{{ 'x' . $order->Quantity }}</li>
                                                                <li>{{__('messages.Pice') . $invoce->Total . "EGP"}}</li>
                                                                @if($Invoice['WithInstallation'] != 0)
                                                                    <li>{{__('messages.InstallationPrice') . $invoce->InstallationCost . "EGP"}} </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                @endforeach
                                            </div>

                                                <p>{{__('messages.DeliveryFees') . $order->DeliveryCost}}</p>
                                                <p> {{__('messages.EstimatedArrivalDate') . date('d-M h:i A', strtotime($order->DeliveryEstimatedArrivalTime)) }}</p>
                                                <div class="Invoice-totals">
                                                    <!--the user used a promocode-->
                                                @if($order->PromoCodeID)
                                                    <p>{{__('messages.PromoUsed') . $PromocodeUsed->Promocode}}</p>
                                                    <p>{{__('messages.Total') . $PromocodeUsed->Total . "EGP"}}</p>
                                                @else
                                                    <p>{{__('messages.Total') . $TotalSum->Total . "EGP"}}</p>
                                                @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <hr>

                            <!-- Purchased -->
                            <h1 class="sub-header">{{__('messages.YourPastOrders')}}</h1>
                            <div class="row">
                                <div class="related-product__carousel owl-carousel owl-theme">
                                    @if($userProducts)
                                        @foreach($userProducts as $product)
                                                <style>
                                                    .product-one__single{
                                                        margin-left: 20px;
                                                    }
                                                </style>
                                                <div class="item">
                                                    <x-user.product-card-user :variable="$product" :productID="$product->ID" />
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="col-lg-12 col-md-6 wow fadeInUp text-center" data-wow-duration="1500ms">
                                            <a href="{{route('Shop.index')}}" class="btn btn-info">{{__('messages.ShopNowButton')}}</a>
                                        </div>
                                    @endif
                            </div>

                            <hr>

                            <!-- Dicover Our Products Slider -->
                            <h1 class="sub-header mt-5 pt-4">{{__('messages.DiscoverourProducts')}}</h1>
                            <div class="related-product__carousel owl-carousel owl-theme">
                                @foreach($products as $product)
                                    <style>
                                        .product-one__single{
                                            width: 251px !important;
                                        }
                                    </style>
                                    <div class="item">
                                        <x-user.product-card-user :variable="$product" :productID="$product->ID" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('Js')
    <script>
        updateCartCount();

        // Alert
        function DeactivateAccount(){
            alert("By deactivating your account, you cannot access your account. if you want to get your account back just contact one of our customer service.")
        }
        function DeleteAccount(){
            alert("By Deleting your account, all your data will be truncated from our system so please think again.")
        }

        $(document).ready(function() {
        // Add click event for the navigation tabs
            $('.list-group-flush li a').click(function(e) {
                e.preventDefault();
                var targetDiv = $(this).attr('href');
                $('.list-group-flush li a').removeClass('active');
                $('div').removeClass('show active');
                $(this).addClass('active');
                $(targetDiv).addClass('show active');
            });
        });
    </script>
@stop
