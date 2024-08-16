@extends('layouts.app')
@section('content')
<style>
    /* Styling for table headers */
    .table>thead>tr>th {
        padding: 0.625rem 1.5rem 0.625rem !important;
        background-color: #6a6e51 !important;
        color: #fff; /* Ensures text is visible on the dark background */
    }

    /* Styling for table cells */
    .table>tbody>tr>td {
        padding: 0.8rem 1rem !important;
        color: #333; /* Adjust text color for better readability */
    }

    /* Adjusted padding for all table cells including the header */
    .table-bordered>thead>tr>th,
    .table-bordered>tbody>tr>td {
        border-width: 1px 1px;
        border-color: #6a6e51;
    }

    /* Ensure consistent padding across all table cells */
    .table>tbody>tr>td {
        padding: 0.8rem 1rem !important;
    }

    /* Adjust background color for table rows on hover */
    .table-hover>tbody>tr:hover {
        background-color: #f1f1f1;
    }

     /* General Badge Styling */
    .badge {
        font-size: 0.75rem; /* Adjust font size if necessary */
        font-weight: 700; /* Make text bold for better visibility */
        padding: 0.25rem 0.4rem;
        border-radius: 0.2rem; /* Rounded corners */
    }

    /* Success Badge */
    .badge-success {
        background-color: #28a745; /* Bootstrap green color */
        color: #fff; /* Ensure text is white */
    }

    /* Warning Badge */
    .badge-warning {
        background-color: #ffc107; /* Bootstrap yellow color */
        color: #212529; /* Dark text for contrast */
    }

    /* Danger Badge */
    .badge-danger {
        background-color: #dc3545; /* Bootstrap red color */
        color: #fff; /* Ensure text is white */
    }

    /* Secondary Badge (for unknown statuses) */
    .badge-secondary {
        background-color: #6c757d; /* Bootstrap gray color */
        color: #fff; /* Ensure text is white */
    }

    /* Responsive styling for smaller screens */
    @media (max-width: 768px) {
        .table>thead>tr>th,
        .table>tbody>tr>td {
            padding: 0.5rem 1rem !important;
        }
    }

</style>

<div class="mb-4 pb-4"></div>
<section class="my-account container">
    <h2 class="page-title">Orders</h2>
    <div class="row">
        <div class="col-lg-2">
            @include('user.account-nav')
        </div>
        <div class="col-lg-10">
            <div class="wg-table table-all-user">
                <div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th class="text-center">Order No</th>
                <th class="text-center">Name</th>
                <th class="text-center">Phone</th>
                <th class="text-center">Subtotal</th>
                <th class="text-center">Tax</th>
                <th class="text-center">Total</th>
                <th class="text-center">Status</th>
                <th class="text-center">Order Date</th>
                <th class="text-center">Items</th>
                <th class="text-center">Delivered On</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
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
                <td class="text-center">{{ $order->created_at}}</td>
                <td class="text-center">{{ $order->orderItems->count() }}</td>
                <td class="text-center">{{ $order->delivered_date}}</td>
                <td class="text-center">
                    <a href="{{ route('user.order_details',$order->id) }}">
                        <div class="list-icon-function view-icon">
                            <div class="item eye">
                                <i class="fa fa-eye"></i>
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
</section>
</main>
@endsection
