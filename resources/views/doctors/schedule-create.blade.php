@extends('layouts.app')
@section('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{asset('assets/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
          href="{{asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="{{asset('assets/plugins/bs-stepper/css/bs-stepper.min.css')}}">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="{{asset('assets/plugins/dropzone/min/dropzone.min.css')}}">
@endsection
@section('title')   {{ trans('main_trans.doctors') }}    @endsection
@section('header-title')    {{ trans('main_trans.doctors') }}    @endsection
@section('header-title-one')    {{ trans('main_trans.doctors') }}    @endsection
@section('header-title-two')    {{ trans('main_trans.create_schedule') }}  @endsection

@section('content')
    @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{!! \Session::get('error') !!}</li>
            </ul>
        </div>
    @endif
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"> {{isset($doctor) ? 'Dr. '.$doctor->name.' ' : 'Doctor'}}Schedule </h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="POST" action="{{route('schedule-update',$doctor->userId)}}">
        @csrf
        <!-- iCheck -->
            <div class="card-body">
                <!-- Minimal style -->
                @for($i=0;$i<7;$i++)
                    <div class="row">
                        <div class="col-sm-2">
                            <!-- checkbox -->
                            <div class="form-group">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" name="day_of_week[{{$i}}]" value="1"
                                           id="checkboxPrimary{{$i}}" {{isset($row[$i]) && $row[$i]->day_attendance == 1 ? 'checked' : ''}}>
                                    <label for="checkboxPrimary{{$i}}">
                                        {{isset($row[$i]) ? $row[$i]->day_of_week : ''}}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-8">
                            <div class="card card-primary card-outline card-tabs">
                                <div class="card-header p-0 pt-1 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                        @if(\Jenssegers\Agent\Facades\Agent::isMobile())
                                        &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-tabs-three-f{{$i}}-tab"
                                               data-toggle="pill" href="#custom-tabs-three-f{{$i}}" role="tab"
                                               aria-controls="custom-tabs-three-f{{$i}}" aria-selected="true">
                                                <span><i class="fa fa-clock"></i></span>
                                            </a>
                                        </li>
                                        {{--<li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-three-s{{$i}}-tab"
                                               data-toggle="pill" href="#custom-tabs-three-s{{$i}}" role="tab"
                                               aria-controls="custom-tabs-three-s{{$i}}" aria-selected="false">
                                                <span><i class="fa fa-clock"></i></span>
                                                <i class="fa fa-sm fa-plus-circle"></i>
                                            </a>
                                        </li>--}}
                                        @else
                                            <li class="nav-item">
                                                <a class="nav-link active" id="custom-tabs-three-f{{$i}}-tab"
                                                   data-toggle="pill" href="#custom-tabs-three-f{{$i}}" role="tab"
                                                   aria-controls="custom-tabs-three-f{{$i}}" aria-selected="true">&ensp;
                                                    {{ trans('main_trans.period') }}</a>
                                            </li>
                                            {{--<li class="nav-item">
                                                <a class="nav-link" id="custom-tabs-three-s{{$i}}-tab"
                                                   data-toggle="pill" href="#custom-tabs-three-s{{$i}}" role="tab"
                                                   aria-controls="custom-tabs-three-s{{$i}}" aria-selected="false">Second
                                                    Period</a>
                                            </li>--}}
                                        @endif
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-three-tabContent">
                                        <div class="tab-pane fade show active" id="custom-tabs-three-f{{$i}}"
                                             role="tabpanel" aria-labelledby="custom-tabs-three-f{{$i}}-tab">
                                            <div class="col-md-12 col-sm-6">
                                                <!-- time Picker -->
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <label for="first_from{{$i}}"><small>{{ trans('main_trans.from') }}</small> &ensp;</label>
                                                        <input type="time" name="first_start_time[]"
                                                               value="{{isset($row[$i]) ? $row[$i]->first_start_time : ''}}"
                                                               class="form-control" id="first_from{{$i}}"/>
                                                        @error('first_start_time')<span class="invalid-feedback"
                                                                                        role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                                <!-- /.form group -->
                                            </div>

                                            <div class="col-md-12 col-sm-4">
                                                <!-- time Picker -->
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <label for="first_to{{$i}}"><small>{{ trans('main_trans.to') }}</small> &ensp;</label>
                                                        <input type="time" name="first_end_time[]"
                                                               value="{{isset($row[$i]) ? $row[$i]->first_end_time : ''}}"
                                                               class="form-control" id="first_to{{$i}}"/>
                                                        @error('first_end_time')<span class="invalid-feedback"
                                                                                      role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                                <!-- /.form group -->
                                            </div>
                                            &ensp;&ensp;&ensp;
                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-three-s{{$i}}" role="tabpanel"
                                             aria-labelledby="custom-tabs-three-s{{$i}}-tab">
                                            <div class="col-md-12 col-sm-4">
                                                <!-- time Picker -->
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <label for="second_from{{$i}}"><small>{{ trans('main_trans.from') }}</small>
                                                            &ensp;</label>
                                                        <input type="time" name="second_start_time[]"
                                                               value="{{isset($row[$i]) ? $row[$i]->second_start_time : ''}}"
                                                               class="form-control" id="second_from{{$i}}"/>
                                                        @error('second_start_time')<span class="invalid-feedback"
                                                                                         role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                                <!-- /.form group -->
                                            </div>
                                            <div class="col-md-12 col-sm-4">
                                                <!-- time Picker -->
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <label for="second_to{{$i}}"><small>{{ trans('main_trans.to') }}</small> &ensp;</label>
                                                        <input type="time" name="second_end_time[]"
                                                               value="{{isset($row[$i]) ? $row[$i]->second_end_time : ''}}"
                                                               class="form-control" id="second_to{{$i}}"/>
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                                <!-- /.form group -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                @endfor
            </div>
            <!-- /.card-body -->
            <!-- /.card -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" name="create">{{ trans('main_trans.submit') }}</button>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <!-- Select2 -->
    <script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
    <!-- date-range-picker -->
    <script src="{{asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="{{asset('assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
    <!-- InputMask -->
    <script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('assets/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
    <!-- date-range-picker -->
    <script src="{{asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- bootstrap color picker -->
    <script src="{{asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>

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
        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function () {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        // DropzoneJS Demo Code Start
        Dropzone.autoDiscover = false

        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template")
        previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)

        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: "/target-url", // Set the url
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        })

        myDropzone.on("addedfile", function (file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function () {
                myDropzone.enqueueFile(file)
            }
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function (progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function (file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1"
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function (progress) {
            document.querySelector("#total-progress").style.opacity = "0"
        })

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function () {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }
        document.querySelector("#actions .cancel").onclick = function () {
            myDropzone.removeAllFiles(true)
        }
        // DropzoneJS Demo Code End
    </script>
@endsection
