@extends('Admin.Layout.Master')
@section('Title' , 'Platforms')

@section('Content')

    @include('Admin.Components.Msg')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Buttons --}}
                    <div class="btn-group w-fit pb-2">
                        <a href="{{ route('Platform.create') }}" class="btn btn-dark p-2"><i class="fa-solid fa-plus mr-1"></i>Add New Platform</a>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Platform</th>
                                <th>Number of Products</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($platforms as $platform)
                                <tr>
                                    <td>
                                        {{ $i++ }}
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="{{ $platform->getFirstMediaUrl('platform-image')}}" alt="{{$platform->name}}" class="avatar avatar-sm me-3">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{$platform->name}}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$platform->products_count}}</td>

                                    <td class="d-flex justify-content-around gap-1 align-items-baseline">
                                        <a href="{{ route('Platform.edit' , $platform->id ) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit Brand">
                                            Check
                                        </a>
                                        <form action="{{ route('Platform.delete' , $platform->id )}}" method="post">
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
