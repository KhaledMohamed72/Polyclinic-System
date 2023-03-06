@csrf

<div class="card-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="mb-3">{{ trans('main_trans.type') }}</label>
                <br>
                <div class="col-sm-2 form-check form-check-inline" style="margin-left: 1%">
                    <input class="form-check-input" type="radio" name="type" checked id="chkExamination"
                           {{isset($prescription) && $prescription->type == 0 ? 'checked' : ''}} value="0">
                    <label class="form-check-label" for="chkExamination">{{ trans('main_trans.examination') }}</label>
                </div>
                <div class="col-sm-2 form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="type" id="chkFollowup"
                           {{isset($prescription) && $prescription->type == 1 ? 'checked' : ''}} value="1">
                    <label class="form-check-label" for="chkFollowup">{{ trans('main_trans.followup') }}</label>
                </div>
                <div class="col-sm-2 form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="type" id="chkSession"
                           {{isset($prescription) && $prescription->type == 2 ? 'checked' : ''}} value="2">
                    <label class="form-check-label" for="chkSession">{{ trans('main_trans.session') }}</label>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        @php $input = 'patient_id' @endphp
        <div class="col-md-12">
            <div class="form-group">
                <label>{{ trans('main_trans.patient') }}</label>
                <select name="{{$input}}" class="form-control select2 sel-doctor" style="width: 100%;">
                    <option selected="" disabled="">{{ trans('main_trans.select_patient') }}</option>
                    @foreach($patient_rows as $patient_row)
                        <option value="{{$patient_row->id}}"
                            {{isset($row) && $row->$patient_row == $patient_row->id ? 'selected' : ''}}>{{$patient_row->name}}</option>
                    @endforeach
                </select>
                @error($input)<span class="badge badge-danger"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    {{--get nOf doctors to show doctor drop down menu if nOf doctors is more than one and hide it if equal to one--}}
    @php $input = 'doctor_id' @endphp
    @if($count_doctors > 1)
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>{{ trans('main_trans.doctor') }}</label>
                    <select name="{{$input}}" class="form-control select2" id="doctor" style="width: 100%;">
                        <option selected="" disabled="">{{ trans('main_trans.select_doctor') }}</option>
                        @foreach($doctor_rows as $doctor_row)
                            <option value="{{$doctor_row->id}}"
                                {{isset($row) && $row->doctor_id == $doctor_row->id ? 'selected' : ''}}>{{$doctor_row->name}}</option>
                        @endforeach
                    </select>
                    @error($input)<span class="badge badge-danger"
                                        role="alert"><strong>{{ $message }}</strong></span>@enderror
                </div>
            </div>
        </div>
    @else
        <input type="hidden" value="{{$doctor_rows[0]->id}}" name="{{$input}}" id="has_one_doctor_id">
    @endif
    <div class="row">
        <div class="col-md-6 form-group datepickerdiv">
            <label class="control-label">{{ trans('main_trans.date') }}</label>
            <div class="form-group">
                <input type="date" class="form-control appointment-date"
                       name="date" id="date" data-provide="datepicker"
                       data-date-autoclose="true" autocomplete="on" min="{{date("Y-m-d")}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 form-group">
            <label for="" class="d-block">{{ trans('main_trans.available_time') }}</label>
            <div class="btn-group btn-group-toggle available_time">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 form-group">
            <label for="" class="d-block">{{ trans('main_trans.available_slot) }}</label>
            <div class="btn-group btn-group-toggle available_slot d-block"
                 data-toggle="buttons">
            </div>
        </div>
    </div>
</div>

