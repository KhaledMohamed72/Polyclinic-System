@csrf

<div class="card-body">
    <div class="row">
        @php $input = 'patient' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ trans('main_trans.patient') }}</label>
                <select name="{{$input}}" class="form-control select2 sel-doctor" style="width: 100%;">
                    <option selected="" disabled="">{{ trans('main_trans.select_patient') }}</option>
                    @foreach($patient_rows as $patient_row)
                        <option value="{{$patient_row->patient_id}}"
                            {{isset($row) && $row->patient_id == $patient_row->patient_id ? 'selected' :
                                (isset($_GET['patient_id']) && $_GET['patient_id']== $patient_row->patient_id ? 'selected' : '')}}>{{$patient_row->name}}</option>
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
                <label>{{ trans('main_trans.type') }}</label>
                <select name="{{$input}}" class="form-control select2 sel-doctor" style="width: 100%;">
                    <option selected="" disabled="">{{ trans('main_trans.select_type') }}</option>
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
            <label class="control-label">{{ trans('main_trans.date') }}</label>
            <div class="form-group">
                <input type="date" value="{{isset($row) ? $row->$input :
                                            (isset($_GET['date']) ? $_GET['date'] : old($input))}}" class="form-control session-date"
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
                <label for="exampleInput{{$input}}">{{ trans('main_trans.session_fees') }}</label>
                <input type="number" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    @if(!$insurance_companies_rows->isEmpty())
        <div class="row">
            <div class="col-sm-6 form-group">
                <label class="control-label">{{ trans('main_trans.insurance_company') }}</label>
                @php $input = 'insurance_company_id'; @endphp
                <select
                    class="form-control select2"
                    name="{{$input}}">
                    <option selected>{{ trans('main_trans.select_company') }}</option>
                    @foreach($insurance_companies_rows as $company)
                        <option value="{{$company->id}}" {{isset($row) && $row->insurance_company_id == $company->id ? 'selected' : ''}}>
                            {{$company->name}}</option>
                    @endforeach
                </select>
                @error($input)<span style="color: red;font-size: smaller"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    @endif
    <div class="row">
        @php $input = 'note' @endphp
        <div class="col-md-6">
            <label for="exampleInput{{$input}}">{{ trans('main_trans.note') }}</label>
            <textarea name="{{$input}}" class="form-control" rows="3" placeholder="{{ trans('main_trans.note') }}" spellcheck="false">{{isset($row) ? $row->$input : old($input)}}</textarea>
            @error($input)<span class="badge badge-danger"
                                role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>
    </div>
</div>

