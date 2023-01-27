
@extends('admin.admin_master')

@section('title')
    Easy Inventory | Suppliers
@endsection

@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Suppliers - All</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <a class="btn btn-link btn-rounded waves-effect waves-light float-end" href="{{ route('supplier.add') }}">
                            <i class="fa fa-plus-square"></i>&nbsp;Add New
                        </a>

                        <br />
                        <br />

                        <!--<h4 class="card-title">Suppliers</h4>-->

                        <table id="datatable"
                               class="table table-bordered dt-responsive"
                               style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Supplier Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>

                                @foreach($data as $row)

                                    <tr>
                                        <td>{{ $row->id }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->phone }}</td>
                                        <td>{{ $row->email }}</td>
                                        <td>{{ $row['status']['status'] }}</td>
                                        <td>
                                            <a href="{{ route('supplier.edit', $row->id) }}" class="btn btn-primary sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <a href="{{ route('supplier.delete', $row->id) }}" class="btn btn-danger sm deleteItem" title="Delete">
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