
@extends('admin.admin_master')

@section('title')
    Easy Inventory | Invoices
@endsection

@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Invoices</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <a class="btn btn-link btn-rounded waves-effect waves-light float-end" href="{{ route('invoice.add') }}">
                            <i class="fa fa-plus-square"></i>&nbsp;Create New Invoice
                        </a>

                        <br />
                        <br />

                        <table id="datatable"
                               class="table table-bordered dt-responsive"
                               style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Customer</th>
                                <th>Invoice Date</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>

                                @foreach($data as $row)

                                    @php
                                        $rowClass = "";
                                        if ($row->status_id == 0){
                                            $rowClass = "onHold";
                                        }
                                        else if ($row->status_id == 1){
                                            $rowClass = "approved";
                                        }
                                    @endphp

                                    <tr class='{{ $rowClass }}'>
                                        <td>{{ $row->invoice_no }}</td>
                                        <td>{{ $row->invoice_no }}</td>
                                        <td>{{ date('n/j/Y', strtotime($row->invoice_date)) }}</td>
                                        <td class="align-left"></td>
                                        <td></td>
                                        <td>{{ $row->status_id }}</td>
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