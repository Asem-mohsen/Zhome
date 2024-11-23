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
                                                        {{$order->name}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Installed In</td>
                                                    <td>{{$order->option->installed ?? " - "}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Building Project Type</td>
                                                    <td>{{$order->option->building_type ?? " - "}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Rooms</td>
                                                    <td>{{$order->option->rooms ?? " - "}}</td>
                                                </tr>
                                                <tr>
                                                    <td>System Type</td>
                                                    <td>{{$order->option->system_type ?? " - "}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Package</td>
                                                    <td>{{$order->option->package ?? " - "}} </td>
                                                </tr>
                                                <tr>
                                                    <td>Platforms</td>
                                                    <td>
                                                        @foreach ($order->platforms as $index => $platform)
                                                            {{$platform->name . ( ($index + 1) !== count($order->platforms) ? "  -  " : "")}}
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Categories</td>
                                                    <td>
                                                        @foreach ($order->toolCategories as $index => $category)
                                                            {{$category->name . ( ($index + 1) !== count($order->toolCategories) ? "  -  " : "")}}
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Order Status</td>
                                                    <td>
                                                        @if ($order->status === \App\Enums\OrderStatusEnum::COMPLETED->value)
                                                            <span class="badge badge-success">Paid</span>
                                                        @elseif ($order->status === \App\Enums\OrderStatusEnum::PENDING->value)
                                                            <span class="badge badge-warning">Pending</span>
                                                        @elseif ($order->status === \App\Enums\OrderStatusEnum::CANCELLED->value)
                                                            <span class="badge badge-danger">Cancelled</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if($order->getFirstMediaUrl('house_documents'))
                                                    <tr>
                                                        <td>File Uploaded</td>
                                                        <td>
                                                            <a href="{{ $order->getFirstMediaUrl('house_documents') }}" target="_blank">View File</a>
                                                        </td>
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
                                                        {{$order->name}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td>
                                                        {{$order->email}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Phone</td>
                                                    <td>
                                                        {{$order->phone}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Address</td>
                                                    <td>
                                                        {{$order->address}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>City</td>
                                                    <td>
                                                        {{$order->city->name ?? "-"}}
                                                    </td>
                                                </tr>
                                                    <tr>
                                                    <td>Country</td>
                                                    <td>
                                                        {{$order->country->country ?? "-"}}
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

