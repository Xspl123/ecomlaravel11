@extends('layouts.admin')
@section('content')

<div class="main-content-inner">

    <div class="main-content-wrap">
        <div class="tf-section-2 mb-30">
            <div class="flex gap20 flex-wrap-mobile">
                <div class="w-half">
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Total Orders</div>
                                    <h4>{{ $data->Total}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="fas fa-rupee-sign"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Total Amount</div>
                                    <h4>{{ $data->TotalAmount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Pending Orders</div>
                                    <h4>{{ $data->TotalPending }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wg-chart-default">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="fas fa-rupee-sign"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Pending Orders Amount</div>
                                    <h4>{{ $data->TotalPendingAmount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-half">

                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Delivered Orders</div>
                                    <h4>{{ $data->TotalDelivered }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="fas fa-rupee-sign"></i>
                                    </div>
                                <div>
                                    <div class="body-text mb-2">Delivered Orders Amount</div>
                                    <h4>{{ $data->TotalDeliveredAmount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="wg-chart-default mb-20">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="icon-shopping-bag"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Canceled Orders</div>
                                    <h4>{{ $data->TotalCanceled }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="wg-chart-default">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap14">
                                <div class="image ic-bg">
                                    <i class="fas fa-rupee-sign"></i>
                                </div>
                                <div>
                                    <div class="body-text mb-2">Canceled Orders Amount</div>
                                    <h4>{{ $data->TotalCanceledAmount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between">
                    <h5>Monthly Revenue</h5>
                </div>
                <div class="flex flex-wrap gap40">
                    <div>
                        <div class="mb-2">
                            <div class="block-legend">
                                <div class="dot t1"></div>
                                <div class="text-tiny">Total</div>
                            </div>
                        </div>
                        <div class="flex items-center gap10">
                            <h4>{{ $dataM->TotalAmount }}</h4>
                        </div>
                    </div>
                    <div>
                        <div class="mb-2">
                            <div class="block-legend">
                                <div class="dot t2"></div>
                                <div class="text-tiny">Pending</div>
                            </div>
                        </div>
                        <div class="flex items-center gap10">
                            <h4>{{ $dataM->TotalOrderAmount }}</h4>
                            <div class="box-icon-trending up">
                                <i class="icon-trending-up"></i>
                                <div class="body-title number">0.56%</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="mb-2">
                            <div class="block-legend">
                                <div class="dot t2"></div>
                                <div class="text-tiny">Delivered</div>
                            </div>
                        </div>
                        <div class="flex items-center gap10">
                            <h4>{{ $dataM->TotalDeliveredAmount }}</h4>
                            <div class="box-icon-trending up">
                                <i class="icon-trending-up"></i>
                                <div class="body-title number">0.56%</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="mb-2">
                            <div class="block-legend">
                                <div class="dot t2"></div>
                                <div class="text-tiny">Canceled</div>
                            </div>
                        </div>
                        <div class="flex items-center gap10">
                            <h4>{{ $dataM->TotalCanceledAmount }}</h4>
                            <div class="box-icon-trending up">
                                <i class="icon-trending-up"></i>
                                <div class="body-title number">0.56%</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="line-chart-8"></div>
            </div>


        </div>
        <div class="tf-section mb-30">

            <div class="wg-box">
                <div class="flex items-center justify-between">
                    <h5>Recent orders</h5>
                    <div class="dropdown default">
                        <a class="btn btn-secondary dropdown-toggle" href="#">
                            <span class="view-all">View all</span>
                        </a>
                    </div>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
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
                                    </td>
                                    <td class="text-center">{{ $order->total }}</td>
                                    </td>

                                    <td class="text-center">{{ $order->status }}</td>
                                    <td class="text-center">{{ $order->created_at }}</td>
                                    <td class="text-center">{{ $order->orderItems->count() }}</td>
                                    <td class="text-center">{{ $order->delivered_date }}</td>
                                    <td class="text-center">
                                        <a href="order-details.html">
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
            </div>

        </div>
    </div>

</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@push('scripts')
<script>
    (function($) {

        var tfLineChart = (function() {

            var chartBar = function() {
                console.log("Initializing chart...");

                var options = {
                    series: [{
                            name: 'Total',
                            data: Array.isArray({!! json_encode($dataM->TotalAmount) !!}) ? {!! json_encode($dataM->TotalAmount) !!} : [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                        }, {
                            name: 'Pending',
                            data: Array.isArray({!! json_encode($dataM->TotalOrderAmount) !!}) ? {!! json_encode($dataM->TotalOrderAmount) !!} : [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                        },
                        {
                            name: 'Delivered',
                            data: Array.isArray({!! json_encode($dataM->TotalDeliveredAmount) !!}) ? {!! json_encode($dataM->TotalDeliveredAmount) !!} : [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                        }, {
                            name: 'Canceled',
                            data: Array.isArray({!! json_encode($dataM->TotalCanceledAmount) !!}) ? {!! json_encode($dataM->TotalCanceledAmount) !!} : [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                        }
                    ],
                    chart: {
                        type: 'bar',
                        height: 325,
                        toolbar: {
                            show: false,
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '10px',
                            endingShape: 'rounded'
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    legend: {
                        show: false,
                    },
                    colors: ['#2377FC', '#FFA500', '#078407', '#FF0000'],
                    stroke: {
                        show: false,
                    },
                    xaxis: {
                        labels: {
                            style: {
                                colors: '#212529',
                            }
                        },
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                    },
                    yaxis: {
                        show: false,
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return "₹ " + val.toFixed(2);
                            }
                        }
                    }
                };

                var chart = new ApexCharts(
                    document.querySelector("#line-chart-8"),
                    options
                );

                if ($("#line-chart-8").length > 0) {
                    chart.render();
                } else {
                    console.log("Chart element not found.");
                }
            };

            /* Function ============ */
            return {
                init: function() {},

                load: function() {
                    chartBar();
                },
                resize: function() {}
            };
        })();

        jQuery(document).ready(function() {
            tfLineChart.load();
        });

    })(jQuery);
</script>




