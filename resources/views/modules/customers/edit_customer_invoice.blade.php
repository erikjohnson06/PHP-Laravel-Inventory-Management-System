
@extends('admin.admin_master')

@section('title')
Easy Inventory | Edit Customer Invoice
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
                    <h4 class="mb-sm-0">Customer Invoice</h4>

                    <div class="page-title-right">

                        <a href="{{ route('customers.credit') }}"><i class="ri-arrow-left-s-line"></i>&nbsp;Back</a>

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
                            <div class="col-6">
                                <h3 class="font-size-16">Invoice #{{ $payment['invoice']['invoice_no'] }}</h3>
                            </div>
                            <div class="col-6 text-end">
                                <h3 class="font-size-16">Invoice Date:
                                    {{ date('n/j/y', strtotime($payment['invoice']['invoice_date'])) }}
                                </h3>
                            </div>
                        </div>

                        <hr />

                        <div class="row">
                            <div class="col-12">
                                <address>
                                    <strong>Customer: </strong><br>
                                    {{ $payment['customer']['name']}}<br>
                                    {{ $payment['customer']['phone']}}<br>
                                    {{ $payment['customer']['email']}}
                                </address>
                            </div>
                        </div>

                        <hr />

                        <div class="row">
                            <div class="col-12">

                                <form method="post" action="{{ route('customer.update.invoice', $payment->invoice_id) }}" id="invoiceUpdateForm">
                                    @csrf


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


                                                        @foreach($inv_details as $k => $val)


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
                                                                <strong>Paid Amount</strong></td>
                                                            <td class="no-line text-end">${{ number_format($payment->payment_amount, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="no-line" colspan="3"></td>
                                                            <td class="no-line text-center">
                                                                <strong>Due Amount</strong></td>
                                                            <td class="no-line text-end">${{ number_format($payment->due_amount, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="no-line" colspan="3"></td>
                                                            <td class="no-line text-center">
                                                                <strong>Total</strong></td>
                                                            <td class="no-line text-end"><h4 class="m-0">${{ number_format($payment->total_amount, 2) }}</h4></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>


                                            <div class="row">

                                                <div class="form-group col-md-3">

                                                    <label>Payment Status</label>
                                                    <select name="payment_status" id="payment_status" class="form-select">
                                                        <option value="">---</option>
                                                        @foreach($payment_statuses as $option)
                                                        <option value="{{ $option->id }}">{{ $option->status }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input
                                                        type="text"
                                                        name="payment_amount"
                                                        id="payment_amount"
                                                        class="form-control payment_amount hide"
                                                        placeholder="Payment Amount $"
                                                        />
                                                </div>
                                                <div class="form-group col-md-3">

                                                    <label for="payment_date" class="form-label">Date</label>
                                                    <input class="form-control"
                                                           type="date"
                                                           name="payment_date"
                                                           value="{{ $curr_date }}"
                                                           id="payment_date"
                                                           placeholder="MM/DD/YYYY"
                                                           />
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <div class="md-3" style="padding-top: 30px;">
                                                        <button type="submit" class="btn btn-primary">Update Invoice</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- end row -->
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>

@endsection

@section('javascript')

<script type="text/javascript">

    $(document).ready(function () {

        $(document).on("change", "select#payment_status", function () {

            var payment_status = $(this).val();

            if (payment_status == "3") { //Partial payment - show amount field
                $("form#invoiceUpdateForm input#payment_amount").show();
            } else {
                $("form#invoiceUpdateForm input#payment_amount").hide().val("");
            }
        });
    });
</script>
@endsection