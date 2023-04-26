<?php

namespace App\Http\Controllers;

use App\Models\Formula;
use App\Models\IncomeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = DB::table('income_types')
            ->where('doctor_id', '=', auth()->user()->id)
            ->orderBy('id','desc')
            ->get();
        if (auth()->user()->hasRole('admin')) {
            return view('income-types.index',compact('rows'));
        } else {
            toastr()->warning(trans('main_trans.something_went_wrong'));
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
        if (auth()->user()->hasRole('admin')) {
            return view('income-types.create');
        } else {
            toastr()->warning(trans('main_trans.something_went_wrong'));
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

        $row = DB::table('income_types')->insert([
            'clinic_id' => $this->getClinic()->id,
            'doctor_id' => auth()->user()->id,
            'name' => $request->name,
            'note' => $request->note,
        ]);
        if ($row) {
            return redirect()->route('income-types.index');
            toastr()->success('Created Successfully');

        } else {
            toastr()->warning(trans('main_trans.something_went_wrong'));
            return redirect()->route('income-types.index');
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
        $row = DB::table('income_types')
            ->where('id' , $id)
            ->where('clinic_id','=',$this->getClinic()->id)
            ->first();

        if (auth()->user()->hasRole('admin')) {
            return view('income-types.edit',compact('row'));
        } else {
            toastr()->warning(trans('main_trans.something_went_wrong'));
            return redirect()->route('income-types.index');
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

        $row = DB::table('income_types')
            ->where('id' , $id)
            ->update([
                'name' => $request->name,
                'note' => $request->note,
            ]);
        if (auth()->user()->hasRole('admin')) {
            toastr()->success('Updated Successfully');
            return redirect()->route('income-types.index');
        } else {
            toastr()->warning(trans('main_trans.something_went_wrong'));
            return redirect()->route('income-types.index');
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
        $row = IncomeType::where('id', '=', $id)->first();

        if ($row) {
            $row = $row->delete();
            toastr()->success('Deleted Successfully');
            return redirect()->route('income-types.index');

        } else {
            toastr()->warning(trans('main_trans.something_went_wrong'));
            return redirect()->route('income-types.index');
        }
    }
}
