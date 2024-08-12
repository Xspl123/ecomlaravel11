@extends('layouts.app')

@section('content')

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
        <h2 class="page-title">Cart</h2>
        <div class="checkout-steps">
            <a href="javascript:void(0)" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">01</span>
                <span class="checkout-steps__item-title">
                    <span>Shopping Bag</span>
                    <em>Manage Your Items List</em>
                </span>
            </a>
            <a href="javascript:void(0)" class="checkout-steps__item">
                <span class="checkout-steps__item-number">02</span>
                <span class="checkout-steps__item-title">
                    <span>Shipping and Checkout</span>
                    <em>Checkout Your Items List</em>
                </span>
            </a>
            <a href="javascript:void(0)" class="checkout-steps__item">
                <span class="checkout-steps__item-number">03</span>
                <span class="checkout-steps__item-title">
                    <span>Confirmation</span>
                    <em>Review And Submit Your Order</em>
                </span>
            </a>
        </div>
        <div class="shopping-cart">
            @if ($items->count() > 0)
            <div class="cart-table__wrapper">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th></th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td>
                                <div class="shopping-cart__product-item">
                                    <img loading="lazy" src="{{ asset('uploads/products/thumbnails') }}/{{$item->model->image}}" width="120" height="120" alt="{{$item->name}}" />
                                </div>
                            </td>
                            <td>
                                <div class="shopping-cart__product-item__detail">
                                    <h4>{{$item->name}}</h4>
                                    <ul class="shopping-cart__product-item__options">
                                        <li>Color: Yellow</li>
                                        <li>Size: L</li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <span class="shopping-cart__product-price">₹{{$item->price}}</span>
                            </td>
                            <td>
                                <div class="qty-control position-relative">
                                    <input type="number" name="quantity" value="{{$item->qty}}" min="1" class="qty-control__number text-center">
                                    <form action="{{ route('cart.decrease',  $item->rowId) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="qty-control__reduce">-</button>
                                    </form>

                                    <form action="{{ route('cart.increase',  $item->rowId) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="qty-control__increase">+</button>
                                    </form>

                                </div>
                            </td>
                            <td>
                                <span class="shopping-cart__subtotal">₹{{ $item->subtotal() }}</span>
                            </td>
                            <td>
                                <form action="{{ route('cart.remove',$item->rowId) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="remove-cart" style="background: none; border: none; padding: 0;">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                            <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="cart-table-footer">

                    @if (!Session::has('coupan'))
                    <form action="{{ route('cart.apply_coupon') }}" method="POST" class="position-relative bg-body">
                        @csrf
                        <input class="form-control" type="text" name="coupon_code" placeholder="Coupon Code" value="">
                        <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit" value="APPLY COUPON">
                    </form>
                    @else

                    <form action="{{ route('cart.remove_coupon') }}" method="POST" class="position-relative bg-body">
                        @csrf
                        @method('DELETE')
                        <input class="form-control" type="text" name="coupon_code" placeholder="Coupon Code" value="@if(Session::has('coupan')) {{ Session::get('coupan')['code'] }} Applied! @endif">
                        <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit" value="Remove Coupan">
                    </form>
                    @endif
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-light">Clear CART</button>
                    </form>
                </div>
                <div class="mt-3">
                    @if (Session::has('success'))
                    <p class="alert alert-success">{{ Session::get('success') }}</p>
                    @elseif(Session::has('error'))
                    <p class="alert alert-danger">{{ Session::get('error') }}</p>
                    @endif
                </div>
            </div>
            <div class="shopping-cart__totals-wrapper">
                <div class="sticky-content">
                    <div class="shopping-cart__totals">
                        <h3>Cart Totals</h3>
                        @if (Session::has('discounts'))
                        <table class="cart-totals">
                            <tbody>
                                <tr>
                                    <th>Subtotal</th>
                                    <td>₹{{ Cart::instance('cart')->subtotal() }}</td>
                                </tr>
                                <tr>
                                    <th>Discount {{ Session::get('coupan')['code'] }}</th>
                                    <td>{{ Session::get('discounts')['discount'] }}</td>
                                </tr>

                                <tr>
                                    <th>Subtotal After Discount</th>
                                    <td>₹{{ Session::get('discounts')['subtotal'] }}</td>
                                </tr>
                                <tr>
                                    <th>Shipping</th>
                                    <td>Free</td>
                                </tr>
                                <tr>
                                    <th>VAT</th>
                                    <td>₹{{ Session::get('discounts')['tax'] }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>₹{{ Session::get('discounts')['total'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                        @else
                        <table class="cart-totals">
                            <tbody>
                                <tr>
                                    <th>Subtotal</th>
                                    <td>₹{{ Cart::instance('cart')->subtotal() }}</td>
                                </tr>
                                <tr>
                                    <th>Shipping</th>
                                    <td>Free</td>
                                </tr>
                                <tr>
                                    <th>VAT</th>
                                    <td>₹{{ Cart::instance('cart')->tax() }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>₹{{ Cart::instance('cart')->total() }}</td>
                                </tr>
                            </tbody>
                        </table>
                        @endif
                    </div>
                    <div class="mobile_fixed-btn_wrapper">
                        <div class="button-wrapper container">
                            <a href="{{ route('cart.checkout') }}" class="btn btn-primary btn-checkout">PROCEED TO CHECKOUT</a>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-md-12 text-center pt-5 bp5">
                    <h2 class="h4">Your Shopping Cart Is Empty</h2>
                    <p>There are no items in your shopping cart. You can start adding products by visiting our store.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary">SHOP NOW</a>
                </div>
            </div>
            @endif
        </div>
    </section>
</main>

@endsection
