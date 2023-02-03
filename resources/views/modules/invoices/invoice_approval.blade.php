
@extends('admin.admin_master')

@section('title')
    Easy Inventory | Approve Invoice
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

                        <h4>Invoice #{{ $invoice->invoice_no }} - {{ date('n/j/y', strtotime($invoice->invoice_date)) }}</h4>

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

                        <form action="{{ route('invoice.approve', $invoice->id) }}" method="post">

                            @csrf

                            <table class="table table-dark" width="100%">
                                <thead>
                                    <tr>
                                        <th class="align-center">Line</th>
                                        <th class="align-center">Category</th>
                                        <th class="align-center">Product</th>
                                        <th class="align-center tableCellHighlightFuscia">Qty In Stock</th>
                                        <th class="align-center">Qty Ordered</th>
                                        <th class="align-center">Unit Price</th>
                                        <th class="align-center">Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($invoice['invoice_details'] as $k => $val)

                                        @php
                                            $subtotal += $val->sales_price
                                        @endphp

                                        <tr>

                                            <input type="hidden" value="{{ $val->category_id }}" name="category_id[]">
                                            <input type="hidden" value="{{ $val->product_id }}" name="product_id[]">
                                            <input type="hidden" value="{{ $val->sales_qty }}" name="sales_qty[{{ $val->id }}]">

                                            <td class="align-center">{{ $k + 1 }}</td>
                                            <td class="align-center">{{ $val['category']['name'] }}</td>
                                            <td class="align-left">{{ $val['product']['id'] }} - {{ $val['product']['name'] }}</td>
                                            <td class="align-center tableCellHighlightFuscia">{{ $val['product']['quantity'] }}</td>
                                            <td class="align-center">{{ $val->sales_qty }}</td>
                                            <td class="align-center">${{ number_format($val->unit_price, 2) }}</td>
                                            <td class="align-center">${{ number_format($val->sales_price, 2) }}</td>
                                        </tr>
                                    @endforeach()

                                    <tr>
                                        <td class="align-right" colspan="6">Subtotal</td>
                                        <td class="align-center">${{ number_format($subtotal, 2) }}</td>
                                    </tr>

                                     <tr>
                                        <td class="align-right" colspan="6">Discount</td>
                                        <td class="align-center">${{ number_format($payment->discount_amount, 2) }}</td>
                                    </tr>

                                    <tr>
                                        <td class="align-right" colspan="6">Paid Amount</td>
                                        <td class="align-center">${{ number_format($payment->payment_amount, 2) }}</td>
                                    </tr>

                                    <tr>
                                        <td class="align-right" colspan="6">Due Amount</td>
                                        <td class="align-center">${{ number_format($payment->due_amount, 2) }}</td>
                                    </tr>

                                    <tr>
                                        <td class="align-right" colspan="6">Total Invoice Amount</td>
                                        <td class="align-center">${{ number_format($payment->total_amount, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <button type="submit" class="btn btn-primary">Approve Invoice {{ $invoice->invoice_no }}</button>
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>
@endsection