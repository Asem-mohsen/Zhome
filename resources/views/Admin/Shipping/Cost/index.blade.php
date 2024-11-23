@extends('Admin.Layout.Master')
@section('Title' , 'Shipping Costs')

@section('Content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Buttons --}}
                    <div class="btn-group w-fit pb-2">
                        <a href="{{ route('Shipping.cost.create') }}" class="btn btn-dark p-2"><i class="fa-solid fa-plus mr-1"></i>Add New Shipping Fees</a>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>Delivery Estimations</th>
                                <th>Fees</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($shippings as $shipping)
                                <tr>
                                    <td>
                                        {{ $i++ }}
                                    </td>

                                    <td>{{$shipping->country->country}}</td>

                                    <td>{{$shipping->city->name}}</td>

                                    <td>{{$shipping->delivery_estimations ?? "--"}}</td>

                                    <td>{{$shipping->shipping_fee . " EGP"}}</td>

                                    <td class="d-flex justify-content-around gap-1 align-items-baseline">
                                        <a href="{{ route('Shipping.cost.edit' , $shipping->id ) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit Brand">
                                            Check
                                        </a>
                                        <form action="{{ route('Shipping.cost.delete' , $shipping->id )}}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <button class="text-secondary bg-transparent border-0 text-danger font-weight-bold text-xs">Delete</button>

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
