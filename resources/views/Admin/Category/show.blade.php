@extends('Admin.Layout.Master')

@section('Title' , $category->name)

@section('Content')

@include('Admin.Components.Msg')


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                {{-- Buttons --}}
                <div class="btn-group w-fit pb-2">
                    <a href="{{ route('Category.edit' , $category->id ) }}" class="btn btn-primary p-2"><i class="fa-solid fa-pen mr-1"></i>Edit Category</a>
                    <a href="{{ route('Category.Subcategory.create' , $category->id ) }}" class="btn btn-info p-2"><i class="fa-solid fa-plus mr-1"></i>Add Subcategory</a>
                    <a href="" class="btn btn-secondary p-2"><i class="fa-solid fa-box-archive mr-1"></i>Archive</a>
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
                        @foreach ($category->subcategories as $subcategory)

                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{$subcategory->name}}</td>
                                <td>{{$subcategory->ar_name}}</td>
                                <td>
                                    @if($subcategory->status === 'active')
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-warning">Hidden</span>
                                    @endif
                                </td>
                                <td class="d-flex justify-content-around align-items-baseline">
                                    <a href="{{ route('Category.Subcategory.edit',$subcategory->id) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit">
                                        Edit
                                    </a>
                                    @if($subcategory->status === 'active')
                                        <a href="{{ route('Category.Subcategory.edit',$subcategory->id) }}" class="text-warning font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Hie">
                                            Hide
                                        </a>
                                    @else
                                        <a href="{{ route('Category.Subcategory.edit',$subcategory->id) }}" class="text-success font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Show">
                                            Show
                                        </a>
                                    @endif
                                    
                                    <form action="{{ route('Category.Subcategory.delete' ,$subcategory->id )}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button  class="border-0 bg-transparent p-0 text-danger font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete">
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
