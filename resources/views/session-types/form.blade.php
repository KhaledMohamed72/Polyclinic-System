@csrf
<div class="card-body">
    <div class="row">
        @php $input = 'name' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">Session Type name</label>
                <input type="text" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
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

    <!-- /.card-body -->
</div>

