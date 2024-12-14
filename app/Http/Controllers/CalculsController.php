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

    public function index()
    {
        $Liste_Magasins = Magasin::all();
        $Liste_Caisses = Caisse::all();
        $Nombre_Caisses_parmagasin = Caisse::groupBy('id_magasin')
        ->selectRaw('id_magasin, count(*) as count')
        ->get();
    

        return view('admin.calculs.index', [ 'magasins' => $Liste_Magasins , 'caisses' => $Liste_Caisses , 'nombre_caisses' => $Nombre_Caisses_parmagasin ]);
    }

    public function voir($id_magasin)
    {
        // Récupérer les stocks
        $stocks = Stock::where('magasin_id', $id_magasin)
            ->join('lestocks', 'lestocks.stock_id', '=', 'stocks.id')
            ->join('produits', 'produits.id', '=', 'lestocks.produit_id')
            ->select(
                'lestocks.id',
                'produits.nom_pr',
                'lestocks.quantity',
            )
            ->groupBy('produits.nom_pr', 'lestocks.id', 'lestocks.quantity')
            ->orderBy('produits.nom_pr', 'ASC')
            ->get();
    
        // Récupérer le magasin
        $magasin = Magasin::find($id_magasin);
        $nom_magasin = $magasin ? $magasin->nom : null;
    
        // Récupérer les transferts
        $transferts = Transfert::where('mag', '=', $nom_magasin)
            ->join('prod_trans', 'prod_trans.id_trans', '=', 'transfert.id')
            ->select(
                'prod_trans.id',
                'prod_trans.produit',
                'prod_trans.quantity',
            )
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
    
        // Lier les stocks, les ventes, et les transferts pour chaque produit
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
    
            // Calculer la quantité totale des transferts pour ce produit
            $quantite_transferee = $transferts_produit->sum('quantity');
    
            // Calculer la différence (quantité transférée - (stock + ventes))
            $quantite_difference = $quantite_transferee - ($stock->quantity + $quantite_vendue);
    
            // Ajouter les résultats pour ce produit
            $resultats_magasin[] = [
                'produit' => $stock->nom_pr,
                'stock' => $stock->quantity,
                'quantite_vendue' => $quantite_vendue,
                'quantite_transferee' => $quantite_transferee,
                'quantite_difference' => $quantite_difference,
            ];
        }
    
        // Retourner la vue avec les données
        return view('admin.calculs.voir', [
            'magasin' => $magasin,
            'stocks' => $stocks,
            'transferts' => $transferts,
            'ventes' => $ventes,
            'resultats_magasin' => $resultats_magasin,
        ]);
    }
    

    
    
    
    

    public function filtrage_calculs_list($id_calculs_transfert)
    {
        try {
            $calculs_list = Calculs_list::where('calculs_transfert_id', '=', $id_calculs_transfert)->get();
            if ($calculs_list->isEmpty()) {
                return response()->json(['message' => 'No calculs found'], 404);
            }
            return response()->json(['calculs_list' => $calculs_list]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
