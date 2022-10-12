@csrf

<div class="card-body">

    {{--get nOf doctors to show doctor drop down menu if nOf doctors is more than one and hide it if equal to one--}}
    @if($count_doctors > 1)
        <div class="row">
            @php $input = 'doctor_id' @endphp
            <div class="col-md-6">
                <div class="form-group">
                    <label>Doctor</label>
                    <select name="{{$input}}" class="form-control select2" style="width: 100%;">
                        <option selected="" disabled="">Select Doctor</option>
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
        @php $input = 'name' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">Patient name</label>
                <input type="text" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
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
                <input type="email" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="Enter {{$input}}">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    {{--    <div class="row">
            @php $input = 'password' @endphp
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInput{{$input}}">Password</label>
                    <input type="password" name="{{$input}}"
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
                <label for="exampleInput{{$input}}">Contact Number</label>
                <input type="text" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="Enter {{$input}}">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
        @php $input = 'gender' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">Gender</label>
                <select name="{{$input}}" class="form-control select2" style="width: 100%;">
                    <option selected="" disabled="">Select Gender</option>
                    <option value="male" {{isset($row) && $row->$input == 'male' ? 'selected' : ''}}>Male</option>
                    <option value="female" {{isset($row) && $row->$input == 'female' ? 'selected' : ''}}>Female</option>
                </select>
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'age' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">Age</label>
                <input type="number" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="Enter {{$input}}">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
        @php $input = 'address' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label>Address</label>
                <input type="text" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="Enter {{$input}}">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'height' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">Height</label>
                <input type="number" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="Enter {{$input}}">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
        @php $input = 'weight' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">Weight</label>
                <input type="number" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="Enter {{$input}}">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'blood_group' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">Blood Group</label>
                <select name="{{$input}}" class="form-control select2" style="width: 100%;">
                    <option selected="" disabled="">Select Blood Group</option>
                    <option value="A+" {{isset($row) && $row->$input == 'A+' ? 'selected' : ''}}>A+</option>
                    <option value="A-" {{isset($row) && $row->$input == 'A-' ? 'selected' : ''}}>A-</option>
                    <option value="B+" {{isset($row) && $row->$input == 'B+' ? 'selected' : ''}}>B+</option>
                    <option value="B-" {{isset($row) && $row->$input == 'B-' ? 'selected' : ''}}>B-</option>
                    <option value="O+" {{isset($row) && $row->$input == 'O+' ? 'selected' : ''}}>O+</option>
                    <option value="O-" {{isset($row) && $row->$input == 'O-' ? 'selected' : ''}}>O-</option>
                    <option value="AB+" {{isset($row) && $row->$input == 'AB+' ? 'selected' : ''}}>AB+</option>
                    <option value="AB-" {{isset($row) && $row->$input == 'AB-' ? 'selected' : ''}}>AB-</option>
                </select>
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
        @php $input = 'blood_pressure' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">Blood Pressure</label>
                <input type="number" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="Enter {{$input}}">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'pulse' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">Pulse</label>
                <input type="number" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="Enter {{$input}}">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
        @php $input = 'allergy' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label>Allergy</label>
                <input type="text" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="Enter {{$input}}">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>

