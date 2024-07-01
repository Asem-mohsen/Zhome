@extends('User.layout.master')

@section('Title', 'Checkout')


@section('Css')
    <link rel="stylesheet" href="{{asset('UI/css/bd-wizard.css')}}">

    <style>
        a{
            text-decoration: none !important;
        }
        .select2-selection__rendered {
                display: none;
        }
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
        .product-checkout-page{
            width: 250px;
        }
    </style>
@endsection

@section('Content')

    <!-- Cart -> Checkout -> Payment -->
    <section>
        <div class="container">
            <div class="CartHeader">
                <p>
                    {{ __('messages.Cart')}}
                </p>
                >
                <p class="active">
                    {{ __('messages.Checkout')}}
                </p>
                >
                <p>
                    {{ __('messages.Payment')}}
                </p>
            </div>
        </div>
    </section>

    <!-- Checkout form -->
    <section>
        <div class="container">
            <div class="Checkout d-block">
                <!--Total Summary -->
                <div class="Summery">
                    <div class="Receipt">
                        <h4>{{ __('messages.ReceiptSummary')}}</h4>
                        <!-- Product One -->
                        <div class="smallSummary">
                            @foreach($orders as $order)
                                <ul>
                                    <div class="product-checkout-page">
                                        <img src="{{asset('Admin/dist/img/web/Products/MainImage/' . $order->product->MainImage)}}" alt="{{$order->product->Name}}">
                                        <div>
                                            <li>{{$order->product->Name}}</li>
                                            <li>x{{$order->Quantity}}    </li>
                                            <li>{{ __('messages.Price'). " "  . $order->Price . " EGP"}}</li>
                                            @if($order->WithInstallation != 0)
                                                <li>{{ __('messages.InstallationPrice') . $order->product->InstallationCost . " EGP" }}</li>
                                            @endif
                                            @if($order->product->sale)
                                                <li>{{ __('messages.Saved') . ": " . ($order->Product->Price - $order->product->sale->PriceAfter). " EGP" }}</li>
                                            @endif
                                        </div>
                                    </div>
                                </ul>
                            @endforeach
                        </div>
                    </div>
                    
                    <p id="deliveryFees"></p>
                    <h6 id="promocode-div" style="display:none;">{{ __('messages.Promocode') }} <span id="promocode"></span></h6>
                    <h6 id="FinalBeforePromoHide"></h6>
                    <h6 id="FinalCheckoutHide" style="display:none;">{{ __('messages.Total') }} <span id="FinalCheckout"></span></h6>
                    <input type="hidden" id="deliveryFeesValue" value="">
                    <input type="hidden" id="TotalCheckout" value="">
                    <input type="hidden" id="TotalCheckoutAfterPromo" value="">
                </div>

                <div id="wizard" class="mb-4">
                    @if(Auth::guard('web')->check()) 
                        <input type="hidden" id="SessionExists" value="1">
                    @endif
                    
                    <!--User Info-->
                    <h3>Step 1 Title</h3>
                    <section>
                        <div class="Userform">

                            <h4>{{ __('messages.ContactInformation')}}</h4>
                            @if(Auth::guard('web')->check())

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="UserName" class="form-control-label">{{ __('messages.CheckoutName')}}</label>
                                            @if(!Auth::guard('web')->check() || (Auth::guard('web')->check() && $userData->is_verified == 0))
                                                <input class="form-control" id="UserName" type="text" name="Name" value="{{ $userData->Name ?? '' }}" autocomplete="off">
                                            @else
                                                <input class="form-control" id="UserName" type="text" name="Name" value="{{ $userData->Name ?? '' }}" autocomplete="off" disabled>
                                            @endif
                                            {{-- @if($user->is_verified && $user->is_verified == 0 )
                                                <input class="form-control" id="UserName" type="text" name="Name" value="@if($user->Name) {{ $user->Name }}" autocomplete="off" >
                                            @else
                                                <input class="form-control" id="UserName" type="text" name="Name" value="@if($user->Name) {{ $user->Name }}" autocomplete="off" disabled>
                                            @endif --}}

                                            <input class="form-control" id="FirstName" type="hidden" name="FirstName" value="{{$firstName}}">
                                            <input class="form-control" id="LastName"  type="hidden" name="LastName" value="{{$lastName}}" >

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="UserEmail" class="form-control-label">{{ __('messages.CheckoutEmail')}}</label>
                                            {{-- @if($user->is_verified && $user->is_verified == 0 )
                                                <input class="form-control" id="UserEmail" type="email"  name="Email" value="@if($user->email) {{ $user->email }}" autocomplete="off">
                                            @else
                                                <input class="form-control" id="UserEmail" type="email"  value="@if($user->email) {{ $user->email }}" autocomplete="off" disabled>
                                            @endif --}}
                                            @if(!Auth::guard('web')->check() || (Auth::guard('web')->check() && $userData->is_verified == 0))
                                                <input class="form-control" id="UserEmail" type="email" name="email" value="{{ $userData->email ?? '' }}" autocomplete="off">
                                            @else
                                                <input class="form-control" id="UserEmail" type="email" value="{{ $userData->email ?? '' }}" autocomplete="off" disabled>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="UserMainAddress" class="form-control-label">{{ __('messages.CheckoutAddress')}}</label>
                                            <textarea class="form-control" id="UserMainAddress" name="Address" >{{ $userData->Address ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="UserPhone" class="form-control-label">{{ __('messages.CheckoutPhone')}}</label>
                                            <input class="form-control" id="UserPhone" type="number"  name="Phone" value="@if (isset($userData->Phone)) {{ '0' . $userData->Phone }} @endif">                                                        
                                        </div>
                                    </div>
                                </div>

                            @else

                                <div class="DarkShadow">
                                    <div id="signInOverlay" class="overlaySignIn">
                                        <div class="cardOverlay" id="signInCard">
                                            <h2>{{ __('messages.ZhomeCommunity')}}</h2>
                                            <p style="font-size: 13px;">{{ __('messages.ZhomeCommunityText')}}</p>
                                            <div class="Div-Overlay-Sign">
                                                <div class="InnerDiv-Overlay">
                                                    <a href="{{route('login')}}" class="ButtonSignInOverlay"><img src="{{asset('UI/Imgs/website/Cart/refer.png')}}" alt="Sign In"></a>
                                                    <p class="small-txt">{{ __('messages.HaveAccount')}}</p>
                                                </div>
                                                <div class="InnerDiv-Overlay">
                                                    <a href="{{route('register')}}" class="ButtonSignUpOverlay"><img src="{{asset('UI/Imgs/website/Cart/add-user.png')}}" alt="Sign Up"></a>
                                                    <p class="small-txt">{{ __('messages.ZhomeCommunityNewUser')}} </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="FirstName" class="form-control-label">{{ __('messages.FirstName')}}</label>
                                                <input class="form-control" id="FirstName" type="text" name="FirstName" autocomplete="off" value="{{$firstName}}"  disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="LastName" class="form-control-label">{{ __('messages.LastName')}}</label>
                                                <input class="form-control" id="LastName" type="text" name="LastName" autocomplete="off" value="{{$lastName}}"  disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="UserEmail" class="form-control-label">{{ __('messages.CheckoutEmail')}}</label>
                                                <input class="form-control" id="UserEmail" type="email"  name="email" autocomplete="off" value="{{ $userData->email ?? '' }}" disabled >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="UserPhone" class="form-control-label">{{ __('messages.CheckoutPhone')}}</label>
                                                <input class="form-control" id="UserPhone" type="number"  name="Phone" autocomplete="off" value="@if (isset($userData->Phone)) {{ '0' . $userData->Phone }} @endif" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="UserCity" class="form-control-label">{{ __('messages.City')}}</label>
                                                <input class="form-control" id="UserCity" type="text"  name="City" value="{{ $userData->City ?? '' }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="UserCountry" class="form-control-label">{{ __('messages.Country')}}</label>
                                                <input class="form-control" id="UserCountry" type="text"  name="Country" value="{{ $userData->Country ?? '' }}" disabled>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="UserAddress" class="form-control-label">{{ __('messages.CheckoutAddress')}}</label>
                                                <textarea class="form-control" id="UserAddress" name="Address" disabled>{{ $userData->Address ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="UserBuilding" class="form-control-label">{{ __('messages.Building')}}</label>
                                                <input class="form-control" id="UserBuilding" type="text"  name="Building" value="{{ $userData->Building ?? '' }}" disabled >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="UserFloor" class="form-control-label">{{ __('messages.Floor')}}</label>
                                                <input class="form-control" id="UserFloor" type="number"  name="Floor" value="{{ $userData->Floor ?? '' }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="UserApartment" class="form-control-label">{{ __('messages.Apartment')}}</label>
                                                <input class="form-control" id="UserApartment" type="number"  name="Apartment" value="{{ $userData->Apartment ?? '' }}" disabled>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            @endif

                        </div>
                    </section>

                    <!--Address-->
                    <h3>Step 2 Title</h3>
                    <section>
                        <div class="Userform">
                            <h4>{{ __('messages.ShippingInformation')}}</h4>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="UserShippingAddress" class="form-control-label">{{ __('messages.CheckoutAddress')}}</label>
                                            <textarea class="form-control" id="UserShippingAddress" name="UserShippingAddress" data-original-value="{{ $userData->UserShippingAddress ?? '' }}"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="UserCountry">Country</label>
                                            <select name="Country" id="UserCountry" class="form-control">
                                                @if(isset($userData->Country))
                                                    <option value="{{$userData->Country}}" selected>{{$userData->Country}}</option>
                                                @else
                                                    <option disabled selected hidden>{{ __('messages.SelectCountry')}}</option>
                                                @endif
                                                    <option value="United Arab Emarits">United Arab Emarits</option>
                                                    <option value="Egypt">Egypt</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="UserCity">City</label>
                                            <select name="City" id="UserCity" class="form-control">
                                                @if(isset($userData->City))
                                                    <option value="{{$userData->City}}" selected>{{$userData->City}}</option>
                                                @else
                                                    <option disabled selected hidden>{{ __('messages.SelectCity')}}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="UserBuilding" class="form-control-label">{{ __('messages.Building')}}</label>
                                                <input class="form-control" id="UserBuilding" type="text"  name="Building" data-original-value="{{ $userData->Building ?? '' }}" value="{{ $userData->Building ?? '' }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="UserFloor" class="form-control-label">{{ __('messages.Floor')}}</label>
                                            <input class="form-control" id="UserFloor" type="text"  name="Floor" data-original-value="{{ $userData->Floor ?? '' }}" value="{{ $userData->Floor ?? '' }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="UserApartment" class="form-control-label">{{ __('messages.Apartment')}}</label>
                                            <input class="form-control" id="UserApartment" type="text"  name="Apartment" data-original-value="{{ $userData->Apartment ?? '' }}" value="{{ $userData->Apartment ?? '' }}" >
                                        </div>
                                    </div>
                                </div>

                        </div>
                    </section>

                    <!--Promocode-->
                    <h3>Step 3 Title</h3>
                    <section>
                        <h4 class="text-center mb-5" style="font-size: 30px;">{{ __('messages.Promocode')}}</h4>
                        <div class="PromocodeInput">
                            <div class="form-group d-flex align-items-center">
                                <input class="form-control" type="text" id="promoCodeInput" name="Promocode" placeholder="{{ __('messages.Promocode')}}" autocomplete="off">
                                <button class="btn btn-primary p-2" type="submit" id="checkPromoCodeButton" onclick="applyPromoCode()">{{ __('messages.Check')}}</button>
                            </div>
                        </div>
                    </section>

                    <!--Payment-->
                    <h3>Step 4 Title</h3>
                    <section>
                        <h4 class="text-center mb-5" style="font-size: 30px;">{{ __('messages.PaymentOptions')}}</h4>
                        <form method="post">
                            @if(Auth::guard('web')->check())
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
                                            <div class="new">{{ __('messages.PaywithCard')}}</div>
                                        </div>
                                    </div>
                                    <button class="button-COD" style="--clr: #00ad54;" onclick="COD()"  id="CODButton">
                                        <span class="button-decor"></span>
                                        <div class="button-content">
                                            <div class="button__icon">
                                                <img src="{{asset('UI/Imgs/website/Cart/cash-on-delivery.png')}}" alt="Cash on Delivery">
                                            </div>
                                            <span class="button__text">{{ __('messages.CashOnDelivery')}}</span>
                                        </div>
                                    </button>
                                </div>
                            @endif
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
            <div class="col-lg-12 p-0">
                <div class="ShopNowInCart" style="background-image: url({{asset('UI/Imgs/website/Cart/bence-boros-anapPhJFRhM-unsplash.jpg')}});">
                    <h4>
                        {{ __('messages.CheckTheNewest')}}<br>
                        Apple Products
                    </h4>
                    <a href="{{route('Shop.index')}}" class="btn btn-secondary">{{ __('messages.ShopNowButton')}}</a>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('Js')
    <script src="{{asset('UI/js/jquery.steps.min.js')}}"></script>
    <script src="{{asset('UI/js/bd-wizard-cart.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        //  Code to update inputs ontime
        // document.addEventListener('DOMContentLoaded', function () {
        //     var formControls = document.querySelectorAll(".Checkout #wizard .form-control");

        //     formControls.forEach(function (inputElement) {
        //         inputElement.addEventListener('input', function () {
        //             clearTimeout(inputElement.timeout);
        //             inputElement.timeout = setTimeout(function () {
        //                 sendDataToPHP(inputElement);
        //             }, 500);
        //         });
        //     });

        // });
    </script>

    <script>

        let totalPrice = {{ $total }};
        let promoCodeDiscount = 0;
        let deliveryCost = 0;
        var messages = {
            total: "{{ __('messages.Total') }}",
        };

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('promoCodeInput').addEventListener('change', applyPromoCode);
            document.getElementById('UserCity').addEventListener('change', applyDeliveryCost);

            displayTotalPrice();
        });

    </script>

    <script>
        $(document).ready(function () {
            var manualCities = {
                "United States of America": ["New York", "Los Angeles", "Chicago", "Houston", "Phoenix"],
                "United Arab Emarits": ["Abu Dhabi", "Dubai", "Sharjah", "Ras Al-Khaimah", "Ajman"],
                "Egypt": ["Cairo", "Giza", "Alexandria", "Redsea", "South Sinai", "North Sinai", "Marsa Alm"],
                "United Kingdom": ["London", "Birmingham", "Manchester", "Leeds", "Glasgow"],
                "France": ["Paris", "Marseille", "Bordeaux", "Lyon", "Nice"],
                "Canada": ["Toronto", "Vancouver", "Montreal", "Ottawa", "Calgary"],
                "Italy": ["Florence", "Milan", "Naples", "Rome", "Venice", "Genoa", "Verona"],
                "Australia": ["Sydney", "Melbourne", "Brisbane", "Perth", "Canberra", 'Darwin'],
                "Spain": ["Madrid", "Seville", "Barcelona", "Valencia", "Malaga"],
                "Germany": ["Berlin", "Hamburg", "Munich", "Cologne", "Frankfurt"],
            };
            $('#UserCountry').change(function () {
                var selectedCountry = $(this).val();
                var cities = manualCities[selectedCountry] || [];

                $('#UserCity').html('<option value="">Select City</option>' + cities.map(city => `<option value="${city}">${city}</option>`).join(''));
            });

            $('#UserCountry').trigger('change');

        });
    </script>
@stop
