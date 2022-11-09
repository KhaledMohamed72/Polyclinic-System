<?php

namespace App\Http\Controllers;


use App\Models\SessionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = DB::table('session_types')
            ->where('doctor_id', '=', auth()->user()->id)
            ->orderBy('id','desc')
            ->get();
        if (auth()->user()->hasRole('doctor')) {
            return view('session-types.index',compact('rows'));
        } else {
            toastr()->warning('Something went wrong!');
            return redirect()->route('home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->hasRole('doctor')) {
            return view('session-types.create');
        } else {
            toastr()->warning('Something went wrong!');
            return redirect()->route('home');
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
            'name' => ['required', 'string', 'max:191'],
            'note' => ['nullable','string'],
        ]);

        $row = DB::table('session_types')->insert([
            'clinic_id' => $this->getClinic()->id,
            'doctor_id' => auth()->user()->id,
            'name' => $request->name,
            'note' => $request->note,
        ]);
        if ($row) {
            return redirect()->route('session-types.index');
            toastr()->success('Created Successfully');

        } else {
            toastr()->warning('Something went wrong!');
            return redirect()->route('session-types.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Formula $formula
     * @return \Illuminate\Http\Response
     */
    public function show(Formula $formula)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Formula $formula
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = DB::table('session_types')
            ->where('id' , $id)
            ->where('clinic_id','=',$this->getClinic()->id)
            ->first();

        if (auth()->user()->hasRole('doctor')) {
            return view('session-types.edit',compact('row'));
        } else {
            toastr()->warning('Something went wrong!');
            return redirect()->route('session-types.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Formula $formula
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:191'],
            'note' => ['nullable','string'],
        ]);

        $row = DB::table('session_types')
            ->where('id' , $id)
            ->update([
                'name' => $request->name,
                'note' => $request->note,
            ]);
        if (auth()->user()->hasRole('doctor')) {
            toastr()->success('Updated Successfully');
            return redirect()->route('session-types.index');
        } else {
            toastr()->warning('Something went wrong!');
            return redirect()->route('session-types.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Formula $formula
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = SessionType::where('id', '=', $id)->first();

        if ($row) {
            $row = $row->delete();
            toastr()->success('Deleted Successfully');
            return redirect()->route('session-types.index');

        } else {
            toastr()->warning('Something went wrong!');
            return redirect()->route('session-types.index');
        }
    }
}
