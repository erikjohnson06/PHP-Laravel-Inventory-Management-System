@extends('admin.admin_master')

@section('title')
    Easy Inventory | Add Unit
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
                                <h4 class="card-title">Add Unit</h4>
                            </div>
                            <div class="col-sm-2">
                                <a class="waves-effect waves-light float-end" href="{{ route('units.all') }}">
                                    <i class="ri-arrow-left-s-line "></i>&nbsp;Back
                                </a>
                            </div>
                        </div>

                        <form method="post" action="{{ route('store.unit') }}" id="unitAddForm">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-sm-2 col-form-label">Unit Name</label>
                                <div class="form-group col-sm-10">
                                    <input name="name" class="form-control" type="text" value=""  >
                                </div>
                            </div>

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

        jQuery("form#unitAddForm").validate({
            rules : {
                name : {required : true}
            },
            messages : {
                name : {
                    required : "Please Enter a Unit Name"
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
