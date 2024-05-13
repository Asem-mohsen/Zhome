@extends('Admin.Layout.Master')
@section('Title' , 'Roles')

@section('Content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
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
                                <td>
                                    <a href="{{ Route('Roles.Role',$Role->ID) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="View Role">
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