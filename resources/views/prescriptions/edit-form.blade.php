@csrf
<div class="card-body">
    <div class="row">
        <div class="col-sm-6 form-group">
            <label class="control-label">Type <span
                    class="text-danger">*</span></label>
            @php $input = 'examination'; @endphp
            <div class="col-sm-3 form-check form-check-inline" style="margin-left: 10%">
                <input class="form-check-input" type="radio" name="type" id="chkYes" onclick="ShowHideDiv()"
                       {{isset($prescription) && $prescription->type == 0 ? 'checked' : ''}} value="0">
                <label class="form-check-label" for="chkYes">Examination</label>
            </div>
            @php $input = 'followup'; @endphp
            <div class="col-sm-3 form-check form-check-inline ml-4">
                <input class="form-check-input" type="radio" name="type" id="chkNo" onclick="ShowHideDiv()"
                       {{isset($prescription) && $prescription->type == 1 ? 'checked' : ''}} value="1">
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
                    <option value="{{$patient->user_id}}"
                        {{ isset($prescription) && $prescription->patient_id ==  $patient->user_id ? 'selected' : ''}}>
                        {{$patient->user_name}}</option>
                @endforeach
            </select>
            @error($input)<span style="color: red;font-size: smaller"
                                role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>
        @php $input = 'date'; @endphp
        <div class="col-md-6 form-group">
            <label class="control-label">Appointment <span
                    class="text-danger">*</span></label>
            <select
                class="form-control select2 sel_appointment "
                name="{{$input}}" id="appointment">
                <option disabled selected>Select Appointment</option>
                <option value="{{$prescription->date}}" selected>{{{$prescription->date}}}</option>
            </select>
            @error($input)<span class="badge badge-danger"
                                role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>
    </div>

    <blockquote>Medication &amp; Test Reports Details</blockquote>
    <div class="row">
        <div class="col-sm-12">
            <div class='repeater mb-4'>
                <div data-repeater-list="medicines" class="form-group">
                    <label>Medicines</label>
                    @if($medicines->isEmpty())
                        <div data-repeater-item class="mb-3 row">
                            @php $input = 'medicine'; @endphp
                            <div class="col-sm-3 mt-1">
                                <input type="text" list="myMediciness" name="{{$input}}"
                                       value="{{$row->medicine_name ?? ''}}" class="form-control medicine"
                                       placeholder="Medicine Name"/>
                                <datalist id="myMediciness">
                                    @foreach($suggested_medicines as $suggested_medicine)
                                        <option value="{{$suggested_medicine->name}}">
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
                                            value="{{$frequency->id}}">
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
                                        <option
                                            value="{{$period->id}}">
                                            {{$period->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @php $input = 'note'; @endphp
                            <div class="col-sm-4 mt-1">
                                            <textarea type="text" name="{{$input}}" class="form-control"
                                                      placeholder="Notes...">{{$row->note ?? ''}}</textarea>
                            </div>
                            <div class="col-sm-1">
                                <input data-repeater-delete type="button"
                                       class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                       value="X"/>
                            </div>
                        </div>
                    @endif
                    @foreach($medicines as $row)

                        <div data-repeater-item class="mb-3 row">
                            @php $input = 'medicine'; @endphp
                            <div class="col-sm-3 mt-1">
                                <input type="text" list="myMediciness" name="{{$input}}"
                                       value="{{$row->medicine_name ?? ''}}" class="form-control medicine"
                                       placeholder="Medicine Name"/>
                                <datalist id="myMediciness">
                                    @foreach($suggested_medicines as $suggested_medicine)
                                        <option value="{{$suggested_medicine->name}}">
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
                                            value="{{$frequency->id}}" {{ $row->frequency_id == $frequency->id ? 'selected' : ''}}>
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
                                        <option
                                            value="{{$period->id}}" {{ $row->period_id == $period->id ? 'selected' : ''}}>
                                            {{$period->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @php $input = 'note'; @endphp
                            <div class="col-sm-4 mt-1">
                                            <textarea type="text" name="{{$input}}" class="form-control"
                                                      placeholder="Notes...">{{$row->note ?? ''}}</textarea>
                            </div>
                            <div class="col-sm-1">
                                <input data-repeater-delete type="button"
                                       class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                       value="X"/>
                            </div>
                        </div>
                    @endforeach
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
                    <label>Formulas</label>
                    @if($formulas->isEmpty())
                        <div data-repeater-item class="mb-3 row">
                            @php $input = 'formula'; @endphp
                            <div class="col-sm-3 mt-1">
                                <select name="{{$input}}" class="form-control select2" style="width: 100%;">
                                    <option selected="" disabled="">Select Formula</option>
                                    @foreach($all_formulas as $formula)
                                        <option value="{{$formula->id}}">{{$formula->name}}</option>
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
                                            value="{{$frequency->id}}">
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
                                        <option value="{{$period->id}}">{{$period->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4 mt-1">
                                @php $input = 'note'; @endphp
                                <textarea type="text" name="{{$input}}" class="form-control"
                                          placeholder="Notes...">{{$row->note ?? ''}}</textarea>
                            </div>
                            <div class="col-sm-1">
                                <input data-repeater-delete type="button"
                                       class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                       value="X"/>
                            </div>
                        </div>
                    @endif
                    @foreach($formulas as $row)
                        <div data-repeater-item class="mb-3 row">
                            @php $input = 'formula'; @endphp
                            <div class="col-sm-3 mt-1">
                                <select name="{{$input}}" class="form-control select2" style="width: 100%;">
                                    <option selected="" disabled="">Select Formula</option>
                                    @foreach($all_formulas as $formula)
                                        <option value="{{$formula->id}}"
                                            {{isset($row) && $row->formula_id == $formula->id ? 'selected' : ''}}>{{$formula->name}}</option>
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
                                            value="{{$frequency->id}}" {{ isset($row) && $row->formula_id == $frequency->id ? 'selected' : ''}}>
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
                                        <option
                                            value="{{$period->id}}" {{ isset($row) && $row->period_id == $period->id ? 'selected' : ''}}>
                                            {{$period->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4 mt-1">
                                @php $input = 'note'; @endphp
                                <textarea type="text" name="{{$input}}" class="form-control"
                                          placeholder="Notes...">{{$row->note ?? ''}}</textarea>
                            </div>
                            <div class="col-sm-1">
                                <input data-repeater-delete type="button"
                                       class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                       value="X"/>
                            </div>
                        </div>
                    @endforeach
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
                    @if($tests->isEmpty())
                        <div data-repeater-item class="mb-3 row">
                            @php $input = 'test'; @endphp
                            <div class="col-sm-3 mt-1">
                                <input type="text" list="myTest" value="{{$row->name ?? ''}}" name="{{$input}}"
                                       class="form-control medicine"
                                       placeholder="Test Name"/>
                                <datalist id="myTest">
                                    @foreach($tests as $test)
                                        <option value="{{$test->name}}">
                                    @endforeach
                                </datalist>
                            </div>
                            @php $input = 'note'; @endphp
                            <div class="col-sm-5 mt-1">
                                                    <textarea type="text" name="{{$input}}" class="form-control"
                                                              placeholder="Notes...">{{$row->$input ?? ''}}</textarea>
                            </div>
                            <div class="col-sm-1">
                                <input data-repeater-delete type="button"
                                       class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                       value="X"/>
                            </div>
                        </div>
                    @endif
                    @foreach($tests as $row)
                        <div data-repeater-item class="mb-3 row">
                            @php $input = 'test'; @endphp
                            <div class="col-sm-3 mt-1">
                                <input type="text" list="myTest" value="{{$row->name ?? ''}}" name="{{$input}}"
                                       class="form-control medicine"
                                       placeholder="Test Name"/>
                                <datalist id="myTest">
                                    @foreach($tests as $test)
                                        <option value="{{$test->name}}">
                                    @endforeach
                                </datalist>
                            </div>
                            @php $input = 'note'; @endphp
                            <div class="col-sm-5 mt-1">
                                                    <textarea type="text" name="{{$input}}" class="form-control"
                                                              placeholder="Notes...">{{$row->$input ?? ''}}</textarea>
                            </div>
                            <div class="col-sm-1">
                                <input data-repeater-delete type="button"
                                       class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                       value="X"/>
                            </div>
                        </div>
                    @endforeach
                </div>
                <input data-repeater-create type="button" class="btn btn-success"
                       value="Add Test Report"/>
            </div>
        </div>
    </div>
    @if(!$insurance_companies->isEmpty())
        <div class="row">
            <div class="col-sm-6 form-group">
                <label class="control-label">Insurance Companies</label>
                @php $input = 'insurance_company_id'; @endphp
                <select
                    class="form-control select2"
                    name="{{$input}}">
                    <option disabled selected>Select Company</option>
                    @foreach($insurance_companies as $company)
                        <option value="{{$company->id}}"
                            {{$prescription->insurance_company_id == $company->id ? 'selected' : ''}}>{{$company->name}}</option>
                    @endforeach
                </select>
                @error($input)<span style="color: red;font-size: smaller"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    @endif
    <div class="row" id="date">
        @php $input = 'followup_date' @endphp
        <div class="col-sm-6">
            <label class="control-label">Followup Date</label>
            <div class="form-group">
                <input type="date" class="form-control appointment-date"
                       name="{{$input}}" value="{{$prescription->followup_date}}" id="date" data-provide="datepicker"
                       data-date-autoclose="true" autocomplete="on" min="{{date("Y-m-d")}}">
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'note' @endphp
        <div class="col-sm-6">
            <label for="exampleInput{{$input}}">Note</label>
            <textarea name="{{$input}}" class="form-control" rows="3" placeholder="Enter Note"
                      spellcheck="false">{{isset($prescription) ? $prescription->$input : old($input)}}</textarea>
            @error($input)<span class="badge badge-danger"
                                role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>
    </div>
    <!-- /.card-body -->
</div>
