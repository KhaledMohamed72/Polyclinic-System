@csrf

<div class="card-body">
    <div class="row">
        @php $input = 'type' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ trans('main_trans.type') }}</label>
                <select name="{{$input}}" class="form-control select2" style="width: 100%;">
                    <option selected="" disabled="">{{ trans('main_trans.select_type') }}</option>
                    @foreach($type_rows as $type_row)
                        <option value="{{$type_row->id}}"
                            {{isset($row) && $row->income_type_id == $type_row->id ? 'selected' : ''}}>{{$type_row->name}}</option>
                    @endforeach
                </select>
                @error($input)<span style="color: red;font-size: smaller"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    {{--get nOf doctors to show doctor drop down menu if nOf doctors is more than one and hide it if equal to one--}}
    @if($count_doctors > 1)
        <div class="row">
            @php $input = 'doctor_id' @endphp
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{ trans('main_trans.doctor') }}<small>{{ trans('main_trans.doctor_hintI') }}</small></label>
                    <select name="{{$input}}" class="form-control select2" style="width: 100%;">
                        <option selected="" disabled="">{{ trans('main_trans.select_doctor') }}</option>
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
        <input type="hidden" value="{{$doctor_rows[0]->id}}" name="has_one_doctor_id">
    @endif
    <div class="row">
        @php $input = 'date' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">{{ trans('main_trans.date') }}</label>
                <input type="date" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'amount' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">{{ trans('main_trans.amount') }}</label>
                <input type="number" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'note' @endphp
        <div class="col-md-6">
            <label for="exampleInput{{$input}}">{{ trans('main_trans.note') }}</label>
            <textarea name="{{$input}}" class="form-control" rows="3" placeholder="Enter Note" spellcheck="false">{{isset($row) ? $row->$input : old($input)}}</textarea>
            @error($input)<span class="badge badge-danger"
                                role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
</div>


