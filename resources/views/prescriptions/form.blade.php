@csrf

<div class="card-body">
    <div class="row">

        <div class="col-md-6 form-group">
            <label class="control-label">Type <span
                    class="text-danger">*</span></label>
            @php $input = 'examination'; @endphp
            <div class="form-check form-check-inline" style="margin-left: 10%">
                <input class="form-check-input" type="radio" name="type" id="inlineRadio1" checked value="examination">
                <label class="form-check-label" for="inlineRadio1">Examination</label>
            </div>
            @php $input = 'followup'; @endphp
            <div class="form-check form-check-inline ml-4">
                <input class="form-check-input" type="radio" name="type" id="inlineRadio2" value="followup">
                <label class="form-check-label" for="inlineRadio2">Followup</label>
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'patient_id'; @endphp
        <div class="col-md-6 form-group">
            <label class="control-label">Patient <span
                    class="text-danger">*</span></label>
            <select
                class="form-control select2 sel_patient"
                name="{{$input}}" id="patient">
                <option disabled selected>Select Patient</option>
                @foreach($patients as $patient)
                    <option value="{{$patient->user_id}}" {{ old($input) == $patient->user_id ? 'selected' : ''}}>
                        {{$patient->user_name}}</option>
                @endforeach
            </select>
            @error($input)<span style="color: red;font-size: smaller"
                                role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>
        <div class="col-md-6 form-group">
            <label class="control-label">Appointment <span
                    class="text-danger">*</span></label>
            <select
                class="form-control select2 sel_appointment "
                name="appointment_id" id="appointment">
                <option disabled selected>Select Appointment</option>
            </select>
        </div>
    </div>

    <blockquote>Medication &amp; Test Reports Details</blockquote>
    <div class="row">
        <div class="col-sm-12">
            <div class='repeater mb-4'>
                <div data-repeater-list="medicines" class="form-group">
                    <label>Medicines <span class="text-danger">*</span></label>
                    <div data-repeater-item class="mb-3 row">
                        @php $input = 'medicine'; @endphp
                        <div class="col-sm-3">
                            <input type="text" name="{{$input}}" class="form-control medicine"
                                   placeholder="Medicine Name"/>
                        </div>
                        @php $input = 'frequency'; @endphp
                        <div class="col-sm-2">
                            <select
                                class="form-control select2 frequency"
                                name="{{$input}}" id="frequency">
                                <option disabled selected>Frequency</option>
                                @foreach($frequencies as $frequency)
                                    <option value="{{$frequency->id}}" {{ old($input) == $frequency->name ? 'selected' : ''}}>
                                        {{$frequency->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @php $input = 'period'; @endphp
                        <div class="col-sm-2">
                            <select
                                class="form-control select2 period"
                                name="{{$input}}" id="period">
                                <option disabled selected>Period</option>
                                @foreach($periods as $period)
                                    <option value="{{$period->id}}" {{ old($input) == $period->name ? 'selected' : ''}}>
                                        {{$period->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                                                    <textarea type="text" name="notes" class="form-control"
                                                              placeholder="Notes..."></textarea>
                        </div>
                        <div class="col-sm-1">
                            <input data-repeater-delete type="button"
                                   class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                   value="X"/>
                        </div>
                    </div>
                </div>
                <input data-repeater-create type="button" class="btn btn-primary"
                       value="Add Medicine"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class='repeater mb-4'>
                <div data-repeater-list="test_reports" class="form-group">
                    <label>Test Reports </label>
                    <div data-repeater-item class="mb-3 row">
                        <div class="col-md-5 col-6">
                            <input type="text" name="test_report" class="form-control"
                                   placeholder="Test Report Name"/>
                        </div>
                        <div class="col-md-5 col-6">
                                                    <textarea type="text" name="notes" class="form-control"
                                                              placeholder="Notes..."></textarea>
                        </div>
                        <div class="col-md-2 col-4">
                            <input data-repeater-delete type="button"
                                   class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                   value="X"/>
                        </div>
                    </div>
                </div>
                <input data-repeater-create type="button" class="btn btn-primary"
                       value="Add Test Report"/>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>

