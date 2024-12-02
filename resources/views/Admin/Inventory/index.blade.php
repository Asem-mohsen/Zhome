@extends('Admin.Layout.Master')
@section('Title' , 'Stock')
@section('Content')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Products</span>
                        <span class="info-box-number">{{$totalProducts}}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Sold Out</span>
                        <span class="info-box-number">{{$soldOut}}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">About to end</span>
                        <span class="info-box-number">{{$aboutToEnd}}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Newest Products</span>
                        <span class="info-box-number">{{$newest}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Brand</th>
                        <th>Quantity</th>
                        <th>Ordered by</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach($products as $product)
                        <tr>
                            <td>
                                <p>{{$i++}}</p>
                            </td>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div>
                                        <img src="{{$product->getFirstMediaUrl('product_featured_image')}}" class="avatar avatar-sm me-3" alt="{{$product->translations->name}}">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0">{{$product->translations->name}}</h6>
                                        <span class="text-sm">Price : {{$product->getCurrentPrice() . " EGP"}}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle text-sm">
                                {{$product->brand->name}}
                            </td>
                            <td>
                                <p class="text-s font-weight-bold mb-0">
                                    @if ($product->quantity >= 20)
                                        <span id="quantity-{{$product->id}}" class="badge badge-sm bg-success">{{$product->quantity}}</span>
                                    @elseif ($product->quantity  == 0)
                                        <span id="quantity-{{$product->id}}" class="badge badge-sm bg-danger">{{$product->quantity}}</span>
                                    @elseif ($product->quantity >= 10 && $product->quantity < 20)
                                        <span id="quantity-{{$product->id}}" class="badge badge-sm bg-info">{{$product->quantity}}</span>
                                    @elseif ($product->quantity  < 10)
                                        <span id="quantity-{{$product->id}}" class="badge badge-sm bg-secondary">{{$product->quantity}}</span>
                                    @endif
                                </p>
                            </td>
                            <td class="align-middle text-center text-sm">
                                {{ $product->ordered_by_users_count }} users
                            </td>
                            <td class="align-middle">
                                <a href="{{ config('app.frontend_url') }}/product/{{ $product->id }}" class="btn bg-info" target="_blank" data-toggle="tooltip">
                                    Check
                                </a>
                                <button data-quantity-id="{{$product->id}}" class="btn bg-success edit-button" data-toggle="tooltip">
                                    Edit
                                </button>
                                <button data-quantity-id="{{$product->id}}"  class="btn bg-success update-button d-none" data-toggle="tooltip">
                                    Update
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection

@section('Js')

    
    <script>
        // Add event listeners to the edit buttons
        const editButtons = document.querySelectorAll('.edit-button');
            editButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                const quantityId = event.target.getAttribute('data-quantity-id');
                enableEditing(quantityId);
            });
        });

        // Add event listeners to the update buttons
        const updateButtons = document.querySelectorAll('.update-button');
            updateButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                const quantityId = event.target.getAttribute('data-quantity-id');
                updateQuantity(quantityId);
            });
        });

        // Function to enable editing for a specific product
        function enableEditing(quantityId) {
            const quantityCell = document.getElementById(`quantity-${quantityId}`);
            if (quantityCell) {
                const quantityText = quantityCell.textContent;

                // Create an input element
                const inputElement = document.createElement('input');
                inputElement.type = 'number';
                inputElement.classList = 'form-control';
                inputElement.value = quantityText;

                // Replace the role text with the input element
                quantityCell.innerHTML = '';
                quantityCell.appendChild(inputElement);

                // Change button visibility
                const editButton = document.querySelector(`.edit-button[data-quantity-id="${quantityId}"]`);
                const updateButton = document.querySelector(`.update-button[data-quantity-id="${quantityId}"]`);
                if (editButton && updateButton) {
                editButton.classList.add('d-none');
                updateButton.classList.remove('d-none');
                }
            } else {
                console.error(`Quantity cell with ID 'quantity-${quantityId}' not found.`);
            }
        }

        // Function to update the product in the database
        function updateQuantity(quantityId) {
            const quantityCell = document.getElementById(`quantity-${quantityId}`);
            const updatedQuantity = quantityCell.querySelector('input').value;

            // Send an AJAX request to the Laravel route to update the quantity
            const url = '/Inventory/update-quantity';
            const method = 'PATCH';
            const data = {
                quantityId: quantityId,
                updatedQuantity: updatedQuantity
            };

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(function(response) {

                if (response.status == 200) {
                    // Update the quantity text in the table based on the value
                    if (updatedQuantity >= 20) { // Greater than 20
                        quantityCell.innerHTML = `<span id="quantity-${quantityId}" class="badge badge-sm bg-success">${updatedQuantity}</span>`;
                    } else if (updatedQuantity == 0) { // Equal to 0
                        quantityCell.innerHTML = `<span id="quantity-${quantityId}" class="badge badge-sm bg-danger">${updatedQuantity}</span>`;
                    } else if (updatedQuantity >= 10 && updatedQuantity < 20) { // Between 10 and 20
                        quantityCell.innerHTML = `<span id="quantity-${quantityId}" class="badge badge-sm b-warning">${updatedQuantity}</span>`;
                    } else if (updatedQuantity < 10) { // Less than 10
                        quantityCell.innerHTML = `<span id="quantity-${quantityId}" class="badge badge-sm bg-danger">${updatedQuantity}</span>`;
                    }

                    // Change button visibility
                    const editButton = document.querySelector(`.edit-button[data-quantity-id="${quantityId}"]`);
                    const updateButton = document.querySelector(`.update-button[data-quantity-id="${quantityId}"]`);
                    editButton.classList.remove('d-none');
                    updateButton.classList.add('d-none');
                } else {
                    throw new Error('Failed to update quantity in the database.');
                }
            })
            .catch(function(error) {
                console.error(error);
            });
        }
    </script>


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