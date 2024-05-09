@extends('Admin.Layout.Master')
@section('Title' , 'Admins')

@section('Content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Admin</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($Admins as $Admin)
                       
                            <tr>
                                <td>
                                    {{ $i++ }}
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="{{ asset('Admin/dist/img/user2-160x160.jpg') }}" class="avatar avatar-sm me-3" alt="user1">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{$Admin->Name}}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{$Admin->Email}}</td>
                                <td>{{$Admin->Role}}</td>
                                <td>{{$Admin->Phone}}</td>
                                <td>
                                    @if($Admin->Active == 1)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Disactivated</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ Route('Admins.profile',$Admin->ID) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Your Profile">
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