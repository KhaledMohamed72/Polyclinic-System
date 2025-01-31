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
    </div>
    <div class="row">
        @php $input = 'gender' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">{{ trans('main_trans.gender') }}</label>
                <select name="{{$input}}" class="form-control select2" style="width: 100%;">
                    <option selected="" disabled="">{{ trans('main_trans.select_gender') }}</option>
                    <option value="male" {{isset($row) && $row->$input == 'male' ? 'selected' : ''}}>Male</option>
                    <option value="female" {{isset($row) && $row->$input == 'female' ? 'selected' : ''}}>Female</option>
                </select>
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
        @php $input = 'age' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">{{ trans('main_trans.age') }}</label>
                <input type="number" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'address' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ trans('main_trans.address') }}</label>
                <input type="text" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>

        @php $input = 'height' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">{{ trans('main_trans.height') }}</label>
                <input type="number" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'weight' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">{{ trans('main_trans.weight') }}</label>
                <input type="number" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>

        @php $input = 'blood_group' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">{{ trans('main_trans.blood_group') }}</label>
                <select name="{{$input}}" class="form-control select2" style="width: 100%;">
                    <option selected="" disabled="">{{ trans('main_trans.select_blood_group') }}</option>
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
    </div>
    <div class="row">
        @php $input = 'blood_pressure' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">{{ trans('main_trans.blood_pressure') }}</label>
                <input type="number" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
        @php $input = 'pulse' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInput{{$input}}">{{ trans('main_trans.pulse') }}</label>
                <input type="number" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <div class="row">
        @php $input = 'allergy' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ trans('main_trans.allergy') }}</label>
                <input type="text" name="{{$input}}" value="{{isset($row) ? $row->$input : old($input)}}"
                       class="form-control @error($input) is-invalid @enderror" id="exampleInput{{$input}}"
                       placeholder="">
                @error($input)<span class="invalid-feedback"
                                    role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>

