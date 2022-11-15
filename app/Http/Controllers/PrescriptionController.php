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
    public function index()
    {
        // admin
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('prescriptions')
                ->join('users as t1', 't1.id', '=', 'prescriptions.doctor_id')
                ->join('users as t2', 't2.id', '=', 'prescriptions.patient_id')
                ->where('prescriptions.clinic_id', '=', $this->getClinic()->id)
                ->select('prescriptions.*', 't1.name as doctor_name', 't2.name as patient_name')
                ->orderBy('prescriptions.id', 'desc')
                ->get();
        }
        // doctor
        if (auth()->user()->hasRole('doctor')) {
            $rows = DB::table('prescriptions')
                ->join('users as t1', 't1.id', '=', 'prescriptions.doctor_id')
                ->join('users as t2', 't2.id', '=', 'prescriptions.patient_id')
                ->where('prescriptions.clinic_id', '=', $this->getClinic()->id)
                ->where('prescriptions.doctor_id', '=', auth()->user()->id)
                ->select('prescriptions.*', 't1.name as doctor_name', 't2.name as patient_name')
                ->orderBy('prescriptions.id', 'desc')
                ->get();
        }
        // receptionist
        if (auth()->user()->hasRole('recep')) {
            $recep_doctors = DB::table('doctors')
                ->where('clinic_id', $this->getClinic()->id)
                ->where('receptionist_id', auth()->user()->id)
                ->select('user_id')
                ->get()->pluck('user_id');
            $recep_doctors_array = $recep_doctors->all();
            $rows = DB::table('prescriptions')
                ->join('users as t1', 't1.id', '=', 'prescriptions.doctor_id')
                ->join('users as t2', 't2.id', '=', 'prescriptions.patient_id')
                ->where('prescriptions.clinic_id', '=', $this->getClinic()->id)
                ->whereIn('prescriptions.doctor_id', $recep_doctors_array)
                ->select('prescriptions.*', 't1.name as doctor_name', 't2.name as patient_name')
                ->orderBy('prescriptions.id', 'desc')
                ->get();
        }
        return view('prescriptions.index', compact('rows'));

    }

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
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
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
            if (isset($formula['formula'])) {
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
        return redirect()->route('prescriptions.show', ['prescription' => $prescription_id]);
    }

    public function show($id)
    {
        $prescription = DB::table('prescriptions')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('id', $id)
            ->first();
        $appointment = DB::table('appointments')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('patient_id', $prescription->patient_id)
            ->where('date', $prescription->date)
            ->select('date', 'time')
            ->first();

        $doctor = DB::table('users')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('id', $prescription->doctor_id)
            ->first();
        $patient = DB::table('users')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('id', $prescription->patient_id)
            ->first();
        $medicines = DB::table('prescription_medicines')
            ->where('prescription_id', $id)
            ->where('clinic_id', $this->getClinic()->id)
            ->select('*','name as medicine_name')
            ->get();
        foreach ($medicines as $medicine){
        if ($medicine->period_type_id == null && $medicine->frequency_type_id != null){
            $medicines = DB::table('prescription_medicines')
                ->join('frequency_types', 'frequency_types.id', '=', 'prescription_medicines.frequency_type_id')
                ->where('prescription_medicines.prescription_id', $id)
                ->where('prescription_medicines.clinic_id', $this->getClinic()->id)
                ->select('prescription_medicines.name as medicine_name'
                    , 'frequency_types.ar_name as frequency_name',
                )->get();
        }
            if ($medicine->period_type_id != null && $medicine->frequency_type_id == null){
                $medicines = DB::table('prescription_medicines')
                    ->join('period_types', 'period_types.id', '=', 'prescription_medicines.period_type_id')
                    ->where('prescription_medicines.prescription_id', $id)
                    ->where('prescription_medicines.clinic_id', $this->getClinic()->id)
                    ->select('prescription_medicines.name as medicine_name',
                        'period_types.ar_name as period_name'
                    )->get();
            }
            if ($medicine->period_type_id != null && $medicine->frequency_type_id != null){
                $medicines = DB::table('prescription_medicines')
                    ->join('frequency_types', 'frequency_types.id', '=', 'prescription_medicines.frequency_type_id')
                    ->join('period_types', 'period_types.id', '=', 'prescription_medicines.period_type_id')
                    ->where('prescription_medicines.prescription_id', $id)
                    ->where('prescription_medicines.clinic_id', $this->getClinic()->id)
                    ->select('prescription_medicines.name as medicine_name'
                        , 'frequency_types.ar_name as frequency_name',
                        'period_types.ar_name as period_name'
                    )->get();
            }
    }
        $formulas = DB::table('prescription_formulas')
            ->join('formulas', 'formulas.id', '=', 'prescription_formulas.formula_id')
            ->where('prescription_formulas.prescription_id', $id)
            ->where('prescription_formulas.clinic_id', $this->getClinic()->id)
            ->select('prescription_formulas.*','formulas.name as formula_name')
            ->get();
        foreach ($formulas as $formula){
            if ($formula->period_type_id == null && $formula->frequency_type_id != null){
                $formulas = DB::table('prescription_formulas')
                    ->join('formulas', 'formulas.id', '=', 'prescription_formulas.formula_id')
                    ->join('frequency_types', 'frequency_types.id', '=', 'prescription_formulas.frequency_type_id')
                    ->where('prescription_formulas.prescription_id', $id)
                    ->where('prescription_formulas.clinic_id', $this->getClinic()->id)
                    ->select('formulas.name as formula_name'
                        , 'frequency_types.ar_name as frequency_name',
                    )->get();
            }
            if ($formula->period_type_id != null && $formula->frequency_type_id == null){
                $formulas = DB::table('prescription_formulas')
                    ->join('formulas', 'formulas.id', '=', 'prescription_formulas.formula_id')
                    ->join('period_types', 'period_types.id', '=', 'prescription_formulas.period_type_id')
                    ->where('prescription_formulas.prescription_id', $id)
                    ->where('prescription_formulas.clinic_id', $this->getClinic()->id)
                    ->select('formulas.name as formula_name',
                        'period_types.ar_name as period_name'
                    )->get();
            }
            if ($formula->period_type_id != null && $formula->frequency_type_id != null){
                $formulas = DB::table('prescription_formulas')
                    ->join('formulas', 'formulas.id', '=', 'prescription_formulas.formula_id')
                    ->join('frequency_types', 'frequency_types.id', '=', 'prescription_formulas.frequency_type_id')
                    ->join('period_types', 'period_types.id', '=', 'prescription_formulas.period_type_id')
                    ->where('prescription_formulas.prescription_id', $id)
                    ->where('prescription_formulas.clinic_id', $this->getClinic()->id)
                    ->select('formulas.name as formula_name'
                        , 'frequency_types.ar_name as frequency_name',
                        'period_types.ar_name as period_name'
                    )->get();
            }
        }

        $tests = DB::table('prescription_tests')
            ->where('prescription_tests.prescription_id', $id)
            ->where('prescription_tests.clinic_id', $this->getClinic()->id)
            ->get();

        return view('prescriptions.show',
            compact(
                'prescription',
                'medicines',
                'tests',
                'formulas',
                'doctor',
                'patient',
                'appointment'
            ));
    }

    public function destroy($id)
    {
        $row = Prescription::where('id', '=', $id)->first();
        if (auth()->user()->hasRole('doctor')) {
            $row = $row->delete();
        }
        if ($row) {
            toastr()->success('Successfully Deleted');
            return redirect()->route('prescriptions.index');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('prescriptions.index');
        }
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
