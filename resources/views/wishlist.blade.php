@extends('layouts.app')

@section('content')

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
        <h2 class="page-title">Wishlist</h2>
        <div class="checkout-steps">
            <a href="shop_cart.html" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">01</span>
                <span class="checkout-steps__item-title">
                    <span>Shopping Bag</span>
                    <em>Manage Your Items List</em>
                </span>
            </a>
            <a href="shop_checkout.html" class="checkout-steps__item">
                <span class="checkout-steps__item-number">02</span>
                <span class="checkout-steps__item-title">
                    <span>Shipping and Checkout</span>
                    <em>Checkout Your Items List</em>
                </span>
            </a>
            <a href="shop_order_complete.html" class="checkout-steps__item">
                <span class="checkout-steps__item-number">03</span>
                <span class="checkout-steps__item-title">
                    <span>Confirmation</span>
                    <em>Review And Submit Your Order</em>
                </span>
            </a>
        </div>
        <div class="shopping-cart">
            <div class="cart-table__wrapper">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th></th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Action</th>
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
                                    <h4>{{ $item->name }}</h4>
                                    <ul class="shopping-cart__product-item__options">
                                        <li>Color: Yellow</li>
                                        <li>Size: L</li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <span class="shopping-cart__product-price">${{$item->price}}</span>
                            </td>
                            <td>
                                {{$item->qty}}
                            </td>
                            <td>
                                <div class="row d-flex justify-content-between">
                                    <div class="col-6">
                                        <form action="{{route('wishlist.move.cart',$item->rowId)}}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-warning d-flex align-items-center" style="background: none; border: none; padding: 0;">
                                                <!-- Icon for the button (e.g., cart icon) -->
                                                <svg width="24" height="24" fill="currentColor" class="bi bi-cart" xmlns="http://www.w3.org/2000/svg" style="margin-right: 5px;">
                                                    <path d="M0 1a1 1 0 0 1 1-1h1.276a.5.5 0 0 1 .484.375L2.89 3H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 10H4a.5.5 0 0 1-.485-.379L1.61 2H1a1 1 0 0 1-1-1z" />
                                                    <path d="M16 3.5a.5.5 0 0 1-.5.5H2.275l1.136 4.546a.5.5 0 0 0 .485.379H13a.5.5 0 0 0 .485-.621l-1.5-6A.5.5 0 0 0 11.5 2H4a.5.5 0 0 0-.485.379L2.89 3H1.5a.5.5 0 0 1-.5-.5z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-6">
                                        <form action="{{ route('wishlist.remove', $item->rowId) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="remove-cart" style="background: none; border: none; padding: 0;">
                                                <svg width="16" height="16" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                                    <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="cart-table-footer">

                    <form action="{{ route('wishlist.clear') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-light">Clear Wishlist</button>
                    </form>
                </div>
            </div>
            {{-- <div class="shopping-cart__totals-wrapper">
                <div class="sticky-content">
                    <div class="shopping-cart__totals">
                        <h3>Cart Totals</h3>
                        <table class="cart-totals">
                            <tbody>
                                <tr>
                                    <th>Subtotal</th>
                                    <td>$1300</td>
                                </tr>
                                <tr>
                                    <th>Shipping</th>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input form-check-input_fill" type="checkbox" value="" id="free_shipping">
                                            <label class="form-check-label" for="free_shipping">Free shipping</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input form-check-input_fill" type="checkbox" value="" id="flat_rate">
                                            <label class="form-check-label" for="flat_rate">Flat rate: $49</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input form-check-input_fill" type="checkbox" value="" id="local_pickup">
                                            <label class="form-check-label" for="local_pickup">Local pickup: $8</label>
                                        </div>
                                        <div>Shipping to AL.</div>
                                        <div>
                                            <a href="#" class="menu-link menu-link_us-s">CHANGE ADDRESS</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>VAT</th>
                                    <td>$19</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>$1319</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mobile_fixed-btn_wrapper">
                        <div class="button-wrapper container">
                            <button class="btn btn-primary btn-checkout">PROCEED TO CHECKOUT</button>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </section>
</main>

@endsection
