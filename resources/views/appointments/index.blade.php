@extends('layouts.app')
@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <!-- fullCalendar -->
    <link rel="stylesheet" href="{{asset('assets/fullcalender/lib/main.css')}}">

    <script src="{{asset('assets/fullcalender/lib/main.js')}}"></script>
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script>

        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                scrollTime: '00:00', // undo default 6am scrollTime
                editable: false, // enable draggable events
                selectable: true,
                height: 650,
                aspectRatio: 1.8,
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'timeGridWeek,dayGridMonth,dayGridDay'
                },
                events: '{{route('get-all-appointments')}}',

                dateClick: function (info) {
                    function tConvert(time) {
                        // Check correct time format and split into components
                        time = time.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

                        if (time.length > 1) { // If time format correct
                            time = time.slice(1);  // Remove full string match value
                            time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
                            time[0] = +time[0] % 12 || 12; // Adjust hours
                        }
                        return time.join(''); // return adjusted time or original string
                    }

                    var dd = info.date;
                    var role = "<?php echo auth()->user()->hasRole(['admin','recep']) ?>";
                    console.log(role);
                    var date = dd.toLocaleDateString('en-CA');
                    $('#selected_date').html(date);
                    $('#new_list').hide();
                    $('#new_list').show();
                    $('#no_list').empty();
                    $.ajax({
                        type: "GET",
                        url: "{{url('/appointment/get-appointments-per-date?date=')}}" + date,
                        dataType: 'json',
                        success: function (response, textStatus, xhr) {
                            if (response == '') {
                                $('#new_list').empty();
                                $('#no_list').append('No Available Appointments')
                            } else {
                                $('#new_list').empty();
                                $('#no_list').empty();
                                for (let i = 0; i < response.length; i++) {
                                    url = "{{route('prescriptions.create')}}" + "?date=" + response[i].date + "&patient_id=" + response[i].patient_id
                                    link = "<a href="+url+" class='btn btn-info btn-sm' title='Create Prescription'><i class='fas fa-file'></i></a>";
                                    // if role is admin or receptionist show doctor name in appointments table else don't show doctor name in appointments table
                                    if(role == 1) {
                                        $('#new_list').append(
                                            '<tr>' +
                                            '<td>' + response[i].id + '</td>' +
                                            '<td>' + response[i].patient_name + '</td>' +
                                            '<td>' + response[i].doctor_name + '</td>' +
                                            '<td>' + tConvert(response[i].time) + '</td>' +
                                            '<td>' +
                                            link
                                            + '</td>' +
                                            '</tr>'
                                        );
                                    }else{
                                        $('#new_list').append(
                                            '<tr>' +
                                            '<td>' + response[i].id + '</td>' +
                                            '<td>' + response[i].patient_name + '</td>' +
                                            '<td>' + tConvert(response[i].time) + '</td>' +
                                            '<td>' +
                                            link
                                            + '</td>' +
                                            '</tr>'
                                        );
                                    }
                                }
                            }
                        },
                        error: function () {
                            console.log('Errors...Something went wrong!!!!');
                        }
                    });
                }
            });
            calendar.changeView('dayGridMonth');
            calendar.render();
        });
    </script>
    <style>
        .fc .fc-toolbar-title {
            font-size: smaller;
            margin-left: 5px;
        }

        .fc .fc-button-group {
            font-size: smaller;
        }
    </style>
@endsection
@section('title')   Appointments    @endsection
@section('header-title')    Appointments    @endsection
@section('header-title-one')    Appointments    @endsection
@section('header-title-two')    Calender   @endsection

@section('content')
    @if(\Jenssegers\Agent\Facades\Agent::isMobile())
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-6 float-right">
                            <a href="{{route('appointments.create')}}" class="btn btn-block bg-gradient-success">Add
                                Appointment</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="appointment_list">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Patient</th>
                                    @if(auth()->user()->hasRole(['admin','recep']))
                                        <th>doctor</th>
                                    @endif
                                    <th>Time</th>
                                    <th>action</th>
                                </tr>
                                </thead>
                                <tbody id="new_list">
                                @foreach($rows as $row)
                                    <tr>
                                        <td>{{$row->id}}</td>
                                        <td> {{$row->patient_name}}</td>
                                        @if(auth()->user()->hasRole(['admin','recep']))
                                            <td>{{$row->doctor_name}}</td>
                                        @endif
                                        <td>{{date("g:i a", strtotime($row->time))}}</td>
                                        <td><a href="{{route('prescriptions.create') . '?date='. $row->date . '&patient_id=' . $row->patient_id}}" class="btn btn-info btn-sm" title="create prescription"><i class="fas fa-file"></i></a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div id="no_list"></div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.col -->
            </div>
        </div>

    @else
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-6 float-right">
                            <a href="{{route('appointments.create')}}" class="btn btn-block bg-gradient-success">Add
                                Appointment</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <h4 class="card-title mb-4">Appointment List | <label
                                id="selected_date">{{date("Y-m-d")}}</label>
                        </h4>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Patient</th>
                                @if(auth()->user()->hasRole(['admin','recep']))
                                <th>doctor</th>
                                @endif
                                <th>Time</th>
                                <th>action</th>
                            </tr>
                            </thead>
                            <tbody id="new_list">
                            <tr>
                            @foreach($rows as $row)
                                <tr>
                                    <td>{{$row->id}}</td>
                                    <td> {{$row->patient_name}}</td>
                                    @if(auth()->user()->hasRole(['admin','recep']))
                                    <td>{{$row->doctor_name}}</td>
                                    @endif
                                    <td>{{date("g:i a", strtotime($row->time))}}</td>
                                    <td><a href="{{route('prescriptions.create') . '?date='. $row->date . '&patient_id=' . $row->patient_id}}" class="btn btn-info btn-sm" title="create prescription"><i class="fas fa-file"></i></a></td>
                                </tr>
                                @endforeach
                                </tr>

                            </tbody>

                        </table>
                        <div id="no_list" class="text-center"></div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
    @endif
    <!-- /.row -->
@endsection
@section('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <!-- jQuery UI -->
    <script src="{{asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- fullCalendar 2.2.5 -->
    <script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('assets/fullcalender/lib/main.js')}}"></script>

    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"], order: [[0, 'desc']],
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });

        $(function () {

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {


                scrollTime: '00:00', // undo default 6am scrollTime
                editable: false, // enable draggable events
                selectable: true,
                height: 650,
                aspectRatio: 1.8,
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'timeGridWeek,dayGridMonth,listWeek'
                },

                initialView: 'dayGridMonth',

                events: '{{route('get-all-appointments')}}',
            });
            dateClick: function ss(info) {
                alert('ddddddd');
            }
            calendar.render();

        })
    </script>
@endsection
