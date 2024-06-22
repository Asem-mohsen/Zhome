@extends('User.layout.master')

@section('Title', 'Design Your Home')

@section('Css')
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('UI/css/bd-wizard.css')}}">

    <style>
        a {
            text-decoration: none !important;
        }
        #header {
            border-bottom: 1px solid #ededed;
        }
        #Icons .separator {
            border-left: 1px solid black !important;
        }
        .JoinUs {
            background: linear-gradient(to right, #154352 50%, #154352 50%);
        }
        .JoinUs:hover {
            /*background-position: left bottom;*/
            /*color: black !important;*/
            /*border: 1px solid #154352;*/
        }
        .nav-icon i {
            color: black;
        }
        .nav-button:hover {
            background-color: #1a798f;
            color: white !important;
        }
        .block-title.text-center{
            margin-top: 95px;
        }
        .menu .menu__inner .menu__item .menu__link {
            color:black;
            text-decoration:none;
        }
        ul.menu__inner{
            margin:0;
        }
        .ErrorMessages {
            top: 88px !important;
        }
        .ErrorMessages .alert {
            width: auto !important;
            font-size: 13px;
            border-right: 4px solid #155724 !important;
        }
        @media (max-width: 767px) {
            .wizard .steps {
                display: none;
            }
            .block-title.text-center{
                display: none;
            }

            #header {
                border-bottom: none !important;
            }
            .wizard .content .section-heading {
                font-size: 29px;

            }
            nav.navbar {
                border-bottom: none !important;
            }
            .MainProposal {
                min-height: auto;
            }
            .wizard .content .bd-wizard-step-title {
                font-size: 20px;
                margin: 15px 0px;
                text-align: center;
            }
            .wizard .content p {
                font-size: 13px;
            }
            .wizard .content .purpose-radios-wrapper .purpose-radio {
                margin-bottom: 8px;
            }
            .wizard .content .purpose-radio .purpose-radio-label {
                height: 80px;
                flex-direction: row ;
                justify-content: left; !important;
            }
            .wizard .content .purpose-radio .purpose-radio-label .label-icon {
                font-size: 40px !important;
                margin: 0 20px;
                margin-bottom: 0;
                width: 44px !important;
                height: auto;
            }
            .wizard .content .purpose-radio .purpose-radio-label .label-text {
                font-size: 18px;
                font-weight: 600;
            }
            .wizard .Proposal-Platforms .purpose-radio .purpose-radio-label {
                height: 80px !important;
                gap: 0 ;
                width: -webkit-fill-available !important;
            }
            #wizard-p-5 .Proposal-Platforms .purpose-radio .purpose-radio-label {
                padding-left: 20px;
                gap: 10px !important;
            }

        }
    </style>
@endsection

