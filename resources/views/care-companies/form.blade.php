@csrf

<div class="card-body">
    <div class="row">
        @php $input = 'name' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">Company Name</label>
                <input type="text" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="Enter {{$input}}">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'from' @endphp
        <div class="col-md-6 form-group datepickerdiv">
            <label class="control-label">Date From</label>
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
            <label class="control-label">Date To</label>
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
                <label for="exampleInput{{$input}}">Discount Rate</label>
                <input type="number" min="1" max="100" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
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
            @error($input)<span class="badge badge-danger"
                                role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>
    </div>
</div>

