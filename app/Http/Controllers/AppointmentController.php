<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AppointmentController extends Controller
{
    public function index()
    {
        // admin
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('appointments')
                ->join('users as t1','t1.id','=','appointments.doctor_id')
                ->join('users as t2','t2.id','=','appointments.patient_id')
                ->where('appointments.clinic_id','=',$this->getClinic()->id)
                ->whereDate('appointments.date', '=', Carbon::today()->toDateString())
                ->where('appointments.status','=','pending')
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
                ->where('appointments.status','=','pending')
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
                ->where('appointments.status','=','pending')
                ->select('appointments.*','t1.name as doctor_name','t2.name as patient_name','t2.phone')
                ->orderBy('appointments.id','desc')->get();
        }
        return view('appointments.index',compact('rows'));
    }
    //  calendar
    public function get_all_appointments(){
        // admin
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('appointments')
                ->where('clinic_id',$this->getClinic()->id)
                ->where('status','=','pending')
                ->select('date', DB::raw('concat(count(*), " appointments") as title'))
                ->groupBy('date')
                ->get();
        }
        // doctor
        if (auth()->user()->hasRole('doctor')) {
            $rows = DB::table('appointments')
                ->where('status','=','pending')
                ->where('clinic_id',$this->getClinic()->id)
                ->where('doctor_id',auth()->user()->id)
                ->select('date', DB::raw('concat(count(*), " appointments") as title'),)
                ->groupBy('date')
                ->get();
        }
        // receptionist
        if (auth()->user()->hasRole('recep')) {
            $rows = DB::table('appointments')
                ->where('status','=','pending')
                ->where('clinic_id',$this->getClinic()->id)
                ->where('receptionist_id',auth()->user()->id)
                ->select('date', DB::raw('concat(count(*), " appointments") as title'),)
                ->groupBy('date')
                ->get();
        }
        if ($rows) {
            return response()->json($rows);
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('appointments.index');
        }
    }

    public function get_appointments_per_date(Request $request){

        // admin
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('appointments')
                ->join('users as t1','t1.id','=','appointments.doctor_id')
                ->join('users as t2','t2.id','=','appointments.patient_id')
                ->where('appointments.clinic_id','=',$this->getClinic()->id)
                ->whereDate('appointments.date', '=', $request->date)
                ->where('appointments.status','=','pending')
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
                ->whereDate('appointments.date', '=', $request->date)
                ->where('appointments.status','=','pending')
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
                ->whereDate('appointments.date', '=', $request->date)
                ->where('appointments.status','=','pending')
                ->select('appointments.*','t1.name as doctor_name','t2.name as patient_name','t2.phone')
                ->orderBy('appointments.id','desc')->get();
        }
        if ($rows) {
            return response()->json($rows);
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('appointments.index');
        }
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
        // list of doctors if the role is doctor
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
                ->where('patients.doctor_id', '=', auth()->user()->id)
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

    public function store(Request $request)
    {

        $this->validate($request, [
            'patient_id' => ['required', 'integer'],
            'date' => ['required', 'string'],
        ]);
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

        if ($appointment) {
            toastr()->success('Successfully Created');
            return redirect()->route('appointments.create');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('appointments.index');
        }
    }


    public function get_available_time(Request $request)
    {
        $available_time = DB::table('doctor_schedules')
            ->where('user_id', '=', $request->doctor_id)
            ->where('day_of_week', '=', $request->day)
            ->where('day_attendance', '=', '1')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->get();
        return response()->json($available_time);
    }

    public function get_time_slots(Request $request)
    {
        $time_slots = DB::table('doctor_schedules')
            ->join('doctors', 'doctors.user_id', '=', 'doctor_schedules.user_id')
            ->where('doctor_schedules.clinic_id', '=', $this->getClinic()->id)
            ->where('doctor_schedules.id', '=', $request->id)
            ->select('doctor_schedules.*', 'doctors.slot_time')
            ->first();

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

        $time_slots_array = array();
        $first_end = strtotime($time_slots->first_end_time);
        $slot_time_or = $time_slots->slot_time;
        $slot_time = $time_slots->slot_time;
        array_push($time_slots_array, $time_slots->first_start_time);

        for (; ;) {
            /*
            Here I made some operation to get the time slots between start and end time of doctor
            1- every round we add slot time of doctor to start time and increment with its value
            2- then we check the difference between (added time slot to start time) and end time
            3- if the result is more than base slot time, we push this time to array
            3 - if the result is less than base slot time, we break the loop
            4 - then we get the difference between the two array =>(time slots , reserved_time)
            */
            $time_to_push = strtotime("+" . $slot_time . "minutes", strtotime($time_slots->first_start_time));

            if (($first_end - $time_to_push) / 60 >= $slot_time_or) {

                array_push($time_slots_array, date('H:i', $time_to_push));

                $slot_time = $slot_time + $slot_time_or;
            } else {
                break;
            }
        }
        $free_time_array = array_diff($time_slots_array, $reserved_time_array);

        return response()->json(array_values($free_time_array));
    }
}
