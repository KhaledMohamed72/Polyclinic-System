<?php

namespace App\Repository\Interfaces;

use Illuminate\Http\Request;

interface PatientRepositoryInterface
{
    public function getPatientRows();
    public function getDoctorRows();
    public function storePatient($request);
    public function editPatient($id);
    public function updatePatient($id,$request);
    public function showPatient($id);
}
