
@extends('admin.admin_master')

@section('title')
Easy Inventory | Product Report
@endsection

@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Product Report</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-6">
                                <div class="invoice-title">

                                    <h3>
                                        <img src="{{ asset('assets/images/easy_logo_sm.png') }}" alt="logo" height="55" />
                                    </h3>
                                </div>


                            </div>
                            <div class="col-6 text-end">
                                <em>{{ $date->format('F j, Y, g:i a') }}</em>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <address>
                                    <strong>Sale Dynamics</strong><br>
                                    Knoxville, TN<br>
                                    support@salesdynamics.com
                                </address>
                            </div>
                            <div class="col-6 text-end">
                                <address>

                                </address>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <div class="p-2">

                                    </div>
                                </div>
                            </div>
                        </div> <!-- end row -->

                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <div class="">
                                        <div class="table-responsive">

                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <td class="text-center"><strong>ID</strong></td>
                                                        <td class="text-center"><strong>Product</strong></td>
                                                        <td class="text-center"><strong>Unit</strong></td>
                                                        <td class="text-center"><strong>Category</strong></td>
                                                        <td class="text-center"><strong>On Hand</strong></td>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr>
                                                        <td class="text-center">{{ $data->id }}</td>
                                                        <td>{{ $data->name }}</td>
                                                        <td class="text-center">{{ $data['unit']['name'] }}</td>
                                                        <td class="text-center">{{ $data['category']['name'] }}</td>
                                                        <td class="text-center">{{ $data->quantity }}</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="d-print-none">
                                            <div class="float-end">
                                                <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="fa fa-print"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end row -->
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>

@endsection