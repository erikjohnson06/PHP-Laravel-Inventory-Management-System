
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
                                    <i class="ri-play-list-add-line "></i>
                                    <span>Suppliers</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('suppliers.all') }}">All Suppliers</a></li>
                                    <li><a href="{{ route('supplier.add') }}">Add New</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-play-list-add-line "></i>
                                    <span>Customers</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('customers.all') }}">All Customers</a></li>
                                    <li><a href="{{ route('customer.add') }}">Add New</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-play-list-add-line "></i>
                                    <span>Products</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('products.all') }}">All Products</a></li>
                                    <li><a href="{{ route('product.add') }}">Add New</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-play-list-add-line "></i>
                                    <span>Units</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('units.all') }}">All Units</a></li>
                                    <li><a href="{{ route('unit.add') }}">Add New</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-play-list-add-line "></i>
                                    <span>Categories</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('categories.all') }}">All Categories</a></li>
                                    <li><a href="{{ route('category.add') }}">Add New</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-play-list-add-line "></i>
                                    <span>Purchase Orders</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('purchaseorders.all') }}">View All</a></li>
                                    <li><a href="{{ route('purchaseorder.add') }}">Create New PO</a></li>
                                    <li><a href="{{ route('purchaseorder.approval') }}">Approve POs</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-play-list-add-line "></i>
                                    <span>Invoices</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('invoices.all') }}">View All</a></li>
                                    <li><a href="{{ route('invoices.pending') }}">View Pending</a></li>
                                    <li><a href="{{ route('invoice.add') }}">Create New Invoice</a></li>
                                </ul>
                            </li>

                            <li class="menu-title">
                                <hr />
                            </li>

                            <li>
                                <a href="{{ route('logout') }}"><i class="ri-shut-down-line"></i>Logout</a>
                            </li>

                            <!--<li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-layout-3-line"></i>
                                    <span>Layouts</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li>
                                        <a href="javascript: void(0);" class="has-arrow">Vertical</a>
                                        <ul class="sub-menu" aria-expanded="true">
                                            <li><a href="layouts-dark-sidebar.html">Dark Sidebar</a></li>
                                            <li><a href="layouts-compact-sidebar.html">Compact Sidebar</a></li>
                                            <li><a href="layouts-icon-sidebar.html">Icon Sidebar</a></li>
                                            <li><a href="layouts-boxed.html">Boxed Layout</a></li>
                                            <li><a href="layouts-preloader.html">Preloader</a></li>
                                            <li><a href="layouts-colored-sidebar.html">Colored Sidebar</a></li>
                                        </ul>
                                    </li>

                                    <li>
                                        <a href="javascript: void(0);" class="has-arrow">Horizontal</a>
                                        <ul class="sub-menu" aria-expanded="true">
                                            <li><a href="layouts-horizontal.html">Horizontal</a></li>
                                            <li><a href="layouts-hori-topbar-light.html">Topbar light</a></li>
                                            <li><a href="layouts-hori-boxed-width.html">Boxed width</a></li>
                                            <li><a href="layouts-hori-preloader.html">Preloader</a></li>
                                            <li><a href="layouts-hori-colored-header.html">Colored Header</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>-->

                            <!--<li class="menu-title">Pages</li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-account-circle-line"></i>
                                    <span>Authentication</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="auth-login.html">Login</a></li>
                                    <li><a href="auth-register.html">Register</a></li>
                                    <li><a href="auth-recoverpw.html">Recover Password</a></li>
                                    <li><a href="auth-lock-screen.html">Lock Screen</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-profile-line"></i>
                                    <span>Utility</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="pages-starter.html">Starter Page</a></li>
                                    <li><a href="pages-timeline.html">Timeline</a></li>
                                    <li><a href="pages-directory.html">Directory</a></li>
                                    <li><a href="pages-invoice.html">Invoice</a></li>
                                    <li><a href="pages-404.html">Error 404</a></li>
                                    <li><a href="pages-500.html">Error 500</a></li>
                                </ul>
                            </li>-->
                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
