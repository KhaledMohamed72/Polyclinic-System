<?php

namespace App\Providers;

use App\Repositories\AppointmentListRepository;
use App\Repositories\AppointmentRepository;
use App\Repositories\Interfaces\AppointmentListRepositoryInterface;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
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
