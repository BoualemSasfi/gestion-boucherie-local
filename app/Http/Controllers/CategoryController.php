<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Produit;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorys = Category::all();
        return view('admin.categorie.index', ['categorys' => $categorys]);

        // return response()->json(['catgory'=>$category]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categorie.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = new Category();
        $category->nom = $request->input('nom');

        // Gestion du logo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancien logo s'il existe
            if ($category->photo) {
                Storage::delete($category->photo);
            }

            // Stocker le nouveau logo et obtenir son chemin
            $path = $request->file('photo')->store('public/images/category');

            // Enregistrer le chemin relatif dans la base de données
            $category->photo = str_replace('public/', '', $path);
        }
        $category->save();

        // Message de succès
        Alert::success('la nouvelle catégorie a bien été ajouter !')->position('center')->autoClose(2000);

        return redirect('/admin/category');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $produits = Produit::where('categorie_id',$id)->get();
        return view('admin.categorie.edit',['category'=>$category,'produits'=>$produits]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
            $category = Category::find($id);
            $category->nom  = $request->input('nom');

             // Gestion du logo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancien logo s'il existe
            if ($category->photo) {
                Storage::delete($category->photo);
            }

            // Stocker le nouveau logo et obtenir son chemin
            $path = $request->file('photo')->store('public/images/category');

            // Enregistrer le chemin relatif dans la base de données
            $category->photo = str_replace('public/', '', $path);
        }
        $category->save();

        return redirect('/admin/category');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect('/admin/category');
    }
}
