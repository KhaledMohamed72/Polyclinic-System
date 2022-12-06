<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
<div class="row">
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
                <strong> الشركة : </strong><span>{{$company->name}}</span>
                <br>
                <strong> نسبة الخصم  : </strong><span>{{'%'.$company->discount_rate}}</span>
                <br>
                <strong> سعر الكشف قبل الخصم  : </strong><span>{{$doctor->examination_fees}}</span>
                <br>
                <strong> سعر الكشف بعد الخصم  : </strong><span>{{$doctor->examination_fees - ($doctor->examination_fees/100)*$company->discount_rate}}</span>
                <br>
                <strong> سعر الاعادة قبل الخصم  : </strong><span>{{$doctor->followup_fees}}</span>
                <br>
                <strong> سعر الاعادة بعد الخصم  : </strong><span>{{$doctor->followup_fees - ($doctor->followup_fees/100)*$company->discount_rate}}</span>
                <br>
            </div>
        </address>
    </div>
</div>

<div class="row" style="margin-top: 3rem">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h1>Prescriptions</h1>
            </div>
            <div class="card-body">
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>المريض</th>
                        <th>التاريخ</th>
                        <th>النوع</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($prescriptions as $prescription)
                    <tr>
                        <td>{{$prescription->id}}</td>
                        <td>{{$prescription->name}}</td>
                        <td>{{date('Y-m-d',strtotime($prescription->created_at))}}</td>
                        <td>{{$prescription->type == 0 ? 'كشف' : 'إعادة'}}</td>
                    </tr>
                    @endforeach
                    <hr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div dir="rtl">
            <strong> اجمالي الكشوفات  : </strong><span>{{$prescriptions_examination_count}}</span>
            <br>
            <strong> اجمالي الاعادة  : </strong><span>{{$prescriptions_followup_count}}</span>
        </div>
    </div>
</div>
@if(count($sessions))
<div class="row" style="margin-top: 3rem">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h1>Sessions</h1>
            </div>
            <div class="card-body">
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>المريض</th>
                        <th>التاريخ</th>
                        <th>النوع</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($sessions as $session)
                        <tr>
                            <td>{{$session->id}}</td>
                            <td>{{$session->patient_name}}</td>
                            <td>{{date('Y-m-d',strtotime($session->created_at))}}</td>
                            <td>{{$session->session_type}}</td>
                        </tr>
                    @endforeach
                    <hr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div dir="rtl">
            <strong> الاجمالي  : </strong><span>{{$sessions_count}}</span>
        </div>
    </div>
</div>
@endif
