@extends('Admin.Layout.Master')
@section('Title' , 'Profile')

    @section('Content')
        <div class="card shadow-lg mx-4 card-profile-bottom">
            <div class="card-body p-3">
                <div class="row gx-4">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <img src="{{ asset('Admin/dist/img/avatar.png') }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ $user->Name }}
                            </h5>
                            <div style="display:flex; gap:20px;align-items: baseline;">
                                <p class="mb-0 font-weight-bold text-sm">
                                    @if($user->Status == 1)
                                        <span class="badge badge-success p-2">Active</span>
                                    @else
                                        <span class="badge badge-danger p-2">Disactivated</span>
                                    @endif  
                                </p>
                                <p>
                                    @if($user->is_verified == 1)
                                        <span class="badge badge-success p-2">Verified</span>
                                    @else
                                        <span class="badge badge-warning p-2">Unverified</span>
                                    @endif 
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                        <div class="nav-wrapper position-relative end-0">
                            <ul class="nav nav-pills nav-fill p-1" role="tablist" data-bs-toggle="tab" href="#primaryhome" role="tab" aria-selected="true">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link mb-0 px-0 py-1 active d-flex align-items-center justify-content-center " data-bs-toggle="tab" role="tab" aria-selected="true">
                                        <i class="ni ni-settings-gear-65"></i>
                                        <span class="ms-2">Settings</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center " data-bs-toggle="tab" role="tab" aria-selected="false">
                                        <i class="ni ni-settings-gear-65"></i>
                                        <span class="ms-2">Users</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid py-4">
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header pb-2">
                                <div class="d-flex align-items-center">
                                    <p class="mb-0">Profile</p>
                                    <a class="btn btn-primary btn-sm ms-auto m-2">Settings</a>
                                </div>
                            </div>
                            <div class="card-body" id="primaryhome">
                                <p class="text-uppercase text-sm">User Information</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Name</label>
                                            <input class="form-control" type="text"  name="Name" value="{{ $user->Name }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Email address</label>
                                            <input class="form-control" type="email" name="email" value="{{ $user->email }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Phone</label>
                                            <input class="form-control" type="text" name="Phone" value="{{ $user->Phone }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Address</label>
                                            <input class="form-control" type="text" name="Address" value="{{ $user->Address }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-sm">Orders</p>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-body p-3">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <div class="numbers">
                                                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Orders</p>
                                                            <h5 class="font-weight-bolder">
                                                                <?php // echo $RowOrder['TotalOrders']?>
                                                            </h5>
                                                            <p class="mb-0">
                                                            <span class="text-success text-sm font-weight-bolder">+55%</span>
                                                            since yesterday
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 text-end">
                                                        <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                                            <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-body p-3">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <div class="numbers">
                                                            <p class="text-sm mb-0 text-uppercase font-weight-bold">User Paid</p>
                                                            <h5 class="font-weight-bolder">
                                                                <?php 
                                                                // if(isset($RowOrder['TotalBeforeSaving'])){ 
                                                                //     echo $RowOrder['TotalBeforeSaving'] . " EGP" ;
                                                                //     }else{
                                                                //         echo "0" ;
                                                                //     }
                                                                ?>
                                                            </h5>
                                                            <p class="mb-0">
                                                            <span class="text-success text-sm font-weight-bolder">+55%</span>
                                                            since yesterday
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 text-end">
                                                        <div class="icon icon-shape bg-primary shadow-primary text-center rounded-circle">
                                                            <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <hr class="horizontal dark">

                                <p class="text-uppercase text-sm">Control</p>
                                    <div class="justify-content-center row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                @if($user->Status == 1)
                                                    <button type="submit" name="Deactivate" class="btn btn-md bg-danger w-100 mt-4 mb-0">Deactivate Account</button>
                                                @else
                                                    <button type="submit" name="Activate" class="btn btn-md bg-success w-100 mt-4 mb-0">Activate</button>
                                                @endif  
                                            </div>
                                        </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <a href="{{ Route('Users.index')}}" class="btn btn-md btn-primary w-100 mt-4 mb-0">Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Side Card -->
                    <div class="col-md-4">
                        <div class="card card-profile">
                            <img src="{{ asset('Admin/dist/img/Background.jpg') }}" alt="Image placeholder" class="card-img-top">
                            <div class="row justify-content-center">
                                <div class="col-4 col-lg-4 order-lg-2">
                                    <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                                        <a>
                                            <img src="{{ asset('Admin/dist/img/avatar.png') }}" class="rounded-circle img-fluid border border-2 border-white">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
                                <div class="d-flex justify-content-center">
                                    @if($user->Status == 1)
                                        <span class="badge badge-success p-2">Active</span>
                                    @else
                                        <span class="badge badge-danger p-2">Disactivated</span>
                                    @endif  
                                </div>
                            </div>
                            <div class="card-body pt-0">
                            <div class="row">
                                <div class="col">
                                    <div class="d-flex justify-content-center">
                                        <div class="d-grid text-center">
                                            <span class="text-lg font-weight-bolder"><?php // echo $RowOrder['TotalOrders']?></span>
                                            <span class="text-sm opacity-8">Total Orders</span>
                                        </div>
                                        <div class="d-grid text-center mx-4">
                                            <span class="text-lg font-weight-bolder">  
                                                                    <?php 
                                                                    // if(isset($RowOrder['TotalBeforeSaving'])){ 
                                                                    //     echo $RowOrder['TotalBeforeSaving'] . " EGP" ;
                                                                    // }else{
                                                                    //     echo "0" ;
                                                                    // }
                                                                ?>
                                                                </span>
                                            <span class="text-sm opacity-8">Total Payments</span>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="text-center mt-4">
                                <h5>
                                {{ $user->Name }}<span class="font-weight-light"></span>
                                </h5>
                                <div class="h6 font-weight-300">
                                <i class="ni location_pin mr-2"></i> {{ $user->Address }} 
                                </div>
                                <div class="h6 mt-4">
                                <i class="ni business_briefcase-24 mr-2"></i>{{ $user->Phone }}
                                </div>
                                <div>
                                <i class="ni education_hat mr-2"></i>{{ $user->email }} 
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endsection