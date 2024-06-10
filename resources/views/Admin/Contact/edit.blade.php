@extends('Admin.Layout.Master')
@section('Title' , 'Edit Zhome Contact')

@section('Content')

@include('Admin.Components.Msg')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('Contact.update', $contact->ID) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card mb-4" style="overflow: hidden; height: auto;">
                        <div class="wrapper">
                            <div class="card">
                                <div class="d-flex justify-content-between align-items-center card-header pb-0">
                                    <h6>Edit Contact</h6>
                                    <div class="mb-1">
                                        <a class="btn btn-info" href="{{route('Contact.index')}}">Cancel</a>
                                        <button type='submit' class="btn btn-success"><i class="fas fa-pen"></i>Update</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example2" class="table table-striped table-bordered">
                                            <thead>
                                                <th scope="col" width="10%">#</th>
                                                <th scope="col" width="20%">Information</th>
                                            </thead>
                                            
                                                <tr>
                                                
                                                    <td>Owner</td>
                                                    <td>
                                                        <input class="form-control" type="text" name="Owner" value="{{$contact->Owner}}" required>
                                                        @error('Owner')
                                                            <div class="alert alert-danger">{{$message}}</div>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Number Of Employees</td>
                                                    <td>
                                                        <input class="form-control" type="number" name="NumberofEmp" value="{{$contact->NumberofEmp}}">
                                                        @error('NumberofEmp')
                                                            <div class="alert alert-danger">{{$message}}</div>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Market 
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="Market" value="{{$contact->Market}}" required>
                                                        @error('Market')
                                                            <div class="alert alert-danger">{{$message}}</div>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Second Market 
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="Market2" value="{{$contact->Market2}}">
                                                        @error('Market2')
                                                            <div class="alert alert-danger">{{$message}}</div>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Phone</td>
                                                    <td>
                                                        <input class="form-control" type="number" name="Phone" value="{{$contact->Phone}}" required>
                                                        @error('Phone')
                                                            <div class="alert alert-danger">{{$message}}</div>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Second Phone</td>
                                                    <td>
                                                        <input class="form-control" type="text" name="Phone2" value="{{$contact->Phone2}}">
                                                        @error('Phone2')
                                                            <div class="alert alert-danger">{{$message}}</div>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Location</td>
                                                    <td>
                                                        <input class="form-control" type="text" name="Location" value="{{$contact->Location}}" required>
                                                        @error('Location')
                                                            <div class="alert alert-danger">{{$message}}</div>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Second Location</td>
                                                    <td>
                                                        <input class="form-control" type="text" name="Location2" value="{{$contact->Location2}}">
                                                        @error('Location2')
                                                            <div class="alert alert-danger">{{$message}}</div>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Address</td>
                                                    <td>
                                                        <input class="form-control" type="text" name="Address" value="{{$contact->Address}}" required>
                                                        @error('Address')
                                                            <div class="alert alert-danger">{{$message}}</div>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Website Link</td>
                                                    <td>
                                                        <input class="form-control" type="url" name="WebsiteLink" value="{{$contact->WebsiteLink}}" required>
                                                        @error('WebsiteLink')
                                                            <div class="alert alert-danger">{{$message}}</div>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Other Links</td>
                                                    <td>
                                                        <input class="form-control" type="url" name="OtherLinks" value="{{$contact->OtherLinks}}">
                                                        @error('OtherLinks')
                                                            <div class="alert alert-danger">{{$message}}</div>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Redirecting</td>
                                                    <td>
                                                        <input type="hidden" name="Redirecting" value="0">
                                                        <input type="checkbox" name="Redirecting" value="{{$contact->Redirecting}}" @checked($contact->Redirecting == 1) data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                                        @error('Redirecting')
                                                            <div class="alert alert-danger">{{$message}}</div>
                                                        @enderror
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
        </div>
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
                if ($('input[name="Redirecting"]').bootstrapSwitch('state')) {
                    $('input[name="Redirecting"]').val(1);
                } else {
                    $('input[name="Redirecting"]').val(0);
                }
            });
        });
    </script>
@stop