@csrf
<div class="card-body">
    <div class="row">
        <div class="col-sm-6 form-group">
            <label class="control-label">Type <span
                    class="text-danger">*</span></label>
            @php $input = 'examination'; @endphp
            <div class="col-sm-3 form-check form-check-inline" style="margin-left: 10%">
                <input class="form-check-input" type="radio" name="type" id="chkYes" onclick="ShowHideDiv()" checked
                       value="0">
                <label class="form-check-label" for="chkYes">Examination</label>
            </div>
            @php $input = 'followup'; @endphp
            <div class="col-sm-3 form-check form-check-inline ml-4">
                <input class="form-check-input" type="radio" name="type" id="chkNo" onclick="ShowHideDiv()" value="1">
                <label class="form-check-label" for="chkNo">Followup</label>
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'patient'; @endphp
        <div class="col-md-6 form-group">
            <label class="control-label">Patient <span
                    class="text-danger">*</span></label>
            <select
                class="form-control select2 sel_patient"
                name="{{$input}}" id="patient">
                <option disabled selected>Select Patient</option>
                @foreach($patients as $patient)
                    <option value="{{$patient->user_id}}" {{ $patient->id == $prescription->patient_id ? 'selected' : ''}}>
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
                name="date" id="appointment">
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
                        <div class="col-sm-3 mt-1">
                            <input type="text" list="myMediciness" name="{{$input}}" class="form-control medicine"
                                   placeholder="Medicine Name"/>
                            <datalist id="myMediciness">
                                @foreach($medicines as $medicine)
                                    <option value="{{$medicine->name}}">
                                @endforeach
                            </datalist>
                        </div>
                        @php $input = 'frequency'; @endphp
                        <div class="col-sm-2 mt-1">
                            <select
                                class="form-control select2 frequency"
                                name="{{$input}}" id="frequency">
                                <option disabled selected>Frequency</option>
                                @foreach($frequencies as $frequency)
                                    <option
                                        value="{{$frequency->id}}" {{ old($input) == $frequency->name ? 'selected' : ''}}>
                                        {{$frequency->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @php $input = 'period'; @endphp
                        <div class="col-sm-2 mt-1">
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
                        @php $input = 'note'; @endphp
                        <div class="col-sm-4 mt-1">
                                                    <textarea type="text" name="{{$input}}" class="form-control"
                                                              placeholder="Notes..."></textarea>
                        </div>
                        <div class="col-sm-1">
                            <input data-repeater-delete type="button"
                                   class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                   value="X"/>
                        </div>
                    </div>
                </div>
                <input data-repeater-create type="button" class="btn btn-success"
                       value="Add Medicine"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class='repeater mb-4'>
                <div data-repeater-list="formulas" class="form-group">
                    <label>Formula <span class="text-danger">*</span></label>
                    <div data-repeater-item class="mb-3 row">
                        @php $input = 'formula'; @endphp
                        <div class="col-sm-3 mt-1">
                            <select name="{{$input}}" class="form-control select2" style="width: 100%;">
                                <option selected="" disabled="">Select Formula</option>
                                @foreach($formulas as $formula)
                                    <option value="{{$formula->id}}"
                                        {{isset($row) && $row->id == $formula->id ? 'selected' : ''}}>{{$formula->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @php $input = 'frequency'; @endphp
                        <div class="col-sm-2 mt-1">
                            <select
                                class="form-control select2 frequency"
                                name="{{$input}}" id="frequency">
                                <option disabled selected>Frequency</option>
                                @foreach($frequencies as $frequency)
                                    <option
                                        value="{{$frequency->id}}" {{ old($input) == $frequency->name ? 'selected' : ''}}>
                                        {{$frequency->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @php $input = 'period'; @endphp
                        <div class="col-sm-2 mt-1">
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
                        <div class="col-sm-4 mt-1">
                            @php $input = 'note'; @endphp
                            <textarea type="text" name="{{$input}}" class="form-control"
                                      placeholder="Notes..."></textarea>
                        </div>
                        <div class="col-sm-1">
                            <input data-repeater-delete type="button"
                                   class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                   value="X"/>
                        </div>
                    </div>
                </div>
                <input data-repeater-create type="button" class="btn btn-success"
                       value="Add Formula"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-9">
            <div class='repeater mb-4'>
                <div data-repeater-list="tests" class="form-group">
                    <label>Test Reports </label>
                    <div data-repeater-item class="mb-3 row">
                        @php $input = 'test'; @endphp
                        <div class="col-sm-3 mt-1">
                            <input type="text" list="myTest" name="{{$input}}" class="form-control medicine"
                                   placeholder="Test Name"/>
                            <datalist id="myTest">
                                @foreach($tests as $test)
                                    <option value="{{$test->name}}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-sm-5 mt-1">
                                                    <textarea type="text" name="note" class="form-control"
                                                              placeholder="Notes..."></textarea>
                        </div>
                        <div class="col-sm-1">
                            <input data-repeater-delete type="button"
                                   class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                   value="X"/>
                        </div>
                    </div>
                </div>
                <input data-repeater-create type="button" class="btn btn-success"
                       value="Add Test Report"/>
            </div>
        </div>
    </div>
    <div class="row" id="date">
        @php $input = 'followup_date' @endphp
        <div class="col-sm-6">
            <label class="control-label">Followup Date</label>
            <div class="form-group">
                <input type="date" class="form-control appointment-date"
                       name="{{$input}}" id="date" data-provide="datepicker"
                       data-date-autoclose="true" autocomplete="on" min="{{date("Y-m-d")}}">
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'prescription_note' @endphp
        <div class="col-sm-6">
            <label for="exampleInput{{$input}}">Note</label>
            <textarea name="{{$input}}" class="form-control" rows="3" placeholder="Enter Note"
                      spellcheck="false">{{isset($row) ? $row->$input : old($input)}}</textarea>
            @error($input)<span class="invalid-feedback"
                                role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>
    </div>
    <!-- /.card-body -->
</div>
