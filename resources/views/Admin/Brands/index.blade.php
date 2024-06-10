@extends('Admin.Layout.Master')
@section('Title' , 'Brands')

@section('Content')

@include('Admin.Components.Msg')


<div class="row">
    <div class="col-12">
        <div class="card">
            {{-- Buttons --}}
            <div class="btn-group w-fit pb-0 pl-3 pt-3">
                <a href="{{ route('Brands.create') }}" class="btn btn-primary p-2"><i class="fa-solid fa-plus"></i>Add New Brand</a>
                <a href="" class="btn btn-secondary p-2"><i class="fa-solid fa-box-archive"></i>Archive</a>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($Brands as $Brand)
                        <div class="col-md-2">
                            <div class="Brand-Box position-relative mb-3">
                                <img src="{{ asset("Admin/dist/img/web/Brands/{$Brand->Logo}") }}" alt="{{$Brand->Brand}}" class="img h-100 w-100">
                                <div class="overlay position-absolute w-100 h-100">
                                    <form action="{{ route('Brands.delete' , $Brand->ID )}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <ul class="d-flex list-unstyled p-0 m-0 justify-content-around align-items-baseline brand-list">
                                            <li>
                                                <a href="{{ route('Brands.edit' , $Brand->ID ) }}" class="text-white font-weight-bold">Edit</a>
                                            </li>
                                            <li>
                                                <button class="border-0 bg-transparent p-0 text-white font-weight-bold">Delete</button>
                                            </li>
                                        </ul>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
