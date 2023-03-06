@extends('layouts.app')
@section('styles')

@endsection
@section('title')   {{ trans('main_trans.session_types') }}    @endsection
@section('header-title')    {{ trans('main_trans.session_types') }}     @endsection
@section('header-title-one')    {{ trans('main_trans.session_types') }}     @endsection
@section('header-title-two')    {{ trans('main_trans.edit') }}    @endsection
@section('styles')

@endsection
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ trans('main_trans.edit_session_type') }}</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->

        <form method="POST" action="{{route('session-types.update' , $row->id)}}">
            {{ method_field('put') }}
            @include('session-types.form')
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" name="update">{{ trans('main_trans.submit') }}</button>
            </div>
        </form>
    </div>

@endsection
@section('scripts')

@endsection
