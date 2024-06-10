@extends('Admin.Layout.Master')
@section('Title' , 'Zhome Contact')

@section('Content')

@include('Admin.Components.Msg')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4" style="overflow: hidden; height: auto;">
                    <div class="wrapper">
                        <div class="card">
                            <div class="d-flex justify-content-between align-items-center card-header pb-0">
                                <h6>About Zhome</h6>
                                <div class="mb-1">
                                    <a class="btn btn-success" href="{{route('Contact.edit' , $contact->ID)}}"><i class="fas fa-pen"></i>&nbsp;&nbsp;Edit Information</a>
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
                                                <td>{{"Mr." . $contact->Owner}}</td>
                                            </tr>
                                            <tr>
                                                <td>Number Of Employees</td>
                                                <td>{{$contact->NumberofEmp}}</td>
                                            </tr>
                                            <tr>
                                                <td>Markets</td>
                                                <td>
                                                    {{$contact->Market}} {{$contact->Market2 ? '- ' . $contact->Market2 : ''  }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Phones</td>
                                                <td>
                                                    {{$contact->Phone}} {{$contact->Phone2 ? '- ' . $contact->Phone2 : ''  }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Location</td>
                                                <td>
                                                    {{$contact->Location }} {{$contact->Location2 ? '- ' . $contact->Location2 : ''  }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Address</td>
                                                <td>
                                                    {{$contact->Address}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Website Link</td>
                                                <td>
                                                    {{$contact->WebsiteLink}}
                                                </td>
                                            </tr>
                                            @if($contact->OtherLinks)
                                                <tr>
                                                    <td>Other Links</td>
                                                    <td>
                                                        {{$contact->OtherLinks}}
                                                    </td>
                                                </tr>
                                            @endif
                                            
                                            <tr>
                                                <td>Redirecting</td>
                                                <td>
                                                    @if($contact->Redirecting == 1)
                                                        <span class='badge bg-warning'>Enabled</span>
                                                    @else
                                                        <span class='badge bg-primary'>Disabled</span>
                                                    @endif
                                                </td>
                                            </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
