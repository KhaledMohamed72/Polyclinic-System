<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title')</title>
    <!-- Google Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- PAGE STYLES -->
    @yield('styles')
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    @if (LaravelLocalization::getCurrentLocale() == 'ar')
        <!-- Bootstrap 4 RTL -->
        <link rel="stylesheet" href="{{ asset('assets/dist/css/bootstrap.min.css') }}">
        <!-- Custom style for RTL -->
        <link rel="stylesheet" href="{{ asset('assets/dist/css/custom.css') }}">
    @endif
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse">
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.header')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.side-bar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            @include('layouts.page-header')
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            @yield('content')
                        </div>
                    </div>
                </div>
                <!--/. container-fluid -->
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
        @include('layouts.footer')
    </div>
    <!-- ./wrapper -->
    @if (LaravelLocalization::getCurrentLocale() == 'ar')
        <!-- Bootstrap 4 rtl -->
        <script src="{{ asset('assets/dist/js/bootstrap.min.js') }}"></script>
    @endif
    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <!-- it makes a conflict with calender libs so i have to disable it on this page -->
    @if (!request()->routeIs('appointments.index'))
        <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    @endif

    <!-- Bootstrap -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

    <!-- PAGE SCRIPTS -->
    @yield('scripts')
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ asset('assets/dist/js/demo.js') }}"></script>
    <script>
        $(function() {
            $('.selectpicker').selectpicker();
        });
    </script>

</body>

</html>
