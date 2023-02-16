
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
                               class="table table-bordered dt-responsive"
                               style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>PO #</th>
                                    <th>PO Date</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Category</th>
                                    <th>Supplier</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @if ($data)

                                @foreach($data as $row)

                                @php
                                $rowClass = "";
                                if ($row->status_id == 1){
                                $rowClass = "onHold";
                                }
                                else if ($row->status_id == 2){
                                $rowClass = "approved";
                                }
                                else if ($row->status_id == 3){ //Cancelled
                                $rowClass = "inactive";
                                }

                                $desc = $row['product']['id'] . " - " . $row['product']['name'];
                                @endphp

                                <tr class='{{ $rowClass }}'>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->po_number }}</td>
                                    <td>{{ date('n/j/Y', strtotime($row->po_date)) }}</td>
                                    <td class="align-left overflow-text">{{ $desc }}</td>
                                    <td>{{ $row->purchase_qty }}</td>
                                    <td>{{ $row['category']['name'] }}</td>
                                    <td>{{ $row['supplier']['name'] }}</td>
                                    <td>{{ $row['status']['status'] }}</td>
                                    <td>
                                        @if ($row->status_id == 1)
                                        <a href="{{ route('purchaseorder.delete', $row->id) }}" class="btn btn-danger sm deleteItem" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                                @endif
                            </tbody>
                        </table>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>
@endsection