<?php

namespace App\Repository\Interfaces;

use Illuminate\Http\Request;

interface AppointmentRepositoryInterface
{
    public function todayAppointments();
    public function appointmentsCountsPerDayCalender();
    public function appointmentsRowsPerDayDataTable(Request $request);
    public function doctorRowsForCreateView(Request $request);
    public function patientRowsForCreateView(Request $request);
    public function storeAppointment(Request $request);
    public function getSlotTimes(Request $request);
}
