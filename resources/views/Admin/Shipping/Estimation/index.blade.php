@extends('Admin.Layout.Master')
@section('Title' , 'Exceptions')

@section('Content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Buttons --}}
                    <div class="btn-group w-fit pb-2">
                        <a href="{{ route('Shipping.estimations.create') }}" class="btn btn-dark p-2"><i class="fa-solid fa-plus mr-1"></i>Add New Exceptions</a>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Products</th>
                                <th>No. Products</th>
                                <th>Location</th>
                                <th>Estimation details</th>
                                <th>Estimated date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($exceptions as $exception)
                                <tr>
                                    <td>
                                        {{ $i++ }}
                                    </td>

                                    <td>
                                        @foreach($exception->products->take(2) as $product)
                                            <span>{{ $product->translations->name }}</span>
                                            @if(!$loop->last)
                                                <span>-</span>
                                            @endif
                                        @endforeach
                                        @if(count($exception->products) > 2) 
                                            <span>...</span>
                                        @endif
                                    </td>

                                    <td>{{$exception->products->count() }}</td>

                                    <td>
                                        <div class="d-gird">
                                            <div>
                                                {{$exception->country->country}}
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{$exception->city->name}}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td>{{$exception->estimation_details}}</td>

                                    <td>{{$exception->estimated_delivery_date->format('Y-m-d')}}</td>

                                    <td class="d-flex justify-content-around gap-1 align-items-baseline">
                                        <a href="{{ route('Shipping.estimations.edit' , $exception->id ) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit Brand">
                                            Check
                                        </a>
                                        <form action="{{ route('Shipping.estimations.delete' , $exception->id )}}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <button class="text-secondary bg-transparent border-0 text-danger font-weight-bold text-xs">Delete</button>

                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('Js')
    <!-- Page specific script -->
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@stop
