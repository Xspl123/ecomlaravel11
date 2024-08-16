@extends('layouts.admin')

@section('content')
<style>
    /* General Badge Styling */
    .badge {
        font-size: 0.75rem;
        /* Adjust font size if necessary */
        font-weight: 700;
        /* Make text bold for better visibility */
        padding: 0.25rem 0.4rem;
        border-radius: 0.2rem;
        /* Rounded corners */
    }

    /* Success Badge */
    .badge-success {
        background-color: #28a745;
        /* Bootstrap green color */
        color: #fff;
        /* Ensure text is white */
    }

    /* Warning Badge */
    .badge-warning {
        background-color: #ffc107;
        /* Bootstrap yellow color */
        color: #212529;
        /* Dark text for contrast */
    }

    /* Danger Badge */
    .badge-danger {
        background-color: #dc3545;
        /* Bootstrap red color */
        color: #fff;
        /* Ensure text is white */
    }

    /* Secondary Badge (for unknown statuses) */
    .badge-secondary {
        background-color: #6c757d;
        /* Bootstrap gray color */
        color: #fff;
        /* Ensure text is white */
    }

</style>
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Orders</h3>
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
                    <div class="text-tiny">Orders</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search" action="{{ route('admin.orders') }}" method="GET">
                        <fieldset class="name">
                            <input type="text" placeholder="Search here..." class="" name="name" tabindex="2" value="{{ request('name') }}">
                        </fieldset>
                        <div class="button-submit">
                            <button class="" type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="wg-table table-all-user">
                <div class="table-responsive">
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width:70px">OrderNo</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Subtotal</th>
                                <th class="text-center">Tax</th>
                                <th class="text-center">Total</th>

                                <th class="text-center">Status</th>
                                <th class="text-center">Order Date</th>
                                <th class="text-center">Total Items</th>
                                <th class="text-center">Delivered On</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Order Data Here -->
                            @foreach($orders as $order)
                            <tr>
                                <td class="text-center">{{ $order->id }}</td>
                                <td class="text-center">{{ $order->name }}</td>
                                <td class="text-center">{{ $order->phone }}</td>
                                <td class="text-center">{{ $order->subtotal }}</td>
                                <td class="text-center">{{ $order->tax }}</td>
                                <td class="text-center">{{ $order->total }}</td>
                                <td class="text-center">
                                    @if ($order->status == 'delivered')
                                    <span class="badge badge-success">Delivered</span>
                                    @elseif ($order->status == 'cancelled')
                                    <span class="badge badge-warning">Cancelled</span>
                                    @elseif ($order->status == 'ordered')
                                    <span class="badge badge-danger">Ordered</span>
                                    @else
                                    <span class="badge badge-secondary">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $order->created_at }}</td>
                                <td class="text-center">{{ $order->orderItems->count() }}</td>
                                <td class="text-center">{{ $order->delivered_date }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.order.show',['order_id'=>$order->id]) }}">
                                        <div class="list-icon-function view-icon">
                                            <div class="item eye">
                                                <i class="icon-eye"></i>
                                            </div>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{ $orders->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

@endsection
