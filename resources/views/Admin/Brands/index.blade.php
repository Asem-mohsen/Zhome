@extends('Admin.Layout.Master')
@section('Title' , 'Brands')

@section('Content')

@include('Admin.Components.Msg')

<style>
    
    .Brand-Box p {
        top: 0;
        font-size: 33px;
    }
    .Brand-Box:hover .overlay{
        transition:all 0.4s;
        opacity: 1;
        background-color: rgb(37 37 37 / 73%);
    }
    .Brand-Box:hover p{
        transition:all 0.4s;
        opacity:0;
    }
    .Brand-Box ul{
        gap:20px;
    }
    .overlay{
        top: 0;
        opacity: 0;
    }
    .overlay a{
        font-size: 26px; 
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @foreach ($Brands as $Brand)
                        <div class="col-md-2">
                            <div class="Brand-Box position-relative mb-3">
                                <img src="{{ asset('Admin/dist/img/photo1.png') }}" alt="" class="w-100">
                                <p class="position-absolute top-0 d-flex align-items-center justify-content-center w-100 h-100 text-white m-0">{{ $Brand->Brand }}</p>
                                <div class="overlay position-absolute w-100 h-100">
                                    <form action="">
                                        <ul class="d-flex list-unstyled p-0 m-0">
                                            <li>
                                                <a href="{{ route('Brands.edit' , $Brand->ID ) }}" class="text-white font-weight-bold">Edit</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('Brands.delete', $Brand->ID ) }}" class="text-white font-weight-bold">Delete</a>
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