<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Formula;
use App\Models\FrequencyType;
use App\Models\Medicine;
use App\Models\PeriodType;
use App\Models\Prescription;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrescriptionController extends Controller
{
    public function create()
    {
        $patients = DB::table('users')
            ->join('patients', 'patients.user_id', '=', 'users.id')
            ->where('patients.doctor_id', '=', auth()->user()->id)
            ->where('users.clinic_id', '=', $this->getClinic()->id)
            ->orderBy('users.id', 'desc')
            ->select('users.name as user_name', 'users.id as user_id')
            ->get();
        $medicines = Medicine::where('doctor_id', auth()->user()->id)->select('name')->get();
        $tests = Test::where('doctor_id', auth()->user()->id)->select('name')->get();
        $formulas = Formula::where('doctor_id', auth()->user()->id)->select('id', 'name')->get();
        $frequencies = FrequencyType::where('doctor_id', auth()->user()->id)
            ->where('clinic_id', $this->getClinic()->id)
            ->orderBy('id', 'desc')
            ->get();
        $periods = PeriodType::where('doctor_id', auth()->user()->id)
            ->where('clinic_id', $this->getClinic()->id)
            ->orderBy('id', 'desc')
            ->get();
        return view('prescriptions.create', compact(
            'patients',
            'frequencies',
            'periods',
            'medicines',
            'formulas',
            'tests'
        ));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => ['required', 'integer'],
            'patient' => ['required', 'integer'],
            'date' => ['required', 'string'],
        ]);

        // function to insert a new medicines or tests to suggest it later when go to create new prescriptions


        $this->checkItemsInDatabase($request, 'medicines', '$medicine', 'medicine');
        $this->checkItemsInDatabase($request, 'tests', '$test', 'test');
        $prescription = DB::table('prescriptions')->insert([
            'clinic_id' => $this->getClinic()->id,
            'doctor_id' => auth()->user()->id,
            'patient_id' => $request->get('patient'),
            'type' => $request->get('type'),
            'date' => $request->get('date'),
            'followup_date' => $request->get('followup_date'),
            'note' => $request->get('note'),
        ]);

        $prescription_id = DB::getPdo()->lastInsertId();

        foreach ($request->medicines as $medicine) {
            if ($medicine['medicine'] != null) {
                DB::table('prescription_medicines')->insert([
                    'clinic_id' => $this->getClinic()->id,
                    'prescription_id' => $prescription_id,
                    'name' => $medicine['medicine'],
                    'frequency_type_id' => $medicine['frequency'] ?? null,
                    'period_type_id' => $medicine['period'] ?? null,
                    'note' => $medicine['note'],
                ]);
            }
        }


        foreach ($request->tests as $test) {
            if ($test['test'] != null) {
                DB::table('prescription_tests')->insert([
                    'clinic_id' => $this->getClinic()->id,
                    'prescription_id' => $prescription_id,
                    'name' => $test['test'],
                    'note' => $test['note'],
                ]);
            }
        }

        foreach ($request->formulas as $formula) {
            if ($formula['formula'] != null) {
                DB::table('prescription_formulas')->insert([
                    'clinic_id' => $this->getClinic()->id,
                    'prescription_id' => $prescription_id,
                    'formula_id' => $formula['formula'],
                    'frequency_type_id' => $formula['frequency'] ?? null,
                    'period_type_id' => $formula['period'] ?? null,
                    'note' => $formula['note'],
                ]);
            }
        }
        return redirect()->route('prescriptions.show', ['id' => $prescription_id]);
    }

    public function show($id)
    {
        $row = Prescription::find($id);
        dd($row);
    }

    public function get_appointments_of_patient(Request $request)
    {
        $appointments = Appointment::where('patient_id', '=', $request->patient_id)
            ->where('doctor_id', '=', auth()->user()->id)
            ->where('status', '=', 'pending')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($appointments);
    }

    public function checkItemsInDatabase($request, $table, $key, $value)
    {
        // get all old medicines and compare them to inserted ones
        $row = DB::table($table)
            ->where('clinic_id', $this->getClinic()->id)
            ->where('doctor_id', auth()->user()->id)
            ->select('name')
            ->get()->pluck('name');
        $row = $row->all();
        // if inserted medicines are not found in our database , then insert them
        foreach ($request->$table as $key) {
            if ($key[$value] != null && !in_array($key[$value], $row)) {
                DB::table($table)->insert([
                    'clinic_id' => $this->getClinic()->id,
                    'doctor_id' => auth()->user()->id,
                    'name' => $key[$value],
                ]);
            }
        }
    }

    public function insertRepeatedItems($request, $table, $prescription_id, $key, $value)
    {
        foreach ($request as $key) {
            DB::table($table)->insert([
                'clinic_id' => $this->getClinic()->id,
                'prescription_id' => $prescription_id,
                'name' => $key[$value],
                'frequency_type_id' => $key['frequency'],
                'period_type_id' => $key['period'],
                'note' => $key['note'],
            ]);
        }
    }
}
