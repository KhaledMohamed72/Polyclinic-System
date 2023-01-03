<?php

namespace App\Http\Controllers;

use App\Repository\AppointmentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

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
        //validate available_slot radio
        if (!$request->has('available_slot')) {
            return Redirect::back()->with('error', 'You must choose any available slot');
        }
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
        $free_time_array = $this->appointmentRepository->getSlotTimes($request);
        return response()->json(array_values($free_time_array));
    }

}
