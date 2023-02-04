
@extends('admin.admin_master')

@section('title')
Easy Inventory | Print Invoice
@endsection

@section('admin')

@php
$subtotal = 0;
@endphp

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Invoice</h4>

                    <div class="page-title-right">

                        <a href="{{ route('invoices.all') }}"><i class="ri-arrow-left-s-line"></i>&nbsp;Back</a>

                        <!--
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active"><a href="{{ route('invoices.all') }}">Back</a></li>
                        </ol>
                        -->
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">
                                <div class="invoice-title">
                                    <h4 class="float-end font-size-16"><strong>Invoice # {{ $invoice->invoice_no }}</strong></h4>
                                    <h3>
                                        <img src="{{ asset('backend/assets/images/easy_logo_sm.png') }}" alt="logo" height="55" />
                                    </h3>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <address>
                                            <strong>Sale Dynamics</strong><br>
                                            Knoxville, TN<br>
                                            support@salesdynamics.com
                                        </address>
                                    </div>
                                    <div class="col-6 text-end">
                                        <address>
                                            <strong>Invoice Date:</strong><br>
                                            {{ date('n/j/y', strtotime($invoice->invoice_date)) }}<br><br>
                                        </address>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-12 mt-2">
                                        <address>
                                            <strong>Billed To:</strong><br>
                                            {{ $payment['customer']['name']}}<br>
                                            {{ $payment['customer']['phone']}}<br>
                                            {{ $payment['customer']['email']}}
                                        </address>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <div class="p-2">
                                        <h3 class="font-size-16"><strong>Customer Invoice Summary</strong></h3>
                                    </div>
                                    <div class="">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <td><strong>Line</strong></td>
                                                        <td><strong>Item</strong></td>
                                                        <td class="text-center"><strong>Unit Price</strong></td>
                                                        <td class="text-center"><strong>Quantity</strong></td>
                                                        <td class="text-end"><strong>Total</strong></td>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach($invoice['invoice_details'] as $k => $val)

                                                    @php
                                                    $subtotal += $val->sales_price;
                                                    @endphp

                                                    <tr>
                                                        <td>{{ $k + 1 }}</td>
                                                        <td>{{ $val['product']['id'] }} - {{ $val['product']['name'] }}</td>
                                                        <td class="text-center">${{ number_format($val->unit_price, 2) }}</td>
                                                        <td class="text-center">{{ $val->sales_qty }}</td>
                                                        <td class="text-end">{{ number_format($val->sales_price, 2) }}</td>
                                                    </tr>

                                                    @endforeach()

                                                    <tr>
                                                        <td class="thick-line" colspan="3"></td>
                                                        <td class="thick-line text-center">
                                                            <strong>Subtotal</strong></td>
                                                        <td class="thick-line text-end">${{ number_format($subtotal, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line" colspan="3"></td>
                                                        <td class="no-line text-center">
                                                            <strong>Discount Amount</strong></td>
                                                        <td class="no-line text-end">${{ number_format($payment->discount_amount, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line" colspan="3"></td>
                                                        <td class="no-line text-center">
                                                            <strong>Invoice Total</strong></td>
                                                        <td class="no-line text-end"><h4 class="m-0">${{ number_format($payment->total_amount, 2) }}</h4></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="d-print-none">
                                            <div class="float-end">
                                                <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-print"></i></a>
                                                <!--<a href="#" class="btn btn-primary waves-effect waves-light ms-2">Download</a>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end row -->
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>

@endsection