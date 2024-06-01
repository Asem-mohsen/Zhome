@extends('Admin.Layout.Master')
@section('Title' , 'Add New Promocode')

@section('Content')

    <div class="container-fluid py-4">
        <div class="card">
            <form action="{{route('Sales.Promocode.store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-header pb-2">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Add New Promo Code</p>
                                <button class="btn btn-primary btn-sm ml-2">Add</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Promocode" class="form-control-label">Code</label>
                                        <input class="form-control" id="Promocode" type="text" name="Promocode" required>
                                    </div>
                                    @error('Promocode')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Save" class="form-control-label">Amount to Save -%-</label>
                                        <input class="form-control" id="Save" type="number" name="Save" required>
                                    </div>
                                    @error('Save')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="AvailableFor" class="form-control-label w-100 text-center">Available For -In Days-</label>
                                        <input class="form-control" id="AvailableFor" type="number" name="AvailableFor" required>
                                        @error('AvailableFor')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="justify-content-center row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary w-100 mt-4 mb-0">Add</button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <a href="{{route('Sales.Promocode.index')}}" class="btn btn-danger w-100 mt-4 mb-0">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

