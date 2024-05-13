@extends('Admin.Layout.Master')
@section('Title' , 'Add Role')

@section('Content')

<div class="card shadow-lg mx-4 card-profile-bottom">
    <div class="card-body p-3">
        <div class="row gx-4">
            <div class="col-auto">
                <div class="avatar avatar-xl position-relative">
                    <img src="{{ asset('Admin/dist/img/user2-160x160.jpg') }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                </div>
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                <h5 class="mb-1">
                  {{ 'Current Admin Name' }}
                </h5>
                <p class="mb-0 font-weight-bold text-sm">
                    {{ 'Current Admin Role' }}
                </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid py-4">
    <form action="{{ Route('Roles.store') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-2">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Add New Role</p>
                            <button class="btn btn-primary btn-sm ms-auto m-2">Add</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-uppercase text-sm">Role Information</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Role Name</label>
                                    <input class="form-control" type="text"  name="Name" required>
                                </div>
                                @error('Name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">Accessibility Information</p>
                        <p class="text-sm mt-30 fw-bolder">Admins</p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="ViewAdmins"  role="switch" id="ViewAdmins" data-action="ViewAdmins">
                                  <label class="form-check-label" for="ViewAdmins">View Admins</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="AddAdmins"  role="switch" id="AddAdmins" data-action="AddAdmins">
                                  <label class="form-check-label" for="AddAdmins">Add Admins</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="EditAdmins"  role="switch" id="EditAdmins" data-action="EditAdmins">
                                  <label class="form-check-label" for="EditAdmins">Edit Admins</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="DeleteAdmins"  role="switch" id="DeleteAdmins" data-action="DeleteAdmins">
                                  <label class="form-check-label" for="DeleteAdmins">Delete Admins</label>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mt-30 fw-bolder">Products</p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="ViewProducts"  role="switch" id="ViewProducts" data-action="ViewProducts">
                                  <label class="form-check-label" for="ViewProducts">View Products</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="AddProducts"  role="switch" id="AddProducts"  data-action="AddProducts">
                                  <label class="form-check-label" for="AddProducts">Add Products</label>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="EditProducts"  role="switch" id="EditProducts" data-action="EditProducts">
                                  <label class="form-check-label" for="EditProducts">Edit Products</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="DeleteProducts"  role="switch" id="DeleteProducts" data-action="DeleteProducts">
                                  <label class="form-check-label" for="DeleteProducts">Delete Products</label>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mt-30 fw-bolder">Categories</p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="ViewCategories"  role="switch" id="ViewCategories" data-action="ViewCategories">
                                  <label class="form-check-label" for="ViewCategories">View Categories</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="AddCategories"  role="switch" id="AddCategories" data-action="AddCategories">
                                  <label class="form-check-label" for="AddCategories">Add Categories</label>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="EditCategories"  role="switch" id="EditCategories" data-action="EditCategories">
                                  <label class="form-check-label" for="EditCategories">Edit Categories</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="DeleteCategories"  role="switch" id="DeleteCategories" data-action="DeleteCategories">
                                  <label class="form-check-label" for="DeleteCategories">Delete Categories</label>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mt-30 fw-bolder">Sub Categories</p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="ViewSubCategories"  role="switch" id="ViewSubCategories"  data-action="ViewSubCategories">
                                  <label class="form-check-label" for="ViewSubCategories">View Sub Categories</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="AddSubCategories"  role="switch" id="AddSubCategories" data-action="AddSubCategories">
                                  <label class="form-check-label" for="AddSubCategories">Add Sub Categories</label>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="EditSubCategories"  role="switch" id="EditSubCategories" data-action="EditSubCategories">
                                  <label class="form-check-label" for="EditSubCategories">Edit Sub Categories</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="DeleteSubCategories"  role="switch" id="DeleteSubCategories"  data-action="DeleteSubCategories">
                                  <label class="form-check-label" for="DeleteSubCategories">Delete Sub Categories</label>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mt-30 fw-bolder">Brands</p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="ViewBrands"  role="switch" id="ViewBrands"  data-action="ViewBrands">
                                  <label class="form-check-label" for="ViewBrands">View Brands</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="AddBrands"  role="switch" id="AddBrands"  data-action="AddBrands">
                                  <label class="form-check-label" for="AddBrands">Add Brands</label>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="EditBrands"  role="switch" id="EditBrands"   data-action="EditBrands">
                                  <label class="form-check-label" for="EditBrands">Edit Brands</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="DeleteBrands"  role="switch" id="DeleteBrands"   data-action="DeleteBrands">
                                  <label class="form-check-label" for="DeleteBrands">Delete Brands</label>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mt-30 fw-bolder">Platforms</p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="ViewPlatforms"  role="switch" id="ViewPlatforms"   data-action="ViewPlatforms">
                                  <label class="form-check-label" for="ViewPlatforms">View Platforms</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="AddPlatforms"  role="switch" id="AddPlatforms"  data-action="AddPlatforms">
                                  <label class="form-check-label" for="AddPlatforms">Add Platforms</label>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="EditPlatforms"  role="switch" id="EditPlatforms"   data-action="EditPlatforms">
                                  <label class="form-check-label" for="EditPlatforms">Edit Platforms</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="DeletePlatforms"  role="switch" id="DeletePlatforms"   data-action="DeletePlatforms">
                                  <label class="form-check-label" for="DeletePlatforms">Delete Platforms</label>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mt-30 fw-bolder">Orders</p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="ViewStock"  role="switch" id="ViewStock" data-action="ViewStock">
                                  <label class="form-check-label" for="ViewStock">View Stock</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="ViewWebsiteOrders"  role="switch" id="ViewWebsiteOrders"  data-action="ViewWebsiteOrders">
                                  <label class="form-check-label" for="ViewWebsiteOrders">Access Website Orders</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="ViewToolsOrders"  role="switch" id="ViewToolsOrders"  data-action="ViewToolsOrders">
                                  <label class="form-check-label" for="AddToolsPlatforms">Access Tools Orders</label>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="ViewVideoOrders"  role="switch" id="ViewVideoOrders"  data-action="ViewVideoOrders">
                                  <label class="form-check-label" for="ViewVideoOrders">Access Video Requests</label>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mt-30 fw-bolder">Services</p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="ViewServices"  role="switch" id="ViewServices" data-action="ViewServices">
                                  <label class="form-check-label" for="ViewServices">View Services</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="AddServices"  role="switch" id="AddServices" data-action="AddServices">
                                  <label class="form-check-label" for="AddServices">Add Services</label>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="EditServices"  role="switch" id="EditServices" data-action="EditServices">
                                  <label class="form-check-label" for="EditServices">Edit Services</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="DeleteServices"  role="switch" id="DeleteServices" data-action="DeleteServices">
                                  <label class="form-check-label" for="DeleteServices">Delete Services</label>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mt-30 fw-bolder">Offers</p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="ViewOffers"  role="switch" id="ViewOffers" data-action="ViewOffers">
                                  <label class="form-check-label" for="ViewOffers">View Offers</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="AddOffers"  role="switch" id="AddOffers" data-action="AddOffers">
                                  <label class="form-check-label" for="AddOffers">Add Offers</label>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="EditOffers"  role="switch" id="EditOffers"  data-action="EditOffers">
                                  <label class="form-check-label" for="EditOffers">Edit Offers</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="DeleteOffers"  role="switch" id="DeleteOffers" data-action="DeleteOffers">
                                  <label class="form-check-label" for="DeleteOffers">Delete Offers</label>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mt-30 fw-bolder">Views</p>
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="RoleOperations"  role="switch" id="Role"  data-action="RoleOperations">
                                  <label class="form-check-label" for="Role">Role Operations</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="ViewPayments"  role="switch" id="ViewPayments"  data-action="ViewPayments">
                                  <label class="form-check-label" for="ViewPayments">View Payments</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="ViewMarketing"  role="switch" id="ViewMarketing"  data-action="ViewMarketing">
                                  <label class="form-check-label" for="ViewMarketing">View Marketing</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="ViewSubscribers"  role="switch" id="ViewSubscribers"  data-action="ViewSubscribers">
                                  <label class="form-check-label" for="ViewSubscribers">View Subscribers</label>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mt-30 fw-bolder">Features</p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="ViewFeatures"  role="switch" id="ViewFeatures"  data-action="ViewFeatures">
                                  <label class="form-check-label" for="ViewFeatures">View Features</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="AddFeatures"  role="switch" id="AddFeatures" data-action="AddFeatures">
                                  <label class="form-check-label" for="AddFeatures">Add Features</label>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="EditFeatures"  role="switch" id="EditFeatures"  data-action="EditFeatures">
                                  <label class="form-check-label" for="EditFeatures">Edit Features</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="DeleteFeatures"  role="switch" id="DeleteFeatures" data-action="DeleteFeatures">
                                  <label class="form-check-label" for="DeleteFeatures">Delete Features</label>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mt-30 fw-bolder">Collections</p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="ViewCollections"  role="switch" id="ViewCollections" data-action="ViewCollections">
                                  <label class="form-check-label" for="ViewCollections">View Collections</label>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="AddCollections"  role="switch" id="AddCollections" data-action="AddCollections">
                                  <label class="form-check-label" for="AddCollections">Add Collections</label>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="EditCollections"  role="switch" id="EditCollections" data-action="EditCollections">
                                  <label class="form-check-label" for="EditCollections">Edit Collections</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="DeleteCollections"  role="switch" id="DeleteCollections" data-action="DeleteCollections">
                                  <label class="form-check-label" for="DeleteCollections">Delete Collections</label>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">

                        <p class="text-uppercase text-sm">Control</p>
                        <div class="justify-content-center row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-md btn-success w-100 mt-4 mb-0">Add</button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <a href="{{ Route('Roles.index')}}" class="btn btn-md btn-danger w-100 mt-4 mb-0">Cancel</a>
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