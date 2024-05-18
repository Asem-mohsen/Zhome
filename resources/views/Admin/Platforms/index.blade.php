@extends('Admin.Layout.Master')
@section('Title' , 'Platforms')

@section('Content')

@include('Admin.Components.Msg')

<div class="row">
    <div class="col-12">
        <div class="card">
            {{-- Buttons --}}
            <div class="btn-group w-fit pb-0 pl-3 pt-3">
                <a href="{{ route('Platform.create') }}" class="btn btn-primary p-2"><i class="fa-solid fa-plus"></i>Add New Platform</a>
                <a href="" class="btn btn-secondary p-2"><i class="fa-solid fa-box-archive"></i>Archive</a>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($Platforms as $Platform)
                        <div class="col-md-4">
                            <div class="Platform-box d-flex mb-3">
                                <img src="{{ asset('Admin/dist/img/photo1.png') }}" alt="" class="platform-image">
                                <div class="position-relative w-100">
                                    <p class="d-flex align-items-center justify-content-center m-0 platform-title h-100">{{ $Platform->Platform }}</p>
                                    <div class="overlay position-absolute w-100 h-100">
                                        <form action="{{ route('Platform.delete' , $Platform->ID )}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <ul class="d-flex list-unstyled p-0 m-0 justify-content-around align-items-baseline platform-list">
                                                <li>
                                                    <a href="{{ route('Platform.edit' , $Platform->ID ) }}" class="text-white font-weight-bold">Edit</a>
                                                </li>
                                                <li>
                                                    <button class="border-0 bg-transparent p-0 text-white font-weight-bold">Delete</button>
                                                </li>
                                            </ul>
                                        </form>
                                    </div>
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
