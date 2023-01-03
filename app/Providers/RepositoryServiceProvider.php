<?php

namespace App\Providers;

use App\Repository\AppointmentListRepository;
use App\Repository\AppointmentRepository;
use App\Repository\DoctorRepository;
use App\Repository\HomeRepository;
use App\Repository\Interfaces\AppointmentListRepositoryInterface;
use App\Repository\Interfaces\AppointmentRepositoryInterface;
use App\Repository\Interfaces\DoctorRepositoryInterface;
use App\Repository\Interfaces\HomeRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AppointmentListRepositoryInterface::class, AppointmentListRepository::class);
        $this->app->bind(AppointmentRepositoryInterface::class, AppointmentRepository::class);
        $this->app->bind(DoctorRepositoryInterface::class, DoctorRepository::class);
        $this->app->bind(HomeRepositoryInterface::class, HomeRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
