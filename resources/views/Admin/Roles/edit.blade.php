@extends('Admin.Layout.Master')
@section('Title' , 'Role')

@section('Content')

<div class="card shadow-lg mx-4 card-profile-bottom">
    <div class="card-body p-3">
        <div class="row gx-4">
            <div class="col-auto my-auto">
                <div class="h-100">
                <h5 class="mb-1">
                    {{ $Role->Role }}
                </h5>
                <p class="mb-0 font-weight-bold text-sm">
                    @if($adminCount > 0 )
                        {{ "Has ". $adminCount . " Admin";}}
                    @else
                        {{ "No Admins for this Role"}}
                    @endif
                </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid py-4">
    <form action="" method="post">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-2">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Settings</p>
                            <button class="btn btn-primary btn-sm ms-auto m-2">Settings</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-uppercase text-sm"> {{ $Role->Role }} Department Users</p>
                        <div class="row">
                            <div class="col-md-12">
                                <ul style="list-style: none;display: flex;justify-content: center;gap: 20px;flex-wrap: wrap;">
                                    @if($adminCount > 0 )
                                        @foreach ( $admins as $admin )
                                            <a href="{{ route('Admins.profile', $admin->ID) }}" target="_blank" data-original-title="Visit Profile" style="display: block;width: fit-content;">
                                                <li style="padding: 10px;width: max-content;border: 1px solid #eee;border-radius: 18px;margin-bottom: 20px;min-width: 239px;">
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <img src="{{ asset('Admin/dist/img/user2-160x160.jpg')}}" class="avatar avatar-sm me-3" alt="user1">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $admin->Name }}</h6>
                                                            <p class="text-xs text-secondary mb-0">{{ $admin->Email }}</p>
                                                        </div>
                                                    </div>
                                                </li>
                                            </a>
                                        @endforeach
                                    @else
                                        {{ "No Admins for this Role"}}
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">Authorization and Accessibility </p>
                        <br>
                        <?php  
                            
                            // $AllViews = $Acess['ViewAdmins'] && $Acess['ViewProducts'] && $Acess['ViewBrands'] && $Acess['ViewCategories'] && $Acess['ViewSubCategories'] && $Acess['ViewPlatforms']&& $Acess['ViewPayments'] && $Acess['ViewMarketing'] && $Acess['ViewServices']&&$Acess['ViewOffers'] && $Acess['ViewFeatures'] && $Acess['ViewCollections']
                            //             && $Acess['ViewSubscribers'] && $Acess['ViewMarketing'] && $Acess['ViewStock'] && $Acess['ViewWebsiteOrders'] && $Acess['ViewToolsOrders'] && $Acess['ViewVideoOrders'];
                            // $AllAdds = $Acess['AddAdmins'] && $Acess['AddProducts'] && $Acess['AddBrands'] && $Acess['AddCategories']  && $Acess['AddSubCategories'] && $Acess['AddPlatforms']&& $Acess['AddServices']&&$Acess['AddOffers'] && $Acess['AddFeatures'] && $Acess['AddCollections'];
                            // $AllEdits = $Acess['EditAdmins'] && $Acess['EditProducts'] && $Acess['EditBrands'] && $Acess['EditCategories'] && $Acess['EditSubCategories'] && $Acess['EditPlatforms'] && $Acess['EditServices']&&$Acess['EditOffers'] && $Acess['EditFeatures'] && $Acess['EditCollections'];
                            // $AllDeletes = $Acess['DeleteAdmins'] && $Acess['DeleteProducts'] && $Acess['DeleteBrands'] && $Acess['DeleteCategories'] && $Acess['DeleteSubCategories'] && $Acess['DeletePlatforms'] && $Acess['DeleteServices'] && $Acess['DeleteOffers'] && $Acess['DeleteFeatures'] && $Acess['DeleteCollections'];
                        ?>
                        <!--All-->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="AllViews" data-action="AllView" <?php //if(isset($AllViews) && $AllViews == 1){ echo "checked" ; } ?>>
                                  <label class="form-check-label" for="AllViews" style="font-size: 22px;font-weight: bold;">All Views</label>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="AllAdds" data-action="AllAdd" <?php //if(isset($AllAdds) && $AllAdds == 1){ echo "checked" ; } ?>>
                                  <label class="form-check-label" for="AllAdds" style="font-size: 22px;font-weight: bold;">All Adds</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="AllEdits" data-action="AllEdit" <?php //if(isset($AllEdits) && $AllEdits == 1){ echo "checked" ; } ?>>
                                  <label class="form-check-label" for="AllEdits" style="font-size: 22px;font-weight: bold;">All Edits</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="AllDeletes" data-action="AllDelete" <?php //if(isset($AllDeletes) && $AllDeletes == 1){ echo "checked" ; } ?>>
                                  <label class="form-check-label" for="AllDeletes" style="font-size: 22px;font-weight: bold;">All Deletes</label>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mt-30 fw-bolder">Admins</p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="ViewAdmins" data-action="ViewAdmins" @checked($accessability->ViewAdmins == 1)  >
                                  <label class="form-check-label" for="ViewAdmins">View Admins</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="AddAdmins" data-action="AddAdmins" @checked($accessability->AddAdmins == 1) >
                                  <label class="form-check-label" for="AddAdmins">Add Admins</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="EditAdmins" data-action="EditAdmins" @checked($accessability->EditAdmins == 1) >
                                  <label class="form-check-label" for="EditAdmins">Edit Admins</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="DeleteAdmins" data-action="DeleteAdmins" @checked($accessability->DeleteAdmins == 1) >
                                  <label class="form-check-label" for="DeleteAdmins">Delete Admins</label>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mt-30 fw-bolder">Products</p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="ViewProducts" data-action="ViewProducts" @checked($accessability->ViewProducts == 1) >
                                  <label class="form-check-label" for="ViewProducts">View Products</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="AddProducts"  data-action="AddProducts" @checked($accessability->AddProducts == 1) >
                                  <label class="form-check-label" for="AddProducts">Add Products</label>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="EditProducts" data-action="EditProducts" @checked($accessability->EditProducts == 1) >
                                  <label class="form-check-label" for="EditProducts">Edit Products</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="DeleteProducts" data-action="DeleteProducts"  @checked($accessability->DeleteProducts == 1) >
                                  <label class="form-check-label" for="DeleteProducts">Delete Products</label>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mt-30 fw-bolder">Categories</p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="ViewCategories" data-action="ViewCategories"  @checked($accessability->ViewCategories == 1) >
                                  <label class="form-check-label" for="ViewCategories">View Categories</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="AddCategories" data-action="AddCategories"  @checked($accessability->AddCategories == 1) >
                                  <label class="form-check-label" for="AddCategories">Add Categories</label>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="EditCategories" data-action="EditCategories"  @checked($accessability->EditCategories == 1) >
                                  <label class="form-check-label" for="EditCategories">Edit Categories</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="DeleteCategories" data-action="DeleteCategories"  @checked($accessability->DeleteCategories == 1) >
                                  <label class="form-check-label" for="DeleteCategories">Delete Categories</label>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mt-30 fw-bolder">Sub Categories</p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="ViewSubCategories"  data-action="ViewSubCategories" @checked($accessability->ViewSubCategories == 1) >
                                  <label class="form-check-label" for="ViewSubCategories">View Sub Categories</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="AddSubCategories" data-action="AddSubCategories"  @checked($accessability->AddSubCategories == 1) >
                                  <label class="form-check-label" for="AddSubCategories">Add Sub Categories</label>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="EditSubCategories" data-action="EditSubCategories"  @checked($accessability->EditSubCategories == 1) >
                                  <label class="form-check-label" for="EditSubCategories">Edit Sub Categories</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="DeleteSubCategories"  data-action="DeleteSubCategories" @checked($accessability->DeleteSubCategories == 1) >
                                  <label class="form-check-label" for="DeleteSubCategories">Delete Sub Categories</label>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mt-30 fw-bolder">Brands</p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="ViewBrands"  data-action="ViewBrands" @checked($accessability->ViewBrands == 1) >
                                  <label class="form-check-label" for="ViewBrands">View Brands</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="AddBrands"  data-action="AddBrands" @checked($accessability->AddBrands == 1)>
                                  <label class="form-check-label" for="AddBrands">Add Brands</label>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="EditBrands"   data-action="EditBrands" @checked($accessability->EditBrands == 1) >
                                  <label class="form-check-label" for="EditBrands">Edit Brands</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="DeleteBrands"   data-action="DeleteBrands" @checked($accessability->DeleteBrands == 1)>
                                  <label class="form-check-label" for="DeleteBrands">Delete Brands</label>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mt-30 fw-bolder">Platforms</p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="ViewPlatforms"   data-action="ViewPlatforms" @checked($accessability->ViewPlatforms == 1) >
                                  <label class="form-check-label" for="ViewPlatforms">View Platforms</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="AddPlatforms"  data-action="AddPlatforms" @checked($accessability->AddPlatforms == 1) >
                                  <label class="form-check-label" for="AddPlatforms">Add Platforms</label>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="EditPlatforms"   data-action="EditPlatforms"  @checked($accessability->EditPlatforms == 1) >
                                  <label class="form-check-label" for="EditPlatforms">Edit Platforms</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="DeletePlatforms"   data-action="DeletePlatforms" @checked($accessability->DeletePlatforms == 1) >
                                  <label class="form-check-label" for="DeletePlatforms">Delete Platforms</label>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mt-30 fw-bolder">Orders</p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="ViewStock" data-action="ViewStock" @checked($accessability->ViewStock == 1) >
                                  <label class="form-check-label" for="ViewStock">View Stock</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="ViewWebsiteOrders"  data-action="ViewWebsiteOrders" @checked($accessability->ViewWebsiteOrders == 1) >
                                  <label class="form-check-label" for="ViewWebsiteOrders">Access Website Orders</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="ViewToolsOrders"  data-action="ViewToolsOrders" @checked($accessability->ViewToolsOrders == 1) >
                                  <label class="form-check-label" for="AddToolsPlatforms">Access Tools Orders</label>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="ViewVideoOrders"  data-action="ViewVideoOrders" @checked($accessability->ViewVideoOrders == 1)>
                                  <label class="form-check-label" for="ViewVideoOrders">Access Video Requests</label>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mt-30 fw-bolder">Services</p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="ViewServices" data-action="ViewServices"  @checked($accessability->ViewServices == 1) >
                                  <label class="form-check-label" for="ViewServices">View Services</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="AddServices" data-action="AddServices"  @checked($accessability->AddServices == 1) >
                                  <label class="form-check-label" for="AddServices">Add Services</label>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="EditServices" data-action="EditServices"  @checked($accessability->EditServices == 1) >
                                  <label class="form-check-label" for="EditServices">Edit Services</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="DeleteServices" data-action="DeleteServices"  @checked($accessability->DeleteServices == 1)>
                                  <label class="form-check-label" for="DeleteServices">Delete Services</label>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mt-30 fw-bolder">Offers</p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="ViewOffers" data-action="ViewOffers"  @checked($accessability->ViewOffers == 1) >
                                  <label class="form-check-label" for="ViewOffers">View Offers</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="AddOffers" data-action="AddOffers" @checked($accessability->AddOffers == 1) >
                                  <label class="form-check-label" for="AddOffers">Add Offers</label>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="EditOffers"  data-action="EditOffers" @checked($accessability->EditOffers == 1) >
                                  <label class="form-check-label" for="EditOffers">Edit Offers</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="DeleteOffers" data-action="DeleteOffers" @checked($accessability->DeleteOffers == 1) >
                                  <label class="form-check-label" for="DeleteOffers">Delete Offers</label>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mt-30 fw-bolder">Views</p>
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="Role"  data-action="RoleOperations"   @checked($accessability->RoleOperations == 1) >
                                  <label class="form-check-label" for="Role">Role Operations</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="ViewPayments"  data-action="ViewPayments"  @checked($accessability->ViewPayments == 1) >
                                  <label class="form-check-label" for="ViewPayments">View Payments</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="ViewMarketing"  data-action="ViewMarketing"  @checked($accessability->ViewMarketing == 1) >
                                  <label class="form-check-label" for="ViewMarketing">View Marketing</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="ViewSubscribers"  data-action="ViewSubscribers"  @checked($accessability->ViewSubscribers == 1) >
                                  <label class="form-check-label" for="ViewSubscribers">View Subscribers</label>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mt-30 fw-bolder">Features</p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="ViewFeatures"  data-action="ViewFeatures" @checked($accessability->ViewFeatures == 1) >
                                  <label class="form-check-label" for="ViewFeatures">View Features</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="AddFeatures" data-action="AddFeatures" @checked($accessability->AddFeatures == 1) >
                                  <label class="form-check-label" for="AddFeatures">Add Features</label>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="EditFeatures"  data-action="EditFeatures" @checked($accessability->EditFeatures == 1) >
                                  <label class="form-check-label" for="EditFeatures">Edit Features</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="DeleteFeatures" data-action="DeleteFeatures" @checked($accessability->DeleteFeatures == 1)>
                                  <label class="form-check-label" for="DeleteFeatures">Delete Features</label>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mt-30 fw-bolder">Collections</p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="ViewCollections" data-action="ViewCollections" @checked($accessability->ViewCollections == 1)>
                                  <label class="form-check-label" for="ViewCollections">View Collections</label>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="AddCollections" data-action="AddCollections" @checked($accessability->AddCollections == 1) >
                                  <label class="form-check-label" for="AddCollections">Add Collections</label>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="EditCollections" data-action="EditCollections" @checked($accessability->EditCollections == 1) >
                                  <label class="form-check-label" for="EditCollections">Edit Collections</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" id="DeleteCollections" data-action="DeleteCollections" @checked($accessability->DeleteCollections == 1) >
                                  <label class="form-check-label" for="DeleteCollections">Delete Collections</label>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">

                        <p class="text-uppercase text-sm">Control</p>
                        <div class="justify-content-center row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <a href="{{ route('Roles.index')}}" class="btn btn-md btn-info w-100 mt-4 mb-0">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.form-check-input');
            const RoleID = document.getElementById('RoleID').value;
            
            checkboxes.forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    const action = this.getAttribute('data-action');
                    const isChecked = this.checked ? 1 : 0;
        
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'UpdateAccessability.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            console.log(xhr.responseText);
                        }
                    };
                    xhr.send(`action=${action}&isChecked=${isChecked}&RoleID=${RoleID}`);
                });
            });
        });
    </script>
@stop