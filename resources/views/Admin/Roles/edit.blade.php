@extends('Admin.Layout.Master')
@section('Title' , 'Role')

@section('Content')

@include('Admin.Components.Msg')
<div class="card shadow-lg mx-4 card-profile-bottom">
    <div class="card-body p-3">
        <div class="row gx-4">
            <div class="col-auto my-auto">
                <div class="h-100">
                <h5 class="mb-1">
                    {{ $Role->Role }}
                </h5>
                <p class="mb-0 font-weight-bold text-sm">
                    @if($adminCount > 0 )
                        {{ "Has ". $adminCount . " Admin";}}
                    @else
                        {{ "No Admins for this Role"}}
                    @endif
                </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid py-4">
    <form action="{{ route('Roles.update', $Role->ID )}}" method="post">
      @csrf
      @method('PUT')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-2">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Settings</p>
                            <a href="" class="btn btn-primary btn-sm ms-auto m-2">Settings</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                          <div class="col-md-12">
                            <label for="example-text-input" class="form-control-label">Role Name</label>
                            <input class="form-control" type="text"  name="Name" required value="{{ $Role->Role }}">
                          </div>
                        </div>

                        <p class="text-uppercase text-sm mt-5 "> {{ $Role->Role }} Department Users</p>
                        <div class="row">
                            <div class="col-md-12">
                                <ul style="list-style: none;display: flex;justify-content: center;gap: 20px;flex-wrap: wrap;">
                                    @if($adminCount > 0 )
                                        @foreach ( $admins as $admin )
                                            <a href="{{ route('Admins.profile', $admin->ID) }}" target="_blank" data-original-title="Visit Profile" style="display: block;width: fit-content;">
                                                <li style="padding: 10px;width: max-content;border: 1px solid #eee;border-radius: 18px;margin-bottom: 20px;min-width: 239px;">
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <img src="{{ asset('Admin/dist/img/user2-160x160.jpg')}}" class="avatar avatar-sm me-3" alt="user1">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $admin->Name }}</h6>
                                                            <p class="text-xs text-secondary mb-0">{{ $admin->Email }}</p>
                                                        </div>
                                                    </div>
                                                </li>
                                            </a>
                                        @endforeach
                                    @else
                                        {{ "No Admins for this Role"}}
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">Authorization and Accessibility </p>
                        <div class="row">
                          @foreach($checkboxColumns as $columnName)
                            <div class="col-md-3 pt-3 pb-3">
                              <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" role="switch" name="{{ $columnName }}" id="{{ $columnName }}" data-action="{{ $columnName }}"  @if($accessability->$columnName == 1) checked @endif>
                                  <label class="form-check-label" for="{{ $columnName }}">{{ $columnName }}</label>
                              </div>
                            </div>
                          @endforeach
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
                                    <a href="{{ route('Roles.index')}}" class="btn btn-md btn-info w-100 mt-4 mb-0">Back</a>
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
