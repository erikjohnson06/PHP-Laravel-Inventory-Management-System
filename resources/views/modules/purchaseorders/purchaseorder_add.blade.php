@extends('admin.admin_master')

@section('title')
Easy Inventory | New Purchase Order
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
                                <h4 class="card-title">New Purchase Order</h4>
                            </div>
                            <div class="col-sm-2">
                                <a class="waves-effect waves-light float-end" href="{{ route('purchaseorders.all') }}">
                                    <i class="ri-arrow-left-s-line "></i>&nbsp;Back
                                </a>
                            </div>
                        </div>

                        <form method="post" action="{{ route('store.purchaseorder') }}" id="productOrderAddForm">
                            @csrf

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="po_date" class="form-label">Date</label>
                                        <input class="form-control" type="date" name="po_date" value="" id="po_date">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="po_date" class="form-label">PO #</label>
                                        <input class="form-control" type="text" name="po_number" value="" id="po_number">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="supplier_id" class="form-label">Supplier</label>
                                        <select id="supplier_id" name="supplier_id" class="form-select" aria-label="Supplier">
                                            <option value="">---</option>
                                            @foreach($suppliers as $option)
                                            <option value="{{ $option->id }}">{{ $option->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Category</label>
                                        <select id="category_id" name="category_id" class="form-select" aria-label="Category">
                                            <option value="">---</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="product_id" class="form-label">Product</label>
                                        <select id="product_id" name="product_id" class="form-select" aria-label="Product">
                                            <option value="">---</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="add_more" class="form-label" style="margin-top: 40px;"></label>
                                        <!--<input type="submit" class="waves-effect waves-light" value="Add More">-->

                                        <button type="button" class="btn btn-link btn-rounded waves-effect waves-light" id="add_more">
                                            <i class="fa fa-plus-square" value="Add More"></i>&nbsp;Add More
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

<script type="text/javascript">

    //jQuery(document).ready(function(){
    window.onload = (function () {

        jQuery(document).on("change", "#supplier_id", function(){
            var supplierId = jQuery(this).val();
            var categorySelect = jQuery("select#category_id");
            var html;

            jQuery.ajax({
                url:"{{ route('get-categories') }}",
                type: "GET",
                data: {supplier_id:supplierId},
                success: function(data){

                    console.log(data);

                    if (!data || !data.length){
                        html = "<option value=''>No Categories Available</option>";
                        categorySelect.html(html);
                        return;
                    }

                    html = "<option value=''>Select Category</option>";

                    jQuery.each(data,function(key, val){
                        html += "<option value='" + val.category_id + "'>" + val.category.name + "</option>";
                    });


                    categorySelect.html(html);
                }
            });
        });

        jQuery("form#productOrderAddForm").validate({
            rules: {
                name: {required: true},
                category_id: {required: true},
                supplier_id: {required: true},
                unit_id: {required: true},
                status_id: {required: true}
            },
            messages: {
                name: {
                    required: "Please Enter a Product Name"
                },
                category_id: {
                    required: "Please Select a Category"
                },
                supplier_id: {
                    required: "Please Select a Supplier"
                },
                unit_id: {
                    required: "Please Select a Unit of Measure"
                },
                status_id: {
                    required: "Please Select a Status"
                }
            },
            errorElement: "span",
            errorPlacement: function (error, element) {
                error.addClass("invalid-feedback");
                element.closest(".form-group").append(error);
            },
            highlight: function (element, errorClass, validClass) {
                jQuery(element).addClass("is-invalid");
            },
            unhighlight: function (element, errorClass, validClass) {
                jQuery(element).removeClass("is-invalid");
            }
        });
    });

</script>

@endsection
