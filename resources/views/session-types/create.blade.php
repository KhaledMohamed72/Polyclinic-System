@extends('layouts.app')
@section('styles')

@endsection
@section('title')   Session Types    @endsection
@section('header-title')    Session Types    @endsection
@section('header-title-one')    Session Types    @endsection
@section('header-title-two')    Create   @endsection

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Add New Session Type</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="post" action="{{route('session-types.store')}}" enctype="multipart/form-data">
            @include('session-types.form')
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" name="create">Submit</button>
            </div>
        </form>
    </div>
@endsection
@section('scripts')

@endsection
