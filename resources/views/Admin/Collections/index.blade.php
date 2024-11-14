@extends('Admin.Layout.Master')
@section('Title' , 'Collections')

@section('Content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                {{-- Buttons --}}
                <div class="btn-group w-fit pb-2">
                    <a href="{{ route('Collections.create') }}" class="btn btn-primary p-2"><i class="fa-solid fa-plus mr-1"></i>Add New Collection</a>
                </div>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Collection</th>
                            <th>Description</th>
                            <th>Number of Products</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp

                        @foreach ($collections as $collection)

                            <tr>
                                <td>
                                    {{ $i++ }}
                                </td>
                                <td>
                                    {{$collection->name}}
                                </td>

                                <td>
                                    {{ \Illuminate\Support\Str::limit($collection->description, 50, '...') }}
                                </td>
                                <td>
                                    {{$collection->products_count . " Products In this Collection"}}
                                </td>
                                <td class="d-flex justify-content-around align-items-baseline">
                                    <a href="{{ route('Collections.edit',$collection->id) }}" class="text-success font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit">
                                        Edit
                                    </a>
                                    <form action="{{ route('Collections.delete' ,$collection->id )}}" method="post">
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