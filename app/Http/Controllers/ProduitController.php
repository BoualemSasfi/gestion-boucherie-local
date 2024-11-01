<?php

namespace App\Http\Controllers;

use App\Models\Lestock;
use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Category;
use App\Models\Sousproduits;

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

        $cat_id = $request->input('category_id');

        $lestocks = Lestock::where('categorie_id',$cat_id)->get();

        foreach($lestocks as $lestock){
            $add_prd = new Lestock();
            
        }


        // Message de succès
        session()->flash('success', 'le nouveau produit a bien été eneregistrier');

        return redirect('/admin/produit');
    }

    public function edit($id)
    {
        $produit = Produit::find($id);
        $categorys = Category::all();
        $sproduits = Sousproduits::where('id_pr',$id)->get();
        $defaultCategoryId = $produit->categorie_id;
        return view(
            'admin.produit.edit',
            [
                'produit' => $produit,
                'categorys' => $categorys,
                'defaultCategoryId' => $defaultCategoryId,
                'sproduits' => $sproduits
            ]
        );


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

    public function add_sous_produit(Request $request)
    {
        // Validez les données
        $request->validate([
            'subProductName' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'priceDetail' => 'required|numeric',
            'priceSemiGros' => 'required|numeric',
            'priceGros' => 'required|numeric',
            'productId' => 'required|integer|exists:produits,id', // Assurez-vous que l'ID du produit existe
        ]);
    
        // Créer un nouvel enregistrement pour le sous-produit
        $nv_sousprod = new Sousproduits();
        $nv_sousprod->nom_s_pr = $request->subProductName;
        $nv_sousprod->prix_vente = $request->priceDetail;
        $nv_sousprod->prix_semi_gros = $request->priceSemiGros;
        $nv_sousprod->prix_gros = $request->priceGros;
        $nv_sousprod->id_pr = $request->productId;
    
        // Gestion de la photo
        if ($request->hasFile('photo')) {
            // Stocker la nouvelle photo et obtenir son chemin
            $path = $request->file('photo')->store('public/images/produit');
            // Enregistrer le chemin relatif dans la base de données
            $nv_sousprod->photo_s_pr = str_replace('public/', '', $path);
        }
    
        // Enregistrer le sous-produit
        $nv_sousprod->save();
    
        // Retourner une réponse JSON
        return response()->json(['message' => 'Sous-produit ajouté avec succès!'], 201);
    }

    public function delete_sous_produit($id){
        try {
            // $sousProduit = Sousproduits::findOrFail($id);
            // $sousProduit->delete();
            Sousproduits::findOrFail($id)->delete();

            return response()->json(['message' => 'Sous-produit supprimé avec succès'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Échec de la suppression'], 500);
        }

    }
    


}
