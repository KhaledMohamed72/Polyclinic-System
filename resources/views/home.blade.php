@extends('layouts.app')
@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection
@section('title')   Home    @endsection
@section('header-title')    Home   @endsection
@section('header-title-one')    Home    @endsection

@section('content')

        <div class="row">
            <div class="col-md-3">

                <div class="card overflow-hidden">
                    <div style="background-color: rgba(85, 110, 230, 0.25) !important">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-3">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p>Pulpo Clinic</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="{{asset('assets/dist/img/home-avatar.png')}}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
            </div>
                <div class="card card-white">
                    <div class="card-header mb-6">
                        <h3 class="card-title font-weight-bold">Monthly Earning</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="month_earring_rate"></div>
                            </div>
                            <div class="col-sm-12">
                                <p class="text-muted">This month</p>
                                <h3>{{$current_monthly_earrings}}£</h3>
                                <p class="text-muted">
                            <span class=" text-success  mr-2">
                                {{number_format($earring_percentage, 2, '.', '')}}% <i class="fa fa-arrow-up"></i>
                            </span>From previous month
                                </p>
                            </div>

                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-check-circle"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Appointments</span>
                                <span class="info-box-number">
                  {{$appointments_count}}
                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-calendar"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Today's Appt.</span>
                                <span class="info-box-number">{{$today_appointments_count}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Today's Earning</span>
                                <span class="info-box-number">{{$today_earrings}}£</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-blue elevation-1"><i class="fas fa-calendar-plus"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Tomorrow Appt.</span>
                                <span class="info-box-number">{{$tomorrow_appointments_count}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-white elevation-1"><i class="fas fa-calendar-week"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Upcoming Appt.</span>
                                <span class="info-box-number">{{$upcomming_appointments_count}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money-bill"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Revenue</span>
                                <span class="info-box-number">{{$revenue}}£</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div id="patients_rate"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div id="prescriptions_rate"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                            @if(\Jenssegers\Agent\Facades\Agent::isMobile())
                            &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-content-below-appointment-tab" data-toggle="pill"
                                   href="#custom-content-below-appointment" role="tab"
                                   aria-controls="custom-content-below-appointment" aria-selected="true">
                                    <span><i class="fa fa-user-plus"></i></span>&ensp;&ensp;
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-prescription-tab" data-toggle="pill"
                                   href="#custom-content-below-prescription" role="tab"
                                   aria-controls="custom-content-below-prescription" aria-selected="false">
                                    &ensp;&ensp;<span><i class="fa fa-file"></i></span>&ensp;&ensp;
                                </a>
                            </li>
                            {{--                            <li class="nav-item">
                                                            <a class="nav-link" id="custom-content-below-invoices-tab" data-toggle="pill"
                                                               href="#custom-content-below-invoices" role="tab"
                                                               aria-controls="custom-content-below-invoices" aria-selected="false">
                                                                &ensp;&ensp;<span><i class="fa fa-pen-square"></i></span>&ensp;
                                                            </a>
                                                        </li>--}}
                            @else
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-content-below-appointment-tab" data-toggle="pill"
                                       href="#custom-content-below-appointment" role="tab"
                                       aria-controls="custom-content-below-appointment" aria-selected="true">
                                        &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;Today's Appointment&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-content-below-prescription-tab" data-toggle="pill"
                                       href="#custom-content-below-prescription" role="tab"
                                       aria-controls="custom-content-below-prescription" aria-selected="false">
                                        &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;Prescription List&ensp;&ensp;&ensp;&ensp;&ensp;
                                    </a>
                                </li>
                                {{--                            <li class="nav-item">
                                                                <a class="nav-link" id="custom-content-below-invoices-tab" data-toggle="pill"
                                                                   href="#custom-content-below-invoices" role="tab"
                                                                   aria-controls="custom-content-below-invoices" aria-selected="false">
                                                                    &ensp;&ensp;&ensp;&ensp;Invoices&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
                                                                </a>
                                                            </li>--}}
                            @endif
                        </ul>
                        <div class="tab-content" id="custom-content-below-tabContent">
                            <div class="tab-pane fade show active" id="custom-content-below-appointment" role="tabpanel"
                                 aria-labelledby="custom-content-below-appointment-tab">
                                {{-- Appointment List table --}}
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <table id="" class="display table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Patient</th>
                                                        <th>Doctor</th>
                                                        <th>Phone</th>
                                                        <th>Date</th>
                                                        <th>time</th>
                                                        <th>status</th>
                                                        <th>action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($appointments as $row)
                                                        <tr>
                                                            <td>{{$row->id}}</td>
                                                            <td>{{$row->patient_name}}</td>
                                                            <td>{{$row->doctor_name}}</td>
                                                            <td>{{$row->phone}}</td>
                                                            <td>{{$row->date}}</td>
                                                            <td>{{date("g:i A", strtotime($row->time))}}</td>
                                                            <td>
                                                                @if($row->status == 'pending')
                                                                    <span class="badge badge-info">pending</span>
                                                                @elseif($row->status == 'cancel')
                                                                    <span class="badge badge-danger">cancel</span>
                                                                @elseif($row->status == 'complete')
                                                                    <span class="badge badge-primary">complete</span>
                                                                @else

                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($row->status == 'pending')
                                                                    @if(auth()->user()->hasRole('doctor'))
                                                                        <a class="btn btn-primary btn-sm"
                                                                           href="{{route('prescriptions.create') . '?date='. $row->date . '&patient_id=' . $row->patient_id}}"
                                                                           title="Complete">
                                                                            Create Prescription
                                                                        </a>
                                                                    @endif

                                                                    <a class="btn btn-danger btn-sm"
                                                                       href="{{route('cancel-action',$row->id)}}"
                                                                       title="Complete">
                                                                        Cancel
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                    </div>
                                </div>
                                {{-- End Appointment List table --}}
                            </div>
                            <div class="tab-pane fade" id="custom-content-below-prescription" role="tabpanel"
                                 aria-labelledby="custom-content-below-prescription-tab">
                                {{-- prescription List table --}}
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <table id="" class="display table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Patient</th>
                                                        <th>Doctor</th>
                                                        <th>Date</th>
                                                        <th>Time</th>
                                                        <th>action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($prescriptions as $row)
                                                        <tr>
                                                            <td>{{$row->id}}</td>
                                                            <td>{{$row->patient_name}}</td>
                                                            <td>{{$row->doctor_name}}</td>
                                                            <td>{{date('Y-m-d',strtotime($row->created_at))}}</td>
                                                            <td>{{date('h:i a',strtotime($row->created_at))}}</td>
                                                            <td class="project-actions text-left">
                                                                <a class="btn btn-primary btn-sm"
                                                                   href="{{route('prescriptions.show',$row->id)}}"
                                                                   title="View">
                                                                    <i class="fas fa-eye">
                                                                    </i>
                                                                </a>

                                                                @if(auth()->user()->hasRole('doctor'))
                                                                    <a class="btn btn-info btn-sm"
                                                                       href="{{route('prescriptions.edit',$row->id)}}"
                                                                       title="Edit">
                                                                        <i class="fas fa-pencil-alt">
                                                                        </i>
                                                                    </a>
                                                                    <form
                                                                        action="{{route('prescriptions.destroy',$row->id)}}"
                                                                        method="POST"
                                                                        style="display: contents;">
                                                                        {{ csrf_field() }}
                                                                        {{ method_field('delete') }}
                                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                                                href="#"
                                                                                title="Delete">
                                                                            <i class="fas fa-trash">
                                                                            </i>
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                    </div>
                                </div>
                                {{-- End Appointment List table --}}
                            </div>
                            {{--                        <div class="tab-pane fade" id="custom-content-below-invoices" role="tabpanel"
                                                         aria-labelledby="custom-content-below-invoices-tab">
                                                        --}}{{-- invoices List table --}}{{--
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="card">
                                                                    <!-- /.card-header -->
                                                                    <div class="card-body">
                                                                        <table id="example2" class="table table-bordered table-striped">
                                                                            <thead>
                                                                            <tr>
                                                                                <th>ID</th>
                                                                                <th>Patient Name</th>
                                                                                <th>Phone</th>
                                                                                <th>Email</th>
                                                                                <th>Date</th>
                                                                                <th>time</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <tr>
                                                                                <td>1</td>
                                                                                <td>test</td>
                                                                                <td>01128206779</td>
                                                                                <td>test@test.com</td>
                                                                                <td>12-5-2022</td>
                                                                                <td>09:00</td>
                                                                                <td>
                                                                                    <a class="btn btn-primary btn-sm" href="#" title="View">
                                                                                        <i class="fas fa-eye">
                                                                                        </i>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>1</td>
                                                                                <td>test</td>
                                                                                <td>01128206779</td>
                                                                                <td>test@test.com</td>
                                                                                <td>12-5-2022</td>
                                                                                <td>09:00</td>
                                                                                <td>
                                                                                    <a class="btn btn-primary btn-sm" href="#" title="View">
                                                                                        <i class="fas fa-eye">
                                                                                        </i>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>1</td>
                                                                                <td>test</td>
                                                                                <td>01128206779</td>
                                                                                <td>test@test.com</td>
                                                                                <td>12-5-2022</td>
                                                                                <td>09:00</td>
                                                                                <td>
                                                                                    <a class="btn btn-primary btn-sm" href="#" title="View">
                                                                                        <i class="fas fa-eye">
                                                                                        </i>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>1</td>
                                                                                <td>test</td>
                                                                                <td>01128206779</td>
                                                                                <td>test@test.com</td>
                                                                                <td>12-5-2022</td>
                                                                                <td>09:00</td>
                                                                                <td>
                                                                                    <a class="btn btn-primary btn-sm" href="#" title="View">
                                                                                        <i class="fas fa-eye">
                                                                                        </i>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>1</td>
                                                                                <td>test</td>
                                                                                <td>01128206779</td>
                                                                                <td>test@test.com</td>
                                                                                <td>12-5-2022</td>
                                                                                <td>09:00</td>
                                                                                <td>
                                                                                    <a class="btn btn-primary btn-sm" href="#" title="View">
                                                                                        <i class="fas fa-eye">
                                                                                        </i>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>1</td>
                                                                                <td>test</td>
                                                                                <td>01128206779</td>
                                                                                <td>test@test.com</td>
                                                                                <td>12-5-2022</td>
                                                                                <td>09:00</td>
                                                                                <td>
                                                                                    <a class="btn btn-primary btn-sm" href="#" title="View">
                                                                                        <i class="fas fa-eye">
                                                                                        </i>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>1</td>
                                                                                <td>test</td>
                                                                                <td>01128206779</td>
                                                                                <td>test@test.com</td>
                                                                                <td>12-5-2022</td>
                                                                                <td>09:00</td>
                                                                                <td>
                                                                                    <a class="btn btn-primary btn-sm" href="#" title="View">
                                                                                        <i class="fas fa-eye">
                                                                                        </i>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>1</td>
                                                                                <td>test</td>
                                                                                <td>01128206779</td>
                                                                                <td>test@test.com</td>
                                                                                <td>12-5-2022</td>
                                                                                <td>09:00</td>
                                                                                <td>
                                                                                    <a class="btn btn-primary btn-sm" href="#" title="View">
                                                                                        <i class="fas fa-eye">
                                                                                        </i>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <!-- /.card-body -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        --}}{{-- End Appointment List table --}}{{--
                                                    </div>--}}
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
@endsection
@section('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('table.display').DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                order: [[0, 'desc']]
            });
        });
    </script>
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
@endsection
