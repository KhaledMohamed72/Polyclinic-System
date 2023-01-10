<?php

namespace App\Repository\Interfaces;

interface PrescriptionRepositoryInterface
{
    public function getPrescriptions();
    public function createPrescriptions();
    public function storePrescriptions($request);
    public function editPrescriptions($id);
    public function updatePrescriptions($request,$id);
    public function showPrescriptions($id);
    public function printPDF($id);
}
