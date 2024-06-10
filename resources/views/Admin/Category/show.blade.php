@extends('Admin.Layout.Master')
@section('Title' , $category->Category)

@section('Content')

@include('Admin.Components.Msg')


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                {{-- Buttons --}}
                <div class="btn-group w-fit pb-2">
                    <a href="{{ route('Category.edit' , $category->ID ) }}" class="btn btn-primary p-2"><i class="fa-solid fa-plus"></i>Edit Category</a>
                    <a href="{{ route('Category.Subcategory.create' , $category->ID ) }}" class="btn btn-info p-2"><i class="fa-solid fa-plus"></i>Add Subcategory</a>
                    <a href="" class="btn btn-secondary p-2"><i class="fa-solid fa-box-archive"></i>Archive</a>
                </div>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sub-category</th>
                            <th>Arabic Name</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($subCategories as $subCategory)

                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{$subCategory->SubName}}</td>
                                <td>{{$subCategory->SubArabicName}}</td>
                                <td>
                                    @if($subCategory->Status == 1)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-warning">Hidden</span>
                                    @endif
                                </td>
                                <td class="d-flex justify-content-around align-items-baseline">
                                    <a href="{{ route('Category.Subcategory.edit',$subCategory->ID) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit">
                                        Edit
                                    </a>
                                    @if($subCategory->Status == 1)
                                        <a href="{{ route('Category.Subcategory.edit',$subCategory->ID) }}" class="text-warning font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Hie">
                                            Hide
                                        </a>
                                    @else
                                        <a href="{{ route('Category.Subcategory.edit',$subCategory->ID) }}" class="text-success font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Show">
                                            Show
                                        </a>
                                    @endif
                                    
                                    <form action="{{ route('Category.Subcategory.delete' ,$subCategory->ID )}}" method="post">
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
