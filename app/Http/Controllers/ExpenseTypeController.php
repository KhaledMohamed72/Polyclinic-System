<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use App\Models\Formula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = DB::table('expense_types')
            ->where('doctor_id', '=', auth()->user()->id)
            ->orderBy('id','desc')
            ->get();
        if (auth()->user()->hasRole('admin')) {
            return view('expense-types.index',compact('rows'));
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
        if (auth()->user()->hasRole('admin')) {
            return view('expense-types.create');
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

        $row = DB::table('expense_types')->insert([
            'clinic_id' => $this->getClinic()->id,
            'doctor_id' => auth()->user()->id,
            'name' => $request->name,
            'note' => $request->note,
        ]);
        if ($row) {
            return redirect()->route('expense-types.index');
            toastr()->success('Created Successfully');

        } else {
            toastr()->warning('Something went wrong!');
            return redirect()->route('expense-types.index');
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
        $row = DB::table('expense_types')
            ->where('id' , $id)
            ->where('clinic_id','=',$this->getClinic()->id)
            ->first();

        if (auth()->user()->hasRole('admin')) {
            return view('expense-types.edit',compact('row'));
        } else {
            toastr()->warning('Something went wrong!');
            return redirect()->route('expense-types.index');
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

        $row = DB::table('expense_types')
            ->where('id' , $id)
            ->update([
                'name' => $request->name,
                'note' => $request->note,
            ]);
        if (auth()->user()->hasRole('admin')) {
            toastr()->success('Updated Successfully');
            return redirect()->route('expense-types.index');
        } else {
            toastr()->warning('Something went wrong!');
            return redirect()->route('expense-types.index');
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
        $row = ExpenseType::where('id', '=', $id)->first();

        if ($row) {
            $row = $row->delete();
            toastr()->success('Deleted Successfully');
            return redirect()->route('expense-types.index');

        } else {
            toastr()->warning('Something went wrong!');
            return redirect()->route('expense-types.index');
        }
    }
}
