<?php

namespace App\Http\Controllers;

use App\Models\PrescriptionDesign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrescriptionDesignController extends Controller
{
    public function index()
    {
        $prescriptions = PrescriptionDesign::all()->count();
        $clinicType = $this->getClinic()->type;
        // admin
        if (auth()->user()->hasRole('admin')) {
            $rows = DB::table('prescription_designs')
                ->join('users', 'users.id', '=', 'prescription_designs.doctor_id')
                ->where('prescription_designs.clinic_id', '=', $this->getClinic()->id)
                ->select('prescription_designs.*', 'users.name as user_name')
                ->get();
        }
        // receptionist
        if (auth()->user()->hasRole('recep')) {
            $rows = DB::table('prescription_designs')
                ->join('users', 'users.id', '=', 'prescription_designs.doctor_id')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->where('doctors.receptionist_id', '=', auth()->user()->id)
                ->where('prescription_designs.clinic_id', '=', $this->getClinic()->id)
                ->select('prescription_designs.*', 'users.name as user_name')
                ->get();
        }
        // doctor
        if (auth()->user()->hasRole('doctor')) {
            $rows = DB::table('prescription_designs')
                ->join('users', 'users.id', '=', 'prescription_designs.doctor_id')
                ->where('prescription_designs.doctor_id', '=', auth()->user()->id)
                ->where('prescription_designs.clinic_id', '=', $this->getClinic()->id)
                ->select('prescription_designs.*', 'users.name as user_name')
                ->get();
        }

        return view('prescription-designs.index', compact('rows', 'prescriptions', 'clinicType'));
    }

    public function create()
    {
        $clinicType = $this->getClinic()->type;
        $dotorsWithPrescriptions = DB::table('prescription_designs')
            ->where('clinic_id', $this->getClinic()->id)
            ->select('doctor_id')
            ->get()->pluck('doctor_id');

        $doctorsWithPrescriptions = $dotorsWithPrescriptions->all();
        // admin
        if (auth()->user()->hasRole('admin')) {
            $doctorsWithNoPrescription = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->where('users.clinic_id', $this->getClinic()->id)
                ->whereNotIn('users.id', $doctorsWithPrescriptions)
                ->select('users.name as doctor_name', 'users.id as doctor_id')
                ->get();
            if($doctorsWithNoPrescription->isEmpty()){
                toastr()->warning('All doctors already have a prescription design, You can just edit it!');
                return redirect()->route('prescription-designs.index');
            }
        }
        // receptionist
        if (auth()->user()->hasRole('recep')) {
            $doctorsWithNoPrescription = DB::table('users')
                ->join('doctors', 'doctors.user_id', '=', 'users.id')
                ->where('doctors.receptionist_id', auth()->user()->id)
                ->where('users.clinic_id', $this->getClinic()->id)
                ->whereNotIn('users.id', $doctorsWithPrescriptions)
                ->select('users.name as doctor_name', 'users.id as doctor_id')
                ->get();
            if ($doctorsWithNoPrescription->isEmpty()) {
                toastr()->warning('All your doctors already have a prescription design, You can just edit it!');
                return redirect()->route('prescription-designs.index');
            }
        }
        // doctor
        if (auth()->user()->hasRole('doctor')) {
            $doctorsWithNoPrescription = DB::table('users')
                ->where('id', auth()->user()->id)
                ->where('clinic_id', $this->getClinic()->id)
                ->first();
        }

        return view('prescription-designs.create', compact('clinicType', 'doctorsWithNoPrescription'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'doctor' => ['required', 'integer'],
        ]);

        if ($request->has('doctor')) {
            $doctor_id = $request->doctor;
        } else {
            $doctor_id = $request->has_one_doctor_id;
        }

        $row = DB::table('prescription_designs')->insert([
            'clinic_id' => $this->getClinic()->id,
            'doctor_id' => $doctor_id,
            'header' => $request->header,
            'footer' => $request->footer,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        if ($row) {
            toastr()->success('Successfully Created');
            return redirect()->route('prescription-designs.index');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('prescription-designs.index');
        }
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        // row
        $row = DB::table('prescription_designs')
            ->where('id', $id)
            ->where('clinic_id',$this->getClinic()->id)
            ->first();

        return view('prescription-designs.edit', compact('row'));

    }

    public function update(Request $request,$id)
    {

        $row = DB::table('prescription_designs')
            ->where('id', '=', $id)
            ->where('clinic_id', '=', $this->getClinic()->id)
            ->update([
                'header' => $request->header,
                'footer' => $request->footer,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
        if ($row) {
            toastr()->success('Successfully Updated');
            return redirect()->route('prescription-designs.index');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('prescription-designs.index');
        }
    }

}
