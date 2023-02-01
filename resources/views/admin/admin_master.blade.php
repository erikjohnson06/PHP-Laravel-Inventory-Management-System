<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>@yield('title', 'Easy Inventory Management | Dashboard')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

        <!-- jquery.vectormap css -->
        <link href="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />

        <!-- DataTables -->
        <link href="{{ asset('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Toaster CSS -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />

        <!-- Styles Css -->
        <link href="{{ asset('backend/assets/css/styles.css') }}" rel="stylesheet" type="text/css" />

        @yield('css')

    </head>

    <body data-topbar="dark">

        <!-- <body data-layout="horizontal" data-topbar="dark"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

            @include('admin.body.header')

            <!-- ========== Left Sidebar Start ========== -->
            @include('admin.body.sidebar')
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                @yield('admin')

                @include('admin.body.footer')

            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JS -->
        <script type="text/javascript" src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>

        <!-- apexcharts -->
        <script type="text/javascript" src="{{ asset('backend/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

        <!-- jquery.vectormap map -->
        <script type="text/javascript" src="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}"></script>

        <!-- App js -->
        <script type="text/javascript" src="{{ asset('backend/assets/js/app.js') }}"></script>

        <!-- Toaster JS -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <!-- Sweet Alert -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script type="text/javascript" src="{{ asset('backend/assets/js/sweetalert.js') }}"></script>

        <!-- jQuery -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- jQuery Validation -->
        <script type="text/javascript" src="{{ asset('backend/assets/js/validate.min.js') }}"></script>

        <!-- Required DataTables JS -->
        <script type="text/javascript" src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

        <!-- Responsive examples -->
        <script type="text/javascript" src="{{ asset('backend/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

        <!-- DataTables JS -->
        <script type="text/javascript" src="{{ asset('backend/assets/js/pages/datatables.init.js') }}"></script>

        <!-- HandleBars JS -->
        <script type="text/javascript" src="{{ asset('backend/assets/js/handlebars.js') }}"></script>

        <!-- Notify JS -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js" ></script>

        <script type="text/javascript" >
            @if(Session::has('message'))

                var type = "{{ Session::get('alert-type','info') }}";

                switch(type){
                   case 'info':
                   toastr.info(" {{ Session::get('message') }} ");
                   break;

                   case 'success':
                   toastr.success(" {{ Session::get('message') }} ");
                   break;

                   case 'warning':
                   toastr.warning(" {{ Session::get('message') }} ");
                   break;

                   case 'error':
                   toastr.error(" {{ Session::get('message') }} ");
                   break;
                }
            @endif
        </script>

        @yield('javascript')
    </body>

</html>