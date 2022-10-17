<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Comment\Doc;

class AppointmentController extends Controller
{
    public function index()
    {
        return view('appointments.index');
    }

    public function create(Request $request)
    {
        if (!auth()->user()->hasRole(['admin', 'doctor', 'recep'])) {
            toastr()->warning('Something went wrong!');
            return redirect()->route('home');
        }
        // list of doctors if the role is admin
        if (auth()->user()->hasRole('admin')) {
            $doctor_rows = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->select('users.id', 'users.name')
                ->get();
            $patient_rows = DB::table('users')
                ->join('patients', 'patients.user_id', '=', 'users.id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->select('users.id', 'users.name')
                ->get();
        }

        // list of doctors if the role is recep
        if (auth()->user()->hasRole('recep')) {
            $doctor_rows = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->where('doctors.receptionist_id', '=', auth()->user()->id)
                ->select('users.id', 'users.name')
                ->get();
            $patient_rows = DB::table('users')
                ->join('patients', 'patients.user_id', '=', 'users.id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->where('patients.receptionist_id', '=', auth()->user()->id)
                ->select('users.id', 'users.name')
                ->get();
        }
        if (auth()->user()->hasRole('doctor')) {
            $doctor_rows = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->where('doctors.user_id', '=', auth()->user()->id)
                ->select('users.id', 'users.name')
                ->get();
            $patient_rows = DB::table('users')
                ->join('patients', 'patients.user_id', '=', 'users.id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->where('patients.user_id', '=', auth()->user()->id)
                ->select('users.id', 'users.name')
                ->get();
        }
        // get nOf doctors to show doctor drop down menu if nOf doctors is more than one and hide it if equal to one
        $count_doctors = count($doctor_rows);
        if ($count_doctors == 0) {
            toastr()->warning('You must create doctors first !');
            return redirect()->route('doctors.create');
        }
        $count_patients = count($patient_rows);
        if ($count_patients == 0) {
            toastr()->warning('There is no patient , You must create patient first !');
            return redirect()->route('patients.create');
        }
        return view('appointments.create', compact(
            'doctor_rows',
            'count_doctors',
            'patient_rows',
            'count_patients'
        ));
    }




    public function get_available_time(Request $request){
        $available_time = DB::table('doctor_schedules')
            ->select('first_start_time','first_end_time','day_of_week')
            ->where('user_id','=',$request->doctor_id)
            ->where('day_attendance','=','1')
            ->where('clinic_id','=',$this->getClinic()->id)
            ->get();
        return response()->json($available_time);
    }
}
