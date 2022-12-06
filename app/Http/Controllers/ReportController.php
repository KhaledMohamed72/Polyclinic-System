<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasRole(['admin', 'doctor', 'recep'])) {
            toastr()->warning('Something went wrong!');
            return redirect()->route('home');
        }

        $patient_rows = DB::table('users')
            ->join('patients', 'patients.user_id', '=', 'users.id')
            ->where('users.clinic_id', '=', $this->getClinic()->id)
            ->where('patients.doctor_id', '=', auth()->user()->id)
            ->select('users.id', 'users.name')
            ->get();

        $doctor_rows = DB::table('users')
            ->join('doctors', 'doctors.user_id', '=', 'users.id')
            ->where('users.clinic_id', '=', $this->getClinic()->id)
            ->select('users.id', 'users.name')
            ->get();
        $company_rows = DB::table('care_companies')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('doctor_id', auth()->user()->id)
            ->get();
        if (auth()->user()->hasRole('doctor')) {
            $count_patients = count($patient_rows);
            if ($count_patients == 0) {
                toastr()->warning('There is no patient , You must create patient first !');
                return redirect()->route('patients.create');
            }
        }
        return view('reports.index', compact(
            'patient_rows',
            'doctor_rows',
            'company_rows'
        ));
    }

    public function patient_history(Request $request)
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
            ->where('doctor_id', auth()->user()->id)
            ->whereBetween('created_at', [$date1, $date2])
            ->select('prescriptions.*')
            ->orderBy('id', 'desc')
            ->get();

        $patient = DB::table('users')
            ->join('patients', 'patients.user_id', '=', 'users.id')
            ->where('users.clinic_id', $this->getClinic()->id)
            ->where('users.id', $request->patient)
            ->select('users.name as name', 'patients.address as address')
            ->first();
        $sessions = [];
        if ($request->sessions != null) {
            $sessions = DB::table('sessions_info')
                ->join('session_types', 'session_types.id', '=', 'sessions_info.session_type_id')
                ->where('sessions_info.doctor_id', '=', auth()->user()->id)
                ->where('sessions_info.clinic_id', '=', $this->getClinic()->id)
                ->whereBetween('sessions_info.created_at', [$date1, $date2])
                ->select('sessions_info.*', 'session_types.name as session_name')
                ->get();
        }
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
        if (auth()->user()->hasRole('admin')) {
            $this->validate($request, [
                'doctor' => ['required', 'integer'],
                'from' => ['nullable', 'date'],
                'to' => ['nullable', 'date', 'after_or_equal:from']
            ]);
            $doctor_id = $request->doctor;
        }
        if (auth()->user()->hasRole('doctor')) {
            $this->validate($request, [
                'from' => ['nullable', 'date'],
                'to' => ['nullable', 'date', 'after_or_equal:from']
            ]);
            $doctor_id = auth()->user()->id;
        }

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
                ->get();
            $incomes_count = $incomes->count();
            $incomes_fees_sum = $incomes->sum('amount');
        }
        $html = view('reports.doctor-history',
            compact('doctor', 'prescriptions_count', 'prescriptions_fees_sum', 'patients_count', 'sessions_count', 'sessions_fees_sum', 'incomes_count', 'incomes_fees_sum'))->render();
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;

        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function care_company(Request $request)
    {

        $this->validate($request, [
            'company' => ['required', 'integer'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from']
        ]);

        $doctor_id = auth()->user()->id;
        $doctor = DB::table('doctors')
            ->where('clinic_id','=',$this->getClinic()->id)
            ->where('user_id','=',$doctor_id)
            ->first();
        $company = DB::table('care_companies')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('id', $request->company)
            ->where('doctor_id', $doctor_id)
            ->first();

        $date1 = date('Y-m-d 00:00:00', strtotime($request->from)) == '1970-01-01 00:00:00' ? '1970-01-01 00:00:00' : date('Y-m-d 00:00:00', strtotime($request->from));
        $date2 = date('Y-m-d 23:59:59', strtotime($request->to)) == '1970-01-01 23:59:59' ? Carbon::today()->toDateString() . ' 23:59:59' : date('Y-m-d 23:59:59', strtotime($request->to));

        $prescriptions = DB::table('prescriptions')
            ->join('users','users.id','=','prescriptions.patient_id')
            ->where('prescriptions.clinic_id', $this->getClinic()->id)
            ->where('prescriptions.care_company_id', $request->company)
            ->where('prescriptions.doctor_id', $doctor_id)
            ->whereBetween('prescriptions.created_at', [$date1, $date2])
            ->select('users.name as name','prescriptions.*')
            ->get();
        $prescriptions_examination_count = $prescriptions->where('type','=', 0)->count();
        $prescriptions_followup_count = $prescriptions->where('type','=', 1)->count();

        $sessions_count = null;
        $sessions =null;
        if ($request->sessions != null) {
            $sessions = DB::table('sessions_info')
                ->join('users','users.id','=','sessions_info.patient_id')
                ->join('session_types','session_types.id','=','sessions_info.session_type_id')
                ->where('sessions_info.doctor_id', '=', $doctor_id)
                ->where('sessions_info.care_company_id', $request->company)
                ->where('sessions_info.clinic_id', '=', $this->getClinic()->id)
                ->whereBetween('sessions_info.created_at', [$date1, $date2])
                ->select('sessions_info.*','session_types.name as session_type','users.name as patient_name')
                ->get();
            $sessions_count = $sessions->count();
        }
        $html = view('reports.care-company',
            compact('company','doctor', 'prescriptions_examination_count','prescriptions_followup_count', 'sessions_count','prescriptions','sessions'))->render();
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;

        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
}
