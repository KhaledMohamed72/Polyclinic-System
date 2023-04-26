<?php

namespace App\Http\Controllers;

use App\Repository\AppointmentListRepository;
use Illuminate\Support\Facades\Redirect;

class AppointmentListController extends Controller
{
    private $appointmentListRepository;

    public function __construct(AppointmentListRepository $appointmentListRepository)
    {
        $this->appointmentListRepository = $appointmentListRepository;
    }

    public function todayAppointments()
    {
        $rows = $this->appointmentListRepository->getTodayAppointments();
        if ($rows) {
            return view('appointment-list.today-appointment', compact('rows'));
        } else {
            toastr()->error(trans('main_trans.something_went_wrong'));
            return redirect()->route('home');
        }
    }

    public function pendingAppointments()
    {
        $rows = $this->appointmentListRepository->getPendingAppointments();
        if ($rows) {
            return view('appointment-list.pending-appointment', compact('rows'));
        } else {
            toastr()->error(trans('main_trans.something_went_wrong'));
            return redirect()->route('home');
        }
    }

    public function upcomingAppointments()
    {
        $rows = $this->appointmentListRepository->getUpcomingAppointments();
        if ($rows) {
            return view('appointment-list.upcomming-appointment', compact('rows'));
        } else {
            toastr()->error(trans('main_trans.something_went_wrong'));
            return redirect()->route('home');
        }
    }

    public function completeAppointments()
    {
        $rows = $this->appointmentListRepository->getCompleteAppointments();
        if ($rows) {
            return view('appointment-list.complete-appointment', compact('rows'));
        } else {
            toastr()->error(trans('main_trans.something_went_wrong'));
            return redirect()->route('home');
        }
    }

    public function cancelAppointments()
    {
        $rows = $this->appointmentListRepository->getCancelAppointments();
        if ($rows) {
            return view('appointment-list.cancel-appointment', compact('rows'));
        } else {
            toastr()->error(trans('main_trans.something_went_wrong'));
            return redirect()->route('home');
        }
    }

    public function completeAction($id)
    {
        $row = $this->appointmentListRepository->changeToCompleteAction($id);
        if ($row) {
            return Redirect::back()->with('success', 'Successfully Completed');
        } else {
            return Redirect::back()->with('error', 'Something went wrong');
        }
    }

    public function cancelAction($id)
    {
        $row = $this->appointmentListRepository->changeToCancelAction($id);
        if ($row) {
            return Redirect::back()->with('success', 'Successfully Canceled');
        } else {
            return Redirect::back()->with('error', 'Something went wrong');
        }
    }

}
