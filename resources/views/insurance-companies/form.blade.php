@csrf

<div class="card-body">
    {{--get nOf doctors to show doctor drop down menu if nOf doctors is more than one and hide it if equal to one--}}
    @php $input = 'doctor_id' @endphp
    @if($count_rows > 1 && auth()->user()->hasRole(['admin', 'recep']))
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{ trans('main_trans.doctor') }}</label>
                    <select name="{{$input}}" class="form-control select2" style="width: 100%;">
                        <option selected="" disabled="">{{ trans('main_trans.select_doctor') }}</option>
                        @foreach($rows as $doctor_row)
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
        <input type="hidden" value="{{$rows[0]->id}}" name="{{$input}}">
    @endif
    <div class="row">
        @php $input = 'name' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">{{ trans('main_trans.name') }}</label>
                <input type="text" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'from' @endphp
        <div class="col-md-6 form-group datepickerdiv">
            <label class="control-label">{{ trans('main_trans.from') }}</label>
            <div class="form-group">
                <input type="date" value="{{isset($row) ? $row->$input : old($input)}}" class="form-control session-date"
                       name="{{$input}}" id="date" data-provide="datepicker"
                       data-date-autoclose="true" autocomplete="on">
                @error($input)<span class="badge badge-danger"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'to' @endphp
        <div class="col-md-6 form-group datepickerdiv">
            <label class="control-label">{{ trans('main_trans.to') }}</label>
            <div class="form-group">
                <input type="date" value="{{isset($row) ? $row->$input : old($input)}}" class="form-control session-date"
                       name="{{$input}}" id="date" data-provide="datepicker"
                       data-date-autoclose="true" autocomplete="on">
                @error($input)<span class="badge badge-danger"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'discount_rate' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">{{ trans('main_trans.discount_rate') }}</label>
                <input type="number" min="1" max="100" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
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

