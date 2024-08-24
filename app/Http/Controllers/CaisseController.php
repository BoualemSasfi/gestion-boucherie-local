<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Information;
use App\Models\Category;
use App\Models\Produit;


class CaisseController extends Controller
{
    public function caisse()
    {
        $categorys = Category::all();
        $produits = Produit::all();
        $informtions = Information::first();

        return view('caisse.test', ['categorys' => $categorys, 'informations' => $informtions, 'produits' => $produits]);
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
