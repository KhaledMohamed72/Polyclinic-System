<div class="card-body">
    <div class="row">
        @php $input = 'patient' @endphp
        <div class="col-sm-4">
            <div class="form-group">
                <label>{{ trans('main_trans.patient') }}</label>
                <select name="{{$input}}" class="form-control select2 sel-doctor" style="width: 100%;">
                    <option selected="" disabled="">{{ trans('main_trans.select_patient') }}</option>
                    @foreach($patient_rows as $patient_row)
                        <option value="{{$patient_row->user_id}}"
                            {{old($input) == $patient_row->user_id ? 'selected' : ''}}>{{$patient_row->patient_name}}</option>
                    @endforeach
                </select>
                @error($input)<span class="badge badge-danger"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
        @php $input = 'from' @endphp
        <div class="col-sm-4 form-group datepickerdiv">
            <label class="control-label">{{ trans('main_trans.from') }}</label>
            <div class="form-group">
                <input type="date" class="form-control appointment-date"
                       name="{{$input}}" value="{{old('from')}}" id="date" data-provide="datepicker"
                       data-date-autoclose="true" autocomplete="on">
                @error($input)<span class="badge badge-danger"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
        @php $input = 'to' @endphp
        <div class="col-sm-4 form-group datepickerdiv">
            <label class="control-label">{{ trans('main_trans.to') }}</label>
            <div class="form-group">
                <input type="date" class="form-control appointment-date"
                       name="{{$input}}" value="{{old('to')}}" id="date" data-provide="datepicker"
                       data-date-autoclose="true" autocomplete="on">
                @error($input)<span class="badge badge-danger"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group float-right">
                <div class="icheck-primary d-inline">
                    <input type="checkbox" name="sessions" value="1"
                           id="checkboxPrimarypatient-history">
                    <label for="checkboxPrimarypatient-history">
                        {{ trans('main_trans.sessions') }}
                    </label>
                </div>
            </div>
        </div>
    </div>

</div>
