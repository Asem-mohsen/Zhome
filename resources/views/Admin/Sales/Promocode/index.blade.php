@extends('Admin.Layout.Master')
@section('Title' , 'Promocodes')

@section('Content')

@include('Admin.Components.Msg')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="d-flex justify-content-between p-4">
                        <h6>Promocodes</h6>
                        <div class="text-end">
                            <a class="btn btn-dark mb-0" href="{{route('Sales.Promocode.create')}}"><i class="fas fa-plus"></i>&nbsp;&nbsp;Add New Promo Code</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table id="example" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Save</th>
                                        <th>Valid From</th>
                                        <th>Valid Until</th>
                                        <th>Status</th>
                                        <th>Users Used It</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach($promotions as $promotion)

                                        <tr id="row-{{$promotion->id}}">
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{$i++}}</p>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$promotion->code}}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{$promotion->discount_amount . "%"}}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ date('Md,Y' , strtotime($promotion->valid_from)) }}</p>
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold">{{ date('Md,Y' , strtotime($promotion->valid_until)) }}</span>
                                            </td>
                                            <td>
                                                @if($promotion->status == 'active' )
                                                    <span class="badge badge-sm bg-success">Working</span>
                                                @else
                                                    <span class="badge badge-sm bg-danger">Disabled</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold">{{$promotion->orders_count }}</span>
                                            </td>
                                            <td class="d-flex justify-content-around gap-1 align-items-baseline">
                                                <a href="{{route('Sales.Promocode.edit' , $promotion->id)}}" class="text-success font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit">Edit</a>
                                                <form action="{{route('Sales.Promocode.delete' , $promotion->id)}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="border-0 bg-transparent p-0 text-danger font-weight-bold text-xs">Remove</button>
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
        </div>
    </div>

@endsection

@section('Js')
    <!-- Page specific script -->
    <script>
        $(function () {
            $("#example").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
        });
    </script>
@stop
