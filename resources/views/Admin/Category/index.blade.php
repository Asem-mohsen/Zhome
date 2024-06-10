@extends('Admin.Layout.Master')
@section('Title' , 'Categories')

@section('Content')

@include('Admin.Components.Msg')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                {{-- Buttons --}}
                <div class="btn-group w-fit pb-2">
                    <a href="{{ route('Category.create') }}" class="btn btn-primary p-2"><i class="fa-solid fa-plus"></i>Add New Category</a>
                    <a href="" class="btn btn-secondary p-2"><i class="fa-solid fa-box-archive"></i>Archive</a>
                </div>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Arabic Name</th>
                            <th>Number of Subcategory</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($Categories as $Category)

                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{$Category->Category}}</td>
                                <td>{{$Category->ArabicName}}</td>
                                <td>{{$subCounts[$Category->ID] }}</td>
                                <td class="d-flex justify-content-around align-items-baseline">
                                    <a href="{{ route('Category.show',$Category->ID) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Check">
                                        Check
                                    </a>
                                    <a href="{{ route('Category.edit',$Category->ID) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit">
                                        Edit
                                    </a>
                                    @if($subCounts[$Category->ID] <= 0)
                                        <form action="{{ route('Category.delete' ,$Category->ID )}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button  class="border-0 bg-transparent p-0 text-danger font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete">
                                                Delete
                                            </button>
                                        </form>
                                    @else
                                            <button class="border-0 bg-transparent p-0 text-danger font-weight-bold text-xs disabled" data-toggle="tooltip" data-original-title="Delete">
                                                Delete
                                            </button>
                                    @endif
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
