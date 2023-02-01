
@extends('admin.admin_master')

@section('title')
    Easy Inventory | Approve Invoice
@endsection

@section('admin')

@php

    $payment = App\Models\Payment::where('invoice_id', $invoice->invoice_no)->first();


@endphp

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Approve Invoice</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">


                        <a class="btn btn-link btn-rounded waves-effect waves-light float-end" href="{{ route('invoices.pending') }}">
                            <i class="ri-arrow-left-s-line"></i>&nbsp;View Pending Invoices
                        </a>

                        <h4>Invoice #{{ $invoice->invoice_no }} - {{ date('n-j-Y', strtotime($invoice->invoice_date)) }}</h4>

                        <br />
                        <br />

                        <table class="table table-dark" width="100%">
                            <tbody>
                                <tr>
                                    <td><p>Customer Info</p></td>
                                    <td><p>Name: <strong>{{ $payment['customer']['name']}}</strong></p></td>
                                    <td><p>Phone: <strong>{{ $payment['customer']['phone']}}</strong></p></td>
                                    <td><p>Email: <strong>{{ $payment['customer']['email']}}</strong></p></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="3"><p>Comments: <strong>{{ $invoice->comments }}</strong></p></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>
@endsection