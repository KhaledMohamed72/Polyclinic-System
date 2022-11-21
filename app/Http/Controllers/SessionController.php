<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->hasRole('admin')) {
            $rows = DB::table('sessions_info')
                ->join('users as t1', 't1.id', '=', 'sessions_info.doctor_id')
                ->join('users as t2', 't2.id', '=', 'sessions_info.patient_id')
                ->join('session_types', 'session_types.id', '=', 'sessions_info.session_type_id')
                ->where('sessions_info.clinic_id','=', $this->getClinic()->id)
                ->select('sessions_info.*', 't1.name as doctor_name', 't2.name as patient_name', 'session_types.name as session_name')
                ->get();
        }
        if(auth()->user()->hasRole('recep')) {
            $rows = DB::table('sessions_info')
                ->join('users as t1', 't1.id', '=', 'sessions_info.doctor_id')
                ->join('users as t2', 't2.id', '=', 'sessions_info.patient_id')
                ->join('doctors as t3', 't3.user_id', '=', 't1.id')
                ->where('t3.receptionist_id' , '=', auth()->user()->id)
                ->join('session_types', 'session_types.id', '=', 'sessions_info.session_type_id')
                ->where('sessions_info.clinic_id','=', $this->getClinic()->id)
                ->select('sessions_info.*', 't1.name as doctor_name', 't2.name as patient_name', 'session_types.name as session_name')
                ->get();
        }
        if(auth()->user()->hasRole('doctor')) {
            $rows = DB::table('sessions_info')
                ->join('users as t1', 't1.id', '=', 'sessions_info.doctor_id')
                ->join('users as t2', 't2.id', '=', 'sessions_info.patient_id')
                ->join('session_types', 'session_types.id', '=', 'sessions_info.session_type_id')
                ->where('sessions_info.doctor_id', '=', auth()->user()->id)
                ->where('sessions_info.clinic_id', '=', $this->getClinic()->id)
                ->select('sessions_info.*', 't1.name as doctor_name', 't2.name as patient_name', 'session_types.name as session_name')
                ->get();
        }
            return  view('sessions.index',compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $patient_rows = DB::table('users')
            ->join('patients', 'patients.user_id','=', 'users.id')
            ->where('patients.doctor_id', '=',auth()->user()->id)
            ->where('users.clinic_id', '=', $this->getClinic()->id)
            ->get();
        $session_rows = DB::table('session_types')
            ->where('doctor_id','=',auth()->user()->id)
            ->where('clinic_id','=',$this->getClinic()->id)
            ->get();

        return view('sessions.create', compact('patient_rows','session_rows'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'patient' => ['required', 'integer'],
            'type' => ['required', 'integer'],
            'date' => ['required', 'string'],
            'fees' => ['required', 'numeric'],
            'note' => ['nullable', 'string'],
        ]);

        $row = DB::table('sessions_info')->insert([
            'clinic_id' => $this->getClinic()->id,
            'patient_id' => $request->patient,
            'doctor_id' => auth()->user()->id,
            'session_type_id' => $request->type,
            'date' => $request->date,
            'fees' => $request->fees,
            'note' => $request->note,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        if ($row) {
            toastr()->success('Successfully Created');
            return redirect()->route('sessions.index');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('sessions.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function show(Session $session)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function edit(Session $session)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Session $session)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function destroy(Session $session)
    {
        //
    }
}
