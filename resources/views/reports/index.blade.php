@extends('layouts.app')
@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection
@section('title')   Reports    @endsection
@section('header-title')    Reports    @endsection
@section('header-title-one')    Reports    @endsection
@section('header-title-two')    Main   @endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline card-tabs">
                <div class="card-header p-0 pt-1 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                        {{-- patient history --}}
                        @if(auth()->user()->hasRole('doctor'))
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-three-patient-history-tab" data-toggle="pill"
                                   href="#custom-tabs-three-patient-history" role="tab"
                                   aria-controls="custom-tabs-three-patient-history" aria-selected="false">Patient
                                    History</a>
                            </li>
                        @endif
                        {{-- Doctor history --}}
                        @if(auth()->user()->hasRole(['admin','doctor']))
                            <li class="nav-item">
                                <a class="nav-link {{auth()->user()->hasRole('admin') ? 'active' : ''}}" id="custom-tabs-three-doctor-history-tab" data-toggle="pill"
                                   href="#custom-tabs-three-doctor-history" role="tab"
                                   aria-controls="custom-tabs-three-doctor-history" aria-selected="true">Doctor
                                    History</a>
                            </li>
                        @endif
                        {{--Insurance Companies--}}
                        @if(auth()->user()->hasRole('doctor'))
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-three-patient-care-company-tab" data-toggle="pill"
                                   href="#custom-tabs-three-care-company" role="tab"
                                   aria-controls="custom-tabs-three-care-company" aria-selected="false">Insurance Companies</a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-three-tabContent">
                        {{-- patient-history--}}
                        @if(auth()->user()->hasRole('doctor'))
                            <div class="tab-pane fade active show" id="custom-tabs-three-patient-history"
                                 role="tabpanel" aria-labelledby="custom-tabs-three-patient-history-tab">
                                <form method="get" action="{{route('patient-history')}}">
                                    @include('reports.forms.patient-history-form')
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary float-right"
                                                name="get-patient-history">Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                        {{-- Doctor history --}}
                        @if(auth()->user()->hasRole(['admin','doctor']))
                            <div class="tab-pane fade {{auth()->user()->hasRole('admin') ? 'active show' : ''}}" id="custom-tabs-three-doctor-history" role="tabpanel"
                                 aria-labelledby="custom-tabs-three-doctor-history-tab">
                                <form method="get" action="{{route('doctor-history')}}">
                                    @include('reports.forms.doctor-history-form')
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary float-right"
                                                name="get-doctor-history">
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                        @if(auth()->user()->hasRole('doctor'))
                            <div class="tab-pane fade" id="custom-tabs-three-care-company" role="tabpanel"
                                 aria-labelledby="custom-tabs-three-care-company-tab">
                                <form method="get" action="{{route('care-company')}}">
                                    @include('reports.forms.care-company-form')
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary float-right"
                                                name="get-care-company">
                                            Submit
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
