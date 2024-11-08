@extends('Admin.Layout.Master')
@section('Title' , 'Edit Promocode')

@section('Content')

    <div class="container-fluid py-4">
        <form action="{{route('Sales.Promocode.update' , $promocode->id )}}" method="post">
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
                                        <input class="form-control" id="Promocode" type="text" name="code" value="{{$promotion->code}}" required>
                                    </div>
                                    @error('code')
                                        <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="discount_amount" class="form-control-label">Amount to Save -%-</label>
                                        <input class="form-control" id="discount_amount" type="number" name="discount_amount" value="{{$promotion->discount_amount}}" required>
                                    </div>
                                    @error('discount_amount')
                                        <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="valid_from" class="form-control-label w-100 text-center">Valid From</label>
                                        <input class="form-control" id="valid_from" type="date" name="valid_from" value="{{$promotion->valid_from}}" required>
                                    </div>
                                    @error('valid_from')
                                        <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group d-grid justify-content-center text-center">
                                        <label for="status" class="form-control-label">Status</label>
                                        <input type="hidden" name="status" value="0">
                                        <input type="checkbox" name="status" value="{{$promotion->status}}" @checked($promotion->status == 'activr') data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                    </div>
                                    @error('status')
                                        <div class="alert alert-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="valid_until" class="form-control-label w-100 text-center">Valid Until</label>
                                        <input class="form-control" id="valid_until" type="text" name="valid_until" value="{{$promotion->valid_until}}" disabled>
                                    </div>
                                    @error('valid_until')
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
                    <h5 class='text-center' style="padding-top: 20px;"> Code - {{$promotion->code}}</h5>
                        <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
                            <div class="d-flex justify-content-center">
                                <a href="" class="btn btn-sm btn-info mb-0 d-none d-lg-block">
                                    @if($promotion->status == 'activr')
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
                                            <td>{{$promotion->discount_amount . "%"}}</td>
                                        </tr>
                                        <tr>
                                            <td>Valid From</td>
                                            <td>{{ date('Md,Y' , strtotime($promotion->valid_from)) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Valid Until</td>
                                            <td>{{ date('Md,Y' , strtotime($promotion->valid_until)) }}</td>
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
                if ($('input[name="status"]').bootstrapSwitch('state')) {
                    $('input[name="status"]').val(1);
                } else {
                    $('input[name="status"]').val(0);
                }
            });
        });
    </script>
@stop