@extends('admin.admin_master')

@section('title')
Easy Inventory | New Invoice
@endsection

@section('css')
    <link href="{{ asset('backend/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
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
                                <a class="waves-effect waves-light float-end" href="{{ route('purchaseorders.all') }}">
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
                                    <label for="addPurchaseOrderRow" class="form-label" style="margin-top: 40px;"></label>

                                    <button type="button" class="btn btn-link btn-rounded waves-effect waves-light" id="addPurchaseOrderRow">
                                        <i class="fa fa-plus-circle"></i>&nbsp;Add Item
                                    </button>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">

                        <form method="post" action="{{ route('store.purchaseorder') }}" id="purchaseOrderAddForm">
                            @csrf

                            <table class="table-sm table-bordered" width="100%" style="border-color: #ddd;">

                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Unit Price</th>
                                        <!--<th>Purchase Price</th>-->
                                        <th>Description</th>
                                        <th>Total Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr id="totalRow">
                                        <td colspan="5"></td>
                                        <td>
                                            <input
                                                type="text"
                                                name="purchaseOrderTotal"
                                                id="purchaseOrderTotal"
                                                value="0"
                                                class="form-control purchaseOrderTotal"
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

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>

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
<script src="{{ asset('backend/assets/libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/pages/form-advanced.init.js') }}"></script>

<script type="text/javascript">

    $(document).ready(function(){

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


        $(document).on("click", "button#addPurchaseOrderRow", function(){

            console.log("Adding row..");

            var po_date = $("#po_date").val();
            var po_number = $("#po_number").val();
            var supplier_id = $("#supplier_id").val();
            var category_id = $("#category_id").val();
            var category_name = $("#category_id").find("option:selected").text();
            var product_id = $("#product_id").val();
            var product_name = $("#product_id").find("option:selected").text();
            var vars = {globalPosition: "top right", className: "error"};
            var source, template, data, html;

            if (!po_date){
                $.notify("PO Date is required", vars);
                return false;
            }

            if (!po_number){
                $.notify("PO Number is required", vars);
                return false;
            }

            if (!supplier_id){
                $.notify("Supplier is required", vars);
                return false;
            }

            if (!category_id){
                $.notify("Category is required", vars);
                return false;
            }

            if (!product_id){
                $.notify("Product is required", vars);
                return false;
            }

            source = $("script#document-template").html();
            template = Handlebars.compile(source);
            data = {
                po_date: po_date,
                po_number: po_number,
                supplier_id: supplier_id,
                category_id: category_id,
                category_name: category_name,
                product_id: product_id,
                product_name: product_name
            };
            html = template(data);
            $("form#purchaseOrderAddForm table tbody").prepend(html);
        });

        $(document).on("click", "form#purchaseOrderAddForm table tbody tr i.removePurchaseOrderLine", function(){
            $(this).closest("tr.PurchaseOrderLine").remove();
            calculateTotalPurchaseOrderAmount();
        });

        //Calculate line total
        $(document).on("keyup click", "form#purchaseOrderAddForm table tbody tr input.purchase_qty, form#purchaseOrderAddForm table tbody tr input.unit_price", function(){

// parseFloat(unitPrice.replace(/,/g, "")).toFixed(2)
            var unitPrice = $(this).closest("tr").find("input.unit_price").val();
            var qty = $(this).closest("tr").find("input.purchase_qty").val();
            var lineTotal = parseFloat(unitPrice.replace(/,/g, "")) * parseFloat(qty.replace(/,/g, ""));

            $(this).closest("tr").find("input.purchase_price").val(lineTotal.toFixed(2));
            calculateTotalPurchaseOrderAmount();
        });

        function calculateTotalPurchaseOrderAmount(){

            var total = 0;

            $("form#purchaseOrderAddForm table tbody tr input.purchase_price").each(function(){

                var val = $(this).val();
                if (!isNaN(val) && val.length != 0){
                    total += parseFloat(val.replace(/,/g, ""));
                }
            });

            $("input#purchaseOrderTotal").val(total.toFixed(2));
        };
    });

</script>

<script id="document-template" type="text/x-handlebars-template">

    <tr class="PurchaseOrderLine">
        <input type="hidden" name="po_date[]" value="@{{po_date}}" />
        <input type="hidden" name="po_number[]" value="@{{po_number}}" />
        <input type="hidden" name="supplier_id[]" value="@{{supplier_id}}" />

        <td>
            <input type="hidden" name="category_id[]" value="@{{category_id}}" />
            @{{ category_name }}
        </td>

        <td>
            <input type="hidden" name="product_id[]" value="@{{product_id}}" />
            @{{ product_name }}
        </td>

        <td>
            <input type="number" min="1" class="form-control purchase_qty text-right" name="purchase_qty[]" value="" />
        </td>

        <td>
            <input type="number" class="form-control unit_price text-right" name="unit_price[]" value="" />
        </td>

        <td>
            <input type="text" class="form-control" name="po_description[]" value="" />
        </td>

        <td>
            <input type="number" class="form-control purchase_price text-right" name="purchase_price[]" value="0" readonly />
        </td>

        <td>
            <i class="btn btn-link fas fa-window-close removePurchaseOrderLine"></i>
        </td>
    </tr>
</script>
@endsection

