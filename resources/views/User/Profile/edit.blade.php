@extends('User.layout.master')

@section('Title', 'Edit Profile')

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
                    <span class="item text-white">{{ __('messages.EditProfile')}}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container py-5">
            <div class="row">
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
                                <li class="list-group-item d-flex justify-content-center align-items-center nav-item p-3" role="presentation" style="border-radius: 12px;">
                                    <a class="nav-link profile-link mb-0 active" data-bs-toggle="tab" href="#Settings" role="tab" aria-selected="true">
                                        {{ __('messages.Settings')}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 tab-content">
                    <!-- Info Card -->
                    <div class="card mb-4 tab-pane fade show active" id="Settings" style="border-radius: 14px;">
                        <form action="{{route('Profile.update' , $user->id)}}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">{{ __('messages.FullName')}}</p>
                                    </div>
                                    <div class="form-group col-sm-9">
                                        <input type="text" class="form-control" name="Name" value="{{$user->Name}}>">
                                    </div>
                                    @error('Name')
                                        <span class="alert alert-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">{{ __('messages.Email')}}</p>
                                    </div>
                                    <div class="form-group col-sm-9">
                                        <input type="email" class="form-control" name="email" value="{{$user->email}}>">
                                    </div>
                                    @error('email')
                                        <span class="alert alert-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">{{ __('messages.Phone')}}</p>
                                    </div>
                                    <div class="form-group col-sm-9">
                                        <input type="phone" class="form-control" name="Phone" value="{{$user->Phone ? "0". $user->Phone : '' }}">
                                    </div>
                                    @error('Phone')
                                        <span class="alert alert-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">{{ __('messages.Address')}}</p>
                                    </div>
                                    <div class="form-group col-sm-9">
                                        <input type="text" class="form-control" name="Address" value="{{$user->Address ? $user->Address : '' }}">
                                    </div>
                                    @error('Address')
                                        <span class="alert alert-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">{{ __('messages.Password')}}</p>
                                    </div>
                                    <div class="form-group col-sm-9">
                                        <input type="password" class="form-control" name="Password" value="">
                                    </div>
                                    @error('Password')
                                        <span class="alert alert-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <hr>
                                <p class="mb-0 text-center">{{ __('messages.ControlyourAccount')}}</p>
                                <div class="row">
                                    <div class="col-sm-12 mt-15 d-flex justify-content-center mt-2" style="gap: 15px">
                                        <a href="{{route('Profile.profile' , $user->id)}}" class="btn btn-info"> {{ __('messages.Cancel')}}</a>
                                        <button class="btn btn-success">{{ __('messages.UpdateAccount')}}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
