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
                                        <input class="form-control" id="Promocode" type="text" name="code" value="{{ old('code') }}" required>
                                    </div>
                                    @error('code')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="discount_amount" class="form-control-label">Amount to Save -%-</label>
                                        <input class="form-control" id="discount_amount" type="number" name="discount_amount" value="{{ old('discount_amount') }}" required>
                                    </div>
                                    @error('discount_amount')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="valid_from" class="form-control-label">Valid from</label>
                                        <input class="form-control" id="valid_from" type="date" name="valid_from" value="{{ old('valid_from') }}" required>
                                    </div>
                                    @error('valid_from')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="valid_until" class="form-control-label">Valid Until</label>
                                        <input class="form-control" id="valid_until" type="date" name="valid_until" value="{{ old('valid_until') }}" required>
                                    </div>
                                    @error('valid_until')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
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

