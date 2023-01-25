@extends('layouts.app')
@section('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection
@section('title')   Appointments    @endsection
@section('header-title')    Appointments   @endsection
@section('header-title-one')    Appointments    @endsection
@section('header-title-one-link')    {{route('appointments.index')}}    @endsection
@section('header-title-two')    Create   @endsection

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <div class="card-title">Book Appointment</div>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="post" action="{{route('appointments.store')}}">
            @include('appointments.form')
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" name="create">Submit</button>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <!-- Select2 -->
    <script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
    {{-- ajax scripts  --}}
    @include('appointments.appointment-store-js')
@endsection
