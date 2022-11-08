@extends('layouts.app')
@section('styles')

@endsection
@section('title')   Formulas    @endsection
@section('header-title')    Formulas    @endsection
@section('header-title-one')    Formulas    @endsection
@section('header-title-two')    Create   @endsection

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Add New Formula</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="post" action="{{route('formulas.store')}}" enctype="multipart/form-data">
            @include('formulas.form')
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" name="create">Submit</button>
            </div>
        </form>
    </div>
@endsection
@section('scripts')

@endsection
