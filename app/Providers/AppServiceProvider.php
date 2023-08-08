<?php

namespace App\Providers;

use App\Repositories\Absensi\AbsensiRepository;
use App\Repositories\Absensi\AbsensiRepositoryImplement;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(AbsensiRepository::class, AbsensiRepositoryImplement::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
