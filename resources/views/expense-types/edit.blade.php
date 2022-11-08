@extends('layouts.app')
@section('styles')

@endsection
@section('title')   Expense Types    @endsection
@section('header-title')    Expense Types    @endsection
@section('header-title-one')    Expense Types    @endsection
@section('header-title-two')    Edit   @endsection
@section('styles')

@endsection
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Expense Type</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->

        <form method="POST" action="{{route('expense-types.update' , $row->id)}}">
            {{ method_field('put') }}
            @include('expense-types.form')
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" name="update">Submit</button>
            </div>
        </form>
    </div>

@endsection
@section('scripts')

@endsection
