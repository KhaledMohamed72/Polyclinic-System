<?php

namespace App\Http\Controllers;


use App\Models\Doctor;
use App\Models\Receptionist;
use App\Models\User;
use App\Repository\DoctorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    private $doctorRepository;

    public function __construct(DoctorRepository $doctorRepository)
    {
        $this->doctorRepository = $doctorRepository;
    }

    public function index()
    {
        // check if the clinic is single or multiple doctors
        $doctors = Doctor::all()->count();
        $clinicType = $this->getClinic()->type;
        $rows = $this->doctorRepository->getDoctorRows();
        if (auth()->user()->hasRole(['admin', 'recep'])) {
            return view('doctors.index', compact('rows', 'clinicType', 'doctors'));
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('home');
        }
    }

    public function create()
    {
        // check if the clinic is single or multiple doctors
        $doctors = Doctor::all()->count();
        $receptionist = Receptionist::all()->count();
        $rows = $this->doctorRepository->getReceptionistRows();
        // if single
        if ($this->getClinic()->type == 0 && $doctors < 1) {
            if (auth()->user()->hasRole('admin')) {
                // check if clinic has receptionist (According to system flow you must add receptionist before adding doctors
                if ($receptionist >= 1) {
                    return view('doctors.create', compact('rows'));
                } else {
                    toastr()->warning('Oops! There is no receptionist. You must first add a receptionist!');
                    return redirect()->route('receptionists.create');
                }

            } else {
                toastr()->warning('Something went wrong!');
                return redirect()->route('doctors.index');
            }
            //if multiple
        } elseif ($this->getClinic()->type == 1) {
            if (auth()->user()->hasRole('admin')) {
                // check if clinic has receptionist (According to system flow you must add receptionist before adding doctors
                if ($receptionist >= 1) {
                    return view('doctors.create', compact('rows'));
                } else {
                    toastr()->warning('Oops! There is no receptionist. You must first add a receptionist!');
                    return redirect()->route('receptionists.create');
                }
            } else {
                toastr()->warning('Something went wrong!');
                return redirect()->route('doctors.index');
            }
        } else {
            toastr()->warning('You can just add one doctor');
            return redirect()->route('doctors.index');
        }
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasRole('admin')) {
            toastr()->warning('Something went wrong!');
            return redirect()->route('doctors.index');
        }
        $doctor_store = $this->doctorRepository->storeDoctor($request);
        if ($doctor_store) {
            toastr()->success('Successfully Created');
            return redirect()->route('doctors.index');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('doctors.index');
        }
    }

    public function edit($id)
    {
        $row = $this->doctorRepository->getDoctorRow($id);
        $rows = $this->doctorRepository->getReceptionistRows();

        if (auth()->user()->hasRole('admin')) {
            return view('doctors.edit', compact('row', 'rows'));
        } else {
            toastr()->warning('Something went wrong!');
            return redirect()->route('doctors.index');
        }
    }

    public function update(Request $request, $id)
    {
        $doctor_update = $this->doctorRepository->updateDoctor($request,$id);
        if ($doctor_update) {
            toastr()->success('Successfully Updated');
            return redirect()->route('doctors.index');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('doctors.index');
        }

    }

    public function destroy($id)
    {
        $user = User::where('id', '=', $id)->first();
        if (auth()->user()->hasRole('admin')) {
            if (!empty($user->profile_photo_path)) {
                unlink(public_path('images/users/' . $user->profile_photo_path));
            }
            $user = $user->delete();
        } else {
            toastr()->warning('You can not delete doctor !');
            return redirect()->route('doctors.index');
        }
        if ($user) {
            toastr()->success('Successfully Deleted');
            return redirect()->route('doctors.index');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('doctors.index');
        }
    }

    public function show($id)
    {
        list($row, $schedule_rows, $appointments_count, $today_appointments_count, $tomorrow_appointments_count, $upcomming_appointments_count, $today_earrings, $earring_percentage, $current_monthly_earrings, $last_monthly_earrings, $revenue, $appointments, $prescriptions, $monthly_patients_counts, $monthly_prescriptions_counts) = $this->doctorRepository->showDoctor($id);
        if ($row) {
            if (auth()->user()->hasRole(['admin', 'recep', 'doctor'])) {
                return view('doctors.show', compact(
                    'row',
                    'schedule_rows',
                    'appointments_count',
                    'today_appointments_count',
                    'tomorrow_appointments_count',
                    'upcomming_appointments_count',
                    'today_earrings',
                    'earring_percentage',
                    'current_monthly_earrings',
                    'last_monthly_earrings',
                    'revenue',
                    'appointments',
                    'prescriptions',
                    'monthly_patients_counts',
                    'monthly_prescriptions_counts',
                ));
            } else {
                toastr()->warning('You are not allowed for this route !');
                return redirect()->route('doctors.index');
            }
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('doctors.index');
        }
    }

    public function scheduleCreate($id)
    {
        $doctor = DB::table('users')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('id', $id)
            ->select('name', 'id as userId')
            ->first();
        $row = DB::table('doctor_schedules')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->where('user_id', '=', $id)
            ->orderBy('id', 'asc')
            ->get();
        return view('doctors.schedule-create', compact('row', 'doctor'));
    }

    public function scheduleUpdate(Request $request,$id)
    {
        $updateSchedule = $this->doctorRepository->updateSchedule($request,$id);
        if ($updateSchedule) {
            toastr()->success('Successfully Updated');
            return redirect()->route('home');
        }
    }
}
