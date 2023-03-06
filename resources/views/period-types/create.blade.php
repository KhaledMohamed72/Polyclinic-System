@extends('layouts.app')
@section('styles')

@endsection
@section('title')  {{ trans('main_trans.period_types') }}    @endsection
@section('header-title')    {{ trans('main_trans.period_types') }}    @endsection
@section('header-title-one')   {{ trans('main_trans.period_types') }}   @endsection
@section('header-title-two')    {{ trans('main_trans.period_types') }}   @endsection

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ trans('main_trans.add_new_period_type') }}</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="post" action="{{route('period-types.store')}}" enctype="multipart/form-data">
            @include('period-types.form')
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" name="create">{{ trans('main_trans.submit') }}</button>
            </div>
        </form>
    </div>
@endsection
@section('scripts')

@endsection
