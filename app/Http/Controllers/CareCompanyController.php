<?php

namespace App\Http\Controllers;

use App\Models\CareCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CareCompanyController extends Controller
{
    public function index()
    {
        $rows = DB::table('care_companies')
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->where('doctor_id', '=', auth()->user()->id)
            ->get();

        if (auth()->user()->hasRole('doctor')) {
            return view('care-companies.index', compact('rows'));
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('home');
        }
    }

    public function create()
    {
        if (auth()->user()->hasRole('doctor')) {
            return view('care-companies.create');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('home');
        }
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasRole('doctor')) {
            toastr()->error('Something went wrong!');
            return redirect()->route('home');
        }
        $this->validate($request, [
            'name' => ['required', 'string', 'max:191'],
            'from' => ['required', 'date'],
            'to' => ['required', 'date', 'after_or_equal:from'],
            'discount_rate' => ['required', 'integer', 'min:1', 'max:100'],
            'note' => ['nullable']
        ]);

        $row = DB::table('care_companies')
            ->insert([
                'clinic_id' => $this->getClinic()->id,
                'doctor_id' => auth()->user()->id,
                'name' => $request->name,
                'from' => $request->from,
                'to' => $request->to,
                'discount_rate' => $request->discount_rate,
                'note' => $request->note,
            ]);
        if ($row) {
            toastr()->success('Successfully Created');
            return redirect()->route('care-companies.index');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('care-companies.index');
        }
    }


    public function edit($id)
    {
        $row = DB::table('care_companies')
            ->where('id', $id)
            ->where('doctor_id', auth()->user()->id)
            ->where('clinic_id', $this->getClinic()->id)
            ->first();
        if (auth()->user()->hasRole('doctor')) {
            return view('care-companies.edit', compact('row'));
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('home');
        }
    }

    public function update(Request $request, $id)
    {
        if (!auth()->user()->hasRole('doctor')) {
            toastr()->error('Something went wrong!');
            return redirect()->route('home');
        }
        $this->validate($request, [
            'name' => ['required', 'string', 'max:191'],
            'from' => ['required', 'date'],
            'to' => ['required', 'date', 'after_or_equal:from'],
            'discount_rate' => ['required', 'integer', 'min:1', 'max:100'],
            'note' => ['nullable']
        ]);

        $row = DB::table('care_companies')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('doctor_id', auth()->user()->id)
            ->update([
                'name' => $request->name,
                'from' => $request->from,
                'to' => $request->to,
                'discount_rate' => $request->discount_rate,
                'note' => $request->note,
            ]);

        if ($row) {
            toastr()->success('Successfully Updated');
            return redirect()->route('care-companies.index');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('care-companies.index');
        }
    }

    public function destroy($id)
    {
        $row = Db::table('care_companies')
            ->where('id', $id)
            ->where('clinic_id', $this->getClinic()->id)
            ->where('doctor_id',auth::user()->id)
            ->delete();

        if ($row) {
            toastr()->success('Successfully Deleted');
            return redirect()->route('care-companies.index');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('care-companies.index');
        }
    }
}
