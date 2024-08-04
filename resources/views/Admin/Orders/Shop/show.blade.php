@extends('Admin.Layout.Master')
@section('Title' , 'Order')

@section('Content')

    <div class="container my-5">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-primary justify-content-center" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#order" aria-selected="true">Order Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#User" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#Product" aria-selected="false">Product Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#Billing" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Billing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#PrevOrders" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Previous Orders</a>
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
                                                    <td>{{$order->user->Name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Product</td>
                                                    <td>{{$order->product->Name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Quantity Ordered</td>
                                                    <td>{{$order->Quantity}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Unit Price</td>

                                                    @if ($productHasSale)
                                                        <td>
                                                            <p style="text-decoration:line-through;">
                                                                {{$order->product->Price . " EGP"}}
                                                            </p>
                                                            {{$order->product->sale->PriceAfter . " EGP"}}
                                                        </td>
                                                    @else
                                                        <td> {{$order->product->Price . " EGP"}} </td>
                                                    @endif

                                                </tr>
                                                <tr>
                                                    <td>Placed Date</td>
                                                    <td>{{$order->created_at }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Promo code</td>
                                                    <td>
                                                        @if ($order->promocode != NULL)
                                                            {{$order->promocode }}
                                                        @else
                                                            Didn't use Promo code
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if ($order->promocode != NULL)
                                                    <tr>
                                                        <td>The Code Save</td>
                                                        <td>{{$order->promocode->Save . "%" }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Saved</td>
                                                        <td>{{$order->Saving . " EGP" }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total</td>
                                                        <td>{{$order->TotalAfterSaving . " EGP" }}</td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td>Total</td>
                                                        <td>{{$order->Total . " EGP" }}</td>
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
                                                    <td>{{$order->user->Name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td>{{$order->user->email}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Phone</td>
                                                    <td>{{$order->user->Phone}}</td>
                                                </tr>
                                                <tr>
                                                    <td>User Address</td>
                                                    <td>{{$order->user->Address}}</td>
                                                </tr>
                                                <tr>
                                                    <td>User Shipping Address</td>
                                                    <td>{{$order->UserShippingAddress}}</td>
                                                </tr>
                                                    <tr>
                                                    <td>City</td>
                                                    <td>{{$order->City}}</td>
                                                </tr>
                                                    <tr>
                                                    <td>Country</td>
                                                    <td>{{$order->Country}}</td>
                                                </tr>
                                                    <tr>
                                                    <td>Building</td>
                                                    <td>{{$order->Building}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Floor</td>
                                                    <td>{{$order->Floor}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Apartment</td>
                                                    <td>{{$order->Apartment}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Status</td>
                                                    <td>
                                                        @if ($order->user->Status)
                                                            <span class="badge badge-sm bg-success">Active</span>
                                                        @else
                                                            <span class="badge badge-sm bg-danger">Not Active</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Product -->
                    <div class="tab-pane fade" id="Product" role="tabpanel">
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
                                                    <td>Product</td>
                                                    <td>{{$order->product->Name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Category</td>
                                                    <td>{{$order->product->subcategory->category->Category}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Sub Category</td>
                                                    <td>{{$order->product->subcategory->SubName}}</td>
                                                </tr>
                                                <!-- Sale -->
                                                @if ($productHasSale)
                                                    <tr>
                                                        <td>In Sale</td>
                                                        <td>YES</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Price Before Sale</td>
                                                        <td>{{$order->product->Price . " EGP"}}  </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Price After Sale</td>
                                                        <td>{{$order->product->sale->PriceAfter . " EGP"}} </td>
                                                    </tr>

                                                @else
                                                    <tr>
                                                        <td>Price</td>
                                                        <td> {{$order->product->Price . " EGP"}} </td>
                                                    </tr>
                                                @endif

                                                <tr>
                                                    <td>In Stock</td>
                                                    <td>{{$order->product->Quantity }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Platform</td>
                                                    <td class="Platforms-orders">
                                                        @foreach($order->product->platforms as $Platform)
                                                            <a href="{{route('Platform.edit' , $Platform->ID )}}">
                                                                <div class="platform d-flex">
                                                                    <img src="{{asset('Admin/dist/imgs/web/Platforms/'.$Platform->Logo.'')}}" alt="{{$Platform->Platform}}">
                                                                    <p>{{$Platform->Platform}}</p>
                                                                </div>
                                                            </a>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Brand</td>
                                                    <td>{{$order->product->brand->Brand }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Is Bundle ?</td>
                                                    <td>
                                                        @if ($order->product->brand->IsBundle == 1)
                                                            Bundle
                                                        @else
                                                            Not a Bundle
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Billing -->
                    <div class="tab-pane fade" id="Billing" role="tabpanel">
                        <div class="wrapper">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example2" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Data</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>User</td>
                                                    <td>{{$order->user->Name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Amount</td>
                                                    <td>{{$order->Total . " EGP"}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Payment Type</td>
                                                    @if ($order->TransactionID != NULL)
                                                        <td>{{$order->transaction->source_data_sub_type}}</td>
                                                    @else
                                                        <td>
                                                            <span class="badge badge-sm bg-warning">Pending</span>
                                                        </td>
                                                    @endif

                                                </tr>
                                                <tr>
                                                    @if ($order->TransactionID != NULL)
                                                        <td>{{$order->transaction->source_data_sub_type}}</td>
                                                        <td>Transaction ID </td>
                                                        <td>{{$order->TransactionID}}</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td>Status</td>
                                                    <td>
                                                        @if ($order->Status == 1)
                                                            <span class="badge badge-sm bg-success">Paid</span>
                                                        @elseif ($order->Status == 2)
                                                            <span class="badge badge-sm bg-warning">Pending</span>
                                                        @elseif ($order->Status == 0)
                                                            <span class="badge badge-sm bg-danger">Faild</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if ($order->promocode != NULL)
                                                    <tr>
                                                        <td>Promo code</td>
                                                        <td>
                                                            {{$order->promocode->Promocode }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>The Code Save</td>
                                                        <td>{{$order->promocode->Save . "%" }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Saved</td>
                                                        <td>{{$order->Saving . " EGP" }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total</td>
                                                        <td>{{$order->TotalAfterSaving . " EGP" }}</td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td>Total</td>
                                                        <td>{{$order->Total . " EGP" }}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Previous Orders -->
                    <div class="tab-pane fade" id="PrevOrders" role="tabpanel">
                        <div class="wrapper">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <h3 class="align-middle text-center text-lg font-weight-bold">
                                            Previous Orders
                                        </h3>
                                        <table id="PrevOrder" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>OrderID</th>
                                                    <th>Product</td>
                                                    <th>Quantity</td>
                                                    <th>Paid With</th>
                                                    <th>Promo code</th>
                                                    <th>Status</th>
                                                    <th>Total</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($prevOrders as $prevOrder)
                                                    <tr>
                                                        <td class="align-middle text-center">
                                                            {{$prevOrder->ID}}
                                                        </td>
                                                        <td>
                                                            <div class="d-flex px-2 py-1">
                                                                <div>
                                                                    <img src="{{ asset('Admin/dist/img/web/Products/MainImage/' . $prevOrder->product->MainImage) }}" class="avatar avatar-sm me-3" alt="{{$prevOrder->product->Name}}">
                                                                </div>
                                                                <div class="d-flex flex-column justify-content-center">
                                                                    <h6 class="mb-0 text-sm">{{$prevOrder->product->Name}}</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <p class="text-xs font-weight-bold mb-0">{{$prevOrder->Quantity}}</p>
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            @if ($prevOrder->TransactionID != NULL)
                                                                {{-- <td>{{$prevOrder->transaction->source_data_sub_type}}</td> --}}
                                                            @else
                                                                <span class="badge badge-sm bg-warning">Pending</span>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            @if ($prevOrder->promocode != NULL)
                                                                <p class="text-xs font-weight-bold mb-0">{{$prevOrder->promocode->Promocode}}</p>
                                                            @else
                                                                <p class="text-xs font-weight-bold mb-0">No promo code used</p>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle text-center text-sm">
                                                            @if ($prevOrder->Status == 1)
                                                                <span class="badge badge-sm bg-success">Paid</span>
                                                            @elseif ($prevOrder->Status == 2)
                                                                <span class="badge badge-sm bg-warning">Pending</span>
                                                            @elseif ($prevOrder->Status == 0)
                                                                <span class="badge badge-sm bg-danger">Faild</span>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            {{$prevOrder->TotalAfterSaving . " EGP"}}
                                                        </td>
                                                        <td class="align-middle text-center">
                                                                <a href="{{route('Orders.ShopOrders.show' , $prevOrder->ID)}}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Check">
                                                                    Check
                                                                </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
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

@section('Js')
    <!-- Page specific script -->
    <script>
        $(function () {
            $("#PrevOrder").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@stop
