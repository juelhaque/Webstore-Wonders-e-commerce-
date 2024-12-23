@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="#">Shop</a></li>
                <li class="breadcrumb-item">Checkout</li>
            </ol>
        </div>
    </div>
</section>

<section class="section-9 pt-4">
    <div class="container">
        <form action="" method="POST" name="orderForm" id="orderForm">
            <div class="row">
                <div class="col-md-8">
                    <div class="sub-title">
                        <h2>Shipping Address</h2>
                    </div>
                    <div class="card shadow-lg border-0">
                        <div class="card-body checkout-form">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="{{ (!empty($customerAddress)) ? $customerAddress->first_name : '' }}">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="{{ (!empty($customerAddress)) ? $customerAddress->last_name : '' }}">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="{{ (!empty($customerAddress)) ? $customerAddress->email : '' }}">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <select name="country" id="country" class="form-control">
                                            <option value="">Select Area</option>
                                            @if ($countries->isNotEmpty())
                                                @foreach ($countries as $country)
                                                    <option {{ (!empty($customerAddress) && $customerAddress->country_id == $country->id) ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="address" id="address" cols="30" rows="3" placeholder="Address" class="form-control">{{ (!empty($customerAddress)) ? $customerAddress->address : '' }}</textarea>
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="apartment" id="apartment" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)" value="{{ (!empty($customerAddress)) ? $customerAddress->apartment : '' }}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="city" id="city" class="form-control" placeholder="City" value="{{ (!empty($customerAddress)) ? $customerAddress->city : '' }}">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="state" id="state" class="form-control" placeholder="State" value="{{ (!empty($customerAddress)) ? $customerAddress->state : '' }}">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="zip" id="zip" class="form-control" placeholder="Zip" value="{{ (!empty($customerAddress)) ? $customerAddress->zip : '' }}">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile No." value="{{ (!empty($customerAddress)) ? $customerAddress->mobile : '' }}">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="order_notes" id="order_notes" cols="30" rows="2" placeholder="Order Notes (optional)" class="form-control"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="sub-title">
                        <h2>Order Summery</h3>
                    </div>
                    <div class="card cart-summery">
                        <div class="card-body">
                            @foreach (Cart::content() as $item)
                                <div class="d-flex justify-content-between pb-2">
                                    <div class="h6">{{ $item->name }} X {{ $item->qty }}</div>
                                    <div class="h6">&#2547;{{ $item->price*$item->qty }}</div>
                                </div>
                            @endforeach
                            <div class="d-flex justify-content-between summery-end">
                                <div class="h6"><strong>Subtotal</strong></div>
                                <div class="h6"><strong>&#2547;{{ Cart::subtotal() }}</strong></div>
                            </div>
                            <div class="d-flex justify-content-between summery-end">
                                <div class="h6"><strong>Discount</strong></div>
                                <div class="h6"><strong id="discount_value">&#2547;{{ $discount }}</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="h6"><strong>Shipping</strong></div>
                                <div class="h6"><strong id="shippingAmount">&#2547;{{ number_format($totalShippingCharge, 2) }}</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2 summery-end">
                                <div class="h5"><strong>Total</strong></div>
                                <div class="h5"><strong id="grandTotal">&#2547;{{ number_format($grandTotal, 2) }}</strong></div>
                            </div>
                        </div>
                    </div>

                    <div class="input-group apply-coupan mt-4">
                        <input type="text" placeholder="Coupon Code" class="form-control" name="discount_code" id="discount_code">
                        <button class="btn btn-dark" type="button" id="apply_discount">Apply Coupon</button>
                    </div>

                    <div id="discount_response_wrapper">
                        @if (Session::has('code'))
                            <div class="mt-4" id="discount_response">
                                <strong>{{ Session::get('code')->code }}</strong>
                                <a class="btn btn-sm btn-danger" id="remove_discount"><i class="fa fa-times"></i></a>
                            </div>
                        @endif
                    </div>

                    <div class="card payment-form ">
                        <h3 class="card-title h5 mb-3">Payment Method</h3>
                        <div class="from-check mb-2">
                            <input checked type="radio" name="payment_method" value="cod" id="payment_method_one">
                            <label for="payment_method_one" class="from-check-label">Cash On Delivery</label>
                        </div>
                        <div class="from-check">
                            <input type="radio" name="payment_method" value="bkash" id="payment_method_two">
                            <label for="payment_method_two" class="from-check-label"><img src="{{ asset('front-assets/images/BKash-Icon-Logo.wine.png') }}" alt="" style="width: 36px; height: 24px;">bKash</label>
                        </div>

                        <div class="card-body p-0 mt-2 d-none" id="card_payment_form">
                            {{-- <form action=""> --}}
                                <p>Please Pay to: <span style="color: red">01700-000000</span></p>
                                <div class="mb-3">
                                    <label for="account_name" class="mb-2">Account holder name</label>
                                    <input type="text" name="account_name" id="account_name" placeholder="Account holder name" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="account_number" class="mb-2">Account number</label>
                                        <input type="text" name="account_number" id="account_number" class="form-control" style="padding: 4px 4px;">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="trax_id" class="mb-2">Transaction ID</label>
                                        <input type="text" name="trax_id" id="trax_id" class="form-control" style="padding: 4px 4px;">
                                    </div>
                                </div>
                            {{-- </form> --}}
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="btn-dark btn btn-block w-100">Pay Now</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('customjs')
<script>

    $("#payment_method_one").click(function(){
        if ($(this).is(":checked") == true) {
            $("#card_payment_form").addClass('d-none');
        }
    });

    $("#payment_method_two").click(function(){
        if ($(this).is(":checked") == true) {
            $("#card_payment_form").removeClass('d-none');
        }
    });

    $("#orderForm").submit(function(event){
        event.preventDefault();

        $('button[type="submit"]').prop('disabled', true);

        $.ajax({
            url: '{{ route("front.processCheckout") }}',
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(response){

                var errors = response.errors;

                $('button[type="submit"]').prop('disabled', false);

                if (response.status == false) {

                    if (errors.first_name) {
                        $("#first_name").addClass('is-invalid').siblings('p')
                        .addClass('invalid-feedback').html(errors.first_name);
                    }else{
                        $("#first_name").removeClass('is-invalid').siblings('p')
                        .removeClass('invalid-feedback').html('');
                    }

                    if (errors.last_name) {
                        $("#last_name").addClass('is-invalid').siblings('p')
                        .addClass('invalid-feedback').html(errors.last_name);
                    }else{
                        $("#last_name").removeClass('is-invalid').siblings('p')
                        .removeClass('invalid-feedback').html('');
                    }

                    if (errors.email) {
                        $("#email").addClass('is-invalid').siblings('p')
                        .addClass('invalid-feedback').html(errors.email);
                    }else{
                        $("#email").removeClass('is-invalid').siblings('p')
                        .removeClass('invalid-feedback').html('');
                    }

                    if (errors.country) {
                        $("#country").addClass('is-invalid').siblings('p')
                        .addClass('invalid-feedback').html(errors.country);
                    }else{
                        $("#country").removeClass('is-invalid').siblings('p')
                        .removeClass('invalid-feedback').html('');
                    }

                    if (errors.address) {
                        $("#address").addClass('is-invalid').siblings('p')
                        .addClass('invalid-feedback').html(errors.address);
                    }else{
                        $("#address").removeClass('is-invalid').siblings('p')
                        .removeClass('invalid-feedback').html('');
                    }

                    if (errors.city) {
                        $("#city").addClass('is-invalid').siblings('p')
                        .addClass('invalid-feedback').html(errors.city);
                    }else{
                        $("#city").removeClass('is-invalid').siblings('p')
                        .removeClass('invalid-feedback').html('');
                    }

                    if (errors.state) {
                        $("#state").addClass('is-invalid').siblings('p')
                        .addClass('invalid-feedback').html(errors.state);
                    }else{
                        $("#state").removeClass('is-invalid').siblings('p')
                        .removeClass('invalid-feedback').html('');
                    }

                    if (errors.zip) {
                        $("#zip").addClass('is-invalid').siblings('p')
                        .addClass('invalid-feedback').html(errors.zip);
                    }else{
                        $("#zip").removeClass('is-invalid').siblings('p')
                        .removeClass('invalid-feedback').html('');
                    }

                    if (errors.mobile) {
                        $("#mobile").addClass('is-invalid').siblings('p')
                        .addClass('invalid-feedback').html(errors.mobile);
                    }else{
                        $("#mobile").removeClass('is-invalid').siblings('p')
                        .removeClass('invalid-feedback').html('');
                    }

                }else{
                    window.location.href="{{ url('/thanks/') }}/"+response.orderId;
                }
            }
        });
    });

    $("#country").change(function(){
        $.ajax({
            url: '{{ route("front.getOrderSummery") }}',
            type: 'post',
            data: {country_id: $(this).val()},
            dataType: 'json',
            success: function(response){
                if (response.status == true) {
                    $("#shippingAmount").html('$'+response.shippingCharge)
                    $("#grandTotal").html('$'+response.grandTotal)
                }
            }
        });
    });

    $("#apply_discount").click(function(){
        $.ajax({
            url: '{{ route("front.applyDiscount") }}',
            type: 'post',
            data: {code: $("#discount_code").val(), country_id: $("#country").val()},
            dataType: 'json',
            success: function(response){
                if (response.status == true) {
                    $("#shippingAmount").html('$'+response.shippingCharge)
                    $("#grandTotal").html('$'+response.grandTotal)
                    $("#discount_value").html('$'+response.discount)
                    $("#discount_response_wrapper").html(response.discountString)
                }else{
                    $("#discount_response_wrapper").html("<span class='text-danger'>"+response.message+"</span>")
                }
            }
        });
    });

    $('body').on('click', "#remove_discount", function(){
        $.ajax({
            url: '{{ route("front.removeCoupon") }}',
            type: 'post',
            data: {country_id: $("#country").val()},
            dataType: 'json',
            success: function(response){
                if (response.status == true) {
                    $("#shippingAmount").html('$'+response.shippingCharge)
                    $("#grandTotal").html('$'+response.grandTotal)
                    $("#discount_value").html('$'+response.discount)
                    $("#discount_response").html('')
                    $("#discount_code").val('')
                }
            }
        });
    })

</script>
@endsection


