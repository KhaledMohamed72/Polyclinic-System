<?php

namespace App\Repository\Interfaces;

use Illuminate\Http\Request;

interface ReportRepositoryInterface
{
    public function main();
    public function get_patient_history($request);
    public function get_doctor_history($request);
    public function get_insurance_company($request);
    public function get_profit($request);
}
