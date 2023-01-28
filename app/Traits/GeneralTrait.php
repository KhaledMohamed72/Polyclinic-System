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
            $rows = DB::table('patients')
                ->join('users AS t1', 't1.id', '=', 'patients.user_id')
                ->join('users AS t2', 't2.id', '=', 'patients.doctor_id')
                ->where('t1.clinic_id', '=', $clinic_id)
                ->select('t1.id as user_id', 't1.name as patient_name', 't2.name as doctor_name', 't1.phone as phone')
                ->orderBy('t1.id', 'desc')
                ->paginate(10);
        }
        if (auth()->user()->hasRole('recep')) {
            $rows = DB::table('patients')
                ->join('users AS t1', 't1.id', '=', 'patients.user_id')
                ->join('users AS t2', 't2.id', '=', 'patients.doctor_id')
                ->where('patients.receptionist_id','=',$user_id)
                ->where('t1.clinic_id', '=', $clinic_id)
                ->select('t1.id as user_id', 't1.name as patient_name', 't2.name as doctor_name', 't1.phone as phone')
                ->orderBy('t1.id', 'desc')
                ->paginate(10);
        }
        if (auth()->user()->hasRole('doctor')){
            $rows = DB::table('patients')
                ->join('users AS t1', 't1.id', '=', 'patients.user_id')
                ->where('patients.doctor_id','=',$user_id)
                ->where('t1.clinic_id', '=', $clinic_id)
                ->select('t1.id as user_id', 't1.name as patient_name', 't1.phone as phone')
                ->orderBy('t1.id', 'desc')
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
