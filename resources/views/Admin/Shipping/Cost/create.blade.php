@extends('Admin.Layout.Master')

@section('Title', 'Add Shipping Fees')

@section('Content')

    <form action="{{ route('Shipping.cost.store') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Add New Shipping Fees</p>
                            <button class="btn btn-primary btn-sm ms-auto m-2">Add</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-uppercase text-sm">Shipping Fees</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country_id" class="form-control-label">Country</label>
                                    <select name="country_id" id="country_id" class="form-control">
                                        <option hidden disabled selected>Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"> {{ $country->country }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('country_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city_id" class="form-control-label">City</label>
                                    <select name="city_id" id="city_id" class="form-control" disabled>
                                        <option hidden disabled selected>Select City</option>
                                    </select>
                                </div>
                                @error('city_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="delivery_estimations" class="form-control-label">Delivery estimation details</label>
                                    <input class="form-control" type="text" id="delivery_estimations" name="delivery_estimations" value="{{ old('delivery_estimations') }}">
                                </div>
                                @error('delivery_estimations')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="shipping_fee" class="form-control-label">Fees</label>
                                    <input class="form-control" type="number" id="shipping_fee" inputmode="numeric" name="shipping_fee" value="{{ old('shipping_fee') }}">
                                </div>
                                @error('shipping_fee')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <p class="text-uppercase text-sm">Control</p>
                        <div class="justify-content-center row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-md btn-success w-100 mt-4 mb-0">Add</button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <a href="{{ route('Shipping.cost.index') }}" class="btn btn-md btn-danger w-100 mt-4 mb-0">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('Js')

<script>
    $(document).ready(function() {
        $('#country_id').change(function() {
            var countryId = $(this).val();

            if (countryId) {
                $('#city_id').prop('disabled', false);

                $.ajax({
                    url: '/get-cities/' + countryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#city_id').empty();
                        $('#city_id').append('<option hidden disabled selected>Select City</option>');
                        $.each(data, function(key, city) {
                            $('#city_id').append('<option value="' + city.id + '">' + city.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            } else {
                $('#city_id').prop('disabled', true);
            }
        });
    });
</script>

@stop
