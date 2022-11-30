<div class="card-body">
    <div class="row">
        @php $input = 'patient' @endphp
        <div class="col-sm-4">
            <div class="form-group">
                <label>Patient</label>
                <select name="{{$input}}" class="form-control select2 sel-doctor" style="width: 100%;">
                    <option selected="" disabled="">Select Patient</option>
                    @foreach($patient_rows as $patient_row)
                        <option value="{{$patient_row->id}}"
                            {{old($input) == $patient_row->id? 'selected' : ''}}>{{$patient_row->name}}</option>
                    @endforeach
                </select>
                @error($input)<span class="badge badge-danger"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
        @php $input = 'from' @endphp
        <div class="col-sm-4 form-group datepickerdiv">
            <label class="control-label">From</label>
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
            <label class="control-label">To</label>
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
                        Include Sessions
                    </label>
                </div>
            </div>
        </div>
    </div>

</div>
