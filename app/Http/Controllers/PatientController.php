<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repository\PatientRepository;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    private $patientRepository;

    public function __construct(PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    public function index()
    {
        $rows = $this->patientRepository->getPatientRows();
        return view('patients.index', compact('rows'));
    }

    public function create()
    {
        $rows = $this->patientRepository->getDoctorRows();
        // get nOf doctors to show doctor drop down menu if nOf doctors is more than one and hide it if equal to one
        $count_rows = count($rows);
        if ($count_rows == 0) {
            toastr()->warning('You must create doctors first !');
            return redirect()->route('doctors.create');
        }
        return view('patients.create', compact('rows', 'count_rows'));
    }

    public function store(Request $request)
    {
        $store_patient = $this->patientRepository->storePatient($request);
        if ($store_patient) {
            toastr()->success('Successfully Created');
            return redirect()->route('patients.index');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('patients.index');
        }
    }

    public function edit($id)
    {
        list($row, $rows) = $this->patientRepository->editPatient($id);
        // get nOf doctors to show doctor drop down menu if nOf doctors is more than one and hide it if equal to one
        $count_rows = count($rows);
        return view('patients.edit', compact('row', 'count_rows', 'rows'));
    }

    public function update($id, Request $request)
    {
        $update_patient = $this->patientRepository->updatePatient($id, $request);
        if ($update_patient) {
            toastr()->success('Successfully Updated');
            return redirect()->route('patients.index');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('patients.index');
        }
    }

    public function destroy($id)
    {
        $user = User::where('id', '=', $id)->first();
        $user = $user->delete();
        if ($user) {
            toastr()->success('Successfully Deleted');
            return redirect()->route('patients.index');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('patients.index');
        }
    }

    public function show($id)
    {
        list($row, $doctor, $appointments, $appointments_count, $sessions_count, $prescriptions_count, $prescriptions) = $this->patientRepository->showPatient($id);
        if ($row) {
            if (auth()->user()->hasRole(['admin', 'recep', 'doctor'])) {
                return view('patients.show', compact(
                    'row',
                    'doctor',
                    'appointments',
                    'appointments_count',
                    'sessions_count',
                    'prescriptions_count',
                    'prescriptions'
                ));
            } else {
                toastr()->warning('You are not allowed for this route !');
                return redirect()->route('patients.index');
            }
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('patients.index');
        }
    }
}
