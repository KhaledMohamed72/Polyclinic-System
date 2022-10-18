@csrf

<div class="card-body">
    <div class="row">
        @php $input = 'patient' @endphp
        <div class="col-md-12">
            <div class="form-group">
                <label>Patient</label>
                <select name="{{$input}}" class="form-control select2 sel-doctor" style="width: 100%;">
                    <option selected="" disabled="">Select Patient</option>
                    @foreach($patient_rows as $patient_row)
                        <option value="{{$patient_row->id}}"
                            {{isset($row) && $row->$patient_row == $patient_row->id ? 'selected' : ''}}>{{$patient_row->name}}</option>
                    @endforeach
                </select>
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    {{--get nOf doctors to show doctor drop down menu if nOf doctors is more than one and hide it if equal to one--}}
    @if($count_doctors > 1)
        <div class="row">
            @php $input = 'doctor_id' @endphp
            <div class="col-md-12">
                <div class="form-group">
                    <label>Doctor</label>
                    <select name="{{$input}}" class="form-control select2" id="doctor" style="width: 100%;">
                        <option selected="" disabled="">Select Doctor</option>
                        @foreach($doctor_rows as $doctor_row)
                            <option value="{{$doctor_row->id}}"
                                {{isset($row) && $row->doctor_id == $doctor_row->id ? 'selected' : ''}}>{{$doctor_row->name}}</option>
                        @endforeach
                    </select>
                    @error($input)<span class="invalid-feedback"
                                        role="alert"><strong>{{ $message }}</strong></span>@enderror
                </div>
            </div>
        </div>
    @else
        <input type="hidden" value="{{$doctor_rows[0]->id}}" name="has_one_doctor_id" id="has_one_doctor_id">
    @endif
    <div class="row">
        <div class="col-md-6 form-group datepickerdiv">
            <label class="control-label">Date</label>
            <div class="form-group">
                <input type="date" class="form-control appointment-date"
                       name="date" id="date" data-provide="datepicker"
                       data-date-autoclose="true" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 form-group">
            <label for="" class="d-block">Available Time</label>
            <div class="btn-group btn-group-toggle available_time" data-toggle="buttons">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 form-group">
            <label for="" class="d-block">Available Slot</label>
            <div class="btn-group btn-group-toggle availble_slot d-block"
                 data-toggle="buttons">
            </div>
        </div>

    </div>
</div>

