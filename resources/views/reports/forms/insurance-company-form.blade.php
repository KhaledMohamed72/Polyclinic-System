<div class="card-body">
    <div class="row">
        @php $input = 'company' @endphp
        <div class="col-sm-4">
            <div class="form-group">
                <label>{{ trans('main_trans.company') }}</label>
                <select name="{{$input}}" class="form-control select2 sel-company" style="width: 100%;">
                    <option selected="" disabled="">{{ trans('main_trans.select_company') }}</option>
                    @foreach($company_rows as $company_row)
                        <option value="{{$company_row->id}}"
                            {{old($input) == $company_row->id ? 'selected' : ''}}>{{$company_row->name}}</option>
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
            <div class="form-group text-right">
                <div class="icheck-primary d-inline">
                    <input type="checkbox" name="sessions" value="1"
                           id="sessions-history">
                    <label for="sessions-history">
                        {{ trans('main_trans.sessions') }}
                    </label>
                </div>
            </div>
        </div>
    </div>

</div>
