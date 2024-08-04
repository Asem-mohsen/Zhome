@extends('Admin.Layout.Master')
@section('Title' , 'Shop Orders')

@section('Content')

@include('Admin.Components.Msg')

<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Orders</span>
                        <span class="info-box-number">{{$totalOrders}}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Paid in cash</span>
                        <span class="info-box-number">{{$totalCash}}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Paid with cards</span>
                        <span class="info-box-number">{{$totalCards}}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">In Cart</span>
                        <span class="info-box-number">{{$totalInCarts}}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($orders as $order)
                            <tr>
                                <td>
                                    {{ $i++ }}
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="{{ asset('Admin/dist/img/avatar.png') }}" class="avatar avatar-sm me-3" alt="user1">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <span class="text-sm">Order ID: {{$order->ID}}</span>
                                            <h6 class="mb-0 text-sm">{{$order->user->Name ?? 'Unknown'  }}</h6>
                                            <span>{{$order->user->email ?? 'Unknown' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="{{ asset('Admin/dist/img/web/Products/MainImage/' . $order->product->MainImage) }}" class="avatar avatar-sm me-3" alt="{{$order->product->Name}}">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0">{{$order->product->Name}}</h6>
                                            <span class="text-sm">Unit Price :{{$order->product->Price}} EGP</span>
                                            <span class="text-sm">Available : {{$order->product->Quantity}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{$order->Quantity}}</td>
                                <td>{{$order->Total}}</td>
                                <td>
                                    @if ($order->Status == 1)
                                        <span class="badge badge-success">Paid</span>
                                    @elseif($order->Status != 1)
                                        <span class="badge badge-warning">Pending</span>
                                    @endif
                                </td>
                                <td class="d-flex justify-content-around align-items-baseline">
                                    <a href="{{route('Orders.ShopOrders.show' , $order->ID )}}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="View">
                                        View
                                    </a>
                                    <form action="{{ route('Orders.ShopOrders.delete' ,$order->ID )}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button  class="border-0 bg-transparent p-0 text-danger font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Remove">
                                            Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('Js')
    <!-- Page specific script -->
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@stop
