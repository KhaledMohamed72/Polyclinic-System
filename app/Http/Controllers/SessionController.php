<?php

namespace App\Http\Controllers;

use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    use GeneralTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('sessions_info')
                ->join('users as t1', 't1.id', '=', 'sessions_info.doctor_id')
                ->join('users as t2', 't2.id', '=', 'sessions_info.patient_id')
                ->join('session_types', 'session_types.id', '=', 'sessions_info.session_type_id')
                ->where('sessions_info.clinic_id', '=', $this->getClinic()->id)
                ->select('sessions_info.*', 't1.name as doctor_name', 't2.name as patient_name', 'session_types.name as session_name')
                ->get();
        }
        if (auth()->user()->hasRole('recep')) {
            $rows = DB::table('sessions_info')
                ->join('users as t1', 't1.id', '=', 'sessions_info.doctor_id')
                ->join('users as t2', 't2.id', '=', 'sessions_info.patient_id')
                ->join('doctors as t3', 't3.user_id', '=', 't1.id')
                ->where('t3.receptionist_id', '=', auth()->user()->id)
                ->join('session_types', 'session_types.id', '=', 'sessions_info.session_type_id')
                ->where('sessions_info.clinic_id', '=', $this->getClinic()->id)
                ->select('sessions_info.*', 't1.name as doctor_name', 't2.name as patient_name', 'session_types.name as session_name')
                ->get();
        }
        if (auth()->user()->hasRole('doctor')) {
            $rows = DB::table('sessions_info')
                ->join('users as t1', 't1.id', '=', 'sessions_info.doctor_id')
                ->join('users as t2', 't2.id', '=', 'sessions_info.patient_id')
                ->join('session_types', 'session_types.id', '=', 'sessions_info.session_type_id')
                ->where('sessions_info.doctor_id', '=', auth()->user()->id)
                ->where('sessions_info.clinic_id', '=', $this->getClinic()->id)
                ->select('sessions_info.*', 't1.name as doctor_name', 't2.name as patient_name', 'session_types.name as session_name')
                ->get();
        }
        return view('sessions.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->hasRole('doctor')) {
            $patient_rows = DB::table('users')
                ->join('patients', 'patients.user_id', '=', 'users.id')
                ->where('patients.doctor_id', '=', auth()->user()->id)
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->select('users.*', 'patients.user_id as patient_id')
                ->get();
            $session_rows = DB::table('session_types')
                ->where('doctor_id', '=', auth()->user()->id)
                ->where('clinic_id', '=', $this->getClinic()->id)
                ->get();
            $insurance_companies_rows = $this->getInsuranceCompaniessBasedOnRole($this->getClinic()->id, auth()->user()->id);
            return view('sessions.create', compact('patient_rows', 'session_rows', 'insurance_companies_rows'));
        } else {
            toastr()->success(trans('main_trans.something_went_wrong'));
            return redirect()->route('sessions.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'patient' => ['required', 'integer'],
            'type' => ['required', 'integer'],
            'date' => ['required', 'string'],
            'fees' => ['required', 'numeric'],
            'insurance_company_id' => ['nullable'],
            'note' => ['nullable', 'string'],
        ]);
        $fees = $request->fees;
        if ($request->has('insurance_company_id') && is_numeric($request->insurance_company_id) != '') {
            $discount_rate = DB::table('insurance_companies')
                ->where('id', $request->insurance_company_id)
                ->where('clinic_id', $this->getClinic()->id)
                ->select('discount_rate')
                ->first();
            $discount_rate = $discount_rate->discount_rate;
            $fees = $fees - (($fees / 100) * $discount_rate);
        }

        $row = DB::table('sessions_info')->insert([
            'clinic_id' => $this->getClinic()->id,
            'patient_id' => $request->patient,
            'doctor_id' => auth()->user()->id,
            'session_type_id' => $request->type,
            'date' => $request->date,
            'fees' => $fees,
            'insurance_company_id' => is_numeric($request->insurance_company_id) ? $request->insurance_company_id : null,
            'note' => $request->note,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        $updateAppointmentStatus = DB::table('appointments')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('patient_id', $request->patient)
            ->where('doctor_id', auth()->user()->id)
            ->where('date', $request->date)
            ->where('type','=', 2)
            ->update([
                'status' => 'complete'
            ]);
        if ($row || $updateAppointmentStatus) {
            toastr()->success(trans('main_trans.successfully_created'));
            return redirect()->route('sessions.index');
        } else {
            toastr()->error(trans('main_trans.something_went_wrong'));
            return redirect()->route('sessions.index');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Session $session
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (auth()->user()->hasRole('doctor')) {
            $patient_rows = DB::table('users')
                ->join('patients', 'patients.user_id', '=', 'users.id')
                ->where('patients.doctor_id', '=', auth()->user()->id)
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->select('users.name as name', 'patients.user_id as patient_id')
                ->get();

            $session_rows = DB::table('session_types')
                ->where('doctor_id', '=', auth()->user()->id)
                ->where('clinic_id', '=', $this->getClinic()->id)
                ->get();
            $insurance_companies_rows = $this->getInsuranceCompaniessBasedOnRole($this->getClinic()->id, auth()->user()->id);
            $row = DB::table('sessions_info')
                ->where('clinic_id', $this->getClinic()->id)
                ->where('id', $id)
                ->where('doctor_id', auth()->user()->id)
                ->first();

            return view('sessions.edit', compact('patient_rows', 'session_rows', 'row', 'insurance_companies_rows'));
        } else {
            toastr()->success(trans('main_trans.something_went_wrong'));
            return redirect()->route('sessions.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Session $session
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'patient' => ['required', 'integer'],
            'type' => ['required', 'integer'],
            'date' => ['required', 'string'],
            'fees' => ['required', 'numeric'],
            'insurance_company_id' => ['nullable'],
            'note' => ['nullable', 'string'],
        ]);
        $old_company_id = DB::table('sessions_info')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('id', $id)
            ->pluck('insurance_company_id')[0] ?? 0;

        $old_company_discount_rate = DB::table('insurance_companies')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('id', $old_company_id)
            ->pluck('discount_rate')[0] ?? 0;
        $request_discount_rate = DB::table('insurance_companies')
            ->where('id', $request->insurance_company_id)
            ->where('clinic_id', $this->getClinic()->id)
            ->pluck('discount_rate')[0] ?? 0;

        $fees = $request->fees;
        if ($old_company_id != $request->insurance_company_id || !is_numeric($request->insurance_company_id)) {
            $original_fees = $fees + (($old_company_discount_rate / (100-$old_company_discount_rate)) * $fees);
            $fees = $original_fees - (($original_fees / 100) * $request_discount_rate);
        }
        $row = DB::table('sessions_info')
            ->where('id', $id)
            ->where('clinic_id', $this->getClinic()->id)->update([
                'patient_id' => $request->patient,
                'session_type_id' => $request->type,
                'date' => $request->date,
                'fees' => $fees,
                'insurance_company_id' => is_numeric($request->insurance_company_id) ? $request->insurance_company_id : null,
                'note' => $request->note,
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
        if ($row) {
            toastr()->success('Successfully Update');
            return redirect()->route('sessions.index');
        } else {
            toastr()->error(trans('main_trans.something_went_wrong'));
            return redirect()->route('sessions.index');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Session $session
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->user()->hasRole('doctor')) {
            $row = DB::table('sessions_info')
                ->where('id', $id)
                ->where('clinic_id', $this->getClinic()->id)
                ->delete();
            if ($row) {
                toastr()->success('Deleted Successfully');
                return redirect()->route('sessions.index');
            }
        } else {
            toastr()->success(trans('main_trans.something_went_wrong'));
            return redirect()->route('sessions.index');
        }
    }
}
