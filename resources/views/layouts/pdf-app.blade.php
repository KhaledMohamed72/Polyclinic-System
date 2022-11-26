<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!-- Google Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- PAGE STYLES -->
@yield('styles')
<!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
    <style>
        * { font-family: DejaVu Sans, sans-serif; }
    </style>
{{--    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">--}}
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse">
<div class="wrapper">
    <!-- Navbar -->

<!-- /.navbar -->

    <!-- Main Sidebar Container -->

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

    <!-- /.content-header -->

        <!-- Main content -->
        <section class="content text-center">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        @yield('content')
                    </div>
                </div>
            </div><!--/. container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<!-- it makes a conflict with calender libs so i have to disable it on this page -->
@if (!request()->routeIs('appointments.index'))
    <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
@endif

<!-- Bootstrap -->
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- PAGE SCRIPTS -->
@yield('scripts')
<!-- AdminLTE App -->
<script src="{{asset('assets/dist/js/adminlte.js')}}"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{asset('assets/dist/js/demo.js')}}"></script>

</body>
</html>
