@extends('layouts.app')
@section('styles')
    <style>
        @media print {
            .no-print, .no-print * {
                display: none !important;
            }
        }
    </style>
@endsection
@section('title')   {{ trans('main_trans.profit_report') }}    @endsection
@section('header-title')    {{ trans('main_trans.profit_report') }}   @endsection
@section('header-title-one')    {{ trans('main_trans.reports') }}    @endsection
@section('header-title-two')    {{ trans('main_trans.profit_report') }}   @endsection

@section('content')
    <div class="row d-print-none">
        <div class="col-12">
            <div class="text-center">
                <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light mb-4 ml-3"
                   title="Print">
                    <i class="fa fa-print"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="text-center">
                <h2><u>{{ trans('main_trans.profit_report') }}</u></h2>
                @if(request()->get('doctor') != null)
                    <p>
                        {{ trans('main_trans.doctor') }}: <strong>{{$doctor}}</strong>
                    </p>
                @endif
                @if(request()->get('from') != null)
                    <p>
                        <span>{{ trans('main_trans.from') . " "}}</span><strong>{{request()->get('to').' '}}</strong><span>{{ trans('main_trans.to')." " }}</span><strong>{{request()->get('from').' '}}</strong>
                    </p>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-bold"><u>{{ trans('main_trans.incomes')}}</u></h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('main_trans.type') }}</th>
                            @if(auth()->user()->hasRole('admin') && $clinicType == 1)
                                <th>{{ trans('main_trans.doctor') }}</th>
                            @endif
                            <th>{{ trans('main_trans.date') }}</th>
                            <th>{{ trans('main_trans.value') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($incomes as $key => $row)
                            <tr>
                                <td>{{++ $key}}</td>
                                <td>{{$row->name}}</td>
                                @if(auth()->user()->hasRole('admin') && $clinicType == 1)
                                    <td>{{$row->doctor_name  ?? trans('main_trans.general')}}</td>
                                @endif
                                <td>{{date('Y-m-d',strtotime($row->date))}}</td>
                                <td>{{$row->amount.' £'}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12 text-right text-bold mr-2">
                        <div class="col-md-8"></div>
                        <div class="col-md-4 float-right bg-secondary p-2">
                            <strong> {{ trans('main_trans.total') }} :&ensp;£</strong>&ensp;<span>{{$incomes_sum}}&ensp;</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-bold"><u>{{ trans('main_trans.expenses') }}</u></h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('main_trans.type') }}</th>
                            @if(auth()->user()->hasRole('admin') && $clinicType == 1)
                                <th>{{ trans('main_trans.doctor') }}</th>
                            @endif
                            <th>{{ trans('main_trans.date') }}</th>
                            <th>{{ trans('main_trans.value') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($expenses as $key => $row)
                            <tr>
                                <td>{{++ $key}}</td>
                                <td>{{$row->name}}</td>
                                @if(auth()->user()->hasRole('admin') && $clinicType == 1)
                                    <td>{{$row->doctor_name  ?? trans('main_trans.general')}}</td>
                                @endif
                                <td>{{date('Y-m-d',strtotime($row->date))}}</td>
                                <td>{{$row->amount.' £'}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12 text-right text-bold mr-2">
                        <div class="col-md-8"></div>
                        <div class="col-md-4 float-right bg-secondary p-2">
                            <strong> {{ trans('main_trans.total') }} :&ensp;£</strong>&ensp;<span>{{$expenses_sum}}&ensp;</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-bold"><u>{{ trans('main_trans.prescriptions') }}</u></h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>{{ trans('main_trans.type') }}</th>
                            <th>{{ trans('main_trans.count') }}</th>
                            <th>{{ trans('main_trans.total') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ trans('main_trans.prescriptions') }}</td>
                            <td>{{$prescriptions_examination_count}}</td>
                            <td>
                                <bold>{{$prescriptions_examination_sum.' £'}}</bold>
                            </td>
                        </tr>
                        <tr>
                            <td>الاعادة</td>
                            <td>{{$prescriptions_followup_count}}</td>
                            <td>
                                <bold>{{$prescriptions_followup_sum.' £'}}</bold>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12 text-right text-bold mr-2">
                        <div class="col-md-7"></div>
                        <div class="col-md-5 float-right bg-secondary p-2">
                            <strong> {{ trans('main_trans.total') }} :&ensp;£</strong>&ensp;<span>{{$prescriptions_total_sum}}&ensp;</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-bold"><u>{{ trans('main_trans.sessions') }}</u></h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>{{ trans('main_trans.type') }}</th>
                            <th>{{ trans('main_trans.count') }}</th>
                            <th>{{ trans('main_trans.total') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sessions as $row)
                            <tr>
                                <td>{{$row->session_type_name}}</td>
                                <td>{{$row->sessions_count}}</td>
                                <td>
                                    <bold>{{$row->fees.' £'}}</bold>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12 text-right text-bold mr-2">
                        <div class="col-md-8"></div>
                        <div class="col-md-4 float-right bg-secondary p-2">
                            <strong> {{ trans('main_trans.total') }} :&ensp;£</strong>&ensp;<span>{{$sessions_sum}}&ensp;</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-bold"><u>{{ trans('main_trans.profit') }}</u></h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>{{ trans('main_trans.total_prescriptions') }}</th>
                            <th>{{ trans('main_trans.total_sessions') }}</th>
                            <th>{{ trans('main_trans.total_incomes') }}</th>
                            <th>{{ trans('main_trans.total_expenses') }}</th>
                            <th>{{ trans('main_trans.net_profit') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-center">
                            <td>{{$prescriptions_total_sum ?? 0 }}</td>
                            <td>{{$sessions_sum ?? 0 }}</td>
                            <td>{{$incomes_sum ?? 0 }}</td>
                            <td>{{$expenses_sum ?? 0}}</td>
                            <td>{{($prescriptions_total_sum+$sessions_sum+$incomes_sum)-($expenses_sum).' £' ?? 0}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>

@endsection
@section('scripts')
@endsection


