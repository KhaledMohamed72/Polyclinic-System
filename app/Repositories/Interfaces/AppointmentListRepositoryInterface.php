<?php

namespace App\Repositories\Interfaces;

interface AppointmentListRepositoryInterface
{
    public function getTodayAppointments();
    public function getPendingAppointments();
    public function getUpcomingAppointments();
    public function getCompleteAppointments();
    public function getCancelAppointments();
    public function changeToCompleteAction($id);
    public function changeToCancelAction($id);
}
