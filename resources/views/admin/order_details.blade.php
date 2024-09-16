@extends('layouts.admin')


@section('content')
<style>
    .pt-90 {
    padding-top: 90px !important;
}

.pr-6px {
    padding-right: 6px;
    text-transform: uppercase;
}

.my-account .page-title {
    font-size: 1.5rem;
    font-weight: 700;
    text-transform: uppercase;
    margin-bottom: 40px;
    border-bottom: 1px solid;
    padding-bottom: 13px;
}

.my-account .wg-box {
    display: flex;
    flex-direction: column;
    gap: 24px;
    padding: 24px;
    border-radius: 12px;
    background: var(--White);
    box-shadow: 0px 4px 24px 2px rgba(20, 25, 38, 0.05);
}

.bg-success {
    background-color: #40c710 !important;
}

.bg-danger {
    background-color: #f44032 !important;
}

.bg-warning {
    background-color: #f5d700 !important;
    color: #000;
}

.table-transaction>tbody>tr:nth-of-type(odd) {
    background-color: #fff !important;
}

.table-transaction th,
.table-transaction td {
    padding: 0.625rem 1.5rem 0.25rem !important;
    color: #000 !important;
}

.table> :not(caption)>tr>th {
    padding: 0.625rem 1.5rem 0.25rem !important;
    background-color: #6a6e51 !important;
}

.table-bordered>:not(caption)>*>* {
    border-width: 1px;
    line-height: 32px;
    font-size: 14px;
    border-color: #e1e1e1;
    vertical-align: middle;
}

.table-striped .image {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    flex-shrink: 0;
    border-radius: 10px;
    overflow: hidden;
}

.table-striped td:nth-child(1) {
    min-width: 250px;
    padding-bottom: 7px;
}

.pname {
    display: flex;
    gap: 13px;
}

.table-bordered> :not(caption)>tr>th,
.table-bordered> :not(caption)>tr>td {
    border-width: 1px;
    border-color: #6a6e51;
}

/* General Badge Styling */
.badge {
    font-size: 0.75rem;
    font-weight: 700;
    padding: 0.25rem 0.4rem;
    border-radius: 0.2rem;
}

/* Success Badge */
.badge-success {
    background-color: #28a745;
    color: #fff;
}

/* Warning Badge */
.badge-warning {
    background-color: #ffc107;
    color: #212529;
}

/* Danger Badge */
.badge-danger {
    background-color: #dc3545;
    color: #fff;
}

/* Secondary Badge (for unknown statuses) */
.badge-secondary {
    background-color: #6c757d;
    color: #fff;
}

</style>
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Order Details</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Order Details</div>
                </li>
            </ul>
        </div>


        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <h5>Order</h5>
                </div>
                <a class="tf-button style-1 w208" href="{{ route('admin.orders') }}">Back</a>
            </div>
            <div class="table-responsive">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Order No</th>
                        <td>{{$order->id}}</td>
                        <th>Mobile</th>
                        <td>{{$order->phone}}</td>
                        <th>Zip Code</th>
                        <td>{{$order->zip}}</td>
                    </tr>
                    <tr>
                        <th>Order Date</th>
                        <td>{{$order->created_at}}</td>
                        <th>Delivered Date</th>
                        <td>{{$order->delivered_date}}</td>
                        <th>Canceled Date</th>
                        <td>{{$order->canceled_date}}</td>
                    </tr>
                    <tr>
                        <th>Order Status</th>
                        <td colspan="5">
                            <span class="badge {{ $order->status == 'canceled' ? 'bg-danger' : 'bg-success' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <h5>Ordered Items</h5>
                </div>
            </div>
            <div class="table-responsive">

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">SKU</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Brand</th>
                            <th class="text-center">Options</th>
                            <th class="text-center">Return Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order_items as $item)
                        <tr>
                            <td class="pname">
                                <div class="image">
                                    <img src="{{ asset('uploads/products/thumbnails') }}/{{ $item->product->image }}" alt="{{ $item->product->name }}" class="image">
                                </div>
                                <div class="name">
                                    <a href="{{ route('shop.product_details',['product_slug'=>$item->product->slug]) }}" target="_blank" class="body-title-2">{{ $item->product->name }}</a>
                                </div>
                            </td>
                            <td class="text-center">{{ $item->price }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-center">{{ $item->product->SKU }}</td>
                            <td class="text-center">{{ $item->product->category->name }}</td>
                            <td class="text-center">{{ $item->product->brand->name }}</td>
                            <td class="text-center">{{ $item->options }}</td>
                            <td class="text-center">{{ $item->rstatus == 0 ? "No":"Yes" }}</td>
                            <td class="text-center">
                                <div class="list-icon-function view-icon">
                                    <div class="item eye">
                                        <i class="icon-eye"></i>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{ $order_items->links('pagination::bootstrap-5') }}
            </div>
        </div>

        <div class="wg-box mt-5">
            <h5>Shipping Address</h5>
            <div class="my-account__address-item col-md-6">
                <div class="my-account__address-item__detail">
                    <p>{{ $order->name }}</p>
                    <p>{{ $order->address }}</p>
                    <p>{{ $order->locality }}</p>
                    <p>{{ $order->city }}, {{ $order->country }},</p>
                    <p>{{ $order->landmark }}</p>
                    <p>{{ $order->zip }}</p>
                    <br>
                    <p>Mobile : {{ $order->phone }}</p>
                </div>
            </div>
        </div>

        <div class="wg-box mt-5">
            <h5>Transactions</h5>
            <table class="table table-striped table-bordered table-transaction">
                <tbody>
                    <tr>
                        <th>Subtotal</th>
                        <td>{{ $order->subtotal }}</td>
                        <th>Tax</th>
                        <td>{{ $order->tax }}</td>
                        <th>Discount</th>
                        <td>{{ $order->discount }}</td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td>{{ $order->total }}</td>
                        <th>Payment Mode</th>
                        <td>{{ $transations->mode }}</td>
                        <th>Status</th>
                        <td>
                            @if ($transations->status == 'approved')
                            <span class="badge badge-success" style="color: blueviolet;">Approved</span>
                            @elseif($transations->status == 'declined')
                            <span class="badge badge-danger">Declined</span>
                            @elseif($transations->status == 'refunded')
                            <span class="badge badge-warning">Refunded</span>
                            @else
                            <span style="color: orange;">Pending</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="wg-box mt-5">
            <h5>Update Order Status</h5>
            <form action="{{ route('admin.order_status_update', $order->id)}}" method="post">
                @csrf
                @method('put')
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="select">
                            <select name="order_status" id="order_status" class="form-control">
                                <option value="orderd" {{ $order->status == 'orderd' ? 'selected' : '' }}>Ordered</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary tf button w208">Update Status</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
