@extends('admin.admin_master')

@section('title')
    Easy Inventory | Update Password
@endsection

@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">

                        <h4 class="card-title">Update Password </h4>
                        <br />


                        @if(count($errors))

                            @foreach ($errors->all() as $error)
                                <p class="alert alert-danger alert-dismissable fade show">{{ $error }}</p>
                            @endforeach
                        @endif

                        <form method="post" action="{{ route('store.password') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="old_password" class="col-sm-2 col-form-label">Old Password</label>
                                <div class="col-sm-10">
                                    <input name="old_password" class="form-control" type="password" value=""  id="old_password">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="new_password" class="col-sm-2 col-form-label">New Password</label>
                                <div class="col-sm-10">
                                    <input name="new_password" class="form-control" type="password" value=""  id="new_password">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="confirm_password" class="col-sm-2 col-form-label">Confirm Password</label>
                                <div class="col-sm-10">
                                    <input name="confirm_password" class="form-control" type="password" value=""  id="confirm_password">
                                </div>
                            </div>

                            <input type="submit" class="btn btn-info waves-effect waves-light" value="Update">

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
</div>


@endsection
