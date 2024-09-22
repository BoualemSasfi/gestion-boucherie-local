<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendeur;

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
    // public function boot(): void
    // {
    //     //
    // }

    

    public function boot()
    {
        View::composer('caisse.paccino', function ($view) {
            // $id_magasin = auth()->user()->id_magasin;
            $IdUser = Auth::id();
            $Vendeur = Vendeur::where('id_user', $IdUser)->first();
            $IdMagasin = $Vendeur->id_magasin;
            $LastFacture = app('App\Http\Controllers\CaisseController')->Get_Last_Facture($IdMagasin,$IdUser);
            $view->with('LastFacture', $LastFacture);
        });
    }
}
