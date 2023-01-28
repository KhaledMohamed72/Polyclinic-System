<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
<div class="row">
    <h1 class="text-center mb-3" style="font-size: 25px;text-underline: transparent"><u>Patient History Report</u></h1>
    <div class="card">
        @if(request()->get('from') != null)
            <div class="card-title text-center mt-2">
                <h5>
                    <span>{{request()->get('to').' '}}</span><span>تقرير من  </span><span>{{request()->get('from').' '}}</span><span>الي</span>
                </h5>
            </div>
        @endif
    </div>
</div>
<div class="row">
    <div class="text-center" style="direction: rtl">
        <address>
            <div>
                <strong> المريض : </strong><span>{{$patient->name}}</span>
            </div>
            <div>
                <strong> العنوان : </strong><span>{{$patient->address}}</span>
            </div>
            <div>
                <strong> التليفون : </strong><span>{{$patient->phone}}</span>
            </div>
        </address>
    </div>
</div>
@foreach($prescriptions as $prescription)
    <div class="row" style="margin-top: 3rem">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <tbody>
                        <tr style="background-color: #b8daff;">
                            <td><strong class="font-size-16">Prescription #{{$prescription->id}}</strong></td>
                            <td><strong> التاريخ
                                    : </strong><span>{{date('Y-m-d',strtotime($prescription->created_at))}}</span>
                            </td>
                            <td><strong> النوع : </strong><span>{{$prescription->type == 0 ? 'كشف' : 'اعادة'}}</span>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                    @php
                        $medicines = \Illuminate\Support\Facades\DB::table('prescription_medicines')
                            ->leftjoin('frequency_types', 'frequency_types.id', '=', 'prescription_medicines.frequency_type_id')
                            ->leftjoin('period_types', 'period_types.id', '=', 'prescription_medicines.period_type_id')
                            ->where('prescription_medicines.prescription_id', $prescription->id)
                            ->select('prescription_medicines.name as medicine_name'
                                , 'frequency_types.ar_name as frequency_name',
                                'period_types.ar_name as period_name'
                            )->get();

                        $tests = \Illuminate\Support\Facades\DB::table('prescription_tests')
                            ->where('prescription_tests.prescription_id', $prescription->id)
                            ->get();
                        $formulas = \Illuminate\Support\Facades\DB::table('prescription_formulas')
                            ->leftjoin('formulas', 'formulas.id', '=', 'prescription_formulas.formula_id')
                            ->leftjoin('frequency_types', 'frequency_types.id', '=', 'prescription_formulas.frequency_type_id')
                            ->where('prescription_formulas.prescription_id', $prescription->id)
                            ->select('formulas.name as formula_name'
                                , 'frequency_types.ar_name as frequency_name',
                            )->get();
                        $attachments =  \Illuminate\Support\Facades\DB::table('prescription_attachments')
                            ->where('prescription_id', $prescription->id)
                            ->get();
                    @endphp
                    @if(!$medicines->isEmpty())
                        <div class="row">
                            <div class="col-md-12">
                                <div class="py-2 mt-3">
                                    <h3 class="font-size-15 font-weight-bold"><u>Medicines</u></h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        @foreach($medicines as $row)
                                            <tr>
                                                <td>{{$row->medicine_name}}</td>
                                                <td>{{$row->frequency_name ?? ''}}</td>
                                                <td>{{$row->period_name ?? ''}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(!$tests->isEmpty())
                        <div class="row">
                            <div class="col-md-12">
                                <div class="py-2 mt-3">
                                    <h3 class="font-size-15 font-weight-bold"><u>Test Reports</u></h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        @foreach($tests as $row)
                                            <tr>
                                                <td>{{$row->name}}</td>
                                                <td>{{$row->note}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(!$formulas->isEmpty())
                        <div class="row">
                            <div class="col-md-12">
                                <div class="py-2 mt-3">
                                    <h3 class="font-size-15 font-weight-bold"><u>Formulas</u></h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        @foreach($formulas as $row)
                                            <tr>
                                                <td>{{$row->formula_name}}</td>
                                                <td>{{$row->frequency_name ?? ''}}</td>
                                                <td>{{$row->period_name ?? ''}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(!$attachments->isEmpty())
                        <div class="row">
                            <div class="col-md-12">
                                <div class="py-2 mt-3">
                                    <h3 class="font-size-15 font-weight-bold"><u>Attachments</u></h3>
                                </div>
                                @foreach($attachments as $row)
                                    <a style="color: blue" target="_blank"
                                       href="{{asset('images/prescriptions/'.$row->attachment)}}">
                                        <i class="fa fa-file"></i>{{' '.\Dotenv\Util\Str::substr($row->attachment,13,25)}}
                                    </a>
                                    <br>
                                    <br>
                                @endforeach
                            </div>
                            @endif
                            @if($prescription->note != '')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="py-2 mt-3">
                                            <h3 class="font-size-15 font-weight-bold"><u>Notes</u></h3>
                                        </div>
                                        <p>{{$prescription->note}}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                </div>
            </div>
        </div>
        @endforeach
        <hr>
        @foreach($sessions as $session)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-title">
                        </div>
                        <div class="card-body">
                            <div class="card-header">
                                <table class="table">
                                    <tbody>
                                    <tr style="background-color: #b8daff;">
                                        <td><strong class="font-size-16">Session #{{$session->id}}</strong></strong>
                                        </td>
                                        <td><strong> التاريخ
                                                : </strong><span>{{date('Y-m-d',strtotime($session->created_at))}}</span></span>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <td>{{$session->session_name}}</td>
                                                <td>{{$session->note ?? ''}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endforeach
