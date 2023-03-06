@csrf

<div class="card-body">
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
        @php $input = 'email' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">{{ trans('main_trans.email') }}</label>
                <input type="email" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    {{--<div class="row">
        @php $input = 'password' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">Password</label>
                <input type="password" name="{{$input}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
        @php $input = 'password_confirmation' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">Confirm Password</label>
                <input type="password" name="{{$input}}"
                       class="form-control" id="exampleInput{{$input}}"
                       placeholder="Confirm your password">
                @error('password_confirmation')<span class="invalid-feedback"
                                                     role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>--}}
    <div class="row">
        @php $input = 'phone' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">{{ trans('main_trans.contact_number') }}</label>
                <input type="text" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
        @php $input = 'title' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">{{ trans('main_trans.title') }}</label>
                <input type="text" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'degree' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">{{ trans('main_trans.degree') }}</label>
                <input type="text" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
        @php $input = 'specialist' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">{{ trans('main_trans.specialist') }}</label>
                <input type="text" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'slot_time' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ trans('main_trans.slot_time') }}</label>
                <select name="{{$input}}" id="some_select" class="form-control select2" style="width: 100%;">
                    @for($i = 5;$i <= 60;$i+=5)
                        <option
                            value="{{$i}}" {{isset($row) && $row->slot_time == $i ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
                </select>
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
        @php $input = 'examination_fees' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">{{ trans('main_trans.examination_fees') }}</label>
                <input type="number" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'followup_fees' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">{{ trans('main_trans.followups_fees') }}</label>
                <input type="number" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
        @php $input = 'receptionist' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ trans('main_trans.receptionist') }}</label>
                <select name="{{$input}}" class="form-control select2" style="width: 100%;">
                    <option selected="" disabled="">{{ trans('main_trans.select_receptionist') }} </option>
                    @foreach($rows as $receptionist)
                        <option
                            value="{{$receptionist->id}}" {{ (isset($row) && $receptionist->id == $row->receptionist_id ? 'selected' : '') }}>{{$receptionist->name}}</option>
                    @endforeach
                </select>
                @error($input)<span class="badge badge-danger"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'bio' @endphp
        <div class="col-md-6">
            <label for="exampleInput{{$input}}">{{ trans('main_trans.short_biography') }}</label>
            <textarea id="summernote" name="{{$input}}">

              </textarea>
            @error($input)<span class="badge badge-danger"
                                role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>
        @php $input = 'image' @endphp
        <div class="col-md-6">
            <div class="form-group ml-4">
                <p><label for="exampleInput{{$input}}">{{ trans('main_trans.profile_photo') }}</label></p>

                <img class="rounded-circle" src="
                {{isset($row) && $row->profile_photo_path != '' ? asset('images/users/'.$row->profile_photo_path) : asset('assets/dist/img/noimage.png')}}"
                     style="width: 20%;margin-left: 100px;" id="profile_display"
                     onclick="triggerClick()" data-toggle="tooltip" data-placement="top"
                     title="Click to Upload Profile Photo"
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

