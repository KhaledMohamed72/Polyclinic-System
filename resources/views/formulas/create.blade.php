@extends('layouts.app')
@section('styles')

@endsection
@section('title')   {{ trans('main_trans.formulas') }}    @endsection
@section('header-title')    {{ trans('main_trans.formulas') }}    @endsection
@section('header-title-one')    {{ trans('main_trans.formulas') }}    @endsection
@section('header-title-two')    {{ trans('main_trans.create') }}   @endsection

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ trans('main_trans.add_new_formula') }}</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="post" action="{{route('formulas.store')}}" enctype="multipart/form-data">
            @include('formulas.form')
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" name="create">{{ trans('main_trans.submit') }}</button>
            </div>
        </form>
    </div>
@endsection
@section('scripts')

@endsection
