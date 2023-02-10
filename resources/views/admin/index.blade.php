@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Dashboard</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Easy Inventory</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Trailing Monthly Sales</p>
                                <h4 class="mb-2">${{ number_format($trailingSales, 2) }}</h4>
                                <p class="text-muted mb-0">
                                    <a href="{{ route('invoices.daily.report') }}" title="View Daily Report">
                                        Daily Report&nbsp;<i class="ri-arrow-right-s-line"></i>
                                    </a>
                                </p>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="ri-shopping-cart-2-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Pending Purchase Orders</p>
                                <h4 class="mb-2">{{ $pendingPOs }}</h4>
                                <p class="text-muted mb-0">
                                    <a href="{{ route('purchaseorder.approval') }}" title="View All Pending Purchase Orders">
                                        View All&nbsp;<i class="ri-arrow-right-s-line"></i>
                                    </a>
                                </p>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <i class="mdi mdi-currency-usd font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Sales this Quarter ({{ $currentQtr }})</p>
                                <h4 class="mb-2">${{ number_format($quarterlySales, 2) }}</h4>
                                <p class="text-muted mb-0">
                                    <a href="{{ route('invoices.all') }}" title="View All Transactions">
                                        View All Transactions&nbsp;<i class="ri-arrow-right-s-line"></i>
                                    </a>
                                </p>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="mdi mdi-chart-areaspline font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Current Inventory Value</p>
                                <h4 class="mb-2">${{ number_format($currentInventoryValue, 2) }}</h4>
                                <p class="text-muted mb-0">
                                    <a href="{{ route('stock.status.report') }}" title="View Stock Status">
                                        View Stock Status&nbsp;<i class="ri-arrow-right-s-line"></i>
                                    </a>
                                </p>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <i class="mdi mdi-chart-bar font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="float-end">
                            <a href="{{ route('invoices.all') }}" class="btn btn-link ">
                                View All <i class="mdi mdi-dots-vertical"></i>
                            </a>
                        </div>

                        <h4 class="card-title mb-4">Latest Transactions</h4>

                        <div class="table-responsive">
                            <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th>Invoice #</th>
                                        <th>Customer</th>
                                        <th>Invoice Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>


                                    @if (count($latestInvoices) > 0)

                                    @foreach($latestInvoices as $row)

                                    @php

                                    $status_class = "";

                                    switch($row->status_id){

                                    case 0:
                                    $status_class = "text-warning";
                                    break;

                                    case 1:
                                    $status_class = "text-success";
                                    break;
                                    }

                                    @endphp

                                    <tr>
                                        <td class="align-center">{{ $row->invoice_no }}</td>
                                        <td class="align-left">{{ $row['payment']['customer']['id'] }} - {{ $row['payment']['customer']['name'] }}</td>
                                        <td class="align-center">{{ date('n/j/Y', strtotime($row->invoice_date)) }}</td>
                                        <td class="align-center">
                                            <div class="font-size-13">
                                                <i class="ri-checkbox-blank-circle-fill font-size-10 {{ $status_class }} align-middle me-2"></i>
                                                {{ $row['status']['status'] }}
                                            </div>
                                        </td>
                                        <td class="align-center">${{ number_format($row['payment']['total_amount'], 2) }}</td>
                                    </tr>

                                    @endforeach

                                    @else

                                    @endif

                                    <!-- end -->
                                    <!-- end -->
                                </tbody><!-- end tbody -->
                            </table> <!-- end table -->
                        </div>
                    </div><!-- end card -->
                </div><!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>

</div>
<!-- End Page-content -->

@endsection