@extends('layouts.app')
@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection
@section('title')   Home    @endsection
@section('header-title')    Home   @endsection
@section('header-title-one')    Home    @endsection

@section('content')
    <div class="row">
    @include('home-sections.side-left')
    <!-- /.col -->
        <div class="col-md-9">
        @include('home-sections.numbers')
        @include('home-sections.statistics-graphs')
        @include('home-sections.datatable')
        <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
@endsection
@section('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('table.display').DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                order: [[0, 'desc']]
            });
        });
    </script>
    @include('home-sections.graphs-js')
@endsection
