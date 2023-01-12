<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait GeneralTrait
{
    function getDoctorsBasedOnRole($clinic_id, $user_id){
        // list of doctors if the role is admin
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->where('users.clinic_id', '=', $clinic_id)
                ->select('users.id', 'users.name')
                ->get();
        }
        // list of doctors if the role is recep
        if (auth()->user()->hasRole('recep')) {
            $rows = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->where('users.clinic_id', '=', $clinic_id)
                ->where('doctors.receptionist_id', '=', $user_id)
                ->select('users.id', 'users.name')
                ->get();
        }
        // list of doctors if the role is doctor
        if (auth()->user()->hasRole('doctor')) {
            $rows = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->where('users.clinic_id', '=', $clinic_id)
                ->where('doctors.user_id', '=', $user_id)
                ->select('users.id', 'users.name')
                ->get();
        }
        return $rows;
    }

    function getPatientsBasedOnRole($clinic_id, $user_id){
        // list of patients according to role of current auth user
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('users')
                ->join('patients', 'patients.user_id', '=', 'users.id')
                ->join('users AS doctors', 'doctors.id', '=', 'patients.doctor_id')
                ->where('users.clinic_id', '=', $clinic_id)
                ->select('users.id as user_id', 'users.name as patient_name', 'doctors.name as doctor_name', 'users.phone as phone')
                ->orderBy('users.id', 'desc')
                ->paginate(10);
        }
        if (auth()->user()->hasRole('recep')) {
            $rows = DB::table('users')
                ->join('patients', 'patients.user_id', '=', 'users.id')
                ->join('users AS doctors', 'doctors.id', '=', 'patients.doctor_id')
                ->where('users.clinic_id', '=', $clinic_id)
                ->where('patients.receptionist_id', '=', $user_id)
                ->select('users.id as user_id', 'users.name as patient_name', 'doctors.name as doctor_name', 'users.phone as phone')
                ->orderBy('users.id', 'desc')
                ->paginate(10);
        }
        if (auth()->user()->hasRole('doctor')){
            $rows = DB::table('users')
                ->join('patients', 'patients.user_id', '=', 'users.id')
                ->join('users AS doctors', 'doctors.id', '=', 'patients.doctor_id')
                ->where('users.clinic_id', '=', $clinic_id)
                ->where('patients.doctor_id', '=', $user_id)
                ->select('users.id as user_id', 'users.name as patient_name', 'users.phone as phone')
                ->orderBy('users.id', 'desc')
                ->paginate(10);
        }
        return $rows;
    }

    function getInsuranceCompaniessBasedOnRole($clinic_id, $user_id){
        // list of companies according to role of current auth user
        if (auth()->user()->hasRole('admin')) {
            $insurance_companies = DB::table('insurance_companies')
                ->where('clinic_id', $clinic_id)
                ->select('id','name')
                ->get();
        }
        if (auth()->user()->hasRole('recep')) {
            $insurance_companies = DB::table('insurance_companies')
                ->where('clinic_id', $clinic_id)
                ->where('receptionist_id', $user_id)
                ->select('id','name')
                ->get();
        }
        if (auth()->user()->hasRole('doctor')){
            $insurance_companies = DB::table('insurance_companies')
                ->where('clinic_id', $clinic_id)
                ->where('doctor_id', $user_id)
                ->select('id','name')
                ->get();
        }
        return $insurance_companies;
    }
}
