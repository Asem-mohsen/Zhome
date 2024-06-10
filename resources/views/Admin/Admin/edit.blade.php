@extends('Admin.Layout.Master')
@section('Title' , 'Edit')

@section('Content')
@include('Admin.Components.Msg')
    <div class="card shadow-lg mx-4 card-profile-bottom">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="{{ asset('Admin/dist/img/user2-160x160.jpg') }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                    <h5 class="mb-1">
                        {{$admin->Name}}
                    </h5>
                    <p class="mb-0 font-weight-bold text-sm">
                        {{$admin->Role}}
                    </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4">
        <form action="{{ route('Admins.update',$admin->ID) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header pb-2">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Edit {{$admin->Name}}</p>
                                <button class="btn btn-primary btn-sm ms-auto m-2">Edit</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">{{$admin->Name}} Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Name</label>
                                        <input class="form-control" type="text"  name="Name" value="{{$admin->Name}}" required>
                                    </div>
                                    @error('Name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email address</label>
                                        <input class="form-control" type="email" name="Email" value="{{$admin->Email}}" required>
                                    </div>
                                    @error('Email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="example-text-input" class="form-control-label">Role</label>
                                    <select class="form-control" name="RoleID" id="choices-button">
                                        @foreach ($Roles as $Role)
                                            <option @selected($Role->ID == $admin->RoleID) value="{{ $Role->ID }}">{{ $Role->Role }}</option>
                                        @endforeach
                                    </select>
                                    @error('Role')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Contact Information</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Address</label>
                                        <input class="form-control" type="text" name="Address" value="{{$admin->Address}}"  required>
                                    </div>
                                    @error('Address')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Phone</label>
                                        <input class="form-control" type="number" name="Phone" value="{{$admin->Phone}}" required>
                                    </div>
                                    @error('Phone')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Date Of Birth</label>
                                        <input class="form-control" type="date" name="DOB"  value="{{$admin->DOB}}" required>
                                    </div>
                                    @error('DOB')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="horizontal dark">

                            <p class="text-uppercase text-sm">Control</p>
                            <div class="justify-content-center row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-md btn-success w-100 mt-4 mb-0">Update</button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <a href="{{ route('Admins.index')}}" class="btn btn-md btn-danger w-100 mt-4 mb-0">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection