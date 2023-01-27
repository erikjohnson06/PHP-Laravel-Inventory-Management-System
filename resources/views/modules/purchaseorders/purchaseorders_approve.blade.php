
@extends('admin.admin_master')

@section('title')
    Easy Inventory | Purchase Approve
@endsection

@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Purchase Orders - Approve</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <a class="btn btn-link btn-rounded waves-effect waves-light float-end" href="{{ route('purchaseorders.all') }}">
                            <i class="ri-arrow-left-s-line"></i>&nbsp;View All POs
                        </a>

                        <br />
                        <br />

                        <table id="datatable"
                               class="table table-bordered dt-responsive"
                               style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>PO #</th>
                                <th>PO Date</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Supplier</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>

                                @foreach($data as $row)

                                    @php
                                        $rowClass = "onHold";
                                    @endphp

                                    <tr class='{{ $rowClass }}'>
                                        <td>{{ $row->id }}</td>
                                        <td>{{ $row->po_number }}</td>
                                        <td>{{ date('n/j/Y', strtotime($row->po_date)) }}</td>
                                        <td class="align-left overflow-text">{{ $row['product']['id'] . " - " . $row['product']['name'] }}</td>
                                        <td>{{ $row->purchase_qty }}</td>
                                        <td>{{ $row->po_description }}</td>
                                        <td>{{ $row['category']['name'] }}</td>
                                        <td>{{ $row['supplier']['name'] }}</td>

                                        <td>{{ $row['status']['status'] }}</td>
                                        <td>

                                            <a href="{{ route('purchaseorder.approve', $row->id) }}" class="btn btn-primary sm approveItem" title="Approve">
                                                <i class="fas fa-check-circle"></i>
                                            </a>
                                            <a href="{{ route('purchaseorder.cancel', $row->id) }}" class="btn btn-danger sm cancelItem" title="Cancel">
                                                <i class="fas fa-times"></i>
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

@section('javascript')
@endsection