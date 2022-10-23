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
                ->where('clinic_id','=',$this->getClinic()->id)
                ->whereDate('appointments.date', '=', Carbon::today()->toDateString())
                ->orderBy('id','desc')->get();
        }
        // doctor
        if (auth()->user()->hasRole('doctor')) {
            $rows = DB::table('appointments')
                ->where('clinic_id','=',$this->getClinic()->id)
                ->where('appointments.doctor_id','=',auth()->user()->id)
                ->whereDate('appointments.date', '=', Carbon::today()->toDateString())
                ->orderBy('id','desc')->get();
        }
        // receptionist
        if (auth()->user()->hasRole('recep')) {
            $rows = DB::table('appointments')
                ->where('clinic_id','=',$this->getClinic()->id)
                ->where('appointments.receptionist_id','=',auth()->user()->id)
                ->whereDate('appointments.date', '=', Carbon::today()->toDateString())
                ->orderBy('id','desc')->get();
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
                ->where('clinic_id','=',$this->getClinic()->id)
                ->where('status','pending')
                ->orderBy('id','desc')->get();
        }
        // doctor
        if (auth()->user()->hasRole('doctor')) {
            $rows = DB::table('appointments')
                ->where('clinic_id','=',$this->getClinic()->id)
                ->where('appointments.doctor_id','=',auth()->user()->id)
                ->where('status','pending')
                ->orderBy('id','desc')->get();
        }
        // receptionist
        if (auth()->user()->hasRole('recep')) {
            $rows = DB::table('appointments')
                ->where('clinic_id','=',$this->getClinic()->id)
                ->where('appointments.receptionist_id','=',auth()->user()->id)
                ->where('status','pending')
                ->orderBy('id','desc')->get();
        }
        if ($rows) {
            return view('appointment-list.pending-appointment',compact('rows'));
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('home');
        }
    }

    public function upcomingAppointments (){
        //  today's appointments

        // admin
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('appointments')
                ->where('clinic_id','=',$this->getClinic()->id)
                ->whereDate('appointments.date', '>', Carbon::today()->toDateString())
                ->orderBy('id','desc')->get();
        }
        // doctor
        if (auth()->user()->hasRole('doctor')) {
            $rows = DB::table('appointments')
                ->where('clinic_id','=',$this->getClinic()->id)
                ->where('appointments.doctor_id','=',auth()->user()->id)
                ->whereDate('appointments.date', '>', Carbon::today()->toDateString())
                ->orderBy('id','desc')->get();
        }
        // receptionist
        if (auth()->user()->hasRole('recep')) {
            $rows = DB::table('appointments')
                ->where('clinic_id','=',$this->getClinic()->id)
                ->where('appointments.receptionist_id','=',auth()->user()->id)
                ->whereDate('appointments.date', '>', Carbon::today()->toDateString())
                ->orderBy('id','desc')->get();
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
        // admin
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('appointments')
                ->where('clinic_id','=',$this->getClinic()->id)
                ->where('status','complete')
                ->orderBy('id','desc')->get();
        }
        // doctor
        if (auth()->user()->hasRole('doctor')) {
            $rows = DB::table('appointments')
                ->where('clinic_id','=',$this->getClinic()->id)
                ->where('appointments.doctor_id','=',auth()->user()->id)
                ->where('status','complete')
                ->orderBy('id','desc')->get();
        }
        // receptionist
        if (auth()->user()->hasRole('recep')) {
            $rows = DB::table('appointments')
                ->where('clinic_id','=',$this->getClinic()->id)
                ->where('appointments.receptionist_id','=',auth()->user()->id)
                ->where('status','complete')
                ->orderBy('id','desc')->get();
        }
        if ($rows) {
            return view('appointment-list.complete-appointment',compact('rows'));
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('home');
        }
    }

    public function cancelAppointments(){
        //  pending appointments
        // admin
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('appointments')
                ->where('clinic_id','=',$this->getClinic()->id)
                ->where('status','cancel')
                ->orderBy('id','desc')->get();
        }
        // doctor
        if (auth()->user()->hasRole('doctor')) {
            $rows = DB::table('appointments')
                ->where('clinic_id','=',$this->getClinic()->id)
                ->where('appointments.doctor_id','=',auth()->user()->id)
                ->where('status','cancel')
                ->orderBy('id','desc')->get();
        }
        // receptionist
        if (auth()->user()->hasRole('recep')) {
            $rows = DB::table('appointments')
                ->where('clinic_id','=',$this->getClinic()->id)
                ->where('appointments.receptionist_id','=',auth()->user()->id)
                ->where('status','cancel')
                ->orderBy('id','desc')->get();
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
