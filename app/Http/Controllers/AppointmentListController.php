<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AppointmentListController extends Controller
{
    public function todayAppointments(){
        //  today's appointments

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
        if ($rows) {
            return view('appointment-list.today-appointment',compact('rows'));
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('home');
        }
    }

    public function pendingAppointments(){
        //  pending appointments
        // admin
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('appointments')
                ->join('users as t1','t1.id','=','appointments.doctor_id')
                ->join('users as t2','t2.id','=','appointments.patient_id')
                ->where('appointments.clinic_id','=',$this->getClinic()->id)
                ->where('appointments.status', '=', 'pending')
                ->select('appointments.*','t1.name as doctor_name','t2.name as patient_name','t2.phone')
                ->orderBy('appointments.id','desc')->get();
        }
        // doctor
        if (auth()->user()->hasRole('doctor')) {
            $rows = DB::table('appointments')
                ->join('users as t1','t1.id','=','appointments.doctor_id')
                ->join('users as t2','t2.id','=','appointments.patient_id')
                ->where('appointments.clinic_id','=',$this->getClinic()->id)
                ->where('appointments.doctor_id', '=', auth()->user()->id)
                ->where('appointments.status', '=', 'pending')
                ->select('appointments.*','t1.name as doctor_name','t2.name as patient_name','t2.phone')
                ->orderBy('appointments.id','desc')->get();
        }
        // receptionist
        if (auth()->user()->hasRole('recep')) {
            $rows = DB::table('appointments')
                ->join('users as t1','t1.id','=','appointments.doctor_id')
                ->join('users as t2','t2.id','=','appointments.patient_id')
                ->where('appointments.clinic_id','=',$this->getClinic()->id)
                ->where('appointments.receptionist_id', '=', auth()->user()->id)
                ->where('appointments.status', '=', 'pending')
                ->select('appointments.*','t1.name as doctor_name','t2.name as patient_name','t2.phone')
                ->orderBy('appointments.id','desc')->get();
        }
        if ($rows) {
            return view('appointment-list.pending-appointment',compact('rows'));
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('home');
        }
    }

    public function upcomingAppointments (){

        // admin
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('appointments')
                ->join('users as t1','t1.id','=','appointments.doctor_id')
                ->join('users as t2','t2.id','=','appointments.patient_id')
                ->where('appointments.clinic_id','=',$this->getClinic()->id)
                ->whereDate('appointments.date', '>', Carbon::today()->toDateString())
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
                ->whereDate('appointments.date', '>', Carbon::today()->toDateString())
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
                ->whereDate('appointments.date', '>', Carbon::today()->toDateString())
                ->select('appointments.*','t1.name as doctor_name','t2.name as patient_name','t2.phone')
                ->orderBy('appointments.id','desc')->get();
        }
        if ($rows) {
            return view('appointment-list.upcomming-appointment',compact('rows'));
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('home');
        }
    }

    public function completeAppointments(){
        //  pending appointments
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('appointments')
                ->join('users as t1','t1.id','=','appointments.doctor_id')
                ->join('users as t2','t2.id','=','appointments.patient_id')
                ->where('appointments.clinic_id','=',$this->getClinic()->id)
                ->where('appointments.status', '=', 'complete')
                ->select('appointments.*','t1.name as doctor_name','t2.name as patient_name','t2.phone')
                ->orderBy('appointments.id','desc')->get();
        }
        // doctor
        if (auth()->user()->hasRole('doctor')) {
            $rows = DB::table('appointments')
                ->join('users as t1','t1.id','=','appointments.doctor_id')
                ->join('users as t2','t2.id','=','appointments.patient_id')
                ->where('appointments.clinic_id','=',$this->getClinic()->id)
                ->where('appointments.doctor_id', '=', auth()->user()->id)
                ->where('appointments.status', '=', 'complete')
                ->select('appointments.*','t1.name as doctor_name','t2.name as patient_name','t2.phone')
                ->orderBy('appointments.id','desc')->get();
        }
        // receptionist
        if (auth()->user()->hasRole('recep')) {
            $rows = DB::table('appointments')
                ->join('users as t1','t1.id','=','appointments.doctor_id')
                ->join('users as t2','t2.id','=','appointments.patient_id')
                ->where('appointments.clinic_id','=',$this->getClinic()->id)
                ->where('appointments.receptionist_id', '=', auth()->user()->id)
                ->where('appointments.status', '=', 'complete')
                ->select('appointments.*','t1.name as doctor_name','t2.name as patient_name','t2.phone')
                ->orderBy('appointments.id','desc')->get();
        }
        if ($rows) {
            return view('appointment-list.complete-appointment',compact('rows'));
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('home');
        }
    }

    public function cancelAppointments(){
        //  complete appointments
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('appointments')
                ->join('users as t1','t1.id','=','appointments.doctor_id')
                ->join('users as t2','t2.id','=','appointments.patient_id')
                ->where('appointments.clinic_id','=',$this->getClinic()->id)
                ->where('appointments.status', '=', 'cancel')
                ->select('appointments.*','t1.name as doctor_name','t2.name as patient_name','t2.phone')
                ->orderBy('appointments.id','desc')->get();
        }
        // doctor
        if (auth()->user()->hasRole('doctor')) {
            $rows = DB::table('appointments')
                ->join('users as t1','t1.id','=','appointments.doctor_id')
                ->join('users as t2','t2.id','=','appointments.patient_id')
                ->where('appointments.clinic_id','=',$this->getClinic()->id)
                ->where('appointments.doctor_id', '=', auth()->user()->id)
                ->where('appointments.status', '=', 'cancel')
                ->select('appointments.*','t1.name as doctor_name','t2.name as patient_name','t2.phone')
                ->orderBy('appointments.id','desc')->get();
        }
        // receptionist
        if (auth()->user()->hasRole('recep')) {
            $rows = DB::table('appointments')
                ->join('users as t1','t1.id','=','appointments.doctor_id')
                ->join('users as t2','t2.id','=','appointments.patient_id')
                ->where('appointments.clinic_id','=',$this->getClinic()->id)
                ->where('appointments.receptionist_id', '=', auth()->user()->id)
                ->where('appointments.status', '=', 'cancel')
                ->select('appointments.*','t1.name as doctor_name','t2.name as patient_name','t2.phone')
                ->orderBy('appointments.id','desc')->get();
        }

        if ($rows) {
            return view('appointment-list.cancel-appointment',compact('rows'));
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('home');
        }
    }

    public function completeAction($id){
        $row = DB::table('appointments')
            ->where('id','=',$id)
            ->update([
                'status' => 'complete'
            ]);
        if ($row){
            return Redirect::back()->with('success', 'Successfully Completed');
        }else{
            return Redirect::back()->with('error', 'Something went wrong');
        }
    }

    public function cancelAction($id){
        $row = DB::table('appointments')
            ->where('id','=',$id)
            ->update([
                'status' => 'cancel'
            ]);
        if ($row){
            return Redirect::back()->with('success', 'Successfully Canceled');
        }else{
            return Redirect::back()->with('error', 'Something went wrong');
        }
    }

}
