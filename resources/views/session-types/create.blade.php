@extends('layouts.app')
@section('styles')

@endsection
@section('title')   {{ trans('main_trans.session_types') }}    @endsection
@section('header-title')    {{ trans('main_trans.session_types') }}     @endsection
@section('header-title-one')    {{ trans('main_trans.session_types') }}     @endsection
@section('header-title-two')    {{ trans('main_trans.create') }}    @endsection

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ trans('main_trans.add_new_session_type') }}</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="post" action="{{route('session-types.store')}}" enctype="multipart/form-data">
            @include('session-types.form')
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" name="create">{{ trans('main_trans.submit') }}</button>
            </div>
        </form>
    </div>
@endsection
@section('scripts')

@endsection
