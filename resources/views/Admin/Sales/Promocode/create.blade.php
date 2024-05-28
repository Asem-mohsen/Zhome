@extends('Admin.Layout.Master')
@section('Title' , 'Add New Promocode')

@section('Content')

    <div class="container-fluid py-4">
        <form v method="post">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Add New Promo Code</p>
                                <button class="btn btn-primary btn-sm ms-auto">Add</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Code</label>
                                        <input class="form-control" type="text" name="Code" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Amount to Save -%-</label>
                                        <input class="form-control" type="number" name="Save" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label w-100 text-center">Available For -In Days-</label>
                                        <input class="form-control" type="number" name="AvailableFor" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Side Card -->
                <div class="col-md-4">
                    <div class="card card-profile" style="height: 338px;">
                        <p class="text-uppercase" style="text-align: center;padding-top: 40px;font-size: 24px;">Control</p>
                        <div class="justify-content-center row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="submit" name="AddCode" class="btn bg-gradient-primary w-100 mt-4 mb-0">Add</button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <a href="./Promocodes.php" class="btn bg-gradient-danger w-100 mt-4 mb-0">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

