<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasRole(['admin', 'doctor', 'recep'])) {
            toastr()->warning('Something went wrong!');
            return redirect()->route('home');
        }
// filter doctors according to role of current auth user
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('users')
                ->join('patients', 'patients.user_id', '=', 'users.id')
                ->join('role_user', 'role_user.user_id', '=', 'patients.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->select('users.*')
                ->paginate(10);
        } elseif (auth()->user()->hasRole('recep')) {
            $rows = DB::table('users')
                ->join('patients', 'patients.user_id', '=', 'users.id')
                ->join('role_user', 'role_user.user_id', '=', 'patients.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->where('patients.receptionist_id', '=', auth()->user()->id)
                ->select('users.*')
                ->paginate(10);
        } else {
            $rows = DB::table('users')
                ->join('patients', 'patients.user_id', '=', 'users.id')
                ->join('role_user', 'role_user.user_id', '=', 'patients.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->where('patients.doctor_id', '=', auth()->user()->id)
                ->select('users.*')
                ->paginate(10);
        }
        return view('patients.index', compact('rows'));
    }

    public function create()
    {
        if (!auth()->user()->hasRole(['admin', 'doctor', 'recep'])) {
            toastr()->warning('Something went wrong!');
            return redirect()->route('home');
        }
        // list of doctors if the role is admin
        if (auth()->user()->hasRole('admin')) {
            $doctor_rows = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->join('role_user', 'role_user.user_id', '=', 'doctors.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->select('users.id', 'users.name')
                ->get();
        }

        // list of doctors if the role is recep
        if (auth()->user()->hasRole('recep')) {
            $doctor_rows = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->join('role_user', 'role_user.user_id', '=', 'doctors.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->where('doctors.receptionist_id', '=', auth()->user()->id)
                ->select('users.id', 'users.name')
                ->get();
        }
        if (auth()->user()->hasRole('doctor')) {
            $doctor_rows = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->join('role_user', 'role_user.user_id', '=', 'doctors.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->where('doctors.user_id', '=', auth()->user()->id)
                ->select('users.id', 'users.name')
                ->get();
        }
        // get nOf doctors to show doctor drop down menu if nOf doctors is more than one and hide it if equal to one
        $count_doctors = count($doctor_rows);
        if ($count_doctors == 0) {
            toastr()->warning('You must create doctors first !');
            return redirect()->route('doctors.create');
        }
        return view('patients.create', compact('doctor_rows', 'count_doctors'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasRole(['admin', 'doctor', 'recep'])) {
            toastr()->warning('Something went wrong!');
            return redirect()->route('home');
        }
        $this->validate($request, [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['nullable', 'string', 'email', 'max:191', 'unique:users'],
            'phone' => ['required', 'numeric', 'digits:11'],
            'gender' => ['nullable', 'string', 'max:8'],
            'age' => ['nullable', 'integer'],
            'address' => ['nullable', 'string', 'max:191'],
            'height' => ['nullable', 'integer'],
            'weight' => ['nullable', 'numeric'],
            'blood_group' => ['nullable', 'string', 'max:8'],
            'blood_pressure' => ['nullable', 'numeric'],
            'pulse' => ['nullable', 'numeric'],
            'allergy' => ['nullable', 'string', 'max:191'],
        ]);
        // patient email not required so i have to escape this because DB does'nt accept this

        if (empty($request->email)) {
            $request->email = 'patient' . time() . '' . random_int(100,100000) . '@gmail.com';
        }
        // insert general info into users table
        $user = DB::table('users')->insert([
            'clinic_id' => $this->getClinic()->id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make(123123123),
            'phone' => $request->phone,
        ]);
        $user_id = DB::getPdo()->lastInsertId();

        // insert the rest of info into Patients table
        // get recep and doctor ids
        // if the form has input doctor
        if ($request->has('doctor_id') && $request->doctor_id != '') {
            $doctor = Doctor::where('user_id', $request->doctor_id)->first();
            $receptionist_id = $doctor['receptionist_id'];
            $doctor_id = $request->doctor_id;
        } else {
            $doctor = Doctor::where('user_id', $request->has_one_doctor_id)->first();
            $receptionist_id = $doctor['receptionist_id'];
            $doctor_id = $doctor['user_id'];
        }

        $patient = DB::table('patients')->insert([
            'clinic_id' => $this->getClinic()->id,
            'user_id' => $user_id,
            'doctor_id' => $doctor_id,
            'receptionist_id' => $receptionist_id,
            'gender' => $request->gender,
            'age' => $request->age,
            'address' => $request->address,
            'height' => $request->height,
            'weight' => $request->weight,
            'blood_group' => $request->blood_group,
            'blood_pressure' => $request->blood_pressure,
            'pulse' => $request->pulse,
            'allergy' => $request->allergy,
        ]);

        // Give a role
        $role_id = DB::table('roles')->where('name', '=', 'patient')->first();
        $role_user = DB::table('role_user')->insert([
            'user_id' => $user_id,
            'role_id' => $role_id->id
        ]);
        if ($user && $patient && $role_user) {
            toastr()->success('Successfully Created');
            return redirect()->route('patients.index');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('patients.index');
        }
    }

    public function edit($id)
    {
        if (!auth()->user()->hasRole(['admin', 'doctor', 'recep'])) {
            toastr()->warning('Something went wrong!');
            return redirect()->route('home');
        }
        $row = DB::table('users')
            ->join('patients', 'patients.user_id', '=', 'users.id')
            ->where('users.clinic_id', '=', $this->getClinic()->id)
            ->where('users.id', '=', $id)
            ->select('users.*', 'users.id as userId', 'patients.*')
            ->first();

        // list of doctors if the role is admin
        if (auth()->user()->hasRole('admin')) {
            $doctor_rows = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->join('role_user', 'role_user.user_id', '=', 'doctors.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->select('users.id', 'users.name')
                ->get();
        }

        // list of doctors if the role is recep
        if (auth()->user()->hasRole('recep')) {
            $doctor_rows = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->join('role_user', 'role_user.user_id', '=', 'doctors.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->where('doctors.receptionist_id', '=', auth()->user()->id)
                ->select('users.id', 'users.name')
                ->get();
        }
        // list of doctors if the role is doctor
        if (auth()->user()->hasRole('doctor')) {
            $doctor_rows = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->join('role_user', 'role_user.user_id', '=', 'doctors.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->where('doctors.user_id', '=', auth()->user()->id)
                ->select('users.id', 'users.name')
                ->get();
        }
        // get nOf doctors to show doctor drop down menu if nOf doctors is more than one and hide it if equal to one
        $count_doctors = count($doctor_rows);
        return view('patients.edit',compact('row','count_doctors','doctor_rows'));
    }

    public function update($id, Request $request)
    {
        if (!auth()->user()->hasRole(['admin', 'doctor', 'recep'])) {
            toastr()->warning('Something went wrong!');
            return redirect()->route('home');
        }

        $row = DB::table('users')
            ->join('patients', 'patients.user_id', '=', 'users.id')
            ->where('users.clinic_id', '=', $this->getClinic()->id)
            ->where('users.id', '=', $id)
            ->select('users.*', 'users.id as userId', 'patients.*')
            ->first();

        $this->validate($request, [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['nullable', 'string', 'email', 'max:191', 'unique:users,email,' . $row->userId],
            'phone' => ['required', 'numeric', 'digits:11'],
            'gender' => ['nullable', 'string', 'max:8'],
            'age' => ['nullable', 'integer'],
            'address' => ['nullable', 'string', 'max:191'],
            'height' => ['nullable', 'integer'],
            'weight' => ['nullable', 'numeric'],
            'blood_group' => ['nullable', 'string', 'max:8'],
            'blood_pressure' => ['nullable', 'numeric'],
            'pulse' => ['nullable', 'numeric'],
            'allergy' => ['nullable', 'string', 'max:191'],
        ]);

        $user = DB::table('users')
            ->where('id', '=', $id)
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
        // insert the rest of info into Patients table
        // get recep and doctor ids
        // if the form has input doctor
        if ($request->has('doctor_id') && $request->doctor_id != '') {
            $doctor = Doctor::where('user_id', $request->doctor_id)->first();
            $receptionist_id = $doctor['receptionist_id'];
            $doctor_id = $request->doctor_id;
        } else {
            $doctor = Doctor::where('user_id', $request->has_one_doctor_id)->first();
            $receptionist_id = $doctor['receptionist_id'];
            $doctor_id = $doctor['user_id'];
        }

        $patient = DB::table('patients')
            ->where('user_id', '=', $id)
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->update([
            'doctor_id' => $doctor_id,
            'receptionist_id' => $receptionist_id,
            'gender' => "'$request->gender'",
            'age' => $request->age,
            'address' => "'$request->address'",
            'height' => $request->height,
            'weight' => $request->weight,
            'blood_group' => "'$request->blood_group'",
            'blood_pressure' => $request->blood_pressure,
            'pulse' => $request->pulse,
            'allergy' => "'$request->allergy'",
        ]);

        if ($user && $patient) {
            toastr()->success('Successfully Updated');
            return redirect()->route('patients.index');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('patients.index');
        }
    }
    public function destroy($id)
    {
        if (!auth()->user()->hasRole(['admin', 'doctor', 'recep'])) {
            toastr()->warning('Something went wrong!');
            return redirect()->route('home');
        }
        $user = User::where('id', '=', $id)->first();
            $user = $user->delete();
        if ($user) {
            toastr()->success('Successfully Deleted');
            return redirect()->route('patients.index');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('patients.index');
        }
    }

    public function show($id)
    {
        $row = DB::table('users')
            ->join('patients', 'patients.user_id', '=', 'users.id')
            ->where('users.clinic_id', '=', $this->getClinic()->id)
            ->where('users.id', '=', $id)
            ->select('users.*', 'users.id as userId', 'patients.*')
            ->first();
        $doctor = DB::table('users')
            ->join('doctors','doctors.user_id','=','users.id')
            ->where('users.clinic_id', '=', $this->getClinic()->id)
            ->where('doctors.user_id','=',$row->doctor_id)
            ->select('users.*')
            ->first();

        if ($row) {
            if (auth()->user()->hasRole(['admin', 'recep','doctor'])) {
                return view('patients.show', compact('row','doctor'));
            } else {
                toastr()->warning('You can not allowed for this route !');
                return redirect()->route('patients.index');
            }
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('patients.index');
        }
    }
}
