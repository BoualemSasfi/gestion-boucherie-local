<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Information;
use App\Models\Category;
use App\Models\Produit;
use App\Models\Magasin;
use App\Models\Stock;
use App\Models\Lestock;
use App\Models\Facture;
use App\Models\Vente;
use App\Models\Vendeur;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class CaisseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function caisse()
    {
        $categorys = Category::all();
        $produits = Produit::all();
        $informtions = Information::first();

        return view('caisse.test', ['categorys' => $categorys, 'informations' => $informtions, 'produits' => $produits]);
    }
    public function caisse_paccino()
    {
        // Vérifier si un utilisateur est connecté
        if (Auth::check()) {
            // L'utilisateur est connecté
            $IdUser = Auth::id(); // ou auth()->id();
            $Vendeur = Vendeur::where('id_user', $IdUser)->first();
            $IdMagasin = $Vendeur->id_magasin;
            $IdCaisse = $Vendeur->id_caisse;
            $magasin = Magasin::find($IdMagasin);
            $StocksFrai = Stock::where('magasin_id', $IdMagasin)->where('type', 'Frais')->first();
            $IdStock = $StocksFrai->id;
            $LesStocks = Lestock::where('stock_id', $IdStock)->get();
            // hadi tafichi man stock magasin 
            $categories = Lestock::where('stock_id', $IdStock)
                ->join('categories', 'categories.id', '=', 'lestocks.categorie_id')
                ->select(
                    DB::raw('MIN(lestocks.id) as id_lestock'),  // Obtenir la valeur minimum de id_lestock
                    'lestocks.categorie_id as id',               // Grouper par categorie_id (alias id)
                    DB::raw('MIN(categories.nom) as nom'),       // Utiliser MIN() ou MAX() pour les autres colonnes
                    DB::raw('MIN(categories.photo) as photo')
                )
                ->groupBy('id')  // Grouper par categorie_id (alias id)
                ->get();


            return view('caisse.paccino', ['categorys' => $categories, 'magasin' => $magasin, 'produits' => $LesStocks,
             'id_magasin' => $IdMagasin, 'id_user' => $IdUser, 'id_caisse' => $IdCaisse]);
        } else {
            return "Utilisateur non connecté";
        }
    }

    public function filtrage_des_produits($id)
    {
        try {

            $categoryId = $id;

            $produits = Produit::where('categorie_id', $categoryId)->get();

            // Retournez les produits au format JSON
            return response()->json(['produits' => $produits]);
        } catch (\Exception $e) {
            // Loguer l'exception pour le débogage
            \Log::error($e);

            // Retourner une réponse d'erreur
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    //
    /// factures 
    //

    public function Nouvelle_Facture_Vide($id_magasin, $id_user, $id_caisse)
    {
        $NewFacture = new Facture();
        $NewFacture->id_user = $id_user;
        $NewFacture->id_magasin = $id_magasin;
        $NewFacture->id_caisse = $id_caisse;
        $NewFacture->id_client = 0;
        $NewFacture->etat_facture = "en-attente";
        $NewFacture->total_facture = 0;
        $NewFacture->versement = 0;
        $NewFacture->credit = 0;
        $NewFacture->save();
    }

    public function Get_Last_Facture($id_magasin)
    {
        $LastFacture = Facture::where('id_magasin', $id_magasin)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function Get_Liste_Ventes($id_facture)
    {
        $LastVentes = Vente::where('id_facture', $id_facture)->get();
    }
}
