@extends('layouts.app')
@section('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection
@section('title')   Appointments    @endsection
@section('header-title')    Appointments   @endsection
@section('header-title-one')    Appointments    @endsection
@section('header-title-two')    Create   @endsection

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <div class="card-title">Book Appointment</div>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="post" action="{{route('appointments.store')}}">
            @include('appointments.form')
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" name="create">Submit</button>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <!-- Select2 -->
    <script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            // convert 24hrs to 12hrs
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

            $(document).on('change', '#doctor', function () {
                $('#date').val('');
                $('.available_time').empty();
                $('.available_slot').empty();
            });

            $('#date').on('change', function () {
                var date = $('#date').val();
                $('.available_time').empty();
                // detect the name of day from given date
                var days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                var d = new Date(date);
                var dayName = days[d.getDay()];
                var has_one_doctor_id = $("#has_one_doctor_id").val();
                var doctor_id = $("#doctor").val();
                var sel_doctor_id = '';
                if (has_one_doctor_id) {
                    sel_doctor_id = has_one_doctor_id;
                } else {
                    sel_doctor_id = doctor_id;
                }
                if (sel_doctor_id) {
                    $.ajax({
                        url: "{{ url('/appointment/get_available_time') }}" + "?doctor_id=" + sel_doctor_id + "&day=" + dayName,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            if (data == '') {
                                $('.available_time').append(
                                    '<span class="badge-warning">Doctor is not available in this day !</span>'
                                );
                            }
                            $.each(data, function (i, time) {
                                //do something

                                if (time.second_start_time != null && time.second_end_time != null) {
                                    $('.available_time').append(
                                        '<label class="btn btn-outline-secondary mr-2"><input type="radio" name="available_time" id="period" class="available_period" value="' +
                                        time.id + '" >' + tConvert(time.first_start_time) + ' to ' + tConvert(time.first_end_time) +
                                        " | " + tConvert(time.second_start_time) + " to " + tConvert(time.second_end_time) +
                                        '</label>');
                                } else {
                                    if (time.first_start_time != 'NULL') {
                                        $('.available_time').append(
                                            '<label class="btn btn-outline-secondary mr-2"><input type="radio" name="available_time" id="period" class="available_period" value="' +
                                            time.id + '" >' + tConvert(time.first_start_time) + ' to ' + tConvert(time.first_end_time) +
                                            '</label>');
                                    } else {
                                        $('.available_time').append(
                                            '<span class="badge-warning">There is no schedule in this day !</span>'
                                        );
                                    }
                                }

                            });

                        },
                    });
                } else {
                    $('.available_time').append(
                        '<span class="badge-danger">You must choose a doctor !</span>'
                    );
                }
            });
            // datepicker change
            $(document).on('change', '#date', function () {
                $('.available_slot').empty();
            });
            // doctor available time show

            $(document).on('click', '#period', function () {
                $('.available_slot').empty();
                var time_id = $(this).val();
                var doctor_id = $('#doctor').val();
                var date = $('#date').val();
                $.ajax({
                    url: "{{url('appointment/get_time_slots?id=')}}" + time_id + "&doctor_id=" + doctor_id + "&date=" + date,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        for (let i = 0; i < data.length; i++) {
                            $('.available_slot').append(
                                '<label class="btn btn-outline-secondary mr-2"><input type="radio" name="available_slot" id="period" class="available_period" value="' +
                                data[i] + '" >' + tConvert(data[i]) +
                                '</label>');
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
        });

    </script>

    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'})
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {'placeholder': 'mm/dd/yyyy'})
            //Money Euro
            $('[data-mask]').inputmask()

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            //Date and time picker
            $('#reservationdatetime').datetimepicker({icons: {time: 'far fa-clock'}});

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker(
                {
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function (start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function (event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            })
        })
    </script>
@endsection
