<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var months = ["{{ trans('main_trans.jun') }}", "{{ trans('main_trans.feb') }}", "{{ trans('main_trans.mar') }}", "{{ trans('main_trans.apr') }}", "{{ trans('main_trans.may') }}", "{{ trans('main_trans.jun') }}", "{{ trans('main_trans.jul') }}", "{{ trans('main_trans.aug') }}", "{{ trans('main_trans.sep') }}", "{{ trans('main_trans.oct') }}", "{{ trans('main_trans.nov') }}", "{{ trans('main_trans.dec') }}"];
        var data = google.visualization.arrayToDataTable([
            ['{{ trans('main_trans.month') }}', '{{ trans('main_trans.patients') }}'],
                @foreach($monthly_patients_counts as $row)
            [months[{{$row->month}} - 1], {{$row->count}}],
            @endforeach
        ]);

        var options = {
            title: '{{ trans('main_trans.patients_growth_rate') }}',
            legend: {position: 'bottom'}
        };

        var chart = new google.visualization.LineChart(document.getElementById('patients_rate'));

        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    google.charts.load('current', {'packages': ['bar']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var months = ["{{ trans('main_trans.jun') }}", "{{ trans('main_trans.feb') }}", "{{ trans('main_trans.mar') }}", "{{ trans('main_trans.apr') }}", "{{ trans('main_trans.may') }}", "{{ trans('main_trans.jun') }}", "{{ trans('main_trans.jul') }}", "{{ trans('main_trans.aug') }}", "{{ trans('main_trans.sep') }}", "{{ trans('main_trans.oct') }}", "{{ trans('main_trans.nov') }}", "{{ trans('main_trans.dec') }}"];
        var data = google.visualization.arrayToDataTable([
            ['{{ trans('main_trans.month') }}', '{{ trans('main_trans.prescriptions') }}'],
                @foreach($monthly_prescriptions_counts as $row)
            [months[{{$row->month}} - 1], {{$row->count}}],
            @endforeach
        ]);

        var options = {
            chart: {
                title: '{{ trans('main_trans.prescriptions_rate') }}',
            }
        };

        var chart = new google.charts.Bar(document.getElementById('prescriptions_rate'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>
<script type="text/javascript">
    google.charts.load("current", {packages: ["corechart"]});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['{{ trans('main_trans.month') }}', '{{ trans('main_trans.earning_per_month') }}'],
            ['{{ trans('main_trans.current_month') }}', {{$current_monthly_earrings}}],
            ['{{ trans('main_trans.last_month') }}', {{$last_monthly_earrings}}],
        ]);

        var options = {
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('month_earring_rate'));
        chart.draw(data, options);
    }
</script>
