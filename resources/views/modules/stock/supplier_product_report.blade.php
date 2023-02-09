
@extends('admin.admin_master')

@section('title')
Easy Inventory | Supplier Product Report
@endsection

@section('css')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Supplier Product Report</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <label for="supplier">Supplier Report</label>
                                <input type="radio" name="supplier_product_report" value="supplier" id="supplier" class="toggle_report_mode" />
                                &nbsp;&nbsp;
                                <label for="product">Product Report</label>
                                <input type="radio" name="supplier_product_report" value="product" id="product" class="toggle_report_mode" />
                            </div>
                        </div>


                        <div class="supplier_selection hide">
                            <form method="GET" action="{{ route('supplier.report.pdf') }}" target="_blank" class="form-inline" id="selectBySupplier">

                                <div class="row">
                                    <div class="col-sm-8 form-group">
                                        <label for="supplier_id" class="col-sm-2 form-label">Supplier</label>
                                        <div class="col-sm-10">
                                            <select name="supplier_id" class="form-select select2" aria-label="Supplier">

                                                <option value="">---</option>
                                                @foreach($suppliers as $option)
                                                <option value="{{ $option->id }}">{{ $option->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4" style="padding-top: 30px;">
                                        <button class="btn btn-primary" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <div class="product_selection hide">
                            <form method="GET" action="{{ route('product.report.pdf') }}" target="_blank" class="form-inline" id="selectByProduct">

                                <div class="row">
                                    <div class="col-md-4">
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

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="product_id" class="form-label">Product</label>
                                            <select id="product_id" name="product_id" class="form-select select2" aria-label="Product">
                                                <option value="">---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4" style="padding-top: 30px;">
                                        <button class="btn btn-primary" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>
@endsection

@section('javascript')

<!-- Select 2 -->
<script type="text/javascript" src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>

<script type="text/javascript">

$(document).ready(function () {

    $("form#selectBySupplier").validate({
        rules: {
            supplier_id: {required: true}

        },
        messages: {
            supplier_id: {
                required: "Please Select a Supplier"
            }
        },
        errorElement: "span",
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            element.closest(".form-group").append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass("is-invalid");
        }
    });

    $(document).on("change", "input.toggle_report_mode", function () {

        var id = $(this).val();

        var supplier_div = $("div.supplier_selection");
        var product_div = $("div.product_selection");

        if (id == "supplier") {
            product_div.addClass("hide");
            supplier_div.removeClass("hide");
        } else {
            supplier_div.addClass("hide");
            product_div.removeClass("hide");
        }
    });

    $(document).on("change", "select#category_id", function () {

        var categoryId = $(this).val();
        var productSelect = $("select#product_id");
        var html;

        productSelect.val("");

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

    $("div.supplier_selection").find("span.select2.select2-container").css({width: "100%"}); //Select collapse when hidden. Expand to full width
    $("div.product_selection").find("span.select2.select2-container").css({width: "100%"});
    $("input.toggle_report_mode").prop("checked", false); //Uncheck both selections
});

</script>

@endsection
