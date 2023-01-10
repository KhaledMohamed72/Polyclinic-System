<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Repository\PrescriptionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class PrescriptionController extends Controller
{
    private $prescriptionRepository;

    public function __construct(PrescriptionRepository $prescriptionRepository)
    {
        $this->prescriptionRepository = $prescriptionRepository;
    }

    public function index()
    {
        $rows = $this->prescriptionRepository->getPrescriptions();
        return view('prescriptions.index', compact('rows'));
    }

    public function create()
    {
        list($patients, $frequencies, $periods, $medicines, $formulas, $tests, $care_companies) = $this->prescriptionRepository->createPrescriptions();
        return view('prescriptions.create', compact(
            'patients',
            'frequencies',
            'periods',
            'medicines',
            'formulas',
            'tests',
            'care_companies'
        ));
    }

    public function store(Request $request)
    {
        list($prescription, $updateAppointmentStatus, $prescription_id) = $this->prescriptionRepository->storePrescriptions($request);
        if ($prescription && $updateAppointmentStatus) {
            return redirect()->route('prescriptions.show', ['prescription' => $prescription_id]);
        }
    }

    public function show($id)
    {
        list($prescription, $medicines, $tests, $formulas, $doctor, $prescription_design, $patient, $appointment)
            = $this->prescriptionRepository->showPrescriptions($id);
        return view('prescriptions.show',
            compact(
                'prescription',
                'medicines',
                'tests',
                'formulas',
                'doctor',
                'prescription_design',
                'patient',
                'appointment'
            ));
    }

    public function edit($id)
    {
        list($prescription,
            $suggested_medicines,
            $suggested_tests,
            $medicines,
            $tests,
            $formulas,
            $all_formulas,
            $patient,
            $patients,
            $appointment,
            $frequencies,
            $periods,
            $care_companies) = $this->prescriptionRepository->editPrescriptions($id);
        return view('prescriptions.edit',
            compact(
                'prescription',
                'suggested_medicines',
                'suggested_tests',
                'medicines',
                'tests',
                'formulas',
                'all_formulas',
                'patient',
                'patients',
                'appointment',
                'frequencies',
                'periods',
                'care_companies'
            ));
    }

    public function update(Request $request, $id)
    {
        $update_prescription = $this->prescriptionRepository->updatePrescriptions($request, $id);
        if ($update_prescription) {
            return redirect()->route('prescriptions.show', ['prescription' => $id]);
        }
    }

    public function destroy($id)
    {
        $row = Prescription::where('id', '=', $id)->first();
        if (auth()->user()->hasRole('doctor')) {
            $row = $row->delete();
        }
        if ($row) {
            toastr()->success('Successfully Deleted');
            return redirect()->route('prescriptions.index');
        } else {
            toastr()->error('Something went wrong!');
            return redirect()->route('prescriptions.index');
        }
    }

    public function get_appointments_of_patient(Request $request)
    {
        $appointments = DB::table('appointments')
            ->where('patient_id', '=', $request->patient_id)
            ->where('doctor_id', '=', auth()->user()->id)
            ->where('status', '=', 'pending')
            ->whereDate('date', '=', Carbon::today()->toDateString())
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($appointments);
    }

    public function pdf_prescription($id)
    {
        list($mpdf, $prescription, $medicines, $tests, $formulas, $doctor, $prescription_design, $appointment, $patient)
            = $this->prescriptionRepository->printPDF($id);
        $html = view('prescriptions.pdf-show', compact(
            'prescription', 'medicines', 'tests',
            'formulas', 'doctor', 'prescription_design', 'appointment', 'patient'
        ))->render();

        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;

        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
}
