@extends('Admin.Layout.Master')
@section('Title' , 'Tools Orders')

@section('Content')

    @include('Admin.Components.Msg')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Type</th>
                                <th>Project</th>
                                <th>Rooms</th>
                                <th>System</th>
                                <th>Package</th>
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
                                    <td>{{ $i++ }}</td>
                                    <td>
                                        @if($order->user)
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-sm">Order ID: {{$order->id}}</span>
                                                    <h6 class="mb-0 text-sm">{{$order->user->name}}</h6>
                                                    <span>{{$order->user->email}}</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-sm">Order ID: {{$order->id}}</span>
                                                    <h6 class="mb-0 text-sm">{{$order->name}}</h6>
                                                    <span>{{$order->email}}</span>
                                                </div>
                                            </div>
                                        @endif

                                    </td>
                                    <td>{{$order->options->installed}}</td>
                                    <td>{{$order->options->building_type}}</td>
                                    <td>{{$order->options->rooms}}</td>
                                    <td>{{$order->options->system_type}}</td>
                                    <td>{{$order->options->package}}</td>
                                    <td>
                                        @if ($order->status === \App\Enums\OrderStatusEnum::COMPLETED->value)
                                            <span class="badge badge-success">Paid</span>
                                        @elseif ($order->status === \App\Enums\OrderStatusEnum::PENDING->value)
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif ($order->status === \App\Enums\OrderStatusEnum::CANCELLED->value)
                                            <span class="badge badge-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td class="d-flex justify-content-around gap-1 align-items-baseline">
                                        <a href="{{route('Orders.ToolsOrders.show' , $order->id )}}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="View">
                                            View
                                        </a>
                                        <form action="{{ route('Orders.ToolsOrders.delete' ,$order->id )}}" method="post">
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
