
@extends('admin.admin_master')

@section('title')
Easy Inventory | Daily Purchase Order Report
@endsection

@section('admin')

@php
$total = 0;
@endphp

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Daily Purchase Order Report</h4>
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
                                    <h3>
                                        <img src="{{ asset('assets/images/easy_logo_sm.png') }}" alt="logo" height="55" />
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <address>
                                    <strong>Sale Dynamics</strong><br>
                                    Knoxville, TN<br>
                                    support@salesdynamics.com
                                </address>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <div class="p-2">
                                        <h3 class="font-size-16">
                                            <strong>Report Summary
                                                <span class="btn btn-primary">{{ $start_date->format('m-d-Y') }}</span>
                                                -
                                                <span class="btn btn-primary">{{ $end_date->format('m-d-Y') }}</span>
                                            </strong>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end row -->

                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <div class="">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-center"><strong>PO #</strong></td>
                                                        <td class="text-center"><strong>PO Date</strong></td>
                                                        <td class="text-center"><strong>Product</strong></td>
                                                        <td class="text-center"><strong>Qty</strong></td>
                                                        <td class="text-center"><strong>Unit Price</strong></td>
                                                        <td class="text-end"><strong>Total Price</strong></td>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @if (count($data) > 0)

                                                    @foreach($data as $k => $row)

                                                    @php
                                                    $total += $row->purchase_price;
                                                    @endphp

                                                    <tr>
                                                        <td class="text-center">{{ $k + 1 }}</td>
                                                        <td class="text-center">{{ $row->po_number }}</td>
                                                        <td class="text-center">{{      date('m/d/Y', strtotime($row->po_date)) }}</td>
                                                        <td>{{ $row['product']['id'] }} - {{ $row['product']['name'] }}</td>
                                                        <td class="text-center">{{ $row->purchase_qty }} ({{ $row['product']['unit']['name'] }})</td>
                                                        <td class="text-center">{{ number_format($row->unit_price, 2) }}</td>
                                                        <td class="text-end">{{ number_format($row->purchase_price, 2) }}</td>
                                                    </tr>

                                                    @endforeach()

                                                    @else
                                                        <tr><td class="text-center">No Results</td></tr>
                                                    @endif

                                                    <tr>
                                                        <td class="thick-line" colspan="5"></td>
                                                        <td class="thick-line text-center">
                                                            <strong>Invoice Total</strong></td>
                                                        <td class="no-line text-end"><h4 class="m-0">${{ number_format($total, 2) }}</h4></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="d-print-none">
                                            <div class="float-end">
                                                <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-print"></i></a>
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