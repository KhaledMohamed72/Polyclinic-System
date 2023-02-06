<?php

namespace App\Repository;

use App\Http\Controllers\Controller;
use App\Repository\Interfaces\ReportRepositoryInterface;
use App\Traits\GeneralTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportRepository extends Controller implements ReportRepositoryInterface
{
    use GeneralTrait;

    public function main()
    {
        if (!auth()->user()->hasRole(['admin', 'doctor', 'recep'])) {
            toastr()->warning('Something went wrong!');
            abort(203);
        }

        $patient_rows = $this->getPatientRows($this->getClinic()->id, auth()->user()->id);
        $doctor_rows = $this->getDoctorRows($this->getClinic()->id, auth()->user()->id);
        $company_rows = $this->getInsuranceCompaniessBasedOnRole($this->getClinic()->id, auth()->user()->id);

        $income_types = DB::table('income_types')
            ->where('clinic_id', $this->getClinic()->id)
            ->select('id', 'name')
            ->get();
        $expense_types = DB::table('expense_types')
            ->where('clinic_id', $this->getClinic()->id)
            ->select('id', 'name')
            ->get();
        $clinicType = $this->getClinic()->type;
        if (auth()->user()->hasRole('doctor')) {
            $count_patients = count($patient_rows);
            if ($count_patients == 0) {
                toastr()->warning('There is no patient , You must create patient first !');
                return redirect()->route('patients.create');
            }
        }
        return [$patient_rows, $doctor_rows, $company_rows, $clinicType, $income_types, $expense_types];
    }

    public function get_patient_history($request)
    {
        $this->validate($request, [
            'patient' => ['required', 'integer'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from']
        ]);
        $date1 = date('Y-m-d 00:00:00', strtotime($request->from)) == '1970-01-01 00:00:00' ? '1970-01-01 00:00:00' : date('Y-m-d 00:00:00', strtotime($request->from));
        $date2 = date('Y-m-d 23:59:59', strtotime($request->to)) == '1970-01-01 23:59:59' ? Carbon::today()->toDateString() . ' 23:59:59' : date('Y-m-d 23:59:59', strtotime($request->to));
        $prescriptions = DB::table('prescriptions')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('patient_id', $request->patient)
            ->whereBetween('created_at', [$date1, $date2])
            ->select('prescriptions.*')
            ->orderBy('id', 'desc')
            ->get();
        $patient = DB::table('users')
            ->join('patients', 'patients.user_id', '=', 'users.id')
            ->where('users.clinic_id', $this->getClinic()->id)
            ->where('users.id', $request->patient)
            ->select('users.name as name', 'users.phone as phone', 'patients.address as address')
            ->first();
        $sessions = [];
        if ($request->sessions != null) {
            $sessions = DB::table('sessions_info')
                ->join('session_types', 'session_types.id', '=', 'sessions_info.session_type_id')
                ->where('sessions_info.clinic_id', '=', $this->getClinic()->id)
                ->where('sessions_info.patient_id', $request->patient)
                ->whereBetween('sessions_info.created_at', [$date1, $date2])
                ->select('sessions_info.*', 'session_types.name as session_name')
                ->get();
        }

        return [$prescriptions,$patient,$sessions];
    }

    public function get_doctor_history($request)
    {
        if (auth()->user()->hasRole(['admin', 'recep'])) {
            $this->validate($request, [
                'doctor' => ['required', 'integer'],
                'from' => ['nullable', 'date'],
                'to' => ['nullable', 'date', 'after_or_equal:from']
            ]);
        }
        if (auth()->user()->hasRole('doctor')) {
            $this->validate($request, [
                'from' => ['nullable', 'date'],
                'to' => ['nullable', 'date', 'after_or_equal:from']
            ]);
        }
        $doctor_id = $request->doctor;
        $doctor = DB::table('users')
            ->join('doctors', 'doctors.user_id', '=', 'users.id')
            ->where('users.clinic_id', $this->getClinic()->id)
            ->where('users.id', $doctor_id)
            ->first();

        $date1 = date('Y-m-d 00:00:00', strtotime($request->from)) == '1970-01-01 00:00:00' ? '1970-01-01 00:00:00' : date('Y-m-d 00:00:00', strtotime($request->from));
        $date2 = date('Y-m-d 23:59:59', strtotime($request->to)) == '1970-01-01 23:59:59' ? Carbon::today()->toDateString() . ' 23:59:59' : date('Y-m-d 23:59:59', strtotime($request->to));

        $prescriptions = DB::table('prescriptions')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('doctor_id', $doctor_id)
            ->whereBetween('created_at', [$date1, $date2])
            ->select('fees')
            ->get();
        $prescriptions_count = $prescriptions->count();
        $prescriptions_fees_sum = $prescriptions->sum('fees');
        $patients_count = DB::table('users')
            ->join('patients', 'patients.user_id', '=', 'users.id')
            ->where('users.clinic_id', $this->getClinic()->id)
            ->where('patients.doctor_id', $doctor_id)
            ->count();
        $sessions_count = null;
        $sessions_fees_sum = null;
        if ($request->sessions != null) {
            $sessions = DB::table('sessions_info')
                ->where('doctor_id', '=', $doctor_id)
                ->where('clinic_id', '=', $this->getClinic()->id)
                ->whereBetween('sessions_info.created_at', [$date1, $date2])
                ->select('fees')
                ->get();
            $sessions_count = $sessions->count();
            $sessions_fees_sum = $sessions->sum('fees');
        }
        $incomes_count = null;
        $incomes_fees_sum = null;
        if ($request->incomes != null) {
            $incomes = DB::table('incomes')
                ->where('doctor_id', '=', $doctor_id)
                ->where('clinic_id', '=', $this->getClinic()->id)
                ->whereBetween('created_at', [$date1, $date2])
                ->select('amount')
                ->get();
            $incomes_count = $incomes->count();
            $incomes_fees_sum = $incomes->sum('amount');
        }

        return [$doctor, $prescriptions_count, $prescriptions_fees_sum, $patients_count, $sessions_count, $sessions_fees_sum, $incomes_count, $incomes_fees_sum];
    }

    public function get_insurance_company($request)
    {
        $this->validate($request, [
            'company' => ['required', 'integer'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from']
        ]);

        $company = DB::table('insurance_companies')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('id', $request->company)
            ->first();
        $date1 = date('Y-m-d 00:00:00', strtotime($request->from)) == '1970-01-01 00:00:00' ? '1970-01-01 00:00:00' : date('Y-m-d 00:00:00', strtotime($request->from));
        $date2 = date('Y-m-d 23:59:59', strtotime($request->to)) == '1970-01-01 23:59:59' ? Carbon::today()->toDateString() . ' 23:59:59' : date('Y-m-d 23:59:59', strtotime($request->to));

        $prescriptions = DB::table('prescriptions')
            ->join('users', 'users.id', '=', 'prescriptions.patient_id')
            ->where('prescriptions.clinic_id', $this->getClinic()->id)
            ->where('prescriptions.insurance_company_id', $request->company)
            ->whereBetween('prescriptions.created_at', [$date1, $date2])
            ->select('users.name as name', 'prescriptions.*')
            ->get();
        $prescriptions_examination_count = $prescriptions->where('type', '=', 0)->count();
        $prescriptions_followup_count = $prescriptions->where('type', '=', 1)->count();
        $prescriptions_fees_sum = $prescriptions->sum('fees');

        $sessions_count = 0;
        $sessions_fees_sum = 0;
        $sessions = [];
        if ($request->sessions != null) {
            $sessions = DB::table('sessions_info')
                ->join('users', 'users.id', '=', 'sessions_info.patient_id')
                ->join('session_types', 'session_types.id', '=', 'sessions_info.session_type_id')
                ->where('sessions_info.insurance_company_id', $request->company)
                ->where('sessions_info.clinic_id', '=', $this->getClinic()->id)
                ->whereBetween('sessions_info.created_at', [$date1, $date2])
                ->select('sessions_info.*', 'session_types.name as session_type', 'users.name as patient_name')
                ->get();
            $sessions_count = $sessions->count();
            $sessions_fees_sum = $sessions->sum('fees');
        }
        return [$company, $prescriptions_examination_count, $prescriptions_followup_count, $prescriptions_fees_sum, $sessions_count,$sessions_fees_sum, $prescriptions, $sessions];
    }

    public function get_profit($request)
    {
        $this->validate($request, [
            'doctor' => ['nullable', 'integer'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from']
        ]);

        $date1 = date('Y-m-d 00:00:00', strtotime($request->from)) == '1970-01-01 00:00:00' ? '1970-01-01 00:00:00' : date('Y-m-d 00:00:00', strtotime($request->from));
        $date2 = date('Y-m-d 23:59:59', strtotime($request->to)) == '1970-01-01 23:59:59' ? Carbon::today()->toDateString() . ' 23:59:59' : date('Y-m-d 23:59:59', strtotime($request->to));

        $clinicType = $this->getClinic()->type;
        if (!empty($request->doctor)) {
            $doctor = DB::table('users')
                ->where('clinic_id', $this->getClinic()->id)
                ->where('id', '=', $request->doctor)
                ->pluck('name')
                ->first();
            $incomes = DB::table('incomes')
                ->leftjoin('income_types', 'income_types.id', '=', 'incomes.income_type_id')
                ->where('incomes.clinic_id', $this->getClinic()->id)
                ->where('incomes.doctor_id', $request->doctor)
                ->whereBetween('incomes.created_at', [$date1, $date2])
                ->select('incomes.created_at as date', 'income_types.name as name', 'incomes.amount as amount')
                ->get();
            $incomes_sum = $incomes->sum('amount');
            $expenses = DB::table('expenses')
                ->leftjoin('expense_types', 'expense_types.id', '=', 'expenses.expense_type_id')
                ->where('expenses.clinic_id', $this->getClinic()->id)
                ->where('expenses.doctor_id', $request->doctor)
                ->whereBetween('expenses.created_at', [$date1, $date2])
                ->select('expenses.created_at as date', 'expense_types.name as name', 'expenses.amount as amount')
                ->get();
            $expenses_sum = $expenses->sum('amount');
            $prescriptions = DB::table('prescriptions')
                ->where('clinic_id', $this->getClinic()->id)
                ->where('doctor_id', $request->doctor)
                ->whereBetween('created_at', [$date1, $date2])
                ->select('fees')
                ->get();
            $prescriptions_examination_count = $prescriptions->where('type', '=', 0)->count();
            $prescriptions_followup_count = $prescriptions->where('type', '=', 1)->count();
            $prescriptions_examination_sum = $prescriptions->where('type', '=', 0)->sum('fees');
            $prescriptions_followup_sum = $prescriptions->where('type', '=', 1)->sum('fees');
            $prescriptions_total_sum = $prescriptions->sum('fees');

            $sessions = DB::table('sessions_info')
                ->leftJoin('session_types','session_types.id','sessions_info.session_type_id')
                ->where('sessions_info.doctor_id', '=', $request->doctor)
                ->where('sessions_info.clinic_id', '=', $this->getClinic()->id)
                ->whereBetween('sessions_info.created_at', [$date1, $date2])
                ->selectRaw('session_types.name as session_type_name,SUM(fees) as fees,count(*) as sessions_count')
                ->groupBy('session_types.name')
                ->get();
            $sessions_sum = $sessions->sum('fees');
        } else {
            $doctor = null;
            $incomes = DB::table('incomes')
                ->leftjoin('users', 'users.id', '=', 'incomes.doctor_id')
                ->leftjoin('income_types', 'income_types.id', '=', 'incomes.income_type_id')
                ->where('incomes.clinic_id', $this->getClinic()->id)
                ->whereBetween('incomes.created_at', [$date1, $date2])
                ->select('incomes.created_at as date', 'income_types.name as name', 'users.name as doctor_name', 'incomes.amount as amount')
                ->get();
            $incomes_sum = $incomes->sum('amount');
            $expenses = DB::table('expenses')
                ->leftjoin('users', 'users.id', '=', 'expenses.doctor_id')
                ->leftjoin('expense_types', 'expense_types.id', '=', 'expenses.expense_type_id')
                ->where('expenses.clinic_id', $this->getClinic()->id)
                ->whereBetween('expenses.created_at', [$date1, $date2])
                ->select('expenses.created_at as date', 'expense_types.name as name', 'users.name as doctor_name', 'expenses.amount as amount')
                ->get();
            $expenses_sum = $expenses->sum('amount');
            $prescriptions = DB::table('prescriptions')
                ->where('clinic_id', $this->getClinic()->id)
                ->whereBetween('created_at', [$date1, $date2])
                ->select('fees','type')
                ->get();
            $prescriptions_examination_count = $prescriptions->where('type', '=', 0)->count();
            $prescriptions_followup_count = $prescriptions->where('type', '=', 1)->count();
            $prescriptions_examination_sum = $prescriptions->where('type', '=', 0)->sum('fees');
            $prescriptions_followup_sum = $prescriptions->where('type', '=', 1)->sum('fees');
            $prescriptions_total_sum = $prescriptions->sum('fees');

            $sessions = DB::table('sessions_info')
                ->leftJoin('session_types','session_types.id','sessions_info.session_type_id')
                ->where('sessions_info.clinic_id', '=', $this->getClinic()->id)
                ->whereBetween('sessions_info.created_at', [$date1, $date2])
                ->selectRaw('session_types.name as session_type_name,SUM(fees) as fees,count(*) as sessions_count')
                ->groupBy('session_types.name')
                ->get();
            $sessions_sum = $sessions->sum('fees');
        }

        return [
            $doctor,
            $expenses,
            $expenses_sum,
            $incomes,
            $incomes_sum,
            $prescriptions_examination_count,
            $prescriptions_followup_count,
            $prescriptions_examination_sum,
            $prescriptions_total_sum,
            $prescriptions_followup_sum,
            $sessions,
            $sessions_sum,
            $clinicType
        ];
    }

    protected function getPatientRows($clinic_id, $user_id)
    {
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('users')
                ->join('patients', 'patients.user_id', '=', 'users.id')
                ->where('users.clinic_id', '=', $clinic_id)
                ->select('users.id as user_id', 'users.name as patient_name')
                ->orderBy('users.id', 'desc')
                ->get();
        }
        if (auth()->user()->hasRole('recep')) {
            $rows = DB::table('users')
                ->join('patients', 'patients.user_id', '=', 'users.id')
                ->where('users.clinic_id', '=', $clinic_id)
                ->where('patients.receptionist_id', '=', $user_id)
                ->select('users.id as user_id', 'users.name as patient_name')
                ->orderBy('users.id', 'desc')
                ->get();
        }
        if (auth()->user()->hasRole('doctor')) {
            $rows = DB::table('users')
                ->join('patients', 'patients.user_id', '=', 'users.id')
                ->where('users.clinic_id', '=', $clinic_id)
                ->where('patients.doctor_id', '=', $user_id)
                ->select('users.id as user_id', 'users.name as patient_name')
                ->orderBy('users.id', 'desc')
                ->get();
        }
        return $rows;
    }

    protected function getDoctorRows($clinic_id, $user_id)
    {
        $rows = array();
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->where('users.clinic_id', '=', $clinic_id)
                ->select('users.id as user_id', 'users.name as doctor_name')
                ->orderBy('users.id', 'desc')
                ->get();
        }
        if (auth()->user()->hasRole('recep')) {
            $rows = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->where('users.clinic_id', '=', $clinic_id)
                ->where('doctors.receptionist_id', '=', $user_id)
                ->select('users.id as user_id', 'users.name as doctor_name')
                ->orderBy('users.id', 'desc')
                ->get();
        }
        if (auth()->user()->hasRole('doctor')) {
            $rows = DB::table('users')
                ->where('clinic_id', '=', $clinic_id)
                ->where('id', '=', $user_id)
                ->select('users.id as user_id')
                ->get();
        }
        return $rows;
    }
}
