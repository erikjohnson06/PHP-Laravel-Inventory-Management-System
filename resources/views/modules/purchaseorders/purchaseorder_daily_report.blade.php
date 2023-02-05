@extends('admin.admin_master')

@section('title')
Easy Inventory | Daily Purchase Orders
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
                                <h4 class="card-title">Purchase Order Invoice Report</h4>
                            </div>
                            <div class="col-sm-2">
                                <a class="waves-effect waves-light float-end" href="{{ route('purchaseorders.all') }}">
                                    <i class="ri-arrow-left-s-line "></i>&nbsp;Back
                                </a>
                            </div>
                        </div>

                        <form method="GET" action="{{ route('purchaseorder.daily.search') }}" target="_blank" id="dailyReportForm">

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="mb-3 form-group">
                                        <label for="start_date" class="form-label">Start Date</label>
                                        <input class="form-control"
                                               type="date"
                                               name="start_date"
                                               value="{{ $curr_date }}"
                                               id="start_date"
                                               placeholder="MM/DD/YY" />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3 form-group">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <input class="form-control"
                                               type="date"
                                               name="end_date"
                                               value="{{ $curr_date }}"
                                               id="end_date"
                                               placeholder="MM/DD/YY" />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label style="margin-top: 37px;">&nbsp;</label>
                                        <button class="btn btn-primary " type="submit">
                                            <i class="fa fa-search"></i>&nbsp;Search
                                        </button>
                                    </div>
                                </div>

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

<script type="text/javascript">

    $(document).ready(function(){

        $("form#dailyReportForm").validate({
            rules : {
                start_date : {required : true},
                end_date : {required : true}
            },
            messages : {
                start_date : {
                    required : "Please Select a Start Date"
                },
                end_date : {
                    required : "Please Select a End Date"
                }
            },
            errorElement : "span",
            errorPlacement : function(error, element){
                error.addClass("invalid-feedback");
                element.closest(".form-group").append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass("is-invalid");
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass("is-invalid");
            }
        });
    });

</script>

@endsection

