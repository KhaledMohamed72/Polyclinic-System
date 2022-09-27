@csrf

<div class="card-body">
    <div class="row">
        @php $input = 'name' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">Doctor name</label>
                <input type="text" name="{{$input}}" value="{{isset($row[0]) ? $row[0]->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="Enter {{$input}}">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
        @php $input = 'email' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">Email</label>
                <input type="email" name="{{$input}}" value="{{isset($row[0]) ? $row[0]->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="Enter {{$input}}">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'password' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">Password</label>
                <input type="password" name="{{$input}}" value="{{isset($row[0]) ? $row[0]->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="Enter {{$input}}">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
        @php $input = 'password_confirmation' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">Confirm Password</label>
                <input type="password" name="{{$input}}" value=""
                       class="form-control" id="exampleInput{{$input}}"
                       placeholder="Confirm your password">
                @error('password_confirmation')<span class="invalid-feedback"
                                                     role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'phone' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">Contact No</label>
                <input type="text" name="{{$input}}" value="{{isset($row[0]) ? $row[0]->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="Enter {{$input}}">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
        @php $input = 'title' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">Title</label>
                <input type="text" name="{{$input}}" value="{{isset($row[0]) ? $row[0]->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="Enter {{$input}}">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'degree' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">Degree</label>
                <input type="text" name="{{$input}}" value="{{isset($row[0]) ? $row[0]->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="Enter {{$input}}">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
        @php $input = 'specialist' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">Specialist</label>
                <input type="text" name="{{$input}}" value="{{isset($row[0]) ? $row[0]->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="Enter {{$input}}">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'slot_time' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label>Slot Time (in minutes)</label>
                <select name="{{$input}}" id="some_select" class="form-control select2" style="width: 100%;">
                </select>
            </div>
        </div>
        @php $input = 'fees' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">Fees</label>
                <input type="number" name="{{$input}}" value="{{isset($row[0]) ? $row[0]->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="Enter {{$input}}">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'bio' @endphp
        <div class="col-md-6">

                <label for="exampleInput{{$input}}">Short Biography</label>
                <textarea id="summernote" name="{{$input}}">

              </textarea>
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>

        @php $input = 'image' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <p><label for="exampleInput{{$input}}">Profile Photo</label></p>

                <img class="rounded-circle" src="
                {{isset($row[0]) && $row[0]->profile_photo_path != '' ? asset('images/users/'.$row[0]->profile_photo_path) : asset('assets/dist/img/noimage.png')}}" style="width: 20%;margin-left: 100px;" id="profile_display"
                     onclick="triggerClick()" data-toggle="tooltip" data-placement="top" title="Click to Upload Profile Photo"
                     data-original-title="Click to Upload Profile Photo">
                <input type="file" name="{{$input}}" tabindex="8" id="profile_photo" style="display:none;"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       onchange="displayProfile(this)">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>

    <!-- /.card-body -->
</div>

