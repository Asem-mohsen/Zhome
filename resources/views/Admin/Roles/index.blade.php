@extends('Admin.Layout.Master')
@section('Title' , 'Roles')

@section('Content')

@include('Admin.Components.Msg')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                {{-- Buttons --}}
                <div class="btn-group w-fit pb-2">
                    <a href="{{ route('Roles.create') }}" class="btn btn-dark p-2"><i class="fa-solid fa-plus mr-1"></i>Add New Role</a>
                </div>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Role</th>
                            <th>Number of Admins</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($Roles as $Role)                            
                            <tr>
                                <td>
                                    {{ $i++ }}
                                </td>
                                <td>
                                    <h6 class="mb-0 text-sm">{{$Role->Role}}</h6>
                                </td>
                                <td>{{ $adminCounts[$Role->ID] }}</td>
                                <td class="d-flex justify-content-around align-items-baseline">
                                    <a href="{{ Route('Roles.edit',$Role->ID) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="View Role">
                                        Check
                                    </a>
                                    <form action="{{ route('Roles.delete' ,$Role->ID )}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button  class="border-0 bg-transparent p-0 text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete">
                                            Delete
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