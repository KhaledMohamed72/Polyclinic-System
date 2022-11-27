<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\IncomeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = DB::table('incomes')
            ->join('income_types', 'income_types.id', '=', 'incomes.income_type_id')
            ->where('incomes.clinic_id', '=', $this->getClinic()->id)
            ->orderBy('incomes.id', 'desc')
            ->select('incomes.*', 'incomes.id as income_id', 'income_types.name as type')
            ->paginate('10');

        if (auth()->user()->hasRole('admin')) {
            return view('incomes.index', compact('rows'));
        } else {
            toastr()->error('Something went wrong!');
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
        // list of doctors
        if (auth()->user()->hasRole('admin')) {
            $doctor_rows = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->select('users.id', 'users.name')
                ->get();
            $type_rows = IncomeType::all();
            $count_doctors = count($doctor_rows);
            return view('incomes.create',
                compact('doctor_rows', 'count_doctors', 'type_rows'));
        } else {
            toastr()->error('Something went wrong!');
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
            'type' => ['required', 'integer'],
            'date' => ['required'],
            'amount' => ['required', 'integer', 'min:0.25'],
            'note' => ['nullable', 'string'],
        ]);

        if ($request->has('doctor_id') && $request->doctor_id != '') {
            $doctor_id = $request->doctor_id;
        }
        if ($request->has('has_one_doctor_id') && $request->has_one_doctor_id != '') {
            $doctor_id = $request->has_one_doctor_id;
        }


        $row = DB::table('incomes')->insert([
            'clinic_id' => $this->getClinic()->id,
            'income_type_id' => $request->type,
            'doctor_id' => $doctor_id ?? null,
            'date' => $request->date,
            'amount' => $request->amount,
            'note' => $request->note,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        if ($row) {
            toastr()->success('Successfully Created');
            return redirect()->route('incomes.index');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('incomes.index');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Income $income
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (auth()->user()->hasRole('admin')) {
            $row = Income::where('id', $id)->first();
            $doctor_rows = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->where('users.clinic_id', '=', $this->getClinic()->id)
                ->select('users.id', 'users.name')
                ->get();
            $type_rows = IncomeType::all();
            $count_doctors = count($doctor_rows);
            return view('incomes.edit',
                compact('row', 'type_rows', 'doctor_rows','count_doctors')
            );
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('home');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Income $income
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'type' => ['required', 'integer'],
            'date' => ['required'],
            'amount' => ['required', 'integer', 'min:0.25'],
            'note' => ['nullable', 'string'],
        ]);

        if ($request->has('doctor_id') && $request->doctor_id != '') {
            $doctor_id = $request->doctor_id;
        }
        if ($request->has('has_one_doctor_id') && $request->has_one_doctor_id != '') {
            $doctor_id = $request->has_one_doctor_id;
        }
        if (auth()->user()->hasRole('admin')) {
        $row = DB::table('incomes')
            ->where('id' , $id)
            ->update([
                'clinic_id' => $this->getClinic()->id,
                'income_type_id' => $request->type,
                'doctor_id' => $doctor_id ?? null,
                'date' => $request->date,
                'amount' => $request->amount,
                'note' => $request->note,
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
            toastr()->success('Updated Successfully');
            return redirect()->route('incomes.index');
        } else {
            toastr()->warning('Something went wrong!');
            return redirect()->route('incomes.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Income $income
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Income::destroy($id);
        if ($row){
            toastr()->success('Deleted Successfully');
            return redirect()->route('incomes.index');
        }
    }
}
