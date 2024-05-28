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
                                        <th>Added In</thps-2>
                                        <th>Available for</th>
                                        <th>Status</th>
                                        <th>Ends In</th>
                                        <th>Users Used It</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach($promocodes as $promocode)
                                            {{-- // Change into Disabled  --}}
                                            {{-- if($TodaysDate >= $Code['EndsIn']){
                                                $CodeID = $Code['ID'];
                                                $UpdateStatus = mysqli_query($con, "UPDATE promocode SET Status = 0 WHERE ID = $CodeID");    
                                            }
                                        ?> --}}
                                        <tr id="row-{{$promocode->ID}}">
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{$i++}}</p>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$promocode->Promocode}}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{$promocode->Save . "%"}}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ date('Md,Y' , strtotime($promocode->created_at)) }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold"{{$promocode->AvailableFor . " Days"}}></span>
                                            </td>
                                            <td>
                                                @if($promocode->Status == 1 )
                                                    <span class="badge badge-sm bg-success">Working</span>
                                                @else
                                                    <span class="badge badge-sm bg-danger">Disabled</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold">{{date('Md,Y' , strtotime($promocode->EndsIn))}}</span>
                                            </td>
                                            <td>
                                                <span class="text-secondary text-xs font-weight-bold">{{$countUsed }}</span>
                                            </td>
                                            <td>
                                                <a href="{{route('Sales.Promocode.edit' , $promocode->ID)}}" class="btn btn-success">Edit</a>
                                            
                                                <from action="{{route('Sales.Promocode.delete' , $promocode->ID)}}" method="post">
                                                    @method('DELETE')
                                                    @csrf

                                                    <button class="btn btn-danger">Remove</button>
                                                </from>
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