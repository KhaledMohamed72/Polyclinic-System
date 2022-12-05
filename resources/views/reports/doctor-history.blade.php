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
                <strong> الطبيب : </strong><span>{{$doctor->name}}</span>
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
                    <tr>
                        <th>#</th>
                        <th>Number</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Prescriptions</td>
                        <td>{{$prescriptions_count}}</td>
                        <td>{{$prescriptions_fees_sum}}</td>
                    </tr>
                    @if(isset($sessions_count))
                        <tr>
                            <td>Sessions</td>
                            <td>{{$sessions_count}}</td>
                            <td>{{$sessions_fees_sum}}</td>
                        </tr>
                    @endif
                    @if(isset($incomes_count))
                    <tr>
                        <td>Incomes</td>
                        <td>{{$incomes_count}}</td>
                        <td>{{$incomes_fees_sum}}</td>
                    </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
