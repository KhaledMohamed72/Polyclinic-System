<?php

namespace App\Http\Controllers;

use App\Repository\ReportRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    protected $reportRepository;

    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function index()
    {
        list($patient_rows, $doctor_rows, $company_rows, $clinicType, $income_types, $expense_types) = $this->reportRepository->main();
        return view('reports.index', compact(
            'patient_rows',
            'doctor_rows',
            'company_rows',
            'clinicType',
            'income_types',
            'expense_types'
        ));
    }

    public function patient_history(Request $request)
    {

        list($prescriptions,$patient,$sessions) = $this->reportRepository->get_patient_history($request);
        $html = view('reports.patient-history',
            compact('prescriptions', 'patient', 'sessions'))->render();
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;

        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function doctor_history(Request $request)
    {
        list($doctor, $prescriptions_count, $prescriptions_fees_sum, $patients_count, $sessions_count, $sessions_fees_sum, $incomes_count, $incomes_fees_sum)
            = $this->reportRepository->get_doctor_history($request);
        $html = view('reports.doctor-history',
            compact('doctor', 'prescriptions_count', 'prescriptions_fees_sum', 'patients_count', 'sessions_count', 'sessions_fees_sum', 'incomes_count', 'incomes_fees_sum'))->render();
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;

        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function insurance_company(Request $request)
    {

        list($company, $prescriptions_examination_count, $prescriptions_followup_count,$prescriptions_fees_sum,$sessions_fees_sum, $sessions_count, $prescriptions, $sessions)
            = $this->reportRepository->get_insurance_company($request);
        $html = view('reports.insurance-company',
            compact('company', 'prescriptions_examination_count', 'prescriptions_followup_count','prescriptions_fees_sum','sessions_fees_sum', 'sessions_count', 'prescriptions', 'sessions'))->render();
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;

        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function incomes_report(Request $request)
    {

        $this->validate($request, [
            'type' => ['required', 'integer'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from']
        ]);

        $income_name = DB::table('income_types')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->where('id', '=', $request->type)
            ->pluck('name')->first();
        $date1 = date('Y-m-d 00:00:00', strtotime($request->from)) == '1970-01-01 00:00:00' ? '1970-01-01 00:00:00' : date('Y-m-d 00:00:00', strtotime($request->from));
        $date2 = date('Y-m-d 23:59:59', strtotime($request->to)) == '1970-01-01 23:59:59' ? Carbon::today()->toDateString() . ' 23:59:59' : date('Y-m-d 23:59:59', strtotime($request->to));

        $incomes = DB::table('incomes')
            ->leftjoin('users', 'users.id', '=', 'incomes.doctor_id')
            ->where('incomes.clinic_id', $this->getClinic()->id)
            ->where('incomes.income_type_id', $request->type)
            ->whereBetween('incomes.created_at', [$date1, $date2])
            ->select('incomes.created_at as date', 'incomes.note as note', 'incomes.amount as amount', 'users.name as doctor_name')
            ->get();
        $incomes_sum = $incomes->sum('amount');

        $html = view('reports.incomes-report',
            compact('incomes', 'income_name', 'incomes_sum'))->render();
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;

        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function expenses_report(Request $request)
    {

        $this->validate($request, [
            'type' => ['required', 'integer'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from']
        ]);

        $expense_name = DB::table('expense_types')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->where('id', '=', $request->type)
            ->pluck('name')->first();
        $date1 = date('Y-m-d 00:00:00', strtotime($request->from)) == '1970-01-01 00:00:00' ? '1970-01-01 00:00:00' : date('Y-m-d 00:00:00', strtotime($request->from));
        $date2 = date('Y-m-d 23:59:59', strtotime($request->to)) == '1970-01-01 23:59:59' ? Carbon::today()->toDateString() . ' 23:59:59' : date('Y-m-d 23:59:59', strtotime($request->to));

        $expenses = DB::table('expenses')
            ->leftjoin('users', 'users.id', '=', 'expenses.doctor_id')
            ->where('expenses.clinic_id', $this->getClinic()->id)
            ->where('expenses.expense_type_id', $request->type)
            ->whereBetween('expenses.created_at', [$date1, $date2])
            ->select('expenses.created_at as date', 'expenses.note as note', 'expenses.amount as amount', 'users.name as doctor_name')
            ->get();
        $expenses_sum = $expenses->sum('amount');

        $html = view('reports.expenses-report',
            compact('expenses', 'expense_name', 'expenses_sum'))->render();
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;

        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function profit_report(Request $request)
    {
        list(
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
            ) = $this->reportRepository->get_profit($request);
        return view('reports.profit-report',
            compact(
                'doctor',
                'expenses',
                'expenses_sum',
                'incomes',
                'incomes_sum',
                'prescriptions_examination_count',
                'prescriptions_followup_count',
                'prescriptions_examination_sum',
                'prescriptions_total_sum',
                'prescriptions_followup_sum',
                'sessions',
                'sessions_sum',
                'clinicType'
            ));
    }

}
