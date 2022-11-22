@csrf

<div class="card-body">
    <div class="row">
        @php $input = 'patient' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label>Patient</label>
                <select name="{{$input}}" class="form-control select2 sel-doctor" style="width: 100%;">
                    <option selected="" disabled="">Select Patient</option>
                    @foreach($patient_rows as $patient_row)
                        <option value="{{$patient_row->patient_id}}"
                            {{isset($row) && $row->patient_id == $patient_row->patient_id ? 'selected' : ''}}>{{$patient_row->name}}</option>
                    @endforeach
                </select>
                @error($input)<span class="badge badge-danger"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'type' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label>Session Type</label>
                <select name="{{$input}}" class="form-control select2 sel-doctor" style="width: 100%;">
                    <option selected="" disabled="">Select Session Type</option>
                    @foreach($session_rows as $session_row)
                        <option value="{{$session_row->id}}"
                            {{isset($row) && $row->session_type_id == $session_row->id ? 'selected' : ''}}>{{$session_row->name}}</option>
                    @endforeach
                </select>
                @error($input)<span class="badge badge-danger"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'date' @endphp
        <div class="col-md-6 form-group datepickerdiv">
            <label class="control-label">Date</label>
            <div class="form-group">
                <input type="date" value="{{isset($row) ? $row->$input : old($input)}}" class="form-control session-date"
                       name="{{$input}}" id="date" data-provide="datepicker"
                       data-date-autoclose="true" autocomplete="on" min="{{date("Y-m-d")}}">
                @error($input)<span class="badge badge-danger"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'fees' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">Session Fees</label>
                <input type="number" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="Enter {{$input}}">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'note' @endphp
        <div class="col-md-6">
            <label for="exampleInput{{$input}}">Note</label>
            <textarea name="{{$input}}" class="form-control" rows="3" placeholder="Enter Note" spellcheck="false">{{isset($row) ? $row->$input : old($input)}}</textarea>
            @error($input)<span class="invalid-feedback"
                                role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>
    </div>
</div>

