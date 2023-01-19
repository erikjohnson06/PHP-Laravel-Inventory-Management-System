@extends('admin.admin_master')

@section('title')
    Easy Inventory | Edit Supplier
@endsection

@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">

                        <h4 class="card-title">Edit Supplier</h4>
                        <br />

                        <form method="post" action="{{ route('update.supplier') }}" id="suppplierEditForm">
                            @csrf

                            <div class="row mb-3">
                                <label for="old_password" class="col-sm-2 col-form-label">Name</label>
                                <div class="form-group col-sm-10">
                                    <input name="name" class="form-control" type="text" value="{{ $data->name }}"  >
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="old_password" class="col-sm-2 col-form-label">Phone</label>
                                <div class="form-group col-sm-10">
                                    <input name="phone" class="form-control" type="text" value="{{ $data->phone }}"  >
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="old_password" class="col-sm-2 col-form-label">Email</label>
                                <div class="form-group col-sm-10">
                                    <input name="email" class="form-control" type="email" value="{{ $data->email }}"  >
                                </div>
                            </div>

                            <!--
                            <div class="row mb-3">
                                <label for="old_password" class="col-sm-2 col-form-label">Address</label>
                                <div class="form-group col-sm-10">
                                    <input name="address" class="form-control" type="address" value=""  >
                                </div>
                            </div>
                            -->

                            <input type="submit" class="btn btn-primary waves-effect waves-light" value="Update">

                            <input type="hidden" name="id" value="{{ $data->id }}" />
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

        jQuery("form#suppplierEditForm").validate({
            rules : {
                name : {required : true},
                phone : {required : true},
                email : {required : true}
                //address : {required : true}
            },
            messages : {
                name : {
                    required : "Please Enter a Supplier Name"
                },
                phone : {
                    required : "Please Enter a Phone Number for this Supplier"
                },
                email : {
                    required : "Please Enter a Email Address for this Supplier"
                }
                //address : {
                //    required : "Please Enter a Supplier Address"
                //}
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