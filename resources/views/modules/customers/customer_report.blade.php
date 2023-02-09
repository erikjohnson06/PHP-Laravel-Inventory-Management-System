
@extends('admin.admin_master')

@section('title')
Easy Inventory | Customer Report
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
                    <h4 class="mb-sm-0">Customer Report</h4>
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
                                <label for="customer">Customer Payment Due Report</label>
                                <input type="radio" name="customer_report" value="customer_credit" id="customer_credit" class="toggle_report_mode" />
                                &nbsp;&nbsp;
                                <label for="product">Customer Zero-Balance Report</label>
                                <input type="radio" name="customer_report" value="customer_paid" id="customer_paid" class="toggle_report_mode" />
                            </div>
                        </div>

                        <div class="customer_credit_selection hide">
                            <form method="GET" action="{{ route('customer.report.pdf') }}" target="_blank" class="form-inline" id="selectByCreditCustomer">

                                <div class="row">
                                    <div class="col-sm-8 form-group">
                                        <label for="customer_id" class="col-sm-2 form-label">Customer</label>
                                        <div class="col-sm-10">
                                            <select name="customer_id" class="form-select select2" aria-label="Customer">

                                                <option value="">---</option>
                                                @foreach($data as $option)
                                                <option value="{{ $option->id }}">{{ $option->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4" style="padding-top: 30px;">
                                        <button class="btn btn-primary" type="submit">Search</button>
                                    </div>
                                </div>

                                <input type="hidden" name="query_type" value="customer_credit" />
                            </form>
                        </div>


                        <div class="customer_paid_selection hide">
                            <form method="GET" action="{{ route('customer.report.pdf') }}" target="_blank" class="form-inline" id="selectByPaidCustomer">

                                <div class="row">
                                    <div class="col-sm-8 form-group">
                                        <label for="customer_id" class="col-sm-2 form-label">Customer</label>
                                        <div class="col-sm-10">
                                            <select name="customer_id" class="form-select select2" aria-label="Customer">

                                                <option value="">---</option>
                                                @foreach($data as $option)
                                                <option value="{{ $option->id }}">{{ $option->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4" style="padding-top: 30px;">
                                        <button class="btn btn-primary" type="submit">Search</button>
                                    </div>
                                </div>
                                <input type="hidden" name="query_type" value="customer_paid" />
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

    $("form#selectByCreditCustomer").validate({
        rules: {
            customer_id: {required: true}

        },
        messages: {
            customer_id: {
                required: "Please Select a Customer"
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

    $("form#selectByPaidCustomer").validate({
        rules: {
            customer_id: {required: true}

        },
        messages: {
            customer_id: {
                required: "Please Select a Customer"
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

        var customer_credit_div = $("div.customer_credit_selection");
        var customer_paid_div = $("div.customer_paid_selection");

        if (id == "customer_credit") {
            customer_paid_div.addClass("hide");
            customer_credit_div.removeClass("hide");
        } else {
            customer_credit_div.addClass("hide");
            customer_paid_div.removeClass("hide");
        }
    });

    $("div.customer_credit_selection").find("span.select2.select2-container").css({width: "100%"}); //Select collapse when hidden. Expand to full width
    $("div.customer_paid_selection").find("span.select2.select2-container").css({width: "100%"});
    $("input.toggle_report_mode").prop("checked", false); //Uncheck both selections
});

</script>

@endsection
