@extends('admin.admin_master')

@section('title')
    Easy Inventory | Edit Product
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
                                <h4 class="card-title">Edit Product</h4>
                            </div>
                            <div class="col-sm-2">
                                <a class="waves-effect waves-light float-end" href="{{ route('products.all') }}">
                                    <i class="ri-arrow-left-s-line "></i>&nbsp;Back
                                </a>
                            </div>
                        </div>

                        <form method="post" action="{{ route('update.product') }}" id="productAddForm">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-sm-2 col-form-label">Product Name</label>
                                <div class="form-group col-sm-10">
                                    <input name="name" class="form-control" type="text" value="{{ $data->name }}"  />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="category_id" class="col-sm-2 col-form-label">Category</label>
                                <div class="col-sm-10">
                                    <select name="category_id" class="form-select" aria-label="Category">
                                        <option value="">---</option>
                                        @foreach($categories as $option)
                                            <option value="{{ $option->id }}" {{ $option->id == $data->category_id ? 'selected' : '' }} >{{ $option->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="supplier_id" class="col-sm-2 col-form-label">Supplier</label>
                                <div class="col-sm-10">
                                    <select name="supplier_id" class="form-select" aria-label="Supplier">
                                        <option value="">---</option>
                                        @foreach($suppliers as $option)
                                            <option value="{{ $option->id }}" {{ $option->id == $data->supplier_id ? 'selected' : '' }} >{{ $option->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="unit_id" class="col-sm-2 col-form-label">Unit of Measure</label>
                                <div class="col-sm-10">
                                    <select name="unit_id" class="form-select" aria-label="Unit">
                                        <option value="">---</option>
                                        @foreach($units as $option)
                                            <option value="{{ $option->id }}" {{ $option->id == $data->unit_id ? 'selected' : '' }} >{{ $option->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="status_id" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <select name="status_id" class="form-select" aria-label="Status">
                                        @foreach($statuses as $option)
                                            <option value="{{ $option->id }}" {{ $option->id == $data->status_id ? 'selected' : '' }} >{{ $option->status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <input type="hidden" name="id" value="{{ $data->id }}" />

                            <input type="submit" class="btn btn-primary waves-effect waves-light" value="Save">

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
    window.onload = (function(){

        jQuery("form#productAddForm").validate({
            rules : {
                name : {required : true},
                category_id : {required : true},
                supplier_id : {required : true},
                unit_id : {required : true},
                status_id : {required : true}
            },
            messages : {
                name : {
                    required : "Please Enter a Product Name"
                },
                category_id : {
                    required : "Please Select a Category"
                },
                supplier_id : {
                    required : "Please Select a Supplier"
                },
                unit_id : {
                    required : "Please Select a Unit of Measure"
                },
                status_id : {
                    required : "Please Select a Status"
                }
            },
            errorElement : "span",
            errorPlacement : function(error, element){
                error.addClass("invalid-feedback");
                element.closest(".form-group").append(error);
            },
            highlight : function(element, errorClass, validClass){
                jQuery(element).addClass("is-invalid");
            },
            unhighlight : function(element, errorClass, validClass){
                jQuery(element).removeClass("is-invalid");
            }
        });
    });

</script>

@endsection
