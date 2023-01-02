<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AppointmentListRepositoryInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AppointmentListRepository extends Controller implements AppointmentListRepositoryInterface
{
    public function getTodayAppointments()
    {
        // admin
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('appointments')
                ->join('users as t1','t1.id','=','appointments.doctor_id')
                ->join('users as t2','t2.id','=','appointments.patient_id')
                ->where('appointments.clinic_id','=',$this->getClinic()->id)
                ->whereDate('appointments.date', '=', Carbon::today()->toDateString())
                ->select('appointments.*','t1.name as doctor_name','t2.name as patient_name','t2.phone')
                ->orderBy('appointments.id','desc')->get();
        }
        // doctor
        if (auth()->user()->hasRole('doctor')) {
            $rows = DB::table('appointments')
                ->join('users as t1','t1.id','=','appointments.doctor_id')
                ->join('users as t2','t2.id','=','appointments.patient_id')
                ->where('appointments.clinic_id','=',$this->getClinic()->id)
                ->where('appointments.doctor_id','=',auth()->user()->id)
                ->whereDate('appointments.date', '=', Carbon::today()->toDateString())
                ->select('appointments.*','t1.name as doctor_name','t2.name as patient_name','t2.phone')
                ->orderBy('appointments.id','desc')->get();
        }
        // receptionist
        if (auth()->user()->hasRole('recep')) {
            $rows = DB::table('appointments')
                ->join('users as t1','t1.id','=','appointments.doctor_id')
                ->join('users as t2','t2.id','=','appointments.patient_id')
                ->where('appointments.clinic_id','=',$this->getClinic()->id)
                ->where('appointments.receptionist_id','=',auth()->user()->id)
                ->whereDate('appointments.date', '=', Carbon::today()->toDateString())
                ->select('appointments.*','t1.name as doctor_name','t2.name as patient_name','t2.phone')
                ->orderBy('appointments.id','desc')->get();
        }
        return $rows;
    }
    public function getPendingAppointments()
    {
        /// admin
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('appointments')
                ->join('users as t1', 't1.id', '=', 'appointments.doctor_id')
                ->join('users as t2', 't2.id', '=', 'appointments.patient_id')
                ->where('appointments.clinic_id', '=', $this->getClinic()->id)
                ->where('appointments.status', '=', 'pending')
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
                ->where('appointments.status', '=', 'pending')
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
                ->where('appointments.status', '=', 'pending')
                ->select('appointments.*', 't1.name as doctor_name', 't2.name as patient_name', 't2.phone')
                ->orderBy('appointments.id', 'desc')->get();
        }
        return $rows;
    }
    public function getUpcomingAppointments()
    {
        // admin
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('appointments')
                ->join('users as t1', 't1.id', '=', 'appointments.doctor_id')
                ->join('users as t2', 't2.id', '=', 'appointments.patient_id')
                ->where('appointments.clinic_id', '=', $this->getClinic()->id)
                ->whereDate('appointments.date', '>', Carbon::today()->toDateString())
                ->where('appointments.status', '=', 'pending')
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
                ->whereDate('appointments.date', '>', Carbon::today()->toDateString())
                ->where('appointments.status', '=', 'pending')
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
                ->whereDate('appointments.date', '>', Carbon::today()->toDateString())
                ->where('appointments.status', '=', 'pending')
                ->select('appointments.*', 't1.name as doctor_name', 't2.name as patient_name', 't2.phone')
                ->orderBy('appointments.id', 'desc')->get();
        }
        return $rows;
    }
    public function getCompleteAppointments()
    {
        //admin
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('appointments')
                ->join('users as t1', 't1.id', '=', 'appointments.doctor_id')
                ->join('users as t2', 't2.id', '=', 'appointments.patient_id')
                ->where('appointments.clinic_id', '=', $this->getClinic()->id)
                ->where('appointments.status', '=', 'complete')
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
                ->where('appointments.status', '=', 'complete')
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
                ->where('appointments.status', '=', 'complete')
                ->select('appointments.*', 't1.name as doctor_name', 't2.name as patient_name', 't2.phone')
                ->orderBy('appointments.id', 'desc')->get();
        }
        return $rows;
    }
    public function getCancelAppointments()
    {
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('appointments')
                ->join('users as t1', 't1.id', '=', 'appointments.doctor_id')
                ->join('users as t2', 't2.id', '=', 'appointments.patient_id')
                ->where('appointments.clinic_id', '=', $this->getClinic()->id)
                ->where('appointments.status', '=', 'cancel')
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
                ->where('appointments.status', '=', 'cancel')
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
                ->where('appointments.status', '=', 'cancel')
                ->select('appointments.*', 't1.name as doctor_name', 't2.name as patient_name', 't2.phone')
                ->orderBy('appointments.id', 'desc')->get();
        }
        return $rows;
    }
    public function changeToCompleteAction($id)
    {
        $row = DB::table('appointments')
            ->where('id', '=', $id)
            ->update([
                'status' => 'complete'
            ]);
        return $row;
    }
    public function changeToCancelAction($id)
    {
        $row = DB::table('appointments')
            ->where('id', '=', $id)
            ->update([
                'status' => 'cancel'
            ]);
        return $row;
    }
}
