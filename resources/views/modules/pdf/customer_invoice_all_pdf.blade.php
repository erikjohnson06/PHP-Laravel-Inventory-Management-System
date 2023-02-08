
@extends('admin.admin_master')

@section('title')
Easy Inventory | {{ $title }}
@endsection

@section('admin')

@php
$inv_total = 0;
@endphp

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ $title }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-6">
                                <div class="invoice-title">
                                    <h3>
                                        <img src="{{ asset('backend/assets/images/easy_logo_sm.png') }}" alt="logo" height="55" />
                                    </h3>
                                </div>
                            </div>
                            <div class="col-6 text-end">
                                <em>{{ $date->format('F j, Y, g:i a') }}</em>
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
                                    <div class="">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-center"><strong>Invoice #</strong></td>
                                                        <td class="text-center"><strong>Customer</strong></td>
                                                        <td class="text-center"><strong>Invoice Date</strong></td>
                                                        <td class="text-center"><strong>Due Amount</strong></td>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach($data as $k => $row)

                                                    @php
                                                    $inv_total += $row->due_amount;
                                                    @endphp

                                                    <tr>
                                                        <td class="text-center">{{ $k + 1 }}</td>
                                                        <td class="text-center">{{ $row['customer']['name'] }}</td>
                                                        <td class="text-center">{{ $row['invoice']['invoice_no'] }}</td>
                                                        <td class="text-center">{{ date('n/j/Y', strtotime($row['invoice']['invoice_date'])) }}</td>
                                                        <td class="text-end">${{ number_format($row->due_amount, 2) }}</td>
                                                    </tr>

                                                    @endforeach()

                                                    <tr>
                                                        <td class="thick-line" colspan="3"></td>
                                                        <td class="thick-line text-center">
                                                            <strong>Due Amount Total</strong></td>
                                                        <td class="no-line text-end"><h4 class="m-0">${{ number_format($inv_total, 2) }}</h4></td>
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