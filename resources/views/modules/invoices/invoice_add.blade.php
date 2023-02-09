@extends('admin.admin_master')

@section('title')
Easy Inventory | New Invoice
@endsection

@section('css')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">

                        <div class="row mb-3">

                            <div class="col-sm-10">
                                <h4 class="card-title">New Invoice</h4>
                            </div>
                            <div class="col-sm-2">
                                <a class="waves-effect waves-light float-end" href="{{ route('invoices.all') }}">
                                    <i class="ri-arrow-left-s-line "></i>&nbsp;Back
                                </a>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-1">
                                <div class="mb-3">
                                    <label for="invoice_no" class="form-label">Invoice #</label>
                                    <input class="form-control readonly" type="text" name="invoice_no" value="{{ $invoice_id }}" id="invoice_no" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="invoice_date" class="form-label">Date</label>
                                    <input class="form-control" type="date" name="invoice_date" value="{{ $curr_date }}" id="invoice_date">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select id="category_id" name="category_id" class="form-select select2" aria-label="Category">
                                        <option value="">---</option>

                                        @foreach($categories as $option)
                                        <option value="{{ $option->id }}">{{ $option->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="product_id" class="form-label">Product</label>
                                    <select id="product_id" name="product_id" class="form-select select2" aria-label="Product">
                                        <option value="">---</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="mb-3">
                                    <label for="current_stock_qty" class="form-label">Qty</label>
                                    <input class="form-control readonly" type="text" value="0" id="current_stock_qty" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="addInvoiceDetailRow" class="form-label" style="margin-top: 40px;"></label>

                                    <button type="button" class="btn btn-link btn-rounded waves-effect waves-light" id="addInvoiceDetailRow">
                                        <i class="fa fa-plus-circle"></i>&nbsp;Add Item
                                    </button>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">

                        <form method="post" action="{{ route('store.invoice') }}" id="invoiceAddForm">
                            @csrf

                            <table class="table-sm table-bordered" width="100%" style="border-color: #ddd;">

                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Product</th>
                                        <th width="7%">Qty</th>
                                        <th width="10%">Unit Price</th>
                                        <th width="15%">Total Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <tr>
                                        <td colspan="4">Discount</td>
                                        <td>
                                            <input
                                                type="text"
                                                name="invoiceDiscountAmount"
                                                id="invoiceDiscountAmount"
                                                value=""
                                                placeholder="0.00"
                                                class="form-control invoiceDiscountAmount"
                                                />
                                        </td>

                                    </tr>
                                    <tr id="totalRow">
                                        <td colspan="4">Invoice Total</td>
                                        <td>
                                            <input
                                                type="text"
                                                name="invoiceTotal"
                                                id="invoiceTotal"
                                                value="0"
                                                class="form-control invoiceTotal"
                                                readonly
                                                style="background-color: #ddd;"
                                                />
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <br />

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <textarea name="comments" class="form-control" id="comments" placeholder="Comments"></textarea>
                                </div>
                            </div>

                            <br />

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

                                <div class="form-group col-md-9">

                                    <label>Customer</label>
                                    <select name="customer_id" id="customer_id" class="form-select">
                                        <option value="">---</option>
                                        @foreach($customers as $option)
                                        <option value="{{ $option->id }}">{{ $option->id }} - {{ $option->name }}</option>
                                        @endforeach
                                        <option value="0"> [+] Add New Customer</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Add Customer Form -->
                            <div class="row addNewCustomer mt-4 hide">
                                <div class="form-group col-md-4">
                                    <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="New Customer Name" />
                                </div>

                                <div class="form-group col-md-4">
                                    <input type="text" name="customer_phone" id="customer_phone" class="form-control" placeholder="Phone Number" />
                                </div>

                                <div class="form-group col-md-4">
                                    <input type="text" name="customer_email" id="customer_email" class="form-control" placeholder="Email Address" />
                                </div>
                            </div>
                            <br />

                            <div class="form-group">
                                <button type="button" id="submitInvoice" class="btn btn-primary waves-effect waves-light">Save</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
</div>

@endsection

@section('javascript')

<!-- Select 2 -->
<script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>

<script type="text/javascript">

$(document).ready(function () {

    $(document).on("change", "select#category_id", function () {

        var categoryId = $(this).val();
        var productSelect = $("select#product_id");
        var currentStockQty = $("input#current_stock_qty");
        var html;

        productSelect.val("");
        currentStockQty.val("0"); //Reset value

        $.ajax({
            url: "{{ route('get-products-by-category') }}",
            type: "GET",
            data: {category_id: categoryId},
            success: function (data) {

                console.log(data);

                if (!data || !data.length) {
                    html = "<option value=''>No Products Available</option>";
                    productSelect.html(html);
                    return;
                }

                html = "<option value=''>Select Product</option>";

                $.each(data, function (key, val) {
                    html += "<option value='" + val.id + "'>" + val.name + "</option>";
                });

                productSelect.html(html);
            }
        });
    });

    $(document).on("change", "select#product_id", function () {

        var productId = $(this).val();
        var currentStockQty = $("input#current_stock_qty");
        var html;

        currentStockQty.val("0"); //Reset value

        $.ajax({
            url: "{{ route('get-product-available-qty') }}",
            type: "GET",
            data: {product_id: productId},
            success: function (data) {

                console.log(data);

                if (typeof (data) === "undefined") {
                    console.error("Unable to fetch product qty");
                    return;
                }

                currentStockQty.val(data);
            }
        });
    });


    $(document).on("click", "button#addInvoiceDetailRow", function () {

        var invoice_date = $("#invoice_date").val();
        var invoice_no = $("#invoice_no").val();
        var category_id = $("#category_id").val();
        var category_name = $("#category_id").find("option:selected").text();
        var product_id = $("#product_id").val();
        var product_name = $("#product_id").find("option:selected").text();
        var vars = {globalPosition: "top right", className: "error"};
        var source, template, data, html;

        if (!invoice_date) {
            $.notify("PO Date is required", vars);
            return false;
        }

        if (!invoice_no) {
            $.notify("PO Number is required", vars);
            return false;
        }

        if (!category_id) {
            $.notify("Category is required", vars);
            return false;
        }

        if (!product_id) {
            $.notify("Product is required", vars);
            return false;
        }

        source = $("script#document-template").html();
        template = Handlebars.compile(source);
        data = {
            invoice_date: invoice_date,
            invoice_no: invoice_no,
            category_id: category_id,
            category_name: category_name,
            product_id: product_id,
            product_name: product_name
        };
        html = template(data);
        $("form#invoiceAddForm table tbody").prepend(html);
    });

    $(document).on("click", "form#invoiceAddForm table tbody tr i.removeInvoiceDetailLine", function () {
        $(this).closest("tr.invoiceDetailLine").remove();
        calculateTotalPurchaseOrderAmount();
    });

    //Calculate line total
    $(document).on("keyup click", "form#invoiceAddForm table tbody tr input.sales_qty, form#invoiceAddForm table tbody tr input.unit_price", function () {

        var unitPrice = $(this).closest("tr").find("input.unit_price").val();
        var qty = $(this).closest("tr").find("input.sales_qty").val();
        var lineTotal = parseFloat(unitPrice.replace(/,/g, "")) * parseFloat(qty.replace(/,/g, ""));

        $(this).closest("tr").find("input.sales_price").val(lineTotal.toFixed(2));
        $("input#invoiceDiscountAmount").trigger("keyup");
    });

    $(document).on("keyup", "form#invoiceAddForm table tbody tr input#invoiceDiscountAmount", function () {

        calculateTotalPurchaseOrderAmount();
    });

    function calculateTotalPurchaseOrderAmount() {

        var total = 0;
        var discount = $("input#invoiceDiscountAmount").val();

        $("form#invoiceAddForm table tbody tr input.sales_price").each(function () {

            var val = $(this).val();
            if (!isNaN(val) && val.length != 0) {
                total += parseFloat(val.replace(/,/g, ""));
            }
        });

        if (!isNaN(discount) && discount.length != 0) {
            total -= parseFloat(discount.replace(/,/g, ""));
        }

        $("input#invoiceTotal").val(total.toFixed(2));
    };

    $(document).on("change", "select#payment_status", function () {

        var payment_status = $(this).val();

        if (payment_status == "3") { //Partial payment - show amount field
            $("form#invoiceAddForm input#payment_amount").show();
        } else {
            $("form#invoiceAddForm input#payment_amount").hide().val("");
        }
    });

    $(document).on("change", "select#customer_id", function () {

        var id = $(this).val();

        if (id == "0") { //Partial payment - show amount field
            $("form#invoiceAddForm div.addNewCustomer").show();
        } else {
            $("form#invoiceAddForm div.addNewCustomer").hide();
        }
    });

    $("form#invoiceAddForm button#submitInvoice").on("click", function (e) {

        e.preventDefault();

        var form = $("form#invoiceAddForm");
        var invoiceTotal = form.find("input#invoiceTotal").val();
        var invoiceDiscount = form.find("input#invoiceDiscountAmount").val();
        var paymentStatus = form.find("select#payment_status").val();
        var paymentAmount = form.find("input#payment_amount").val();
        var customerId = form.find("select#customer_id").val();
        var newCustomerName = form.find("div.addNewCustomer input#customer_name").val();
        var newCustomerPhone = form.find("div.addNewCustomer input#customer_phone").val();
        var newCustomerEmail = form.find("div.addNewCustomer input#customer_email").val();
        var invoiceDetailLines = form.find("table tbody tr.invoiceDetailLine");
        var sales_qty, unit_price, sales_price;

        console.log(invoiceTotal, paymentStatus, paymentAmount, invoiceDetailLines, customerId);

        try {

            if (!invoiceDetailLines || !invoiceDetailLines.length) {
                throw "No items have been added to the Invoice";
            } else {

                invoiceDetailLines.each(function () {

                    sales_qty = form.find("input.sales_qty").val();
                    unit_price = form.find("input.unit_price").val();
                    sales_price = form.find("input.sales_price").val();

                    if (isNaN(sales_qty) || parseFloat(sales_qty) < 0) {
                        throw "Sales Quantity value is not valid";
                    }

                    if (isNaN(unit_price) || parseFloat(sales_qty) < 0) {
                        throw "Unit Price value is not valid";
                    }

                    if (isNaN(sales_price) || parseFloat(sales_qty) < 0) {
                        throw "Sales Price value is not valid";
                    }
                });
            }

            if (isNaN(invoiceDiscount) || parseFloat(invoiceDiscount) > parseFloat(invoiceTotal)) {
                throw "Discount Amount cannot exceed the Invoice total";
            }

            if (parseFloat(invoiceTotal) < 0) {
                throw "Invoice amount cannot be negative";
            }

            if (paymentAmount && parseFloat(paymentAmount) > parseFloat(invoiceTotal)) {
                throw "Paid Amount cannot exceed the Invoice total";
            }

            if (customerId === "") {
                throw "Please select a Customer";
            } else if (parseInt(customerId) === 0) { //New customer

                if (!newCustomerName || !newCustomerPhone || !newCustomerEmail) {
                    throw "New customer info is not complete";
                }
            }
        } catch (e) {
            $.notify(e, {globalPosition: "top right", className: "error"});
            return;
        }

        form.submit();
    });
});

</script>

<script id="document-template" type="text/x-handlebars-template">

    <tr class="invoiceDetailLine">
    <input type="hidden" name="invoice_date" value="@{{invoice_date}}" />
    <input type="hidden" name="invoice_no" value="@{{invoice_no}}" />

    <td>
    <input type="hidden" name="category_id[]" value="@{{category_id}}" />
    @{{ category_name }}
    </td>

    <td>
    <input type="hidden" name="product_id[]" value="@{{product_id}}" />
    @{{ product_name }}
    </td>

    <td>
    <input type="number" min="1" class="form-control sales_qty text-right" name="sales_qty[]" value="" />
    </td>

    <td>
    <input type="number" class="form-control unit_price text-right" name="unit_price[]" value="" />
    </td>

    <td>
    <input type="number" class="form-control sales_price text-right" name="sales_price[]" value="0" readonly />
    </td>

    <td>
    <i class="btn btn-link fas fa-window-close removeInvoiceDetailLine"></i>
    </td>
    </tr>
</script>
@endsection

