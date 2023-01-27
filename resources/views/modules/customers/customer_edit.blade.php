@extends('admin.admin_master')

@section('title')
    Easy Inventory | Edit Customer
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
                                <h4 class="card-title">Edit Customer</h4>
                            </div>
                            <div class="col-sm-2">
                                <a class="waves-effect waves-light float-end" href="{{ route('customers.all') }}">
                                    <i class="ri-arrow-left-s-line "></i>&nbsp;Back
                                </a>
                            </div>
                        </div>

                        <br />

                        <form method="post" action="{{ route('update.customer') }}" id="customerAddForm" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                <div class="form-group col-sm-10">
                                    <input name="name" class="form-control" type="text" value="{{ $data->name }}"  >
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                                <div class="form-group col-sm-10">
                                    <input name="phone" class="form-control" type="text" value="{{ $data->phone }}"  >
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="form-group col-sm-10">
                                    <input name="email" class="form-control" type="email" value="{{ $data->email }}"  >
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="address" class="col-sm-2 col-form-label">Address</label>
                                <div class="form-group col-sm-10">
                                    <input name="address" class="form-control" type="address" value="{{ $data->address }}"  >
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

                            <div class="row mb-3">
                                <label for="customer-image" class="col-sm-2 col-form-label">Customer Image</label>
                                <div class="form-group col-sm-10">
                                    <input name="image" class="form-control" type="file" id="customer-image" value="{{ (!empty($data->image)) ? $data->image : ""}}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <img id="customer-image-show"
                                         class="rounded avatar-lg"
                                         src="{{ ($data->image) ? asset($data->image) : ""}}"
                                         alt="[None]">
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

@endsection

@section('javascript')

<script type="text/javascript">

    $(document).ready(function(){

        $("input#customer-image").change(function(e){
            var reader = new FileReader();

            reader.onload = function(e){
                $('img#customer-image-show').attr("src", e.target.result);
            };

            reader.readAsDataURL(e.target.files['0']);
        });

        $("form#customerAddForm").validate({
            rules : {
                name : {required : true},
                phone : {required : true},
                email : {required : true},
                address : {required : true}
            },
            messages : {
                name : {
                    required : "Please Enter a Customer Name"
                },
                phone : {
                    required : "Please Enter a Phone Number for this Customer"
                },
                email : {
                    required : "Please Enter an Email Address for this Customer"
                },
                address : {
                    required : "Please Enter an Address for this Customer"
                }
                //image : {
                //    required : "Please Enter a Email Address for this Customer"
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
