<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
<div class="row">
    <h1 class="text-center mb-3" style="font-size: 25px;text-underline: transparent"><u>Expense Report</u></h1>
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
                <strong> نوع المصروف : </strong><span>{{$expense_name}}</span>
                <br>
            </div>
        </address>
    </div>
</div>

<div class="row" style="margin-top: 3rem">
    <div class="col-lg-12">
        <div class="card">

            <div class="card-body">
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                    <tr style="background-color: #b8daff;">
                        <th>#</th>
                        <th>التاريخ</th>
                        <th>الدكتور</th>
                        <th>الوصف</th>
                        <th>القيمة</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($expenses as $key => $row)
                    <tr>
                        <td>{{++ $key}}</td>
                        <td>{{date('Y-m-d',strtotime($row->date))}}</td>
                        <td>{{$row->doctor_name  ?? 'عام'}}</td>
                        <td>{{$row->note ?? '' }}</td>
                        <td>{{$row->amount}}</td>
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
            <strong> اجمالي القيمة  : </strong><span>{{$expenses_sum}}</span>
        </div>
    </div>
</div>
