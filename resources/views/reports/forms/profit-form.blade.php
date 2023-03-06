<div class="card-body">
    <div class="row">
        @php $input = 'doctor' @endphp
        @if(auth()->user()->hasRole('admin') && $clinicType == 1)
            <div class="col-sm-4">
                <div class="form-group">
                    <label>{{ trans('main_trans.doctor') }}<small>{{ trans('main_trans.doctor_hintR') }}</small></label>
                    <select name="{{$input}}" class="form-control select2 sel-doctor" style="width: 100%;">
                        <option selected="" disabled="">{{ trans('main_trans.select_doctor') }}</option>
                        @foreach($doctor_rows as $doctor_row)
                            <option value="{{$doctor_row->user_id}}"
                                {{old($input) == $doctor_row->user_id? 'selected' : ''}}>{{$doctor_row->doctor_name}}</option>
                        @endforeach
                    </select>
                    @error($input)<span class="badge badge-danger"
                                        role="alert"><strong>{{ $message }}</strong></span>@enderror
                </div>
            </div>
        @else
            <input type="hidden" name="{{$input}}" value="{{$doctor_rows[0]->user_id}}">
        @endif
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
</div>
