@csrf
<div class="card-body">
    @if(auth()->user()->hasRole(['admin','recep']) && $clinicType == 1)
    <div class="row">
        @php $input = 'doctor' @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label>Doctor</label>
                <select name="{{$input}}" class="form-control select2" style="width: 100%;">
                    <option selected="" disabled="">Select Doctor</option>
                    @foreach($doctorsWithNoPrescription as $doctor)
                        <option
                            value="{{$doctor->doctor_id}}" {{ (isset($row) && $doctor->doctor_id == $row->doctor_id ? 'selected' : '') }}>{{$doctor->doctor_name}}</option>
                    @endforeach
                </select>
                @error($input)<span class="badge badge-danger" role="alert">
                    <strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
    </div>
    @else
        <input type="hidden" value="{{$doctorsWithNoPrescription->id}}" name="has_one_doctor_id">
    @endif
    <div class="row">
        @php $input = 'header' @endphp
        <div class="col-md-8">
            <label for="exampleInput{{$input}}">Prescription Header</label>
            <textarea id="summernote1" name="{{$input}}">
                {{isset($row) ? $row->$input : '<div style="text-align: center;"><font color="#000000" face="Times New Roman" size="3"><b>اللقب</b></font><br style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-weight: 700;"><span style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-weight: 700; font-size: large;"><strong>اسم الدكتور</strong></span><br style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-weight: 700;"><h6 class=""><font color="#000000" face="Times New Roman" size="3"><b>الاختصاص(مثال:</b></font><span style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: small; font-weight: 700;">استشارى الجهاز الهضمى والكبد</span><b style="color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium;">)</b></h6></div>'}}
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
                {{isset($row) ? $row->$input : '<table align="center" style="font-family: &quot;Times New Roman&quot;; width: 554.75px;"><tbody><tr align="center"><td><h6 class=""><strong><span style="font-size: x-small;">العنوان&nbsp;</span></strong></h6></td></tr><tr align="center"><td><h6><strong><span style="font-size: x-small;">موبايل&nbsp;</span></strong></h6></td></tr><tr align="center"><td><h6><strong><span style="font-size: x-small;">المواعيد</span></strong></h6></td></tr><tr align="center"><td><h6 class=""><br></h6></td></tr></tbody></table>'}}
              </textarea>
            @error($input)<span class="badge badge-danger"
                                role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>
    </div>
    <!-- /.card-body -->
</div>
