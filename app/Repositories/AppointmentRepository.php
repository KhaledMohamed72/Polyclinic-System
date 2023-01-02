<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AppointmentRepository extends Controller implements AppointmentRepositoryInterface
{
    public function todayAppointments()
    {
        // admin
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('appointments')
                ->join('users as t1', 't1.id', '=', 'appointments.doctor_id')
                ->join('users as t2', 't2.id', '=', 'appointments.patient_id')
                ->where('appointments.clinic_id', '=', $this->getClinic()->id)
                ->whereDate('appointments.date', '=', Carbon::today()->toDateString())
                ->select('appointments.*', 't1.name as doctor_name', 't2.name as patient_name', 't2.phone')
                ->orderBy('appointments.id', 'desc')->get();
        }
        // doctor
        if (auth()->user()->hasRole('doctor')) {
            $rows = DB::table('appointments')
                ->join('users as t1', 't1.id', '=', 'appointments.doctor_id')
                ->join('users as t2', 't2.id', '=', 'appointments.patient_id')
                ->where('appointments.clinic_id', '=', $this->getClinic()->id)
                ->where('appointments.doctor_id', '=', auth()->user()->id)
                ->whereDate('appointments.date', '=', Carbon::today()->toDateString())
                ->select('appointments.*', 't1.name as doctor_name', 't2.name as patient_name', 't2.phone')
                ->orderBy('appointments.id', 'desc')->get();
        }
        // receptionist
        if (auth()->user()->hasRole('recep')) {
            $rows = DB::table('appointments')
                ->join('users as t1', 't1.id', '=', 'appointments.doctor_id')
                ->join('users as t2', 't2.id', '=', 'appointments.patient_id')
                ->where('appointments.clinic_id', '=', $this->getClinic()->id)
                ->where('appointments.receptionist_id', '=', auth()->user()->id)
                ->whereDate('appointments.date', '=', Carbon::today()->toDateString())
                ->select('appointments.*', 't1.name as doctor_name', 't2.name as patient_name', 't2.phone')
                ->orderBy('appointments.id', 'desc')->get();
        }
        return $rows;
    }
    public function appointmentsCountsPerDayCalender()
    {
        // admin
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('appointments')
                ->where('clinic_id', $this->getClinic()->id)
                ->select('date', DB::raw('concat(count(*), " appointments") as title'))
                ->groupBy('date')
                ->get();
        }
        // doctor
        if (auth()->user()->hasRole('doctor')) {
            $rows = DB::table('appointments')
                ->where('clinic_id', $this->getClinic()->id)
                ->where('doctor_id', auth()->user()->id)
                ->select('date', DB::raw('concat(count(*), " appointments") as title'),)
                ->groupBy('date')
                ->get();
        }
        // receptionist
        if (auth()->user()->hasRole('recep')) {
            $rows = DB::table('appointments')
                ->where('clinic_id', $this->getClinic()->id)
                ->where('receptionist_id', auth()->user()->id)
                ->select('date', DB::raw('concat(count(*), " appointments") as title'),)
                ->groupBy('date')
                ->get();
        }
        return $rows;
    }
    public function appointmentsRowsPerDayDataTable(Request $request)
    {
        // admin
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('appointments')
                ->join('users as t1', 't1.id', '=', 'appointments.doctor_id')
                ->join('users as t2', 't2.id', '=', 'appointments.patient_id')
                ->where('appointments.clinic_id', '=', $this->getClinic()->id)
                ->whereDate('appointments.date', '=', $request->date)
                ->select('appointments.*', 't1.name as doctor_name', 't2.name as patient_name', 't2.phone')
                ->orderBy('appointments.id', 'desc')->get();
        }
        // doctor
        if (auth()->user()->hasRole('doctor')) {
            $rows = DB::table('appointments')
                ->join('users as t1', 't1.id', '=', 'appointments.doctor_id')
                ->join('users as t2', 't2.id', '=', 'appointments.patient_id')
                ->where('appointments.clinic_id', '=', $this->getClinic()->id)
                ->where('appointments.doctor_id', '=', auth()->user()->id)
                ->whereDate('appointments.date', '=', $request->date)
                ->select('appointments.*', 't1.name as doctor_name', 't2.name as patient_name', 't2.phone')
                ->orderBy('appointments.id', 'desc')->get();
        }
        // receptionist
        if (auth()->user()->hasRole('recep')) {
            $rows = DB::table('appointments')
                ->join('users as t1', 't1.id', '=', 'appointments.doctor_id')
                ->join('users as t2', 't2.id', '=', 'appointments.patient_id')
                ->where('appointments.clinic_id', '=', $this->getClinic()->id)
                ->where('appointments.receptionist_id', '=', auth()->user()->id)
                ->whereDate('appointments.date', '=', $request->date)
                ->select('appointments.*', 't1.name as doctor_name', 't2.name as patient_name', 't2.phone')
                ->orderBy('appointments.id', 'desc')->get();
        }
        return $rows;
    }
    public function doctorRowsForCreateView(Request $request){
        // list of doctors if the role is admin
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->select('users.id', 'users.name')
                ->get();
        }

        // list of doctors if the role is recep
        if (auth()->user()->hasRole('recep')) {
            $rows = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->where('doctors.receptionist_id', '=', auth()->user()->id)
                ->select('users.id', 'users.name')
                ->get();
        }
        // list of doctors if the role is doctor
        if (auth()->user()->hasRole('doctor')) {
            $rows = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->where('doctors.user_id', '=', auth()->user()->id)
                ->select('users.id', 'users.name')
                ->get();
        }
        return $rows;
    }
    public function patientRowsForCreateView(Request $request){
        // list of doctors if the role is admin
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('users')
                ->join('patients', 'patients.user_id', '=', 'users.id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->select('users.id', 'users.name')
                ->get();
        }

        // list of doctors if the role is recep
        if (auth()->user()->hasRole('recep')) {
            $rows = DB::table('users')
                ->join('patients', 'patients.user_id', '=', 'users.id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->where('patients.receptionist_id', '=', auth()->user()->id)
                ->select('users.id', 'users.name')
                ->get();
        }
        // list of doctors if the role is doctor
        if (auth()->user()->hasRole('doctor')) {
            $rows = DB::table('users')
                ->join('patients', 'patients.user_id', '=', 'users.id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->where('patients.doctor_id', '=', auth()->user()->id)
                ->select('users.id', 'users.name')
                ->get();
        }
        return $rows;
    }
    public function storeAppointment(Request $request){
        //validate available_slot radio
        if (!$request->has('available_slot')) {
            return Redirect::back()->with('error', 'You must choose any available slot');
        }
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
        $appointment = DB::table('appointments')->insert([
            'clinic_id' => $this->getClinic()->id,
            'patient_id' => $request->patient_id,
            'doctor_id' => $doctor_id,
            'receptionist_id' => $receptionist_id,
            'date' => $request->date,
            'time' => $request->available_slot,
            'status' => 'pending',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        return $appointment;
    }
    public function getReservedTime(Request $request){
        // check if there is reserved times or not and covert it to array
        if ($request->has('has_one_doctor_id')) {
            $doctor_id = $request->has_one_doctor_id;
        } else {
            $doctor_id = $request->doctor_id;
        }
        if (auth()->user()->hasRole('admin')) {
            $reserved_time = DB::table('appointments')
                ->where('clinic_id', $this->getClinic()->id)
                ->where('doctor_id', $doctor_id)
                ->where('date', $request->date)
                ->select('time')
                ->get()->pluck('time');
        }
        if (auth()->user()->hasRole('recep')) {
            $reserved_time = DB::table('appointments')
                ->where('clinic_id', $this->getClinic()->id)
                ->where('receptionist_id', auth()->user()->id)
                ->where('date', $request->date)
                ->select('time')
                ->get()->pluck('time');
        }
        if (auth()->user()->hasRole('doctor')) {
            $reserved_time = DB::table('appointments')
                ->where('clinic_id', $this->getClinic()->id)
                ->where('doctor_id', auth()->user()->id)
                ->where('date', $request->date)
                ->select('time')
                ->get()->pluck('time');
        }
        $reserved_time_array = $reserved_time->all();
        return $reserved_time_array;
    }
}
