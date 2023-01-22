<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="invoice-title">
                    <strong class="float-right font-size-16">Prescription #{{$prescription->id}}</strong>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4" style="direction: rtl">
                        <address>
                            <strong>المريض</strong>
                            <div>
                                <strong> الاسم : </strong><span>{{$patient->name}}</span>
                            </div>
                            <div>
                                <strong> التاريخ : </strong><span>{{$prescription->date}}</span>
                            </div>
                            <div>
                                <strong>  العنوان : </strong><span>{{$patient->address}}</span>
                            </div>
                        </address>
                    </div>
                </div>
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
                    <div class="row no-print">
                        <div class="col-md-12">
                            <div class="py-2 mt-3">
                                <h3 class="font-size-15 font-weight-bold">Attachments</h3>
                            </div>
                            @foreach($attachments as $row)
                                <a class="btn btn-default mt-2 mr-3" target="_blank"
                                   href="{{asset('images/prescriptions/'.$row->attachment)}}">
                                    <i class="fa fa-file"></i>{{' '.\Dotenv\Util\Str::substr($row->attachment,13,25)}}
                                </a>
                                <br>
                            @endforeach
                        </div>
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
