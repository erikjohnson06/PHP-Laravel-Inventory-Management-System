
@extends('admin.admin_master')

@section('title')
    Easy Inventory | Customers
@endsection

@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Zero-Balance Customers</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <a class="btn btn-link btn-rounded waves-effect waves-light float-end" href="{{ route('paid.customers.print.pdf') }}">
                            <i class="fa fa-print"></i>&nbsp;Print
                        </a>

                        <br />
                        <br />

                        <table id="datatable"
                               class="table table-bordered dt-responsive"
                               style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Customer</th>
                                <th>Invoice</th>
                                <th>Date</th>
                                <th>Due Amount</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>

                                @foreach($data as $k => $row)

                                    <tr>
                                        <td>{{ $k + 1 }}</td>
                                        <td>{{ $row['customer']['name'] }} ({{ $row['customer']['id'] }})</td>
                                        <td>{{ $row['invoice']['invoice_no'] }}</td>
                                        <td>{{ date('n/j/Y', strtotime($row['invoice']['invoice_date'])) }}</td>
                                        <td>${{ number_format($row->due_amount, 2) }}</td>
                                        <td>
                                            <a href="{{ route('customer.invoice.details',$row->invoice_id) }}" class="btn btn-info sm" title="Customer Invoice Details" target="_blank">
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