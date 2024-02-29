<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Interfaces\QueueInterface::class, \App\Repositories\QueueRepository::class);
        $this->app->bind(\App\Interfaces\MedicalRecordInterface::class, \App\Repositories\MedicalRecordRepository::class);
        $this->app->bind(\App\Interfaces\ExaminationInterface::class, \App\Repositories\ExaminationRepository::class);
        $this->app->bind(\App\Interfaces\OdontogramInterface::class, \App\Repositories\OdontogramRepository::class);
        $this->app->bind(\App\Interfaces\OdontogramResultInterface::class, \App\Repositories\OdontogramResultRepository::class);
        $this->app->bind(\App\Interfaces\TransactionInterface::class, \App\Repositories\TransactionRepository::class);
        $this->app->bind(\App\Interfaces\TreatmentInterface::class, \App\Repositories\TreatmentRepository::class);
        $this->app->bind(\App\Interfaces\ItemInterface::class, \App\Repositories\ItemRepository::class);
        $this->app->bind(\App\Interfaces\AddonInterface::class, \App\Repositories\AddonRepository::class);
        $this->app->bind(\App\Interfaces\CustomerInterface::class, \App\Repositories\CustomerRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
    }
}
