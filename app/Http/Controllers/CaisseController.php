<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Information;
use App\Models\Category;
use App\Models\Produit;


class CaisseController extends Controller
{
    public function caisse(Request $request , $id){
        // $categorys = Category::all();
        // $produits = Produit::all();
        // $informtions = Information::first();

        // return view('caisse.test',['categorys'=>$categorys , 'informations'=>$informtions , 'produits'=>$produits]);

        // ajax 
    
    //   $categoryId = $id;
      $categoryId = 1;
    
            // Récupérer les produits en fonction de la catégorie sélectionnée
            if ($categoryId) {
                $produits = Produit::where('categorie_id', $categoryId)->get();
            } else {
                $produits = Produit::all();
            }
    
            $categorys = Category::all();
    
            if ($request->ajax()) {
                return response()->json(['produits' => $produits]);
            }
    
            return view('caisse.test', ['produits' => $produits, 'categorys' => $categorys]);
        
    }
}
