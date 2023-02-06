
@extends('admin.admin_master')

@section('title')
Easy Inventory | Credit Customers
@endsection

@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Credit Customers</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <a class="btn btn-link btn-rounded waves-effect waves-light float-end" href="{{ route('credit.customers.print.pdf') }}" target="_blank">
                            <i class="fa fa-print"></i>&nbsp;Print
                        </a>

                        <br />
                        <br />

                        <!--<h4 class="card-title">Credit Customers</h4>-->

                        <table id="datatable"
                               class="table table-bordered dt-responsive"
                               style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer Name</th>
                                    <th>Invoice #</th>
                                    <th>Date</th>
                                    <th>Due Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($data as $k => $row)

                                <tr>
                                    <td>{{ $k + 1 }}</td>
                                    <td>{{ $row['customer']['name'] }}</td>
                                    <td>{{ $row['invoice']['invoice_no'] }}</td>
                                    <td>{{ date('n/j/Y', strtotime($row['invoice']['invoice_date'])) }}</td>
                                    <td>${{ number_format($row->due_amount, 2) }}</td>
                                    <td>
                                        <a href="{{ route('customer.edit.invoice', $row->invoice_id) }}" class="btn btn-primary sm" title="Edit Invoice Data">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="{{ route('customer.delete', $row['invoice']['id']) }}" class="btn btn-warning sm" title="Customer Invoice Details">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>
@endsection