@extends('front.layouts.app')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.shop') }}">Shop</a></li>
                    <li class="breadcrumb-item">Cart</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-9 pt-4">
        <div class="container">
            @if (Session::has('success'))
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {!! Session::get('success') !!}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
            @if (Session::has('error'))
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Sorry!</strong> {!! Session::get('error') !!}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <div class="row">
                @if (Cart::count() > 0)
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table" id="cart">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Price</th>
                                        <th>Request Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartContent as $item)
                                        <tr id="cart-item-{{ $item->rowId }}">
                                            <td class="text-start">
                                                <div class="d-flex align-items-center">
                                                    @if (!empty($item->options->productImage->image))
                                                        <img
                                                            src="{{ asset('uploads/product/small/' . $item->options->productImage->image) }}">
                                                    @else
                                                        <img src="{{ asset('admin-assets/img/default-150x150.png') }}">
                                                    @endif
                                                    <h2>{{ $item->name }}</h2>
                                                </div>
                                            </td>
                                            <td>&#2547;{{ $item->price }}</td>

                                            <td><input type="number" id="request-price-{{ $item->rowId }}" name="request_price" data-row-id="{{ $item->rowId }}" value="{{ $item->price }}" class="request-price" style="width: 115px"></td>

                                            <td>
                                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1 sub" data-id="{{ $item->rowId }}"><i class="fa fa-minus"></i></button>
                                                    </div>
                                                    <input type="text" id="qty-{{ $item->rowId }}" class="form-control form-control-sm border-0 text-center" value="{{ $item->qty }}">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1 add" data-id="{{ $item->rowId }}"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span id="product-price-{{ $item->rowId }}">&#2547;{{ $item->price * $item->qty }}</span></td>

                                            <td><button class="btn btn-sm btn-danger delete-item" data-id="{{ $item->rowId }}"><i class="fa fa-times"></i></button></td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card cart-summery">
                            <div class="card-body">
                                <div class="sub-title">
                                    <h2 class="bg-white">Cart Summery</h3>
                                </div>
                                <div class="d-flex justify-content-between pb-2">
                                    <div>Subtotal</div>
                                    <div><span id="subtotal">&#2547;{{ Cart::subtotal() }}</span></div>
                                </div>
                                <div class="pt-3">
                                    <button id="proceed-to-checkout" class="btn-dark btn btn-block w-100">Proceed to Checkout</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body d-flex justify-content-center">
                                <h1>Cart id empty!</h1>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@section('customjs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
        // Increment quantity
        $('.add').click(function() {
            var qtyElement = $(this).parent().prev(); // Quantity input field
            var qtyValue = parseInt(qtyElement.val());

            if (qtyValue < 10) { // Max quantity check
                qtyElement.val(qtyValue + 1);

                var rowId = $(this).data('id');
                var newQty = qtyElement.val();
                var requestPrice = $('#request-price-' + rowId).val(); // Get custom request price
                updateCart(rowId, newQty, requestPrice);
            }
        });

        // Decrement quantity
        $('.sub').click(function() {
            var qtyElement = $(this).parent().next(); // Quantity input field
            var qtyValue = parseInt(qtyElement.val());

            if (qtyValue > 1) { // Min quantity check
                qtyElement.val(qtyValue - 1);

                var rowId = $(this).data('id');
                var newQty = qtyElement.val();
                var requestPrice = $('#request-price-' + rowId).val(); // Get custom request price
                updateCart(rowId, newQty, requestPrice);
            }
        });

        // Handle request price input change
        $('.request-price').on('input', function() {
            var rowId = $(this).data('row-id');
            var newQty = $('#qty-' + rowId).val(); // Get current quantity
            var requestPrice = $(this).val(); // Get updated custom price
            updateCart(rowId, newQty, requestPrice); // Update cart with new request price
        });

        // AJAX function to update cart
        function updateCart(rowId, qty, requestPrice) {
            $.ajax({
                url: "{{ route('front.updateCart') }}",
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}", // CSRF token for security
                    rowId: rowId,
                    qty: qty,
                    request_price: requestPrice
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Update subtotal, total, and individual item price in the DOM
                        $('#subtotal').text(response.subtotal.toFixed(2));
                        $('#total').text(response.total.toFixed(2));
                        $('#product-price-' + rowId).text(response.item_price.toFixed(2));
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText); // Handle errors
                }
            });
        }

        // Delete cart item
        function deleteItem(rowId) {
            if (confirm('Are you sure you want to remove this item?')) {
                $.ajax({
                    url: "{{ route('front.deleteItem.cart') }}",
                    type: 'post',
                    data: {
                        _token: "{{ csrf_token() }}",
                        rowId: rowId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Remove item from DOM and update subtotal/total
                            $('#cart-item-' + rowId).remove(); // Remove row from table
                            $('#subtotal').text(response.subtotal.toFixed(2));
                            $('#total').text(response.total.toFixed(2));

                            if (response.cart_is_empty) {
                                // If cart is empty, display empty cart message
                                $('#cart').html('<h1>Cart is empty!</h1>');
                            }
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
        }

        // Bind delete function to delete button
        $('.delete-item').click(function() {
            var rowId = $(this).data('id');
            deleteItem(rowId); // Call delete function
        });

        // Proceed to checkout
        $('#proceed-to-checkout').click(function(e) {
            e.preventDefault();

            var cartItems = [];
            $('.request-price').each(function() {
                cartItems.push({
                    rowId: $(this).data('row-id'),
                    request_price: $(this).val()
                });
            });

            // Send updated cart items to server before proceeding to checkout
            $.ajax({
                url: "{{ route('front.checkout.update') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    cartItems: cartItems
                },
                success: function(response) {
                    window.location.href = "{{ route('front.checkout') }}"; // Redirect to checkout
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });

    </script>


@endsection
