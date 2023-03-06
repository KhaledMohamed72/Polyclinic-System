@extends('layouts.app')
@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection
@section('title')   {{ trans('main_trans.reports') }}    @endsection
@section('header-title')    {{ trans('main_trans.reports') }}    @endsection
@section('header-title-one')    {{ trans('main_trans.reports') }}    @endsection
@section('header-title-two')    {{ trans('main_trans.main') }}   @endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline card-tabs">
                <div class="card-header p-0 pt-1 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                        {{-- patient history --}}
                        @if(auth()->user()->hasRole(['admin','recep','doctor']))
                            {{-- Patient history --}}
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-three-patient-history-tab" data-toggle="pill"
                                   href="#custom-tabs-three-patient-history" role="tab"
                                   aria-controls="custom-tabs-three-patient-history" aria-selected="false">{{ trans('main_trans.patient_history') }}</a>
                            </li>
                            {{-- Doctor history --}}
                            <li class="nav-item">
                                <a class="nav-link"
                                   id="custom-tabs-three-doctor-history-tab" data-toggle="pill"
                                   href="#custom-tabs-three-doctor-history" role="tab"
                                   aria-controls="custom-tabs-three-doctor-history" aria-selected="true">{{ trans('main_trans.doctor_history') }}</a>
                            </li>
                            {{--Insurance Companies--}}
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-three-patient-insurance_company-tab"
                                   data-toggle="pill"
                                   href="#custom-tabs-three-insurance_company" role="tab"
                                   aria-controls="custom-tabs-three-insurance_company" aria-selected="false">{{ trans('main_trans.insurance_companies') }}</a>
                            </li>
                            {{--Income--}}
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-three-income-tab" data-toggle="pill"
                                   href="#custom-tabs-three-income" role="tab"
                                   aria-controls="custom-tabs-three-income" aria-selected="false">
                                    {{ trans('main_trans.income_report') }}</a>
                            </li>
                            {{--Expenses--}}
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-three-expenses-tab" data-toggle="pill"
                                   href="#custom-tabs-three-expenses" role="tab"
                                   aria-controls="custom-tabs-three-expenses" aria-selected="false">
                                    {{ trans('main_trans.expenses_report') }}</a>
                            </li>
                        @endif
                        @if(auth()->user()->hasRole(['admin','doctor']))
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-three-profit-tab" data-toggle="pill"
                                   href="#custom-tabs-three-profit" role="tab"
                                   aria-controls="custom-tabs-three-profit" aria-selected="false">
                                    {{ trans('main_trans.profit_report') }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-three-tabContent">
                        {{-- patient-history--}}
                        @if(auth()->user()->hasRole(['admin','recep','doctor']))
                            <div class="tab-pane fade active show" id="custom-tabs-three-patient-history"
                                 role="tabpanel" aria-labelledby="custom-tabs-three-patient-history-tab">
                                <form method="get" action="{{route('patient-history')}}">
                                    @include('reports.forms.patient-history-form')
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary float-right"
                                                name="get-patient-history">{{ trans('main_trans.submit') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                            {{-- Doctor history --}}
                            <div class="tab-pane fade" id="custom-tabs-three-doctor-history" role="tabpanel"
                                 aria-labelledby="custom-tabs-three-doctor-history-tab">
                                <form method="get" action="{{route('doctor-history')}}">
                                    @include('reports.forms.doctor-history-form')
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary float-right"
                                                name="get-doctor-history">
                                            {{ trans('main_trans.submit') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                            {{-- Insurance company --}}
                            <div class="tab-pane fade" id="custom-tabs-three-insurance_company" role="tabpanel"
                                 aria-labelledby="custom-tabs-three-insurance_company-tab">
                                <form method="get" action="{{route('insurance_company')}}">
                                    @include('reports.forms.insurance-company-form')
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary float-right"
                                                name="get-insurance_company">
                                            {{ trans('main_trans.submit') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                            {{-- Income --}}
                            <div class="tab-pane fade" id="custom-tabs-three-income" role="tabpanel"
                                 aria-labelledby="custom-tabs-three-income-tab">
                                <form method="get" action="{{route('incomes_report')}}">
                                    @include('reports.forms.income-form')
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary float-right" name="get-insurance_company">
                                            {{ trans('main_trans.submit') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                            {{-- Expenses --}}
                            <div class="tab-pane fade" id="custom-tabs-three-expenses" role="tabpanel"
                                 aria-labelledby="custom-tabs-three-expenses-tab">
                                <form method="get" action="{{route('expenses_report')}}">
                                    @include('reports.forms.expense-form')
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary float-right"
                                                name="get-insurance_company">
                                            {{ trans('main_trans.submit') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                        @if(auth()->user()->hasRole(['admin','doctor']))
                            {{-- Expenses --}}
                            <div class="tab-pane fade" id="custom-tabs-three-profit" role="tabpanel"
                                 aria-labelledby="custom-tabs-three-profit-tab">
                                <form method="get" action="{{route('profit_report')}}">
                                    @include('reports.forms.profit-form')
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary float-right"
                                                name="get-profit">
                                            {{ trans('main_trans.submit') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- Select2 -->
    <script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
@endsection
