<?php

namespace App\Http\Controllers;


use App\Models\Transfert;
use App\Models\Stock;
use App\Models\Lestock;
use App\Models\Magasin;
use App\Models\Caisse;
use App\Models\Facture;
use App\Models\Vente;
use App\Models\Credit;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Psy\Readline\Hoa\Console;
use Carbon\Carbon;



class CalculsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ListeMag1()
    {
        $Liste_Magasins = Magasin::all();
        $Liste_Caisses = Caisse::all();
        $Nombre_Caisses_parmagasin = Caisse::groupBy('id_magasin')
            ->selectRaw('id_magasin, count(*) as count')
            ->get();


        return view('admin.calculs.stock.index', ['magasins' => $Liste_Magasins, 'caisses' => $Liste_Caisses, 'nombre_caisses' => $Nombre_Caisses_parmagasin]);
    }

    public function VoirStock($id_magasin)
    {
        // Récupérer les stocks
        $stocks = Stock::where('magasin_id', $id_magasin)
            ->join('lestocks', 'lestocks.stock_id', '=', 'stocks.id')
            ->join('produits', 'produits.id', '=', 'lestocks.produit_id')
            ->join('categories', 'categories.id', '=', 'produits.categorie_id')
            ->select(
                'lestocks.id',
                'produits.nom_pr',
                'categories.nom as categorie',
                'lestocks.quantity',
            )
            ->groupBy('produits.nom_pr', 'categories.nom', 'lestocks.id', 'lestocks.quantity')
            ->orderBy('produits.nom_pr', 'ASC')
            ->get();

        // Récupérer le magasin
        $magasin = Magasin::find($id_magasin);
        $nom_magasin = $magasin->nom;

        // Récupérer les transferts
        $transferts = Transfert::where('mag', '=', $nom_magasin)
            ->join('prod_trans', 'prod_trans.id_trans', '=', 'transfert.id')
            ->select(
                'prod_trans.id',
                'prod_trans.produit',
                'prod_trans.quantity',
            )
            ->where('transfert.type', '=', 'transfert') // Exclure les retours
            ->groupBy('prod_trans.produit', 'prod_trans.id', 'prod_trans.quantity')
            ->orderBy('prod_trans.produit', 'ASC')
            ->get();

        // Récupérer les retours
        $retours = Transfert::where('atl', '=', $nom_magasin)
            ->join('prod_trans', 'prod_trans.id_trans', '=', 'transfert.id')
            ->select(
                'prod_trans.id',
                'prod_trans.produit',
                'prod_trans.quantity',
            )
            ->where('transfert.type', '=', 'retour') // Inclure uniquement les retours
            ->groupBy('prod_trans.produit', 'prod_trans.id', 'prod_trans.quantity')
            ->orderBy('prod_trans.produit', 'ASC')
            ->get();

        // Récupérer les ventes
        $ventes = Facture::where('id_magasin', $id_magasin)
            ->join('ventes', 'ventes.id_facture', '=', 'factures.id')
            ->select(
                'ventes.id',
                'ventes.designation_produit',
                'ventes.quantite',
            )
            ->groupBy('ventes.designation_produit', 'ventes.id', 'ventes.quantite')
            ->orderBy('ventes.designation_produit', 'ASC')
            ->get();

        // Initialisation des tableaux
        $resultats_magasin = [];

        // Lier les stocks, les ventes, les transferts et les retours pour chaque produit
        foreach ($stocks as $stock) {
            // Trouver les ventes correspondantes pour ce produit
            $ventes_produit = $ventes->filter(function ($vente) use ($stock) {
                return $vente->designation_produit == $stock->nom_pr;
            });

            // Calculer la quantité totale des ventes pour ce produit
            $quantite_vendue = $ventes_produit->sum('quantite');

            // Trouver les transferts correspondants pour ce produit
            $transferts_produit = $transferts->filter(function ($transfert) use ($stock) {
                return $transfert->produit == $stock->nom_pr;
            });


            // Trouver les retours correspondants pour ce produit
            $retours_produit = $retours->filter(function ($retour) use ($stock) {
                return $retour->produit == $stock->nom_pr;
            });

            $quantite_retour = $retours_produit->sum('quantity'); // Utilise la somme agrégée
            $quantite_transferee = $transferts_produit->sum('quantity'); // Quantités transférées


            // Calculer la différence (quantité transférée - (stock + ventes))
            $quantite_difference = $quantite_transferee - ($stock->quantity + $quantite_vendue + $quantite_retour);

            // Ajouter les résultats pour ce produit
            $resultats_magasin[] = [
                'categorie' => $stock->categorie,
                'produit' => $stock->nom_pr,
                'stock' => $stock->quantity,
                'quantite_vendue' => $quantite_vendue,
                'quantite_transferee' => $quantite_transferee,
                'quantite_retour' => $quantite_retour,
                'quantite_difference' => $quantite_difference,
            ];
        }



        // Retourner la vue avec les données
        return view('admin.calculs.stock.voir', [
            'magasin' => $magasin,
            'stocks' => $stocks,
            'transferts' => $transferts,
            'retours' => $retours,
            'ventes' => $ventes,
            'resultats_magasin' => $resultats_magasin,
        ]);
    }


    // -----------------------------------------------------------------------------------------------------------------------------------------


    public function VoirStockFiltre($magasin_id, $date1, $date2, $filterCase)
    {
        try {

            if ($date1) {
                $date1 = Carbon::parse($date1)->format('Y-m-d H:i:s');
            }
            if ($date2) {
                $date2 = Carbon::parse($date2)->format('Y-m-d H:i:s');
            }


            $magasin = Magasin::find($magasin_id);

            $nom_magasin = $magasin->nom;

            // Requête pour récupérer les stocks
            $stocks = Stock::where('magasin_id', $magasin_id)
                ->join('lestocks', 'lestocks.stock_id', '=', 'stocks.id')
                ->join('produits', 'produits.id', '=', 'lestocks.produit_id')
                ->join('categories', 'categories.id', '=', 'produits.categorie_id')
                ->select(
                    'lestocks.id',
                    'produits.nom_pr as produit_nom',
                    'categories.nom as categorie_nom',
                    'lestocks.quantity as stock_quantity'
                )
                ->groupBy('lestocks.id', 'produits.nom_pr', 'categories.nom', 'lestocks.quantity')
                ->orderBy('produits.nom_pr', 'ASC')
                ->get();

            // $ventes = $transferts = $retours = collect();

            // Filtrage par période entre deux dates
            if ($filterCase === 'periode' && $date1 && $date2) {
                $transferts = Transfert::where('mag', '=', $nom_magasin)
                    ->whereBetween('transfert.created_at', [$date1, $date2])
                    ->where('transfert.type', '=', 'transfert')
                    ->join('prod_trans', 'prod_trans.id_trans', '=', 'transfert.id')
                    ->select('prod_trans.produit', 'prod_trans.quantity')
                    ->groupBy('prod_trans.produit', 'prod_trans.quantity')
                    ->get();

                $retours = Transfert::where('atl', '=', $nom_magasin)
                    ->whereBetween('transfert.created_at', [$date1, $date2])
                    ->where('transfert.type', '=', 'retour')
                    ->join('prod_trans', 'prod_trans.id_trans', '=', 'transfert.id')
                    ->select('prod_trans.produit', 'prod_trans.quantity')
                    ->groupBy('prod_trans.produit', 'prod_trans.quantity')
                    ->get();

                $ventes = Facture::where('id_magasin', $magasin_id)
                    ->join('ventes', 'ventes.id_facture', '=', 'factures.id')
                    ->whereBetween('ventes.created_at', [$date1, $date2])
                    ->select('ventes.designation_produit', 'ventes.quantite')
                    ->groupBy('ventes.designation_produit', 'ventes.quantite')
                    ->get();
            }

            // Filtrage depuis une date de début jusqu'à maintenant
            if ($filterCase === 'debut' && $date1) {
                $transferts = Transfert::where('mag', '=', $nom_magasin)
                    ->where('transfert.created_at', '>=', $date1)
                    ->where('transfert.type', '=', 'transfert')
                    ->join('prod_trans', 'prod_trans.id_trans', '=', 'transfert.id')
                    ->select('prod_trans.produit', 'prod_trans.quantity')
                    ->groupBy('prod_trans.produit', 'prod_trans.quantity')
                    ->get();

                $retours = Transfert::where('atl', '=', $nom_magasin)
                    ->where('transfert.created_at', '>=', $date1)
                    ->where('transfert.type', '=', 'retour')
                    ->join('prod_trans', 'prod_trans.id_trans', '=', 'transfert.id')
                    ->select('prod_trans.produit', 'prod_trans.quantity')
                    ->groupBy('prod_trans.produit', 'prod_trans.quantity')
                    ->get();

                $ventes = Facture::where('id_magasin', $magasin_id)
                    ->join('ventes', 'ventes.id_facture', '=', 'factures.id')
                    ->where('ventes.created_at', '>=', $date1)
                    ->select('ventes.designation_produit', 'ventes.quantite')
                    ->groupBy('ventes.designation_produit', 'ventes.quantite')
                    ->get();
            }

            // Filtrage jusqu'à une date de fin
            if ($filterCase === 'fin' && $date2) {
                $transferts = Transfert::where('mag', '=', $nom_magasin)
                    ->where('transfert.created_at', '<=', $date2)
                    ->where('transfert.type', '=', 'transfert')
                    ->join('prod_trans', 'prod_trans.id_trans', '=', 'transfert.id')
                    ->select('prod_trans.produit', 'prod_trans.quantity')
                    ->groupBy('prod_trans.produit', 'prod_trans.quantity')
                    ->get();

                $retours = Transfert::where('atl', '=', $nom_magasin)
                    ->where('transfert.created_at', '<=', $date2)
                    ->where('transfert.type', '=', 'retour')
                    ->join('prod_trans', 'prod_trans.id_trans', '=', 'transfert.id')
                    ->select('prod_trans.produit', 'prod_trans.quantity')
                    ->groupBy('prod_trans.produit', 'prod_trans.quantity')
                    ->get();

                $ventes = Facture::where('id_magasin', $magasin_id)
                    ->join('ventes', 'ventes.id_facture', '=', 'factures.id')
                    ->where('ventes.created_at', '<=', $date2)
                    ->select('ventes.designation_produit', 'ventes.quantite')
                    ->groupBy('ventes.designation_produit', 'ventes.quantite')
                    ->get();
            }


            // Préparation des résultats
            $resultats_magasin = [];
            foreach ($stocks as $stock) {
                // Récupérer les quantités ou 0 si elles sont vides
                $quantite_vendue = $ventes->where('designation_produit', $stock->produit_nom)->sum('quantite') ?? 0;
                $quantite_transferee = $transferts->where('produit', $stock->produit_nom)->sum('quantity') ?? 0;
                $quantite_retour = $retours->where('produit', $stock->produit_nom)->sum('quantity') ?? 0;

                // Calculer la différence en gérant les valeurs vides
                $stock_quantity = $stock->stock_quantity ?? 0;
                $quantite_difference = $quantite_transferee - ($stock_quantity + $quantite_vendue + $quantite_retour);

                // Ajouter au tableau des résultats
                $resultats_magasin[] = [
                    'categorie' => $stock->categorie_nom ?? '',
                    'produit' => $stock->produit_nom ?? '',
                    'stock' => $stock_quantity,
                    'quantite_vendue' => $quantite_vendue,
                    'quantite_transferee' => $quantite_transferee,
                    'quantite_retour' => $quantite_retour,
                    'quantite_difference' => $quantite_difference,
                ];
            }


            return response()->json(['resultats_magasin' => $resultats_magasin]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur interne du serveur'], 500);
        }
    }

    // ------------------------------------------------------------------------------------------------------------------------------------------
    public function VoirCategories()
    {
        $ventes = Vente::join('produits', 'produits.id', '=', 'ventes.id_produit')
            ->join('categories', 'categories.id', '=', 'produits.categorie_id')
            ->select(
                'categories.nom as categorie_nom',
                'ventes.unite_mesure as unite',
                DB::raw('SUM(ventes.quantite) as total_quantite'),
                DB::raw('SUM(ventes.total_vente) as total_total_vente')
            )
            ->groupBy('categories.nom', 'ventes.unite_mesure')
            ->orderBy('categories.nom', 'ASC')
            ->get();


        return view('admin.calculs.categories.index', ['ventes' => $ventes]);
    }
    // ------------------------------------------------------------------------------------------------------------------------------------------
    public function VoirCategoriesFiltre($date1, $date2, $filterCase)
    {
        if ($date1) {
            $date1 = Carbon::parse($date1)->format('Y-m-d H:i:s');
        }
        if ($date2) {
            $date2 = Carbon::parse($date2)->format('Y-m-d H:i:s');
        }
        try {

            // Filtrage par période entre deux dates
            if ($filterCase === 'periode' && $date1 && $date2) {
                $ventes = Vente::join('produits', 'produits.id', '=', 'ventes.id_produit')
                    ->join('categories', 'categories.id', '=', 'produits.categorie_id')
                    ->whereBetween('ventes.created_at', [$date1, $date2])
                    ->select(
                        'categories.nom as categorie_nom',
                        'ventes.unite_mesure as unite',
                        DB::raw('SUM(ventes.quantite) as total_quantite'),
                        DB::raw('SUM(ventes.total_vente) as total_total_vente')
                    )
                    ->groupBy('categories.nom', 'ventes.unite_mesure')
                    ->orderBy('categories.nom', 'ASC')
                    ->get();
            }

            // Filtrage depuis une date de début jusqu'à maintenant
            if ($filterCase === 'debut' && $date1) {
                $ventes = Vente::join('produits', 'produits.id', '=', 'ventes.id_produit')
                    ->join('categories', 'categories.id', '=', 'produits.categorie_id')
                    ->where('ventes.created_at', '>=', $date1)
                    ->select(
                        'categories.nom as categorie_nom',
                        'ventes.unite_mesure as unite',
                        DB::raw('SUM(ventes.quantite) as total_quantite'),
                        DB::raw('SUM(ventes.total_vente) as total_total_vente')
                    )
                    ->groupBy('categories.nom', 'ventes.unite_mesure')
                    ->orderBy('categories.nom', 'ASC')
                    ->get();
            }


            // Filtrage jusqu'à une date de fin
            if ($filterCase === 'fin' && $date2) {
                $ventes = Vente::join('produits', 'produits.id', '=', 'ventes.id_produit')
                    ->join('categories', 'categories.id', '=', 'produits.categorie_id')
                    ->where('ventes.created_at', '<=', $date2)
                    ->select(
                        'categories.nom as categorie_nom',
                        'ventes.unite_mesure as unite',
                        DB::raw('SUM(ventes.quantite) as total_quantite'),
                        DB::raw('SUM(ventes.total_vente) as total_total_vente')
                    )
                    ->groupBy('categories.nom', 'ventes.unite_mesure')
                    ->orderBy('categories.nom', 'ASC')
                    ->get();
            }
            return response()->json(['ventes' => $ventes]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur interne du serveur'], 500);
        }
    }

    // ------------------------------------------------------------------------------------------------------------------------------------------





}
