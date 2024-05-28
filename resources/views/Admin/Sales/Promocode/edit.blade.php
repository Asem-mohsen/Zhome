@extends('Admin.Layout.Master')
@section('Title' , 'Edit Promocode')

@section('Content')

    <div class="container-fluid py-4">
        <form action="" method="post">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Edit Promo Code</p>
                                <button class="btn btn-success btn-sm ms-auto">Edit</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Information</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label text-center w-100">Code</label>
                                        <input class="form-control" type="text" name="Code" value="<?php echo $row['Promocode'] ?>">
                                        <input type="hidden" name="CodeID" value="<?php echo $row['ID'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Amount to Save -%-</label>
                                        <input class="form-control" type="number" name="Save" value="<?php echo $row['Save'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label w-100 text-center">Available For -In Days-</label>
                                        <input class="form-control" type="number" name="AvailableFor" value="<?php echo $row['AvailableFor'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="example-text-input" class="form-control-label">Status</label>
                                    <select class="form-control" name="Status" placeholder="Status">
                                        <option value="1">Working</option>
                                        <option value="2">Disabled</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="example-text-input" class="form-control-label">Added By</label>
                                    <select class="form-control" name="AddedBy" placeholder="AddedBy">
                                        <?php  
                                            $SelectAdmin = "SELECT * FROM admin";
                                            $Run = mysqli_query($con , $SelectAdmin);
                                            $Query = mysqli_fetch_row($Run);
                                            foreach($Run as $AdminName){ ?>
                                                <option value="<?php echo $AdminName['ID'] ?>"><?php echo $AdminName['Name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label w-100 text-center">Added At</label>
                                        <input class="form-control" type="date" name="AddedAt" value="<?php echo $row['AddedAt'] ?>" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label w-100 text-center">Ends In</label>
                                        <input class="form-control" type="text" name="EndsIn" value="<?php echo $row['EndsIn'] ?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">

                            <p class="text-uppercase text-sm">Control</p>
                            <div class="justify-content-center row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button type="submit" name="UpdateCode" class="btn btn-md bg-gradient-success w-100 mt-4 mb-0">Update</button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <a href="./Promocodes.php" class="btn btn-md bg-gradient-primary w-100 mt-4 mb-0">Cancel</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Side Card -->
                <div class="col-md-4">
                    <div class="card card-profile" style="height: 450px;">
                    <h5 class='text-center' style="padding-top: 20px;"> Code -  <?php echo $row['Promocode'] ?> </h5>
                        <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
                            <div class="d-flex justify-content-center">
                                <a href="" class="btn btn-sm btn-info mb-0 d-none d-lg-block"><?php if($row['Status'] == 1 ){ echo "Working" ;}else{ echo "Disabled" ;} ?></a>
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
                                            <td><?php echo $row['Save'] ?> %</td>
                                        </tr>
                                        <tr>
                                            <td>Available For</td>
                                            <td><?php echo $row['AvailableFor'] ?> Days</td>
                                        </tr>
                                        <tr>
                                            <td>Added At</td>
                                            <td><?php echo date('M d,Y', strtotime($row['AddedAt'])); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Ends In</td>
                                            <td><?php echo date('M d,Y', strtotime($row['EndsIn'])); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Added By</td>
                                            <td><?php echo $row['Name']; ?>
                                            </td>
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