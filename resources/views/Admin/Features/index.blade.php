@extends('Admin.Layout.Master')
@section('Title' , 'Features')

@section('Content')

@include('Admin.Components.Msg')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                {{-- Buttons --}}
                <div class="btn-group w-fit pb-2">
                    <a href="{{ route('Features.create') }}" class="btn btn-primary p-2"><i class="fa-solid fa-plus mr-1"></i>Add Feature</a>
                </div>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Feature</th>
                            <th>Description</th>
                            <th>Number of Products</th>
                            <th>Number of Collections</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp

                        @foreach ($features as $feature)

                            <tr>
                                <td>
                                    {{ $i++ }}
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h5 class="mb-0 text-sm">{{$feature->name}}</h5>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    {{ \Illuminate\Support\Str::limit($feature->description, 100, '...') }}
                                </td>
                                <td>
                                    {{$feature->products_count . " Products have this feature"}}
                                </td>
                                <td>
                                    {{$feature->collections_count . " Collection have this feature"}}
                                </td>
                                <td class="d-flex justify-content-around gap-1 align-items-baseline">
                                    <a href="{{ route('Features.show',$feature->id) }}" class="text-primary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="view">
                                        show
                                    </a>
                                    <a href="{{ route('Features.edit',$feature->id) }}" class="text-success font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit">
                                        Edit
                                    </a>
                                    <form action="{{ route('Features.delete' ,$feature->id )}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button  class="border-0 bg-transparent p-0 text-danger font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete">
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
