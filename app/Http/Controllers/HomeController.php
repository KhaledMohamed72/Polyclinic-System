<?php

namespace App\Http\Controllers;

use App\Repository\HomeRepository;

class HomeController extends Controller
{
    private $homeRepository;

    public function __construct(HomeRepository $homeRepository)
    {
        $this->homeRepository = $homeRepository;
    }

    function index()
    {
        $data = $this->homeRepository->showHome();
        list($appointments_count, $today_appointments_count, $tomorrow_appointments_count, $upcomming_appointments_count, $today_earrings, $revenue, $appointments, $prescriptions, $current_monthly_earrings, $last_monthly_earrings, $earring_percentage, $monthly_patients_counts, $monthly_prescriptions_counts) = $data;
        if (auth()->user()->hasRole('admin')) {
            return view('home', compact(
                'appointments_count',
                'today_appointments_count',
                'tomorrow_appointments_count',
                'upcomming_appointments_count',
                'today_earrings',
                'revenue',
                'appointments',
                'prescriptions',
                'current_monthly_earrings',
                'last_monthly_earrings',
                'earring_percentage',
                'monthly_patients_counts',
                'monthly_prescriptions_counts'
            ));
        } elseif (auth()->user()->hasRole('doctor')) {
            return redirect()->route('doctors.show', auth()->user()->id);
        } elseif (auth()->user()->hasRole('recep')) {
            return redirect()->route('receptionists.show', auth()->user()->id);
        } else {
            toastr()->warning('Something went wrong!');
            return redirect()->route('home.index');
        }
    }


}
