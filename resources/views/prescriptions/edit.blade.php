@extends('layouts.app')
@section('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.min.css')}}">
@endsection
@section('title')   {{ trans('main_trans.prescriptions') }}    @endsection
@section('header-title')    {{ trans('main_trans.prescriptions') }}    @endsection
@section('header-title-one')    {{ trans('main_trans.prescriptions') }}    @endsection
@section('header-title-one-link')    {{route('prescriptions.index')}}    @endsection
@section('header-title-two')    {{ trans('main_trans.edit') }}   @endsection
@section('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.min.css')}}">

@endsection
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ trans('main_trans.edit_prescription') }}</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->

        <form method="POST" action="{{route('prescriptions.update' , $prescription->id)}}" enctype="multipart/form-data">
            {{ method_field('put') }}
            @include('prescriptions.edit-form')
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" name="update">{{ trans('main_trans.submit') }}</button>
            </div>
        </form>
    </div>

@endsection
@section('scripts')
    <!-- Select2 -->
    <script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
    <!-- repeater -->
    <script src="{{asset('assets/plugins/jquery-repeater/jquery-repeater.min.js')}}"></script>
    <script src="{{asset('assets/plugins/jquery-repeater/form-repeater.int.js')}}"></script>
    <!-- custom input file -->
    <script src="{{asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <!-- get appointments of chosen patient -->
    <script>
        $('.sel_patient').on('change', function (e) {
            e.preventDefault();
            var patient_id = $(this).val();
            $.ajax({
                url: "{{ url('/appointment/get-appointments-of-patient') }}" + "?patient_id=" + patient_id,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    if (data == '') {
                        $('.sel_appointment').empty();
                        $('.sel_appointment').append(
                            '<option>No available appointments</option>'
                        );
                    } else {
                        $('.sel_appointment').empty();
                        $('.sel_appointment').append('<option disabled selected>Select Appointment</option>');
                        $.each(data, function (i, appointment) {
                            //do something
                            $('.sel_appointment').append(
                                '<option value="' + appointment.date + '">' + appointment.date + '</option>'
                            );
                        });
                    }

                },
                error: function (res) {
                    console.log(res);
                }
            });
        });
    </script>
    <!-- autocomplete for medicines -->
    {{--    <script>
            $('.medicine').on('keyup', function (e) {
                var medicine = $(this).val();
                $.ajax({
                    url: "{{url('prescription/get_doctor_medicines?medicine=')}}" + medicine,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#myMedicines').empty();
                        $.each(data, function (i, medicine) {
                            //do something
                            $('#myMedicines').append(
                                '<option value="'+medicine.name+'">'
                            );
                        });
                    },
                    error: function (res) {
                        console.log(res);
                    }
                });
            });
        </script>--}}

    <!-- Libaries configurations  -->
    <script>
        // display or hide followup date based on investigation type
        function ShowHideDiv() {
            var chkYes = document.getElementById("chkYes");
            var date = document.getElementById("date");
            date.style.display = chkYes.checked ? "block" : "none";
        }
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
