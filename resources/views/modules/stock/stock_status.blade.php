
@extends('admin.admin_master')

@section('title')
    Easy Inventory | Stock Status
@endsection

@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Stock Status</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <a class="btn btn-link btn-rounded waves-effect waves-light float-end" target="_blank" href="{{ route('stock.status.pdf') }}">
                            <i class="fa fa-print"></i>&nbsp;Print
                        </a>

                        <br />
                        <br />

                        <table id="datatable"
                               class="table table-bordered dt-responsive"
                               style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product</th>
                                <th>Supplier</th>
                                <th>Unit</th>
                                <th>Category</th>
                                <th>On Hand</th>
                            </tr>
                            </thead>

                            <tbody>

                                @foreach($data as $row)

                                    @php
                                        $rowClass = "";
                                        if ($row->quantity < 5){
                                            $rowClass = "inactive";
                                        }
                                        else if ($row->quantity <10){
                                            $rowClass = "onHold";
                                        }
                                    @endphp

                                    <tr class='{{ $rowClass }}'>
                                        <td>{{ $row->id }}</td>
                                        <td class="align-left overflow-text">{{ $row->name }}</td>
                                        <td>{{ $row['supplier']['name'] }}</td>
                                        <td>{{ $row['unit']['name'] }}</td>
                                        <td>{{ $row['category']['name'] }}</td>
                                        <td>{{ $row->quantity }}</td>
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