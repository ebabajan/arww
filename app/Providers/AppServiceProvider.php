<?php

namespace App\Providers;

use Livewire\Livewire;
use App\Livewire\TotalExpenses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
       //Livewire::component('total-expenses', TotalExpenses::class);
    }
}
