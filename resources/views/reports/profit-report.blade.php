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
@section('title')   Profit Report    @endsection
@section('header-title')    Profit Report   @endsection
@section('header-title-one')    Reports    @endsection
@section('header-title-two')    Profit   @endsection

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
                <h2><u>Profit Report</u></h2>
                @if(request()->get('doctor') != null)
                    <p>
                         Doctor: <strong>{{$doctor}}</strong>
                    </p>
                @endif
                @if(request()->get('from') != null)
                    <p>
                        <strong>{{request()->get('to').' '}}</strong><span> من  </span><strong>{{request()->get('from').' '}}</strong><span>الي</span>
                    </p>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-bold"><u>Incomes</u></h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>النوع</th>
                            @if(auth()->user()->hasRole('admin') && $clinicType == 1)
                                <th>الدكتور</th>
                            @endif
                            <th>التاريخ</th>
                            <th>القيمة</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($incomes as $key => $row)
                            <tr>
                                <td>{{++ $key}}</td>
                                <td>{{$row->name}}</td>
                                @if(auth()->user()->hasRole('admin') && $clinicType == 1)
                                    <td>{{$row->doctor_name  ?? 'عام'}}</td>
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
                            <strong> الإجمالي :&ensp;£</strong>&ensp;<span>{{$incomes_sum}}&ensp;</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-bold"><u>Expenses</u></h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>النوع</th>
                            @if(auth()->user()->hasRole('admin') && $clinicType == 1)
                                <th>الدكتور</th>
                            @endif
                            <th>التاريخ</th>
                            <th>القيمة</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($expenses as $key => $row)
                            <tr>
                                <td>{{++ $key}}</td>
                                <td>{{$row->name}}</td>
                                @if(auth()->user()->hasRole('admin') && $clinicType == 1)
                                    <td>{{$row->doctor_name  ?? 'عام'}}</td>
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
                            <strong> الإجمالي :&ensp;£</strong>&ensp;<span>{{$expenses_sum}}&ensp;</span>
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
                    <h3 class="card-title text-bold"><u>Prescriptions</u></h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>النوع</th>
                            <th>العدد</th>
                            <th>الاجمالي</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>الكشوفات</td>
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
                            <strong> الإجمالي :&ensp;£</strong>&ensp;<span>{{$prescriptions_total_sum}}&ensp;</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-bold"><u>Sessions</u></h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>النوع</th>
                            <th>العدد</th>
                            <th>الاجمالي</th>
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
                            <strong> الإجمالي :&ensp;£</strong>&ensp;<span>{{$incomes_sum}}&ensp;</span>
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
                    <h3 class="card-title text-bold"><u>Profit</u></h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>إجمالي الكشوفات</th>
                            <th>إجمالي الجلسات</th>
                            <th><small>(incomes)</small>إجمالي الدخل</th>
                            <th>إجمالي المصروفات</th>
                            <th>صافي الأرباح</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-center">
                            <td>{{$prescriptions_total_sum}}</td>
                            <td>{{$sessions_sum}}</td>
                            <td>{{$incomes_sum}}</td>
                            <td>{{$expenses_sum}}</td>
                            <td>{{($prescriptions_total_sum+$sessions_sum+$incomes_sum)-($expenses_sum).' £'}}</td>
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


