@csrf
<div class="card-body">
    <div class="row">
        <div class="col-sm-6 form-group">
            <label class="control-label">{{ trans('main_trans.type') }} <span
                    class="text-danger">*</span></label>
            @php $input = 'examination'; @endphp
            <div class="col-sm-3 form-check form-check-inline" style="margin-left: 10%">
                <input class="form-check-input" type="radio" name="type" id="chkYes" onclick="ShowHideDiv()"
                       {{!isset($_GET['type']) ? 'checked' : (isset($_GET['type']) && $_GET['type'] == 0 ? 'checked' : '')}}
                       value="0">
                <label class="form-check-label" for="chkYes">{{ trans('main_trans.examination') }}</label>
            </div>
            @php $input = 'followup'; @endphp
            <div class="col-sm-3 form-check form-check-inline ml-4">
                <input class="form-check-input" type="radio" name="type" id="chkNo" onclick="ShowHideDiv()"
                       {{(isset($_GET['type']) && $_GET['type'] == 1 ? 'checked' : '')}}
                       value="1">
                <label class="form-check-label" for="chkNo">{{ trans('main_trans.followup') }}</label>
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'patient'; @endphp
        <div class="col-md-6 form-group">
            <label class="control-label">{{ trans('main_trans.patient') }} <span
                    class="text-danger">*</span></label>
            <select
                class="form-control select2 sel_patient"
                name="{{$input}}" id="patient">
                <option disabled selected>{{ trans('main_trans.select_patient') }}</option>
                @foreach($patients as $patient)
                    <option
                        value="{{$patient->user_id}}" {{ isset(request()->patient_id) && request()->patient_id == $patient->user_id  ? 'selected' : ''}}>
                        {{$patient->user_name}}</option>
                @endforeach
            </select>
            @error($input)<span style="color: red;font-size: smaller"
                                role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>
        @php $input = 'date'; @endphp
        <div class="col-md-6 form-group">
            <label class="control-label">{{ trans('main_trans.appointment') }} <span
                    class="text-danger">*</span></label>
            <select
                class="form-control select2 sel_appointment "
                name="{{$input}}" id="appointment">
                @if(isset(request()->patient_id))
                    <option value="{{request()->date}}">{{request()->date}}</option>
                @else
                    <option disabled selected>{{ trans('main_trans.select_appointment') }}</option>
                @endif
            </select>
            @error($input)<span class="badge badge-danger"
                                role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>
    </div>

    <blockquote>{{ trans('main_trans.medication_&_test_reports_details') }}</blockquote>
    <div class="row">
        <div class="col-sm-12">
            <div class='repeater mb-4'>
                <div data-repeater-list="medicines" class="form-group">
                    <label>{{ trans('main_trans.medicines') }} <span class="text-danger">*</span></label>
                    <div data-repeater-item class="mb-3 row">
                        @php $input = 'medicine'; @endphp
                        <div class="col-sm-3 mt-1">
                            <input type="text" list="myMediciness" name="{{$input}}" class="form-control medicine"
                                   placeholder="{{ trans('main_trans.medicine_name') }}"/>
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
                                <option disabled selected>{{ trans('main_trans.frequency') }}</option>
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
                                <option disabled selected>{{ trans('main_trans.period') }}</option>
                                @foreach($periods as $period)
                                    <option value="{{$period->id}}" {{ old($input) == $period->name ? 'selected' : ''}}>
                                        {{$period->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @php $input = 'note'; @endphp
                        <div class="col-sm-4 mt-1">
                                                    <textarea type="text" name="{{$input}}" class="form-control"
                                                              placeholder="{{ trans('main_trans.note') }}..."></textarea>
                        </div>
                        <div class="col-sm-1">
                            <input data-repeater-delete type="button"
                                   class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                   value="X"/>
                        </div>
                    </div>
                </div>
                <input data-repeater-create type="button" class="btn btn-success"
                       value="{{ trans('main_trans.add_medicine') }}"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class='repeater mb-4'>
                <div data-repeater-list="formulas" class="form-group">
                    <label>{{ trans('main_trans.formulas') }} <span class="text-danger">*</span></label>
                    <div data-repeater-item class="mb-3 row">
                        @php $input = 'formula'; @endphp
                        <div class="col-sm-3 mt-1">
                            <select name="{{$input}}" class="form-control select2" style="width: 100%;">
                                <option selected="" disabled="">{{ trans('main_trans.select_formula') }}</option>
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
                                <option disabled selected>{{ trans('main_trans.frequency') }}</option>
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
                                <option disabled selected>{{ trans('main_trans.period') }}</option>
                                @foreach($periods as $period)
                                    <option value="{{$period->id}}" {{ old($input) == $period->name ? 'selected' : ''}}>
                                        {{$period->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4 mt-1">
                            @php $input = 'note'; @endphp
                            <textarea type="text" name="{{$input}}" class="form-control"
                                      placeholder="{{ trans('main_trans.note') }}..."></textarea>
                        </div>
                        <div class="col-sm-1">
                            <input data-repeater-delete type="button"
                                   class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                   value="X"/>
                        </div>
                    </div>
                </div>
                <input data-repeater-create type="button" class="btn btn-success"
                       value="{{ trans('main_trans.add_formula') }}"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-9">
            <div class='repeater mb-4'>
                <div data-repeater-list="tests" class="form-group">
                    <label>{{ trans('main_trans.test_reports') }} </label>
                    <div data-repeater-item class="mb-3 row">
                        @php $input = 'test'; @endphp
                        <div class="col-sm-3 mt-1">
                            <input type="text" list="myTest" name="{{$input}}" class="form-control medicine"
                                   placeholder="{{ trans('main_trans.test_name') }}"/>
                            <datalist id="myTest">
                                @foreach($tests as $test)
                                    <option value="{{$test->name}}">
                                @endforeach
                            </datalist>
                        </div>
                        @php $input = 'note'; @endphp
                        <div class="col-sm-5 mt-1">
                            <textarea type="text" name="{{$input}}" class="form-control"
                                      placeholder="{{ trans('main_trans.note') }}..."></textarea>
                        </div>
                        <div class="col-sm-1">
                            <input data-repeater-delete type="button"
                                   class="fcbtn btn btn-outline btn-danger btn-1d btn-sm inner"
                                   value="X"/>
                        </div>
                    </div>
                </div>
                <input data-repeater-create type="button" class="btn btn-success"
                       value="{{ trans('main_trans.add_test_report') }}"/>
            </div>
        </div>
    </div>
    @if(!$insurance_companies->isEmpty())
        <div class="row">
            <div class="col-sm-6 form-group">
                <label class="control-label">{{ trans('main_trans.insurance_companies') }}</label>
                @php $input = 'insurance_company_id'; @endphp
                <select
                    class="form-control select2"
                    name="{{$input}}">
                    <option disabled selected>{{ trans('main_trans.select_company') }}</option>
                    @foreach($insurance_companies as $company)
                        <option value="{{$company->id}}">
                            {{$company->name}}</option>
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
            <label class="control-label">{{ trans('main_trans.followup_date') }}</label>
            <div class="form-group">
                <input type="date" class="form-control appointment-date"
                       name="{{$input}}" id="date" data-provide="datepicker"
                       data-date-autoclose="true" autocomplete="on" min="{{date("Y-m-d")}}">
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'file[]' @endphp
        <div class="col-sm-6">
            <label class="control-label">{{ trans('main_trans.attachment') }}</label>
            <div class="form-group">
                <div class="custom-file">
                    <input type="file" name="{{$input}}" class="custom-file-input" id="customFile" multiple>
                    <label class="custom-file-label" for="customFile">{{ trans('main_trans.choose_files') }}</label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'note' @endphp
        <div class="col-sm-6">
            <label for="exampleInput{{$input}}">{{ trans('main_trans.note') }}</label>
            <textarea name="{{$input}}" class="form-control" rows="3" placeholder="{{ trans('main_trans.note') }}"
                      spellcheck="false">{{isset($row) ? $row->$input : old($input)}}</textarea>
            @error($input)<span class="badge badge-danger"
                                role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>
    </div>
    <!-- /.card-body -->
</div>

