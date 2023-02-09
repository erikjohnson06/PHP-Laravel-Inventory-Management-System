
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!-- User details -->

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-hotel-fill"></i>
                        <span>Suppliers</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('suppliers.all') }}">All Suppliers</a></li>
                        <li><a href="{{ route('supplier.add') }}">Add New</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-database-fill "></i>
                        <span>Customers</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('customers.all') }}">All Customers</a></li>
                        <li><a href="{{ route('customers.credit') }}">Credit Customers</a></li>
                        <li><a href="{{ route('customers.paid') }}">Zero-Balance Customers</a></li>
                        <li><a href="{{ route('customers.report') }}">Customer Report</a></li>
                        <li><a href="{{ route('customer.add') }}">Add New</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-barcode-line "></i>
                        <span>Products</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('products.all') }}">All Products</a></li>
                        <li><a href="{{ route('product.add') }}">Add New</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-database-2-fill "></i>
                        <span>Units</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('units.all') }}">All Units</a></li>
                        <li><a href="{{ route('unit.add') }}">Add New</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-function-fill "></i>
                        <span>Categories</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('categories.all') }}">All Categories</a></li>
                        <li><a href="{{ route('category.add') }}">Add New</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class=" ri-stack-line"></i>
                        <span>Purchase Orders</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('purchaseorders.all') }}">View All</a></li>
                        <li><a href="{{ route('purchaseorder.add') }}">Create New PO</a></li>
                        <li><a href="{{ route('purchaseorder.approval') }}">Approve POs</a></li>
                        <li><a href="{{ route('purchaseorder.daily.report') }}">Daily Report</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-stack-line "></i>
                        <span>Invoices</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('invoices.all') }}">View All</a></li>
                        <li><a href="{{ route('invoices.pending') }}">View Pending</a></li>
                        <li><a href="{{ route('invoice.add') }}">Create New Invoice</a></li>
                        <li><a href="{{ route('invoices.daily.report') }}">Daily Report</a></li>
                    </ul>
                </li>

                <li class="menu-title">Inventory</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-device-fill "></i>
                        <span>Manage Inventory</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('stock.status.report') }}">Stock Status</a></li>
                        <li><a href="{{ route('stock.supplier.report') }}">Supplier / Product Report</a></li>
                    </ul>
                </li>

                <li class="menu-title">
                    <hr />
                </li>

                <li>
                    <a href="{{ route('logout') }}"><i class="ri-shut-down-line"></i>Logout</a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
