
@extends('admin.admin_master')

@section('title')
    Easy Inventory | Products
@endsection

@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Products - All</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <a class="btn btn-link btn-rounded waves-effect waves-light float-end" href="{{ route('product.add') }}">
                            <i class="fa fa-plus-square"></i>&nbsp;Add New
                        </a>

                        <br />
                        <br />

                        <table id="datatable"
                               class="table table-bordered dt-responsive nowrap"
                               style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Supplier</th>
                                <th>Category</th>
                                <!--<th>Unit</th>-->
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
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row['supplier']['name'] }}</td>
                                        <td>{{ $row['category']['name'] }}</td>
                                        <!--<td>{{ $row['unit']['name'] }}</td>-->
                                        <td>{{ $row['status']['status'] }}</td>
                                        <td>
                                            <a href="{{ route('product.edit', $row->id) }}" class="btn btn-primary sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <a href="{{ route('product.delete', $row->id) }}" class="btn btn-danger sm deleteItem" title="Delete">
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