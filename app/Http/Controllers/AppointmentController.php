<?php

namespace App\Http\Controllers;

use App\Repositories\AppointmentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    private $appointmentRepository;

    public function __construct(AppointmentRepository $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

    public function index()
    {
        $rows = $this->appointmentRepository->todayAppointments();
        return view('appointments.index', compact('rows'));
    }

    //  get appointments counts per day for calender view
    public function get_all_appointments()
    {
        $rows = $this->appointmentRepository->appointmentsCountsPerDayCalender();
        if ($rows) {
            return response()->json($rows);
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('appointments.index');
        }
    }

    public function get_appointments_per_date(Request $request)
    {
        $rows = $this->appointmentRepository->appointmentsRowsPerDayDataTable($request);
        if ($rows) {
            return response()->json($rows);
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('appointments.index');
        }
    }

    public function create(Request $request)
    {
        $doctor_rows = $this->appointmentRepository->doctorRowsForCreateView($request);
        $patient_rows = $this->appointmentRepository->patientRowsForCreateView($request);
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
        $appointment = $this->appointmentRepository->storeAppointment($request);
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
        $reserved_time_array = $this->appointmentRepository->getReservedTime($request);
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
