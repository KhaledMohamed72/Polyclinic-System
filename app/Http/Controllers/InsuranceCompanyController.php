<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InsuranceCompanyController extends Controller
{
    use GeneralTrait;

    public function index()
    {
        if (auth()->user()->hasRole('doctor')) {
            $rows = DB::table('insurance_companies')
                ->where('clinic_id', '=', $this->getClinic()->id)
                ->where('doctor_id', '=', auth()->user()->id)
                ->select('insurance_companies.id as id', 'insurance_companies.name as company_name', 'insurance_companies.discount_rate', 'insurance_companies.from', 'insurance_companies.to')
                ->get();
        }
        if (auth()->user()->hasRole(['admin', 'recep'])) {
            $rows = DB::table('insurance_companies')
                ->join('users', 'users.id', '=', 'insurance_companies.doctor_id')
                ->where('insurance_companies.clinic_id', '=', $this->getClinic()->id)
                ->select('insurance_companies.id as id', 'insurance_companies.name as company_name', 'users.name as doctor_name', 'insurance_companies.discount_rate', 'insurance_companies.from', 'insurance_companies.to')
                ->get();
        }
        if (auth()->user()->hasRole(['doctor', 'recep', 'admin'])) {
            return view('insurance-companies.index', compact('rows'));
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('home');
        }
    }

    public function create()
    {
        $rows = $this->getDoctorsBasedOnRole($this->getClinic()->id,\auth()->user()->id);
        $count_rows = count($rows);
        if ($count_rows == 0) {
            toastr()->warning('You must create doctors first !');
            return redirect()->route('doctors.create');
        }
        if (auth()->user()->hasRole(['doctor', 'recep', 'admin'])) {
            return view('insurance-companies.create', compact('rows','count_rows'));
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('home');
        }
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasRole(['doctor', 'recep', 'admin'])) {
            toastr()->error('Something went wrong!');
            return redirect()->route('home');
        }
        $this->validate($request, [
            'doctor_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:191'],
            'from' => ['required', 'date'],
            'to' => ['required', 'date', 'after_or_equal:from'],
            'discount_rate' => ['required', 'numeric', 'min:1', 'max:100'],
            'note' => ['nullable']
        ]);

        // get recep id
        $receptionist_id = Doctor::where('user_id', $request->doctor_id)->pluck('receptionist_id')->first();

        $row = DB::table('insurance_companies')->insert([
                'clinic_id' => $this->getClinic()->id,
                'doctor_id' => $request->doctor_id,
                'receptionist_id' => $receptionist_id,
                'name' => $request->name,
                'from' => $request->from,
                'to' => $request->to,
                'discount_rate' => $request->discount_rate,
                'note' => $request->note,
            ]);
        if ($row) {
            toastr()->success('Successfully Created');
            return redirect()->route('insurance-companies.index');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('insurance-companies.index');
        }
    }


    public function edit($id)
    {
        $rows = $this->getDoctorsBasedOnRole($this->getClinic()->id,\auth()->user()->id);
        $count_rows = count($rows);
        if ($count_rows == 0) {
            toastr()->warning('You must create doctors first !');
            return redirect()->route('doctors.create');
        }
        $row = DB::table('insurance_companies')
            ->where('id', $id)
            ->where('clinic_id', $this->getClinic()->id)
            ->first();
        if (auth()->user()->hasRole(['doctor', 'recep', 'admin'])) {
            return view('insurance-companies.edit', compact('row','rows','count_rows'));
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('home');
        }
    }

    public function update(Request $request, $id)
    {
        if (!auth()->user()->hasRole(['doctor', 'recep', 'admin'])) {
            toastr()->error('Something went wrong!');
            return redirect()->route('home');
        }
        $this->validate($request, [
            'doctor_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:191'],
            'from' => ['required', 'date'],
            'to' => ['required', 'date', 'after_or_equal:from'],
            'discount_rate' => ['required', 'numeric', 'min:1', 'max:100'],
            'note' => ['nullable']
        ]);
        // get recep id
        $receptionist_id = Doctor::where('user_id', $request->doctor_id)->pluck('receptionist_id')->first();
        $row = DB::table('insurance_companies')
            ->where('clinic_id', $this->getClinic()->id)
            ->where('id', $id)
            ->update([
                'doctor_id' => $request->doctor_id,
                'receptionist_id' => $receptionist_id,
                'name' => $request->name,
                'from' => $request->from,
                'to' => $request->to,
                'discount_rate' => $request->discount_rate,
                'note' => $request->note,
            ]);

        if ($row) {
            toastr()->success('Successfully Updated');
            return redirect()->route('insurance-companies.index');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('insurance-companies.index');
        }
    }

    public function destroy($id)
    {
        $row = DB::table('insurance_companies')
            ->where('id', $id)
            ->where('clinic_id', $this->getClinic()->id)
            ->delete();

        if ($row) {
            toastr()->success('Successfully Deleted');
            return redirect()->route('insurance-companies.index');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('insurance-companies.index');
        }
    }
}
