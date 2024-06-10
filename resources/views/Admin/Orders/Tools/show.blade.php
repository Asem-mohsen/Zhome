@extends('Admin.Layout.Master')
@section('Title' , 'Order')

@section('Content')

    <div class="container my-5">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-primary justify-content-center" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#order" aria-selected="true">Proposal Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#User" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">User</a>
                    </li>
                </ul>
                <div class="tab-content py-3">
                    <!-- Order -->
                    <div class="tab-pane fade show active" id="order" role="tabpanel">
                        <div class="wrapper">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example2" class="table table-striped table-bordered">
                                            <thead>
                                                <th scope="col" width="10%">#</th>
                                                <th scope="col" width="20%">Data</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>User</td>
                                                    <td>
                                                        @if($order->user)
                                                            {{$order->user->Name}}
                                                        @else
                                                            {{$order->Name}}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Installed In</td>
                                                    <td>{{$order->Installed}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Building Project Type</td>
                                                    <td>{{$order->BuildingProject}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Rooms</td>
                                                    <td>{{$order->Rooms}}</td>
                                                </tr>
                                                <tr>
                                                    <td>System Type</td>
                                                    <td>{{$order->SystemType}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Package</td>
                                                    <td>{{$order->Package}} </td>
                                                </tr>
                                                <tr>
                                                    <td>Platforms</td>
                                                    <td>{{$order->Platforms}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Categories</td>
                                                    <td>
                                                        @foreach ($order->toolsCategories as $category)
                                                            {{$category->Category . " - "}}
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                @if($order->PlanHouseDocument)
                                                    <tr>
                                                        <td>File Uploaded</td>
                                                        <td><a href="https://zhome.com.eg/Admin/Proposal/UsersUploads/" target="_blank">View File</a> </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- User -->
                    <div class="tab-pane fade" id="User" role="tabpanel">
                        <div class="wrapper">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example2" class="table table-striped table-bordered">
                                            <thead>
                                                <th scope="col" width="10%">#</th>
                                                <th scope="col" width="20%">Data</th>
                                            </thead>
                                                <tr>
                                                    <td>User</td>
                                                    <td>
                                                        @if($order->user)
                                                            {{$order->user->Name}}
                                                        @else
                                                            {{$order->Name}}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td>
                                                        @if($order->user)
                                                            {{$order->user->Email}}
                                                        @else
                                                            {{$order->Email}}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Phone</td>
                                                    <td>
                                                        @if($order->user)
                                                            {{$order->user->Phone}}
                                                        @else
                                                            {{$order->Phone}}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Address</td>
                                                    <td>
                                                        @if($order->user)
                                                            {{$order->user->Address}}
                                                        @else
                                                            {{$order->Address}}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>City</td>
                                                    <td>
                                                        @if($order->user)
                                                            {{$order->user->City}}
                                                        @else
                                                            {{$order->City}}
                                                        @endif
                                                    </td>
                                                </tr>
                                                    <tr>
                                                    <td>Country</td>
                                                    <td>
                                                        @if($order->user)
                                                            {{$order->user->Country}}
                                                        @else
                                                            {{$order->Country}}
                                                        @endif
                                                    </td>
                                                </tr>
                                                    <tr>
                                                    <td>Status</td>
                                                    <td>
                                                        @if($order->user)
                                                            @if ($order->user->Status == 1)
                                                                <span class="badge badge-succes">Active</span>
                                                            @else
                                                                <span class="badge badge-warning">Inactive</span>
                                                            @endif
                                                        @else
                                                            <span class="badge badge-danger">Not a User</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

