@extends('Admin.Layout.Master')
@section('Title' , 'Edit Promocode')

@section('Content')

    <div class="container-fluid py-4">
        <form action="{{route('Sales.Promocode.update' , $promocode->ID )}}" method="post">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header pb-2">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Edit Promocode</p>
                                <button class="btn btn-success btn-sm mL-2">Edit</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Promocode" class="form-control-label text-center w-100">Code</label>
                                        <input class="form-control" id="Promocode" type="text" name="Promocode" value="{{$promocode->Promocode}}" required>
                                    </div>
                                    @error('Promocode')
                                        <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Save" class="form-control-label">Amount to Save -%-</label>
                                        <input class="form-control" id="Save" type="number" name="Save" value="{{$promocode->Save}}" required>
                                    </div>
                                    @error('Save')
                                        <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="AvailableFor" class="form-control-label w-100 text-center">Available For -In Days-</label>
                                        <input class="form-control" id="AvailableFor" type="number" name="AvailableFor" value="{{$promocode->AvailableFor}}" required>
                                    </div>
                                    @error('AvailableFor')
                                        <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group d-grid justify-content-center text-center">
                                        <label for="Status" class="form-control-label">Status</label>
                                        <input type="hidden" name="Status" value="0">
                                        <input type="checkbox" name="Status" value="{{$promocode->Status}}" @checked($promocode->Status == 1) data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                    </div>
                                    @error('Status')
                                        <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="AddedAt" class="form-control-label w-100 text-center">Added At</label>
                                        <input class="form-control" type="date" name="AddedAt" value="{{$promocode->created_at}}" disabled>
                                    </div>
                                    @error('AddedAt')
                                        <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="EndsIn" class="form-control-label w-100 text-center">Ends In</label>
                                        <input class="form-control" id="EndsIn" type="text" name="EndsIn" value="{{$promocode->EndsIn}}" disabled>
                                    </div>
                                    @error('EndsIn')
                                        <div class="alert alert-danger">{{$message}}</div>
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
                                        <a href="{{route('Sales.Promocode.index')}}" class="btn btn-md btn-primary w-100 mt-4 mb-0">Cancel</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Side Card -->
                <div class="col-md-4">
                    <div class="card card-profile" style="height: 450px;">
                    <h5 class='text-center' style="padding-top: 20px;"> Code - {{$promocode->Promocode}}</h5>
                        <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
                            <div class="d-flex justify-content-center">
                                <a href="" class="btn btn-sm btn-info mb-0 d-none d-lg-block">
                                    @if($promocode->Status == 1)
                                        Working
                                    @else
                                        Disabled
                                    @endif
                                </a>
                                <a href="" class="btn btn-sm btn-info mb-0 d-block d-lg-none"><i class="ni ni-collection"></i></a>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table id="example2" class="table table-striped table-bordered">
                                    <thead>
                                        <th scope="col" width="10%">#</th>
                                        <th scope="col" width="20%"></th>
                                    </thead>
                                        <tr>
                                            <td>Amount to Save</td>
                                            <td>{{$promocode->Save . "%"}}</td>
                                        </tr>
                                        <tr>
                                            <td>Available For</td>
                                            <td>{{$promocode->AvailableFor . " Days"}}</td>
                                        </tr>
                                        <tr>
                                            <td>Added At</td>
                                            <td>{{ date('M d,Y', strtotime($promocode->created_at))}}</td>
                                        </tr>
                                        <tr>
                                            <td>Ends In</td>
                                            <td>{{ date('M d,Y', strtotime($promocode->EndsIn))}}</td>
                                        </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('Js')

    <!-- Bootstap Switch -->
    <script src="{{asset('Admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>


    <script>
        $(document).ready(function () {
            $("input[data-bootstrap-switch]").each(function(){
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })

            // Handle form submission
            $('form').on('submit', function () {
                // Manually update the hidden input value based on the checkbox state
                if ($('input[name="Status"]').bootstrapSwitch('state')) {
                    $('input[name="Status"]').val(1);
                } else {
                    $('input[name="Status"]').val(0);
                }
            });
        });
    </script>
@stop