<?php

namespace App\Repository;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Formula;
use App\Models\FrequencyType;
use App\Models\Medicine;
use App\Models\PeriodType;
use App\Models\Prescription;
use App\Models\Test;
use App\Repository\Interfaces\PrescriptionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PrescriptionRepository extends Controller implements PrescriptionRepositoryInterface
{
    public function getPrescriptions()
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
        return $rows;
    }

    public function createPrescriptions()
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
        $insurance_companies = DB::table('insurance_companies')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('doctor_id', auth()->user()->id)
            ->get();
        return [$patients, $frequencies, $periods, $medicines, $formulas, $tests, $insurance_companies];
    }

    public function storePrescriptions($request)
    {
        $this->validate($request, [
            'type' => ['required', 'integer'],
            'patient' => ['required', 'integer'],
            'date' => ['required', 'date'],
        ]);
        // functions to insert a new medicines or tests to suggest it later when going to create new prescription
        $this->checkItemsInDatabase($request, 'medicines', '$medicine', 'medicine');
        $this->checkItemsInDatabase($request, 'tests', '$test', 'test');

        // get fees based on prescription type and insurance company
        $fees = $this->getFees($request);
        $fileName = $this->storeImage($request, 'images/prescriptions');
        $prescription = DB::table('prescriptions')->insert([
            'clinic_id' => $this->getClinic()->id,
            'doctor_id' => auth()->user()->id,
            'patient_id' => $request->get('patient'),
            'insurance_company_id' => $request->insurance_company_id,
            'type' => $request->get('type'),
            'date' => $request->get('date'),
            'followup_date' => $request->get('followup_date'),
            'fees' => $fees,
            'file' => $fileName ?? null,
            'note' => $request->get('note'),
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        $prescription_id = DB::getPdo()->lastInsertId();
        $prescription = Prescription::find($prescription_id);
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
            if (isset($test['test'])) {
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

        $updateAppointmentStatus = DB::table('appointments')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('patient_id', $prescription->patient_id)
            ->where('doctor_id', $prescription->doctor_id)
            ->where('date', $prescription->date)
            ->update([
                'status' => 'complete'
            ]);
        return [$prescription, $updateAppointmentStatus, $prescription_id];
    }

    public function editPrescriptions($id)
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
        $patients = DB::table('users')
            ->join('patients', 'patients.user_id', '=', 'users.id')
            ->where('patients.doctor_id', '=', auth()->user()->id)
            ->where('users.clinic_id', '=', $this->getClinic()->id)
            ->orderBy('users.id', 'desc')
            ->select('users.name as user_name', 'users.id as user_id')
            ->get();
        $patient = DB::table('users')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('id', $prescription->patient_id)
            ->first();

        // control of frequency and period show in prescription for medicines
        $suggested_medicines = Medicine::where('doctor_id', auth()->user()->id)->select('name')->get();
        $suggested_tests = Test::where('doctor_id', auth()->user()->id)->select('name')->get();
        $all_formulas = Formula::where('doctor_id', auth()->user()->id)->select('id', 'name')->get();
        $frequencies = FrequencyType::where('doctor_id', auth()->user()->id)
            ->where('clinic_id', $this->getClinic()->id)
            ->orderBy('id', 'desc')
            ->get();
        $periods = PeriodType::where('doctor_id', auth()->user()->id)
            ->where('clinic_id', $this->getClinic()->id)
            ->orderBy('id', 'desc')
            ->get();

        $medicines = DB::table('prescription_medicines')
            ->leftjoin('frequency_types', 'frequency_types.id', '=', 'prescription_medicines.frequency_type_id')
            ->leftjoin('period_types', 'period_types.id', '=', 'prescription_medicines.period_type_id')
            ->where('prescription_medicines.prescription_id', $id)
            ->where('prescription_medicines.clinic_id', $this->getClinic()->id)
            ->select('prescription_medicines.name as medicine_name'
                , 'frequency_types.id as frequency_id',
                'period_types.id as period_id',
                'prescription_medicines.note as note'
            )->get();
        // control of frequency and period show in prescription for formulas
        $formulas = DB::table('prescription_formulas')
            ->join('formulas', 'formulas.id', '=', 'prescription_formulas.formula_id')
            ->leftjoin('frequency_types', 'frequency_types.id', '=', 'prescription_formulas.frequency_type_id')
            ->leftjoin('period_types', 'period_types.id', '=', 'prescription_formulas.period_type_id')
            ->where('prescription_formulas.prescription_id', $id)
            ->where('prescription_formulas.clinic_id', $this->getClinic()->id)
            ->select('formulas.name as formula_name'
                , 'frequency_types.id as frequency_id',
                'period_types.id as period_id',
                'prescription_formulas.note as note',
                'prescription_formulas.formula_id as formula_id',
            )->get();

        $tests = DB::table('prescription_tests')
            ->where('prescription_tests.prescription_id', $id)
            ->where('prescription_tests.clinic_id', $this->getClinic()->id)
            ->get();

        $insurance_companies = DB::table('insurance_companies')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('doctor_id', auth()->user()->id)
            ->get();

        return [$prescription,
            $suggested_medicines,
            $suggested_tests,
            $medicines,
            $tests,
            $formulas,
            $all_formulas,
            $patient,
            $patients,
            $appointment,
            $frequencies,
            $periods,
            $insurance_companies];
    }

    public function showPrescriptions($id)
    {
        $prescription = DB::table('prescriptions')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('id', $id)
            ->first();
        $prescription_design = DB::table('prescription_designs')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('doctor_id', $prescription->doctor_id)
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
            ->join('patients', 'patients.user_id', '=', 'users.id')
            ->where('users.clinic_id', $this->getClinic()->id)
            ->where('users.id', $prescription->patient_id)
            ->first();

        // control of frequency and period show in prescription for medicines
        $medicines = DB::table('prescription_medicines')
            ->where('prescription_id', $id)
            ->where('clinic_id', $this->getClinic()->id)
            ->select('*', 'name as medicine_name')
            ->get();
        foreach ($medicines as $medicine) {
            $medicines = DB::table('prescription_medicines')
                ->leftjoin('frequency_types', 'frequency_types.id', '=', 'prescription_medicines.frequency_type_id')
                ->leftjoin('period_types', 'period_types.id', '=', 'prescription_medicines.period_type_id')
                ->where('prescription_medicines.prescription_id', $id)
                ->where('prescription_medicines.clinic_id', $this->getClinic()->id)
                ->select('prescription_medicines.name as medicine_name'
                    , 'frequency_types.ar_name as frequency_name',
                    'period_types.ar_name as period_name'
                )->get();
        }
        // control of frequency and period show in prescription for formulas
        $formulas = DB::table('prescription_formulas')
            ->join('formulas', 'formulas.id', '=', 'prescription_formulas.formula_id')
            ->where('prescription_formulas.prescription_id', $id)
            ->where('prescription_formulas.clinic_id', $this->getClinic()->id)
            ->select('prescription_formulas.*', 'formulas.name as formula_name')
            ->get();
        foreach ($formulas as $formula) {
            $formulas = DB::table('prescription_formulas')
                ->join('formulas', 'formulas.id', '=', 'prescription_formulas.formula_id')
                ->leftjoin('frequency_types', 'frequency_types.id', '=', 'prescription_formulas.frequency_type_id')
                ->leftjoin('period_types', 'period_types.id', '=', 'prescription_formulas.period_type_id')
                ->where('prescription_formulas.prescription_id', $id)
                ->where('prescription_formulas.clinic_id', $this->getClinic()->id)
                ->select('formulas.name as formula_name'
                    , 'frequency_types.ar_name as frequency_name',
                    'period_types.ar_name as period_name'
                )->get();
        }

        $tests = DB::table('prescription_tests')
            ->where('prescription_tests.prescription_id', $id)
            ->where('prescription_tests.clinic_id', $this->getClinic()->id)
            ->get();
        return [$prescription, $medicines, $tests, $formulas, $doctor, $prescription_design, $patient, $appointment];
    }

    public function updatePrescriptions($request, $id)
    {
        $this->validate($request, [
            'type' => ['required', 'integer'],
            'patient' => ['required', 'integer'],
            'date' => ['required', 'date'],
        ]);
        $row = DB::table('prescriptions')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('id', $id)
            ->first();
        // function to insert a new medicines or tests to suggest it later when go to create new prescriptions
        $this->checkItemsInDatabase($request, 'medicines', '$medicine', 'medicine');
        $this->checkItemsInDatabase($request, 'tests', '$test', 'test');

        // get fees based on prescription type and insurance company
        $fees = $this->getFees($request);
        // delete old file if new one uploaded
        if (!empty($row->file) && file_exists(public_path('images/prescriptions/' . $row->file))) {
            if ($request->hasFile('file') && $request->file('file')) {
                unlink(public_path('images/prescriptions/' . $row->file));
            }
        }
        $prescription = DB::table('prescriptions')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('id', $id)
            ->update([
                'patient_id' => $request->get('patient'),
                'insurance_company_id' => $request->insurance_company_id,
                'type' => $request->get('type'),
                'date' => $request->get('date'),
                'followup_date' => $request->get('followup_date') ?? null,
                'fees' => $fees,
                'file' => ($request->hasFile('file') && $request->file('file') != '' ? $this->storeImage($request,'images/prescriptions') : $row->file),
                'note' => $request->get('note'),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);

        DB::table('prescription_medicines')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('prescription_id', $id)
            ->delete();
        foreach ($request->medicines as $medicine) {
            if ($medicine['medicine'] != null) {
                DB::table('prescription_medicines')->insert([
                    'clinic_id' => $this->getClinic()->id,
                    'prescription_id' => $id,
                    'name' => $medicine['medicine'],
                    'frequency_type_id' => $medicine['frequency'] ?? null,
                    'period_type_id' => $medicine['period'] ?? null,
                    'note' => $medicine['note'],
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ]);
            }
        }

        DB::table('prescription_tests')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('prescription_id', $id)
            ->delete();
        foreach ($request->tests as $test) {
            if ($test['test'] != null) {
                DB::table('prescription_tests')->insert([
                    'clinic_id' => $this->getClinic()->id,
                    'prescription_id' => $id,
                    'name' => $test['test'],
                    'note' => $test['note'],
                ]);
            }
        }
        DB::table('prescription_formulas')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('prescription_id', $id)
            ->delete();
        foreach ($request->formulas as $formula) {
            if (isset($formula['formula'])) {
                DB::table('prescription_formulas')->insert([
                    'clinic_id' => $this->getClinic()->id,
                    'prescription_id' => $id,
                    'formula_id' => $formula['formula'],
                    'frequency_type_id' => $formula['frequency'] ?? null,
                    'period_type_id' => $formula['period'] ?? null,
                    'note' => $formula['note'],
                ]);
            }
        }
        return $prescription;
    }

    public function printPDF($id)
    {
        $prescription = DB::table('prescriptions')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('id', $id)
            ->first();
        $prescription_design = DB::table('prescription_designs')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('doctor_id', $prescription->doctor_id)
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
            ->join('patients', 'patients.user_id', '=', 'users.id')
            ->where('users.clinic_id', $this->getClinic()->id)
            ->where('users.id', $prescription->patient_id)
            ->first();

        // control of frequency and period show in prescription for medicines
        $medicines = DB::table('prescription_medicines')
            ->where('prescription_id', $id)
            ->where('clinic_id', $this->getClinic()->id)
            ->select('*', 'name as medicine_name')
            ->get();
        foreach ($medicines as $medicine) {
            $medicines = DB::table('prescription_medicines')
                ->leftjoin('frequency_types', 'frequency_types.id', '=', 'prescription_medicines.frequency_type_id')
                ->leftjoin('period_types', 'period_types.id', '=', 'prescription_medicines.period_type_id')
                ->where('prescription_medicines.prescription_id', $id)
                ->where('prescription_medicines.clinic_id', $this->getClinic()->id)
                ->select('prescription_medicines.name as medicine_name'
                    , 'frequency_types.ar_name as frequency_name',
                    'period_types.ar_name as period_name'
                )->get();
        }
        // control of frequency and period show in prescription for formulas
        $formulas = DB::table('prescription_formulas')
            ->join('formulas', 'formulas.id', '=', 'prescription_formulas.formula_id')
            ->where('prescription_formulas.prescription_id', $id)
            ->where('prescription_formulas.clinic_id', $this->getClinic()->id)
            ->select('prescription_formulas.*', 'formulas.name as formula_name')
            ->get();
        foreach ($formulas as $formula) {
            $formulas = DB::table('prescription_formulas')
                ->join('formulas', 'formulas.id', '=', 'prescription_formulas.formula_id')
                ->leftjoin('frequency_types', 'frequency_types.id', '=', 'prescription_formulas.frequency_type_id')
                ->leftjoin('period_types', 'period_types.id', '=', 'prescription_formulas.period_type_id')
                ->where('prescription_formulas.prescription_id', $id)
                ->where('prescription_formulas.clinic_id', $this->getClinic()->id)
                ->select('formulas.name as formula_name'
                    , 'frequency_types.ar_name as frequency_name',
                    'period_types.ar_name as period_name'
                )->get();
        }

        $tests = DB::table('prescription_tests')
            ->where('prescription_tests.prescription_id', $id)
            ->where('prescription_tests.clinic_id', $this->getClinic()->id)
            ->get();
        $mpdf = new \Mpdf\Mpdf();
        return [$mpdf, $prescription, $medicines, $tests, $formulas, $doctor, $prescription_design, $appointment, $patient];
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

    public function getFees($request)
    {
        // get fees based on prescription type
        $doctor = Doctor::where('user_id', auth()->user()->id)->first();
        if ($request->type == 0) {
            $fees = $doctor->examination_fees;
            if ($request->has('insurance_company_id') && $request->insurance_company_id != '') {
                $discount_rate = DB::table('insurance_companies')
                    ->where('id', $request->insurance_company_id)
                    ->where('clinic_id', $this->getClinic()->id)
                    ->select('discount_rate')
                    ->first();
                $discount_rate = $discount_rate->discount_rate;
                $fees = $fees - (($fees / 100) * $discount_rate);
            }
        } else {
            $fees = $doctor->followup_fees;
            if ($request->has('insurance_company_id') && $request->insurance_company_id != '') {
                $discount_rate = DB::table('insurance_companies')
                    ->where('id', $request->insurance_company_id)
                    ->where('clinic_id', $this->getClinic()->id)
                    ->select('discount_rate')
                    ->first();
                $discount_rate = $discount_rate->discount_rate;
                $fees = $fees - (($fees / 100) * $discount_rate);
            }
        }
        return $fees;
    }

    protected function storeImage($request, $path)
    {
        if (!file_exists(public_path($path))) {
            mkdir($path, 666, true);
        }
        if ($request->file('file')) {
            $fileName = uniqid() . $request->file('file')->getClientOriginalName();
            $request->file('file')->move(public_path($path) , $fileName);
            return $fileName;
        }
    }
}
