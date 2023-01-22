
@extends('admin.admin_master')

@section('title')
    Easy Inventory | Purchase Orders
@endsection

@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Purchase Orders - All</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <a class="btn btn-link btn-rounded waves-effect waves-light float-end" href="{{ route('purchaseorder.add') }}">
                            <i class="fa fa-plus-square"></i>&nbsp;Create New PO
                        </a>

                        <br />
                        <br />

                        <table id="datatable"
                               class="table table-bordered dt-responsive nowrap"
                               style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>PO #</th>
                                <th>PO Date</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Description</th>

                                <th>Supplier</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>

                                @foreach($data as $row)

                                    @php
                                        $rowClass = "";
                                        if ($row->status_id == 4){
                                            $rowClass = "inactive";
                                        }
                                        else if ($row->status_id == 3){
                                            $rowClass = "onHold";
                                        }
                                    @endphp

                                    <tr class='{{ $rowClass }}'>
                                        <td>{{ $row->id }}</td>
                                        <td>{{ $row->po_number }}</td>
                                        <td>{{ $row->po_date }}</td>

                                        <td>{{ $row->product_id }}</td>
                                        <td>{{ $row->purchase_qty }}</td>
                                        <td>{{ $row->po_description }}</td>
                                        <td>{{ $row->supplier_id }}</td>

                                        <td>{{ $row->status_id }}</td>
                                        <td>
                                            <a href="{{ route('purchaseorder.edit', $row->id) }}" class="btn btn-primary sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <a href="{{ route('purchaseorder.delete', $row->id) }}" class="btn btn-danger sm deleteItem" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
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