@extends('Admin.Layout.Master')
@section('Title' , 'Products')

@section('Content')

@include('Admin.Components.Msg')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                {{-- Buttons --}}
                <div class="btn-group w-fit pb-2">
                    <a href="{{ route('Products.create') }}" class="btn btn-primary p-2"><i class="fa-solid fa-plus"></i>Add Product</a>
                    <a href="" class="btn btn-secondary p-2"><i class="fa-solid fa-box-archive"></i>Archive All Products</a>
                </div>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Brand</th>
                            <th>Platform</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp

                        @foreach ($products as $product)
                        
                            <tr>
                                <td>
                                    {{ $i++ }}
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="{{ asset("Admin/dist/img/web/Products/MainImage/{$product->MainImage}") }}" class="avatar avatar-sm me-3" alt="{{$product->Name}}">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h5 class="mb-0 text-sm">{{$product->Name}}</h5>
                                            <h6 class="mb-0 text-sm">{{$product->ArabicName ?$product->ArabicName : "بعيب" }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $product->brand->Brand }}</td>
                                <td>
                                    <div class="Platform-index">
                                        @foreach($product->platforms as $platform)
                                            <a href="{{route('Platform.edit' , $platform->ID )}}">
                                                <div class="platform">
                                                    <img src="{{ asset("Admin/dist/img/web/Platforms/{$platform->Logo}") }}" alt="{{$platform->Platform}}">
                                                    <p>{{$platform->Platform}}</p>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column justify-content-center text-center px-2 py-1">
                                        <h6>{{$product->subcategory->category->Category}}</h6>
                                        <p class="text-sm">{{$product->subcategory->SubName}}</p>
                                    </div>
                                    
                                </td>
                                <td>
                                    @if($product->Quantity > 0)
                                        {{$product->Quantity}}
                                    @else
                                        <span class="badge badge-danger">Sold Out</span>
                                    @endif
                                </td>
                                
                                <td>
                                    {{$product->Price}}
                                </td>
                                <td class="d-flex justify-content-around align-items-baseline">
                                    <a href="{{ route('Products.show',$product->ID) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Your Profile">
                                        Check
                                    </a>
                                    <a href="{{ route('Products.edit',$product->ID) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit">
                                        Edit
                                    </a>
                                    <form action="{{ route('Products.delete' ,$product->ID )}}" method="post">
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