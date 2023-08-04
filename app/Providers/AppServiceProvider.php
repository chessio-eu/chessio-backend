<?php

namespace App\Providers;

use App\Models\Piece;
use App\Observers\PieceObserver;
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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Piece::observe(PieceObserver::class);
    }
}
