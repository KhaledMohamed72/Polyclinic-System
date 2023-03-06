@extends('layouts.app')
@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection
@if(auth()->user()->hasRole(['admin','recep']))
@section('title')   {{ trans('main_trans.doctor_profile') }}    @endsection
@section('header-title')    {{ trans('main_trans.doctor_profile') }}    @endsection
@section('header-title-one')    {{ trans('main_trans.doctor_profile') }}   @endsection
@section('header-title-two')    {{ trans('main_trans.profile') }}   @endsection
@else
@section('title')   {{ trans('main_trans.home') }}    @endsection
@section('header-title')    {{ trans('main_trans.home') }}    @endsection
@section('header-title-one')    {{ trans('main_trans.home') }}    @endsection
@endif

@section('content')
    <div class="row">
    @include('doctors.show-sections.side-left')
    <!-- /.col -->
        <div class="col-md-9">
            @include('doctors.show-sections.numbers')
            @include('doctors.show-sections.statistics-graphs')
            @include('doctors.show-sections.datatable')
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
    @include('doctors.show-sections.graphs-js')
@endsection
