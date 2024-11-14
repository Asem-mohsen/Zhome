@extends('Admin.Layout.Master')
@section('Title' , 'Users')

@section('Content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    {{ $i++ }}
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="{{ asset('Admin/dist/img/avatar.png') }}" class="avatar avatar-sm me-3" alt="{{$user->name}}">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{$user->name}}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @forelse ($user->phones as $index => $phone)
                                        {{ $phone->phone }}{{ $index < $user->phones->count() - 1 ? ' - ' : '' }}
                                    @empty
                                        No data
                                    @endforelse
                                </td>
                                <td>
                                    @if ($user->address)
                                        {{ \Illuminate\Support\Str::limit($user->address->street_address, 25) }}
                                    @else
                                        No data
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d F Y') }}</td>
                                <td>
                                    <a href="{{ Route('Users.profile',$user->id) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Your Profile">
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
