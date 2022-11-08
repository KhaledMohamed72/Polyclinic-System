@extends('layouts.app')
@section('styles')

@endsection
@section('title')   Expense Types    @endsection
@section('header-title')    Expense Types    @endsection
@section('header-title-one')    Expense Types    @endsection
@section('header-title-two')    Create   @endsection

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Add New Expense Type</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="post" action="{{route('expense-types.store')}}" enctype="multipart/form-data">
            @include('expense-types.form')
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" name="create">Submit</button>
            </div>
        </form>
    </div>
@endsection
@section('scripts')

@endsection
