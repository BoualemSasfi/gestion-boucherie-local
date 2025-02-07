<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendeur;

use Illuminate\Support\Facades\Request;

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
        // View::composer('caisse.paccino', function ($view) {
        //     $IdUser = Auth::id();
        //     $Vendeur = Vendeur::where('id_user', $IdUser)->first();
        //     $IdMagasin = $Vendeur->id_magasin;
        //     $LastFacture = app('App\Http\Controllers\CaisseController')->Get_Last_Facture($IdMagasin,$IdUser);
        //     $view->with('LastFacture', $LastFacture);
        // });

        View::composer('caisse.paccino', function ($view) {
            // Récupérer id_magasin depuis l'URL
            $id_magasin = Request::route('id_magasin');
            $id_caisse = Request::route('id_caisse');

            $IdUser = 0;
            $IdMagasin = $id_magasin;
            $IdCaisse = $id_caisse;
            $LastFacture = app('App\Http\Controllers\AfficheController')->Get_Last_Facture($IdMagasin, $IdUser, $IdCaisse);

            $view->with('LastFacture', $LastFacture);
        });

        View::composer('caisse.copie.paccino', function ($view) {
            // Récupérer id_magasin depuis l'URL
            $id_magasin = Request::route('id_magasin');
            $id_caisse = Request::route('id_caisse');

            $IdUser = 0;
            $IdMagasin = $id_magasin;
            $IdCaisse = $id_caisse;
            $LastFacture = app('App\Http\Controllers\AfficheController')->Get_Last_Facture($IdMagasin, $IdUser, $IdCaisse);

            $view->with('LastFacture', $LastFacture);
        });
    }
}
