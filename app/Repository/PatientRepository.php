<?php

namespace App\Repository;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Repository\Interfaces\PatientRepositoryInterface;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PatientRepository extends Controller implements PatientRepositoryInterface
{
    use GeneralTrait;

    public function getPatientRows()
    {
        $rows = $this->getPatientsBasedOnRole($this->getClinic()->id, auth()->user()->id);
        return $rows;
    }

    public function getDoctorRows()
    {
        $rows = $this->getDoctorsBasedOnRole($this->getClinic()->id, auth()->user()->id);
        return $rows;
    }

    public function storePatient($request)
    {
        $this->validate($request, [
            'doctor_id' => ['required', 'integer'],
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
        // get recep
        $receptionist_id = Doctor::where('user_id', $request->doctor_id)->pluck('receptionist_id');
        // patient email not required so i have to escape this because DB doesn't accept this
        if (empty($request->email)) {
            $request->email = 'patient' . time() . '' . random_int(100, 100000) . '@gmail.com';
        }
        // insert general info into users table
        $user = DB::table('users')->insert([
            'clinic_id' => $this->getClinic()->id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('patient12=2'),
            'phone' => $request->phone,
        ]);
        $user_id = DB::getPdo()->lastInsertId();
        // insert the rest of info into Patients table
        $patient = DB::table('patients')->insert([
            'clinic_id' => $this->getClinic()->id,
            'user_id' => $user_id,
            'doctor_id' => $request->doctor_id,
            'receptionist_id' => $receptionist_id[0],
            'gender' => $request->gender,
            'age' => $request->age,
            'address' => $request->address,
            'height' => $request->height,
            'weight' => $request->weight,
            'blood_group' => $request->blood_group,
            'blood_pressure' => $request->blood_pressure,
            'pulse' => $request->pulse,
            'allergy' => $request->allergy,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        // Give a role
        $role_id = DB::table('roles')->where('name', '=', 'patient')->first();
        $role_user = DB::table('role_user')->insert([
            'user_id' => $user_id,
            'role_id' => $role_id->id
        ]);

        return $user && $patient && $role_user;
    }

    public function editPatient($id)
    {
        $row = DB::table('users')
            ->join('patients', 'patients.user_id', '=', 'users.id')
            ->where('users.clinic_id', '=', $this->getClinic()->id)
            ->where('users.id', '=', $id)
            ->select('users.*', 'users.id as userId', 'patients.*')
            ->first();
        $rows = $this->getDoctorsBasedOnRole($this->getClinic()->id, auth()->user()->id);
        return [$row, $rows];
    }

    public function updatePatient($id, $request)
    {
        $row = DB::table('users')
            ->join('patients', 'patients.user_id', '=', 'users.id')
            ->where('users.clinic_id', '=', $this->getClinic()->id)
            ->where('users.id', '=', $id)
            ->select('users.*', 'users.id as userId', 'patients.*')
            ->first();

        $this->validate($request, [
            'doctor_id' => ['required', 'integer'],
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
                'email' => $row->email,
                'phone' => $request->phone,
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
        // get recep id
        $receptionist_id = Doctor::where('user_id', $request->doctor_id)->pluck('receptionist_id');
        // insert the rest of info into Patients table
        $patient = DB::table('patients')
            ->where('user_id', '=', $id)
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->update(array(
                    'doctor_id' => $request->doctor_id,
                    'receptionist_id' => $receptionist_id[0],
                    'gender' => $request->gender,
                    'age' => $request->age,
                    'address' => $request->address,
                    'height' => $request->height,
                    'weight' => $request->weight,
                    'blood_group' => $request->blood_group,
                    'blood_pressure' => $request->blood_pressure,
                    'pulse' => $request->pulse,
                    'allergy' => $request->allergy,
                )
            );
        return $user && $patient;
    }

    public function showPatient($id)
    {
        $row = DB::table('users')
            ->join('patients', 'patients.user_id', '=', 'users.id')
            ->where('users.clinic_id', '=', $this->getClinic()->id)
            ->where('users.id', '=', $id)
            ->select('users.*', 'users.id as userId', 'patients.*')
            ->first();
        $doctor = DB::table('users')
            ->join('doctors', 'doctors.user_id', '=', 'users.id')
            ->where('users.clinic_id', '=', $this->getClinic()->id)
            ->where('doctors.user_id', '=', $row->doctor_id)
            ->select('users.*')
            ->first();
        $appointments_count = DB::table('appointments')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('patient_id', $id)
            ->count();
        $prescriptions_count = DB::table('prescriptions')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('patient_id', $id)
            ->count();
        $sessions_count = DB::table('sessions_info')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('patient_id', $id)
            ->count();
        $appointments = DB::table('appointments')
            ->join('users as t2', 't2.id', '=', 'appointments.patient_id')
            ->where('appointments.clinic_id', '=', $this->getClinic()->id)
            ->where('appointments.patient_id', '=', $id)
            ->select('appointments.*', 't2.name as patient_name', 't2.phone')
            ->orderBy('appointments.date', 'desc')->get();
        $prescriptions = DB::table('prescriptions')
            ->join('users as t2', 't2.id', '=', 'prescriptions.patient_id')
            ->where('prescriptions.clinic_id', '=', $this->getClinic()->id)
            ->where('prescriptions.patient_id', '=', $id)
            ->select('prescriptions.*', 't2.name as patient_name')
            ->orderBy('prescriptions.date', 'desc')
            ->get();
        return [$row, $doctor, $appointments, $appointments_count, $sessions_count, $prescriptions_count, $prescriptions];
    }
}
