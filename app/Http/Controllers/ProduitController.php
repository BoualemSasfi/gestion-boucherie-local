<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Category;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;


class ProduitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $produits = Produit::all();  // Récupère tous les produits

        // Passe les données à la vue
        return view('admin.produit.index', ['produits' => $produits]);
    }

    public function create()
    {
        $categorys = Category::all(); // Récupère toutes les catégories
        return view('admin.produit.add', ['categorys' => $categorys]);
    }
    public function store(Request $request)
    {
        $produit = new Produit();
        $produit->nom_pr = $request->input('nom_pr');
        $produit->prix_vent = $request->input('prix_vent');
        $produit->semi_gros = $request->input('semi_gros');
        $produit->gros = $request->input('gros');
        $produit->categorie_id = $request->input('category_id');


        // Gestion du logo
        if ($request->hasFile('photo_pr')) {
            // Supprimer l'ancien logo s'il existe
            if ($produit->photo_pr) {
                Storage::delete($produit->photo_pr);
            }

            // Stocker la nouvelle photo et obtenir son chemin
            $path = $request->file('photo_pr')->store('public/images/produit');

            // Enregistrer le chemin relatif dans la base de données
            $produit->photo_pr = str_replace('public/', '', $path);
        }
        $produit->save();

        // Message de succès
        session()->flash('success', 'le nouveau produit a bien été eneregistrier');

        return redirect('/admin/produit');
    }

    public function edit($id)
    {
        $produit = Produit::find($id);
        $categorys = Category::all();
        $defaultCategoryId = $produit->categorie_id;
        return view('admin.produit.edit', ['produit' => $produit, 'categorys' => $categorys, 'defaultCategoryId' => $defaultCategoryId]);


    }

    public function update(Request $request, $id)
    {
        $produit = Produit::find($id);
        $produit->nom_pr = $request->input('nom_pr');
        $produit->prix_vent = $request->input('prix_vent');
        $produit->semi_gros = $request->input('semi_gros');
        $produit->gros = $request->input('gros');
        $produit->categorie_id = $request->input('category_id');


        // Gestion du logo
        if ($request->hasFile('photo_pr')) {
            // Supprimer l'ancien logo s'il existe
            if ($produit->photo_pr) {
                Storage::delete($produit->photo_pr);
            }

            // Stocker la nouvelle photo et obtenir son chemin
            $path = $request->file('photo_pr')->store('public/images/produit');

            // Enregistrer le chemin relatif dans la base de données
            $produit->photo_pr = str_replace('public/', '', $path);
        }
        $produit->save();
        session()->flash('success', 'Modification eneregistrier');
        return redirect('/admin/produit');

    }

    public function destroy($id)
    {
        $produit = Produit::find($id);
        $produit->delete();

        session()->flash('success', 'le produit est supprimer ');

        return redirect('/admin/produit');
    }


}
