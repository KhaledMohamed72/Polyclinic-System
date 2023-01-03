<?php

namespace App\Repository\Interfaces;

use Illuminate\Http\Request;

interface DoctorRepositoryInterface
{
    public function getDoctorRows();
    public function getReceptionistRows();
    public function storeDoctor($request);
    public function getDoctorRow($id);
    public function updateDoctor($request,$id);
    public function showDoctor($id);
    public function updateSchedule($request,$id);
}
