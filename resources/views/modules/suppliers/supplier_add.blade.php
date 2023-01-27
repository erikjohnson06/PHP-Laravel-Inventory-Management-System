@extends('admin.admin_master')

@section('title')
    Easy Inventory | Add Supplier
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
                                <h4 class="card-title">Add Supplier</h4>
                            </div>
                            <div class="col-sm-2">
                                <a class="waves-effect waves-light float-end" href="{{ route('suppliers.all') }}">
                                    <i class="ri-arrow-left-s-line "></i>&nbsp;Back
                                </a>
                            </div>
                        </div>

                        <form method="post" action="{{ route('store.supplier') }}" id="suppplierAddForm">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                <div class="form-group col-sm-10">
                                    <input name="name" class="form-control" type="text" value=""  >
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                                <div class="form-group col-sm-10">
                                    <input name="phone" class="form-control" type="text" value=""  >
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="form-group col-sm-10">
                                    <input name="email" class="form-control" type="email" value=""  >
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="status_id" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <select name="status_id" class="form-select" aria-label="Status">
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->status }}</option>
                                        @endforeach
                                    </select>
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

@endsection

@section('javascript')

<script type="text/javascript">

    $(document).ready(function(){

        $("form#suppplierAddForm").validate({
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
                $(element).addClass("is-invalid");
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass("is-invalid");
            }
        });
    });

</script>

@endsection
