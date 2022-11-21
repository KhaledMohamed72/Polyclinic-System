@csrf
<div class="card-body">
    <div class="row">
        @php $input = 'header' @endphp
        <div class="col-md-8">
            <label for="exampleInput{{$input}}">Prescription Header</label>
            <textarea id="summernote1" name="{{$input}}">
                {{isset($row) ? $row->$input : old($input)}}
              </textarea>
            @error($input)<span class="badge badge-danger"
                                role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>
    </div>
    <div class="row">
        @php $input = 'footer' @endphp
        <div class="col-md-8">
            <label for="exampleInput{{$input}}">Prescription Footer</label>
            <textarea id="summernote2" name="{{$input}}">
                {{isset($row) ? $row->$input : old($input)}}
              </textarea>
            @error($input)<span class="badge badge-danger"
                                role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>
    </div>
    <!-- /.card-body -->
</div>
