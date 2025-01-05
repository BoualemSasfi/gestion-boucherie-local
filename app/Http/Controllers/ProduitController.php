<?php

namespace App\Http\Controllers;

use App\Models\Lestock;
use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Category;
use App\Models\Sousproduits;
use Illuminate\Support\Facades\DB;
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
        $categories = Category::all();
        // Passe les données à la vue
        return view('admin.produit.index', ['produits' => $produits, 'categories' => $categories]);
    }

    public function create()
    {
        $categorys = Category::all(); // Récupère toutes les catégories
        return view('admin.produit.add', ['categorys' => $categorys]);
    }

    public function add($id)
    {
        $categorys = Category::find($id);
        return view('admin.produit.add', ['categorys' => $categorys]);
    }
    public function store(Request $request)
    {
        $produit = new Produit();
        $produit->nom_pr = $request->input('nom_pr');
        $produit->prix_achat = $request->input('prix_achat');
        $produit->unite_mesure = $request->input('unite_mesure');
        $produit->prix_vente = $request->input('prix_vente');
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

        $lestocks = Lestock::select('stock_id', DB::raw('MAX(categorie_id) as categorie_id'))
            ->where('categorie_id', $cat_id)
            ->groupBy('stock_id')
            ->get();

        foreach ($lestocks as $lestock) {
            $add_prd = new Lestock();
            $add_prd->stock_id = $lestock->stock_id;
            $add_prd->categorie_id = $cat_id;
            $add_prd->produit_id = $produit->id;
            $add_prd->save();
        }

        $category_id = $request->input('category_id');
        // return redirect()->route(' /admin/category/'.$category_id.'/edit')->with('success', 'le nouveau produit a bien été eneregistrier');
        return redirect()->route('category.edit', ['id' => $category_id])
            ->with('success', 'Le nouveau produit a bien été enregistré.');

        // Message de succès
        // session()->flash('success', 'le nouveau produit a bien été eneregistrier');
        // return redirect('/admin/produit');
    }

    public function edit($id)
    {
        $produit = Produit::find($id);
        $categorys = Category::all();
        $sproduits = Sousproduits::where('id_pr', $id)->get();
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
    public function mdf($id, $id_cat)
    {
        $produit = Produit::find($id);
        $categorys = Category::all();
        $categorie = Category::find($id_cat);
        $sproduits = Sousproduits::where('id_pr', $id)->get();
        $defaultCategoryId = $produit->categorie_id;
        return view(
            'admin.produit.edit',
            [
                'produit' => $produit,
                'categorys' => $categorys,
                'defaultCategoryId' => $defaultCategoryId,
                'sproduits' => $sproduits,
                'categorie' => $categorie
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $produit = Produit::find($id);
        $produit->nom_pr = $request->input('nom_pr');
        $produit->prix_achat = $request->input('prix_achat');
        $produit->unite_mesure = $request->input('unite_mesure');
        $produit->prix_vente = $request->input('prix_vente');
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
    public function modifier(Request $request, $id, $id_cat)
    {
        $produit = Produit::find($id);
        $produit->nom_pr = $request->input('nom_pr');
        $produit->prix_achat = $request->input('prix_achat');
        $produit->unite_mesure = $request->input('unite_mesure');
        $produit->prix_vente = $request->input('prix_vente');
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

        $category_id = $id_cat;
        $produit = $id;
        $lestocks = Lestock::all();

        foreach ($lestocks as $lestock) {
            if ($lestock->produit_id == $produit) {
                    $lestock->categorie_id =  $request->input('category_id');
                    $lestock->save(); // Sauvegardez les modifications
            }
        }

        // return redirect()->route(' /admin/category/'.$category_id.'/edit')->with('success', 'le nouveau produit a bien été eneregistrier');
        return redirect()->route('category.edit', ['id' => $category_id])
            ->with('success', 'Le produit a bien été Modifier.');

        // session()->flash('success', 'Modification eneregistrier');
        // return redirect('/admin/produit');

    }

    public function destroy($id)
    {
        $produit = Produit::find($id);
        $produit->delete();

        session()->flash('success', 'le produit est supprimer ');

        return redirect('/admin/produit');
    }


    public function add_produit(Request $request)
    {
        $request->validate([
            'ProductName' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'priceAchat' => 'required|numeric',
            'priceDetail' => 'required|numeric',
            'priceSemiGros' => 'required|numeric',
            'priceGros' => 'required|numeric',
            'unite_mesure' => 'required|string',
            'categorie_id' => 'required|integer',
        ]);

        try {
            $nv_prod = new Produit();
            $nv_prod->nom_pr = $request->ProductName;
            $nv_prod->prix_achat = $request->priceAchat;
            $nv_prod->prix_vente = $request->priceDetail;
            $nv_prod->semi_gros = $request->priceSemiGros;
            $nv_prod->gros = $request->priceGros;
            $nv_prod->unite_mesure = $request->unite_mesure;
            $nv_prod->categorie_id = $request->categorie_id;

            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('public/images/produit');
                $nv_prod->photo_s_pr = str_replace('public/', '', $path);
            }

            $nv_prod->save();

            return response()->json(['message' => 'Produit ajouté avec succès!'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de l\'ajout du produit.', 'error' => $e->getMessage()], 500);
        }
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

    public function delete_sous_produit($id)
    {
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
