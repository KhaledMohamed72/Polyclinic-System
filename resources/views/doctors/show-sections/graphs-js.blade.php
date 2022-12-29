<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var months = ["jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec"];
        var data = google.visualization.arrayToDataTable([
            ['Month', 'Patients'],
                @foreach($monthly_patients_counts as $row)
            [months[{{$row->month}}-1], {{$row->count}}],
            @endforeach
        ]);

        var options = {
            title: 'patients growth rate',
            legend: { position: 'bottom' }
        };
        var chart = new google.visualization.LineChart(document.getElementById('patients_rate'));

        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var months = ["jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec"];
        var data = google.visualization.arrayToDataTable([
            ['Month', 'Prescriptions'],
                @foreach($monthly_prescriptions_counts as $row)
            [months[{{$row->month}}-1], {{$row->count}}],
            @endforeach
        ]);

        var options = {
            chart: {
                title: 'prescriptions rate',
            }
        };

        var chart = new google.charts.Bar(document.getElementById('prescriptions_rate'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>
<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Month', 'Earring per Month'],
            ['Current Month', {{$current_monthly_earrings}}],
            ['last Month', {{$last_monthly_earrings}}],
        ]);

        var options = {
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('month_earring_rate'));
        chart.draw(data, options);
    }
</script>
