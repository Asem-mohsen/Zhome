@extends('Admin.Layout.Master')
@section('Title' , 'Sales')

@section('Content')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="d-flex justify-content-between p-4">
                        <h6>Sales</h6>
                        <div class="text-end">
                            <a class="btn bg-gradient-light mb-0" href="{{route('Sales.create')}}"><i class="fas fa-plus"></i>&nbsp;&nbsp;Create New Sale</a>       
                            <a class="btn btn-dark mb-0" href="{{route('Sales.createGroup')}}"><i class="fas fa-plus"></i>&nbsp;&nbsp;Create New Group Sale</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table id="example1" class="table table-striped align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>New Price</th>
                                        <th>Ends In</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach($sales as $sale)

                                        <tr>
                                            <td>
                                                {{ $i++ }}
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <a href="{{ config('app.frontend_url') }}/product/{{ $sale->product_id }}" target="_blank" >
                                                            <h6 class="mb-0 text-sm">{{$sale->product->translations->name}}</h6>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold" style="text-decoration: line-through;">{{$sale->product->price . " EGP"}}</span>
                                                <br>
                                                <span class="text-secondary text-xs">{{$sale->sale_price ." EGP"}}</span>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ date('d-M-Y' , strtotime($sale->end_date)) }}</p>
                                            </td>
                                            <td>
                                                <a href="{{ route('Sales.edit' , $sale->id) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit">
                                                    Edit
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