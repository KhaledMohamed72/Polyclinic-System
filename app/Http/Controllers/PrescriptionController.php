<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Formula;
use App\Models\FrequencyType;
use App\Models\Medicine;
use App\Models\PeriodType;
use App\Models\Test;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrescriptionController extends Controller
{
    public function create(){
        $patients = DB::table('users')
            ->join('patients','patients.user_id','=','users.id')
            ->where('patients.doctor_id','=', auth()->user()->id)
            ->where('users.clinic_id','=', $this->getClinic()->id)
            ->orderBy('users.id','desc')
            ->select('users.name as user_name','users.id as user_id')
            ->get();
        $medicines = Medicine::where('doctor_id',auth()->user()->id)->select('name')->get();
        $tests = Test::where('doctor_id',auth()->user()->id)->select('name')->get();
        $formulas = Formula::where('doctor_id',auth()->user()->id)->select('id','name')->get();
        $frequencies = FrequencyType::where('doctor_id',auth()->user()->id)
                        ->where('clinic_id',$this->getClinic()->id)
                        ->orderBy('id','desc')
                        ->get();
        $periods = PeriodType::where('doctor_id',auth()->user()->id)
            ->where('clinic_id',$this->getClinic()->id)
            ->orderBy('id','desc')
            ->get();
        return view('prescriptions.create', compact(
            'patients',
            'frequencies',
            'periods',
            'medicines',
            'formulas',
            'tests'
        ));
    }

    public function show(){
        return view('prescriptions.show');
    }

    public function get_appointments_of_patient(Request $request){
        $appointments = Appointment::where('patient_id','=',$request->patient_id)
                        ->where('doctor_id','=',auth()->user()->id)
                        ->where('status','=','pending')
                        ->orderBy('id','desc')
                        ->get();
        return response()->json($appointments);
    }
}
