<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function store(Request $request)
    {

        $this->validate($request, [
            'patient_id' => ['required', 'integer'],
            'date' => ['required', 'string'],
            'available_slot' => ['required', 'string'],
        ]);

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
            'status' => 'comming',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        if ($appointment) {
            toastr()->success('Successfully Created');
            return redirect()->route('appointments.index');
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

        // check if this time slot is found or not
        $reserved_time = DB::table('appointments')
            ->where('clinic_id',$this->getClinic()->id)
            ->where('doctor_id',$request->doctor_id)
            ->where('date',$request->date)
            ->select('time')
            ->get();
        foreach($reserved_time as $object)
        {
            $arrays[] = (array)$object;
        }
        print_r($arrays);
        $time_slots_array = array();
        $first_start = strtotime($time_slots->first_start_time);
        $first_end = strtotime($time_slots->first_end_time);

        $slot_time_or = $time_slots->slot_time;
        $slot_time = $time_slots->slot_time;
        array_push($time_slots_array, $time_slots->first_start_time);

        for (; ;) {
            $time_to_push = strtotime("+" . $slot_time . "minutes", strtotime($time_slots->first_start_time));

            if (($first_end - $time_to_push) / 60 >= $slot_time_or) {

                    array_push($time_slots_array, date('H:i', $time_to_push));

                $slot_time = $slot_time + 30;
            } else {
                break;
            }
        }
        $arr1 = ['11:47','12:17'];
        $arr2 = ['11:47'];
        dd(array_diff($arr1,$arr2));
        return response()->json($time_slots_array);
    }
}
