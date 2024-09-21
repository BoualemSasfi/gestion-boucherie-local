<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Information;
use App\Models\Category;
use App\Models\Produit;
use App\Models\Magasin;
use App\Models\Stock;
use App\Models\Lestock;

use Illuminate\Support\Facades\DB;



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
        $id_magasin = 2;
        $magasin = Magasin::find($id_magasin);
        $stock_frais = Stock::where('magasin_id', $id_magasin)->where('type', 'Frais')->first();
        $id_stock = $stock_frais->id;
        $lestocks = Lestock::where('stock_id', $id_stock)->get();
        // hadi tafichi man stock magasin 
        $categories = Lestock::where('stock_id', $id_stock)
        ->join('categories', 'categories.id', '=', 'lestocks.categorie_id')
        ->select(
            DB::raw('MIN(lestocks.id) as id_lestock'),  // Obtenir la valeur minimum de id_lestock
            'lestocks.categorie_id as id',               // Grouper par categorie_id (alias id)
            DB::raw('MIN(categories.nom) as nom'),       // Utiliser MIN() ou MAX() pour les autres colonnes
            DB::raw('MIN(categories.photo) as photo')
        )
        ->groupBy('id')  // Grouper par categorie_id (alias id)
        ->get();


        return view('caisse.paccino', ['categorys' => $categories, 'magasin' => $magasin, 'produits' => $lestocks]);
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
}