@section('Content')

    <main class="MainProposal">
        <div class="container">
            <div class="block-title text-center mt-3">
                <p class="block-title__tag-line text-center" >{{__('messages.GetYourDesignButton')}}</p>
            </div>

                @include('User.Components.Msg')

            <form method="POST" id="MainForm" action="{{ route('Tools.store') }}" enctype="multipart/form-data">
                @csrf
                <div id="wizard">

                    <h3>Step 1 Title</h3>
                    <!--Installed-->
                    <section>
                        <h5 class="bd-wizard-step-title">{{__('messages.Step')}} 1</h5>
                        <h2 class="section-heading">{{__('messages.Step1Question')}}</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna.</p>
                        @error('Installed')
                            <span class="alert alert-danger">{{$message}}</span>
                        @enderror
                        <div class="purpose-radios-wrapper">
                        <div class="purpose-radio">
                            <input type="radio" name="Installed" id="Home" class="purpose-radio-input installed" value="Home">
                            <label for="Home" class="purpose-radio-label">
                            <span class="label-icon">
                                <i class="fa-solid fa-house Icon" ></i>
                            </span>
                            <span class="label-text">{{__('messages.HomeQuestion1')}}</span>
                            </label>
                        </div>
                        <div class="purpose-radio">
                            <input type="radio" name="Installed" id="Flat" class="purpose-radio-input installed" value="Flat">
                            <label for="Flat" class="purpose-radio-label">
                                <span class="label-icon">
                                    <i class="fa-solid fa-building-user Icon"></i>
                                </span>
                                <span class="label-text">{{__('messages.Flat')}}</span>
                            </label>
                        </div>
                            <div class="purpose-radio">
                                <input type="radio" name="Installed" id="Office" class="purpose-radio-input installed" value="Office">
                                <label for="Office" class="purpose-radio-label">
                                    <span class="label-icon">
                                    <i class="fa-solid fa-building Icon"></i>
                                    </span>
                                    <span class="label-text">{{__('messages.Office')}}</span>
                                </label>
                            </div>
                        </div>
                    </section>

                    <h3>Step 2 Title</h3>
                    <!--Building Project-->
                    <section>
                        <h5 class="bd-wizard-step-title">{{__('messages.Step')}} 2</h5>
                        <h2 class="section-heading"> {{__('messages.Step2Question')}}</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</p>
                        @error('BuildingProject')
                            <span class="alert alert-danger">{{$message}}</span>
                        @enderror
                        <div class="purpose-radios-wrapper">
                            <div class="purpose-radio">
                                <input type="radio" name="BuildingProject" id="Finished" class="purpose-radio-input Building" value="Finished">
                                <label for="Finished" class="purpose-radio-label">
                                <span class="label-icon">
                                    <i class="fa-solid fa-house Icon"></i>
                                </span>
                                <span class="label-text">{{__('messages.Finished')}}</span>
                                </label>
                            </div>
                            <div class="purpose-radio">
                                <input type="radio" name="BuildingProject" id="SemiFinished" class="purpose-radio-input Building" value="Semi-Finished">
                                <label for="SemiFinished" class="purpose-radio-label">
                                    <span class="label-icon">
                                    <i class="fa-solid fa-paint-roller Icon"></i>
                                    </span>
                                    <span class="label-text">{{__('messages.Semi-Finished')}}</span>
                                </label>
                            </div>
                            <div class="purpose-radio">
                                <input type="radio" name="BuildingProject" id="Under-Construction" class="purpose-radio-input Building" value="Under-Construction">
                                <label for="Under-Construction" class="purpose-radio-label">
                                <span class="label-icon">
                                    <i class="fa-solid fa-person-digging Icon"></i>
                                </span>
                                <span class="label-text"> {{__('messages.UnderConstruction')}}</span>
                                </label>
                            </div>
                        </div>
                    </section>

                    <h3>Step 3 Title</h3>
                    <!--Rooms-->
                    <section>
                        <h5 class="bd-wizard-step-title">{{__('messages.Step')}} 3</h5>
                        <h2 class="section-heading">{{__('messages.Step3Question')}}</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</p>
                        @error('Rooms')
                            <span class="alert alert-danger">{{$message}}</span>
                        @enderror
                        <div class="purpose-radios-wrapper">
                            <div class="purpose-radio">
                                <input type="radio" name="Rooms" id="3" class="purpose-radio-input RoomsInput" value="3">
                                <label for="3" class="purpose-radio-label">
                                <span class="label-icon">
                                    <i class="fa-solid fa-3 Icon"></i>
                                </span>
                                <span class="label-text">{{__('messages.ThreeRooms')}} </span>
                                </label>
                            </div>
                            <div class="purpose-radio">
                                <input type="radio" name="Rooms" id="4" class="purpose-radio-input RoomsInput" value="4">
                                <label for="4" class="purpose-radio-label">
                                    <span class="label-icon">
                                    <i class="fa-solid fa-4 Icon"></i>
                                    </span>
                                    <span class="label-text">{{__('messages.FourRooms')}} </span>
                                </label>
                            </div>
                            <div class="purpose-radio">
                                <input type="radio" name="Rooms" id="Other" class="purpose-radio-input RoomsInput" onclick="openPopup()" value="Other">
                                <label for="Other" class="purpose-radio-label">
                                <span class="label-icon">
                                    <i class="fa-solid fa-ellipsis Icon"></i>
                                </span>
                                <span class="label-text">{{__('messages.Other')}} </span>
                                </label>
                            </div>
                        </div>

                        <!--PopUp-->
                        <div id="Roomspopup" class="Roomspopup">
                            <div class="popup-content">
                                <span class="close" onclick="closePopup()">&times;</span>
                                <label for="otherInput" style="margin-bottom: 18px;">{{__('messages.OtherNumbers')}}</label>
                                <input type="text" class="form-control purpose-radio-input RoomsInput" id="otherInput" name="RoomsInput">
                                <ul role="menu" aria-label="Pagination">
                                    <li aria-hidden="false" aria-disabled="false" class="" style="display: list-item;">
                                        <a href="#next" role="menuitem" style="margin-top: 18px;" onclick="submitPopup()">{{__('messages.Next')}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </section>

                    <h3>Step 4 Title</h3>
                    <!--Categroies -->
                    <section>
                        <h5 class="bd-wizard-step-title">{{__('messages.Step')}} 4</h5>
                        <h2 class="section-heading">{{__('messages.Step4Question')}}</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</p>
                        @error('Categories')
                            <span class="alert alert-danger">{{$message}}</span>
                        @enderror
                        <div class="purpose-radios-wrapper">
                            <div class="purpose-radio">
                                <input type="checkbox" name="Categories[]" id="Lighting" class="purpose-radio-input CategoriesInputs" value="Lighting" >
                                <label for="Lighting" class="purpose-radio-label">
                                <span class="label-icon">
                                    <i class="fa-solid fa-lightbulb Icon"></i>
                                </span>
                                <span class="label-text">{{__('messages.Lighting')}}</span>
                                </label>
                            </div>
                            <div class="purpose-radio">
                                <input type="checkbox" name="Categories[]" id="Heating" class="purpose-radio-input CategoriesInputs" value="Heating" >
                                <label for="Heating" class="purpose-radio-label">
                                    <span class="label-icon">
                                        <i class="fa-solid fa-fire Icon"></i>
                                    </span>
                                    <span class="label-text">{{__('messages.Heating')}}</span>
                                </label>
                            </div>
                            <div class="purpose-radio">
                                <input type="checkbox" name="Categories[]" id="Security" class="purpose-radio-input CategoriesInputs" value="Security" >
                                <label for="Security" class="purpose-radio-label">
                                    <span class="label-icon">
                                        <i class="fa-solid fa-shield-halved Icon"></i>
                                    </span>
                                    <span class="label-text">{{__('messages.Security')}}</span>
                                </label>
                            </div>
                            <div class="purpose-radio">
                                <input type="checkbox" name="Categories[]" id="Entertainment" class="purpose-radio-input CategoriesInputs" value="Entertainment" >
                                <label for="Entertainment" class="purpose-radio-label">
                                    <span class="label-icon">
                                        <i class="fa-solid fa-volume-high Icon"></i>
                                    </span>
                                    <span class="label-text">{{__('messages.Entertainment')}}</span>
                                </label>
                            </div>
                            <div class="purpose-radio">
                                <input type="checkbox" name="Categories[]" id="Shutters" class="purpose-radio-input CategoriesInputs" value="Shutters" >
                                <label for="Shutters" class="purpose-radio-label">
                                    <span class="label-icon">
                                        <i class="fa-solid fa-house-chimney-window Icon"></i>
                                    </span>
                                    <span class="label-text">{{__('messages.Shutters')}}</span>
                                </label>
                            </div>
                            <div class="purpose-radio">
                                <input type="checkbox" name="Categories[]" id="GarageGates" class="purpose-radio-input CategoriesInputs" value="GarageGates" >
                                <label for="GarageGates" class="purpose-radio-label">
                                    <span class="label-icon">
                                        <i class="fa-solid fa-warehouse Icon"></i>
                                    </span>
                                    <span class="label-text">{{__('messages.Garage-Gates')}}</span>
                                </label>
                            </div>
                            <div class="purpose-radio">
                                <input type="checkbox" name="Categories[]" id="AccessControl" class="purpose-radio-input CategoriesInputs" value="AccessControl" >
                                <label for="AccessControl" class="purpose-radio-label">
                                    <span class="label-icon">
                                        <i class="fa-solid fa-house-signal Icon"></i>
                                    </span>
                                    <span class="label-text">{{__('messages.AccessControl')}}</span>
                                </label>
                            </div>
                            <div class="purpose-radio">
                                <input type="checkbox" name="Categories[]" id="AcControl" class="purpose-radio-input CategoriesInputs" value="AcControl" >
                                <label for="AcControl" class="purpose-radio-label">
                                    <span class="label-icon">
                                        <i class="fa-solid fa-snowflake Icon"></i>
                                    </span>
                                    <span class="label-text">{{__('messages.AC-Control')}}</span>
                                </label>
                            </div>
                        </div>
                    </section>

                    <h3>Step 5 Title</h3>
                    <!--SystemType -->
                    <section>
                    <h5 class="bd-wizard-step-title">{{__('messages.Step')}} 5</h5>
                    <h2 class="section-heading"> {{__('messages.Step5Question')}} </h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</p>
                    <div class="purpose-radios-wrapper">
                        <div class="purpose-radio">
                            <input type="radio" name="SystemType" id="Wired" class="purpose-radio-input SystemTypeInput" value="Wired">
                            <label for="Wired" class="purpose-radio-label">
                            <span class="label-icon">
                                <i class="fa-solid fa-plug Icon"></i>
                            </span>
                            <span class="label-text">{{__('messages.Wired')}}</span>
                            </label>
                            </div>
                            <div class="purpose-radio">
                            <input type="radio" name="SystemType" id="Wireless" class="purpose-radio-input SystemTypeInput" value="Wireless" >
                            <label for="Wireless" class="purpose-radio-label">
                                <span class="label-icon">
                                <i class="fa-solid fa-wifi Icon"></i>
                                </span>
                                <span class="label-text">{{__('messages.Wireless')}}</span>
                            </label>
                            </div>
                    </div>
                    </section>

                    <h3>Step 6 Title</h3>
                    <!--Platforms -->
                    <section>
                        <style>
                            .wizard .Proposal-Platforms .purpose-radio .purpose-radio-label {
                                    height: 70px;
                                    flex-direction: row;
                                    align-items: center;
                                    gap: 10px;
                                    border: 1px solid #a6a6a6;
                                    filter: brightness(1.2);
                                    width: 290px;
                                    flex-wrap: wrap;
                            }
                            .Proposal-Platforms .purpose-radio span.label-icon{
                                    margin: 0 !important;
                            }
                        </style>
                        <h5 class="bd-wizard-step-title">{{__('messages.Step')}} 6</h5>
                        <h2 class="section-heading">{{__('messages.Step6Question')}}</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</p>
                        @error('Platform')
                            <span class="alert alert-danger">{{$message}}</span>
                        @enderror
                        <div class="purpose-radios-wrapper Proposal-Platforms">
                            @foreach ($platforms as $platform )
                                <div class="purpose-radio">
                                    <input type="radio" name="Platform" id="{{$platform->Platform}}" class="purpose-radio-input PlatformsInputs" value="{{$platform->Platform}}">
                                    <label for="{{$platform->Platform}}" class="purpose-radio-label">
                                    <span class="label-icon">
                                        <img src="{{asset("Admin/dist/img/web/Platforms/$platform->Logo")}}" class="label-icon-default" alt="{{$platform->Platform}}">
                                        <img src="{{asset("Admin/dist/img/web/Platforms/$platform->Logo")}}" class="label-icon-active" alt="{{$platform->Platform}}">
                                    </span>
                                    <span class="label-text">{{$platform->Platform}}</span>
                                    </label>
                                </div>
                            @endforeach
                            <div class="purpose-radio">
                                <input  type="radio" name="Platform" id="Any Platform" class="purpose-radio-input PlatformsInputs" value="Any Platform">
                                <label for="Any Platform" id="AnyPlatform" class="purpose-radio-label justify-content-center">
                                <span class="label-text">{{__('messages.AnyPlatform')}}</span>
                                </label>
                            </div>
                        </div>
                    </section>

                    <h3>Step 7 Title</h3>
                    <!--Package -->
                    <section>
                        <h5 class="bd-wizard-step-title">{{__('messages.Step')}} 7</h5>
                        <h2 class="section-heading">{{__('messages.Step7Question')}}</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</p>
                        @error('Package')
                            <span class="alert alert-danger">{{$message}}</span>
                        @enderror
                        <div class="purpose-radios-wrapper">
                            <div class="purpose-radio">
                                <input type="radio" name="Package" id="Luxury" class="purpose-radio-input PackageInput" value="Luxury">
                                <label for="Luxury" class="purpose-radio-label">
                                    <span class="label-icon">
                                        <i class="fa-regular fa-gem"></i>
                                    </span>
                                    <span class="label-text">{{__('messages.Luxury')}}</span>
                                </label>
                            </div>
                            <div class="purpose-radio">
                                <input type="radio" name="Package" id="Comfort" class="purpose-radio-input PackageInput" value="Comfort">
                                <label for="Comfort" class="purpose-radio-label">
                                    <span class="label-icon">
                                    <i class="fa-solid fa-star"></i>
                                    </span>
                                    <span class="label-text">{{__('messages.Comfort')}}</span>
                                </label>
                            </div>
                            <div class="purpose-radio">
                                <input type="radio" name="Package" id="Standard" class="purpose-radio-input PackageInput" value="Standard">
                                <label for="Standard" class="purpose-radio-label">
                                <span class="label-icon">
                                    <i class="fa-regular fa-face-smile-beam Icon"></i>
                                </span>
                                <span class="label-text">{{__('messages.Standard')}}</span>
                                </label>
                            </div>
                        </div>
                    </section>

                    <h3>Step 8 Title</h3>
                    <!--Contant -->
                    <section>
                        <style>
                            .flag-icon {
                                width: 25px;
                                margin-right: 5px;
                            }

                            .select2-selection__rendered {
                                display: none;
                            }
                        </style>

                        <h5 class="bd-wizard-step-title">{{__('messages.Step')}} 8</h5>
                        <h2 class="section-heading">{{__('messages.Step8Question')}}</h2>

                        @if (Auth::guard('web')->check())
                            <input type="hidden" name="UserID" value="{{Auth::guard('web')->user()->id}}" >
                            <div class="row mt-2">
                                <div class="col-md-5">
                                    <label for="Name" class="sr-only">{{__('messages.FirstName')}}</label>
                                    <input type="text" name="Name" id="Name" class="form-control" value="{{Auth::guard('web')->user()->Name}}" placeholder="{{__('messages.FirstName')}}" >
                                    @error('Name')
                                        <span class="alert alert-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <label for="Email" class="sr-only">{{__('messages.EmailAddress')}}</label>
                                    <input type="email" name="Email" id="Email" class="form-control" value="{{Auth::guard('web')->user()->email}}" placeholder="{{__('messages.EmailAddress')}}">
                                    @error('Email')
                                        <span class="alert alert-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-5">
                                    <label for="Phone" class="sr-only">{{__('messages.PhoneNumber')}}</label>
                                    <input type="number" name="Phone" id="Phone" class="form-control" value="{{Auth::guard('web')->user()->Phone}}" placeholder="{{__('messages.PhoneNumber')}}">
                                    @error('Phone')
                                        <span class="alert alert-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <label for="Address" class="sr-only">{{__('messages.Address')}}</label>
                                    <input type="text" name="Address" id="Address" class="form-control" value="{{Auth::guard('web')->user()->Address}}" placeholder="{{__('messages.Address')}}">
                                    @error('Address')
                                        <span class="alert alert-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-5">
                                    <label for="Country" class="sr-only">{{__('messages.Country')}}</label>
                                    <select name="Country" id="Country" class="form-control countrypicker" data-flag="true"  style="padding: 0px 25px;color: #959aa6;">
                                        <option disabled selected hidden>{{__('messages.SelectCountry')}}</option>
                                    </select>
                                    @error('Country')
                                        <span class="alert alert-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <label for="City" class="sr-only">{{__('messages.City')}}</label>
                                    <select name="City" id="City" class="form-control"  style="padding: 0px 25px;color: #959aa6;">
                                        <option disabled selected hidden>{{__('messages.SelectCity')}}</option>
                                    </select>
                                    @error('City')
                                        <span class="alert alert-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="UnkownID" value="{{ session()->getId() }}" >
                            <div class="row mt-2">
                                <div class="col-md-5">
                                    <label for="Name" class="sr-only">{{__('messages.FirstName')}}</label>
                                    <input type="text" name="Name" id="Name" class="form-control" placeholder="{{__('messages.FirstName')}}" >
                                    @error('Name')
                                        <span class="alert alert-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <label for="Email" class="sr-only">{{__('messages.EmailAddress')}}</label>
                                    <input type="email" name="Email" id="Email" class="form-control" placeholder="{{__('messages.EmailAddress')}}">
                                    @error('Email')
                                        <span class="alert alert-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-5">
                                    <label for="Phone" class="sr-only">{{__('messages.PhoneNumber')}}</label>
                                    <input type="number" name="Phone" id="Phone" class="form-control" placeholder="{{__('messages.PhoneNumber')}}">
                                    @error('Phone')
                                        <span class="alert alert-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <label for="Address" class="sr-only">{{__('messages.Address')}}</label>
                                    <input type="text" name="Address" id="Address" class="form-control" placeholder="{{__('messages.Address')}}">
                                    @error('Address')
                                        <span class="alert alert-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-5">
                                    <label for="Country" class="sr-only">{{__('messages.Country')}}</label>
                                    <select name="Country" id="Country" class="form-control countrypicker" data-flag="true"  style="padding: 0px 25px;color: #959aa6;">
                                        <option disabled selected hidden>{{__('messages.SelectCountry')}}</option>
                                    </select>
                                    @error('Country')
                                        <span class="alert alert-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <label for="City" class="sr-only">{{__('messages.City')}}</label>
                                    <select name="City" id="City" class="form-control"  style="padding: 0px 25px;color: #959aa6;">
                                        <option disabled selected hidden>{{__('messages.SelectCity')}}</option>
                                    </select>
                                    @error('City')
                                        <span class="alert alert-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <div class="form-group" style="width: -webkit-fill-available;">
                            <label for="formFile" class=""><i class="fa-solid fa-house"></i>{{__('messages.UploadTheDesign')}}  </label>
                            <div class="row">
                                <input class="FileType form-control" type="file" name='file' id="formFile" accept=".pdf, .png, .jpg, .jpeg" style="padding: 10px 21px;width: 33%;">
                                <img src="{{asset('UI/Imgs/website/Tools/AutocadHoe.jpg')}}" style="width: 177px;border-radius: 3px;" alt="Home Autocad">
                            </div>
                        </div>

                        <script>
                            document.getElementById('formFile').addEventListener('change', function() {
                                var fileInput = this;
                                var allowedExtensions = /(\.pdf|\.png|\.jpg|\.jpeg)$/i;

                                if (!allowedExtensions.exec(fileInput.value)) {
                                    alert('Invalid file type. Please select a PDF, PNG, JPG, or JPEG file.');
                                    fileInput.value = '';
                                    return false;
                                }
                            });
                        </script>
                    </section>

                    <h3>Step 9 Title</h3>
                    <!--Invoice -->
                    <section>
                        <h5 class="bd-wizard-step-title">{{__('messages.Step')}} 9</h5>
                        <h2 class="section-heading mb-5">{{__('messages.Step9Question')}}</h2>
                        <h6 class="font-weight-bold" id="Installed" style="font-size: 22px;"></h6><!-- Installed -->
                        <p> {{__('messages.Status')}}  :  <span id="BuildingType"></span></p><!-- Building Type -->
                        <p> <span id="Rooms"></span>{{__('messages.Rooms')}}  </p> <!-- Rooms -->
                        <p><span id="System"></span> {{__('messages.System')}} </p> <!-- System Type -->
                            <p><span id="Package"></span> {{__('messages.Package')}}</p> <!-- Package -->
                        <p> {{__('messages.Platforms')}} : <span id="Platforms"></span></p><!-- Platforms -->
                        <p> {{__('messages.Categories')}} : <span id="Categories"></span></p><!-- Categories -->

                        <h6 class="font-weight-bold">{{__('messages.AccountDetails')}} </h6>
                        <p class="mb-4 text-black" style="font-size: 18px;font-weight: 600;"> <span id="enteredName"></span></p>
                        <div class="d-grid">
                            <p class="mb-2">{{__('messages.Email')}}   : <span id="enteredEmail"></span></p>
                            <p class="mb-2">{{__('messages.Phone')}}   : <span id="enteredPhone"></span></p>
                            <p class="mb-2">{{__('messages.Address')}}   : <span id="enteredAddress"></span></p>
                            <p class="mb-2">{{__('messages.City')}}   : <span id="enteredCity"></span></p>
                            <p class="mb-2">{{__('messages.Country')}}   : <span id="enteredCountry"></span></p>
                        </div>
                    </section>
                </div>
            </form>
        </div>
    </main>

@endsection

@section('Js')

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="{{asset('UI/js/jquery.steps.min.js')}}"></script>
    <script src="{{asset('UI/js/bd-wizard.js')}}"></script>

    <!--Submit form-->
    <script>

        $(document).ready(function () {
            var finishLink = document.querySelector('a[href="#finish"]');
            finishLink.id = 'finishButton';

            document.getElementById('finishButton').addEventListener('click', function () {
                    document.getElementById("MainForm").submit()
            });
        });


    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>



    <script>

        $(document).ready(function () {


            $('#Country').select2({
                templateResult: formatCountry,
                templateSelection: formatCountrySelection,
                escapeMarkup: function (m) { return m; }
            });

            $('#City').select2();

            function formatCountry(country) {
                if (!country.id) {
                    return country.text;
                }

                var flagCode = country.element.value.toLowerCase();
                var flagUrl = `https://flagcdn.com/w20/${flagCode}.png`;
                var flag = `<img class="flag-icon" src="${flagUrl}" />`;
                return flag + ' ' + country.text;
            }

            function formatCountrySelection(country) {
                if (!country.id) {
                    return country.text;
                }

                var flagCode = $(country.element).data('flag');
                var flagUrl = `https://flagcdn.com/w20/${flagCode}.png`;
                var flag = `<img class="flag-icon" src="${flagUrl}" />`;
                return flag + ' ' + country.text;
            }

            var selectedCountries = ['eg', 'us', 'gb', 'fr', 'de', 'es', 'it', 'ca', 'au'];

            $.ajax({
                url: 'https://restcountries.com/v2/all',
                method: 'GET',
                success: function (response) {
                    response.forEach(function (country) {
                        if (selectedCountries.includes(country.alpha2Code.toLowerCase())) {
                            var flagCode = country.alpha2Code.toLowerCase();
                            var flagUrl = `https://flagcdn.com/w20/${flagCode}.png`;
                            var option = $('<option>', {
                                value: country.name,
                                text: country.name,
                                'data-flag': flagCode
                            }).html(`<img class="flag-icon" src="${flagUrl}" />` + ' ' + country.name);

                            $('#Country').append(option);
                        }
                    });

                    $('#Country').trigger('change');
                }
            });

            $('#Country').change(function () {
                var selectedCountry = $(this).val();
                var cities = getCityListForCountry(selectedCountry);

                $('#City').html('<option value="" disabled selected>Select City</option>' +
                    cities.map(city => '<option value="' + city + '">' + city + '</option>').join(''));

                $('#City').trigger('change');
            });

            function getCityListForCountry(countryCode) {
                const cities = {
                    "United States of America": ["New York", "Los Angeles", "Chicago", "Houston", "Phoenix"],
                    "Egypt": ["Cairo", "Giza", "Alexandria", "Redsea", "South Sinai", "North Sinai", "Marsa Alm"],
                    "United Kingdom of Great Britain and Northern Ireland": ["London", "Birmingham", "Manchester", "Leeds", "Glasgow"],
                    "France": ["Paris", "Marseille", "Bordeaux", "Lyon", "Nice"],
                    "Canda": ["Toronto", "Vancouver", "Montreal", "Ottawa", "Calgary"],
                    "Italy": ["Florence", "Milan", "Naples", "Rome", "Venice", "Genoa", "Verona"],
                    "Australia": ["Sydney", "Melbourne", "Brisbane", "Perth", "Canberra", 'Darwin'],
                    "Spain": ["Madrid", "Seville", "Barcelona", "Valencia", "Malaga"],
                    "Germany": ["Berlin", "Hamburg", "Munich", "Cologne", "Frankfurt"],
                };
                return cities[countryCode] || [];
            }
        });
            document.addEventListener('DOMContentLoaded', function () {
                var errorMessagesDiv = document.getElementById('errorMessages');

                if (errorMessagesDiv) {
                    setTimeout(function () {
                        errorMessagesDiv.style.display = 'none';
                    }, 5000);
                }
            });
    </script>

    <!-- Add to Cart -->
    <script>
        updateCartCount()
    </script>
@stop
