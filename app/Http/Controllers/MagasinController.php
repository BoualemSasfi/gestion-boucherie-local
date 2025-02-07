<?php

namespace App\Http\Controllers;

use App\Models\Magasin;
use App\Models\Lestock;
use App\Models\Stock;
use App\Models\Ajuste;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;


class MagasinController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $magasins = Magasin::all();
        return view('admin.magasin.index', ['magasins' => $magasins]);
    }

    public function create()
    {

        return view('admin.magasin.add');
    }

    public function store(Request $request)
    {
        $magasin = new Magasin();
        $magasin->nom = $request->input('nom');
        $magasin->tel = $request->input('tel');
        $magasin->N_reg = $request->input('N_reg');
        $magasin->type = $request->input('type');
        $magasin->adresse = $request->input('adresse');
        $magasin->loca = $request->input('loca');

        // Gestion du photo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancien photo s'il existe
            if ($magasin->photo) {
                Storage::delete($magasin->photo);
            }

            // Stocker la nouvelle photo et obtenir son chemin
            $path = $request->file('photo')->store('public/images/magasin');

            // Enregistrer le chemin relatif dans la base de données
            $magasin->photo = str_replace('public/', '', $path);
        }
        $magasin->save();

        // Message de succès
        // Alert::success('le nouveau magasin a bien été enregitrier !')->position('center')->autoClose(2000);
        session()->flash('success', 'le nouveau magasin a bien été eneregistrier');
        return redirect('/admin/magasin');

    }

    public function edit($id)
    {
        $magasins = Magasin::find($id);
        return view('admin.magasin.edit', ['magasins' => $magasins]);
    }

    public function update(Request $request, $id)
    {
        $magasins = Magasin::find($id);
        $magasins->nom = $request->input('nom');
        $magasins->N_reg = $request->input('N_reg');
        $magasins->adresse = $request->input('adresse');
        $magasins->loca = $request->input('loca');
        $magasins->tel = $request->input('tel');
        $magasins->type = $request->input('type');

        //  Gestion du photo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancien photo s'il existe
            if ($magasins->photo) {
                Storage::delete($magasins->photo);
            }

            // Stocker la nouvelle photo et obtenir son chemin
            $path = $request->file('photo')->store('public/images/magasin');

            // Enregistrer le chemin relatif dans la base de données
            $magasins->photo = str_replace('public/', '', $path);
        }
        $magasins->save();
        // Alert::success('le nouveau magasin a bien été enregitrier !')->position('center')->autoClose(9000);
        session()->flash('success', 'le magasin a bien été modifier   !');
        return redirect('/admin/magasin');

    }

    public function destroy($id)
    {
        $magasin = Magasin::find($id);
        $magasin->delete();
        session()->flash('success', 'le magasin est supprimet !');
        return redirect('/admin/magasin');
    }


    public function ajouster(Request $request)
    {
        $data = $request->input('stockData');

        // Valider les données reçues
        $request->validate([
            'stockData.id' => 'required|integer',
            'stockData.quantity' => 'required|numeric',
            'stockData.magasin' => 'required|string',
            'stockData.user' => 'required|string',
            'stockData.categorie' => 'required|string',
            'stockData.produit' => 'required|string',
            'stockData.etat' => 'required|integer'
        ]);

        // Récupérer et mettre à jour le produit
        $produit = Lestock::find($data['id']);
        if ($produit) {
            $produit->quantity = $data['quantity'];
            $produit->save();


            // Enregistrement dans la table Ajuste
            $ajst = new Ajuste();
            $ajst->user = $data['user'];
            $ajst->atl = $data['magasin'];
            $ajst->categorie = $data['categorie'] ;
            $ajst->produit = $data['produit'] ;
            $ajst->qauntity = $data['quantity'];
            $ajst->etat = $data['etat'];
            $ajst->save();

            // Log ou ajuster selon vos besoins...
            return response()->json(['message' => 'Quantité mise à jour avec succès.']);
        } else {
            return response()->json(['message' => 'Produit non trouvé.'], 404);
        }

    }

    public function stock($id)
    {
        $magasins = Magasin::find($id);

        $stock_frais = Lestock::join('stocks', 'stocks.id', '=', 'lestocks.stock_id')
            ->join('categories', 'categories.id', '=', 'lestocks.categorie_id')
            ->join('produits', 'produits.id', '=', 'lestocks.produit_id')
            ->join('magasins', 'stocks.magasin_id', '=', 'magasins.id')
            ->where('stocks.magasin_id', $id)
            ->where('stocks.type', 'frais')
            ->select(
                'stocks.id as id_frais',
                'categories.nom as categorie',
                'produits.nom_pr as produit',
                'produits.photo_pr as photo',
                'lestocks.id as id_frais',
                'quantity'
            )
            ->get();


        // $stcok_frais_categorie = Lestock::join('stocks', 'stocks.id', '=', 'lestocks.stock_id')
        // ->join('categories', 'categories.id', '=', 'lestocks.categorie_id')
        // ->join('produits', 'produits.id', '=', 'lestocks.produit_id')
        // ->join('magasins', 'stocks.magasin_id', '=', 'magasins.id')
        // ->where('stocks.magasin_id', $id)
        // ->where('stocks.type', 'frais')
        // ->select(
        //     'categories.nom as categorie',
        //   'categories.id as categorie_id' 
        // )
        // ->groupBy('categorie.nom','categories.id')
        // ->get(); 







        // $stock_congele = Lestock::join('stocks', 'stocks.id', '=', 'lestocks.stock_id')
        //     ->join('categories', 'categories.id', '=', 'lestocks.categorie_id')
        //     ->join('produits', 'produits.id', '=', 'lestocks.produit_id')
        //     ->join('magasins', 'stocks.magasin_id', '=', 'magasins.id')
        //     ->where('stocks.magasin_id', $id)
        //     ->where('stocks.type', 'congele')
        //     ->select(
        //         'stocks.id as id_congele',
        //         'categories.nom as categorie',
        //         'produits.nom_pr as produit',
        //         'produits.photo_pr as photo',
        //         'lestocks.id as id_congele',
        //         'quantity'
        //     )
        //     ->get();









        $stock_congele = Lestock::join('stocks', 'stocks.id', '=', 'lestocks.stock_id')
            ->join('categories', 'categories.id', '=', 'lestocks.categorie_id')
            ->join('produits', 'produits.id', '=', 'lestocks.produit_id')
            ->join('magasins', 'stocks.magasin_id', '=', 'magasins.id')
            ->where('stocks.magasin_id', $id)
            ->where('stocks.type', 'congele')
            ->select(
                'stocks.id as id_congele',
                'categories.nom as categorie',
                'produits.nom_pr as produit',
                'produits.photo_pr as photo',
                'lestocks.id as id_congele',
                'quantity'
            )
            ->get();



        $lesmagasins = Magasin::all();

        $stock_congele_id = Stock::where('magasin_id', $id)
            ->where('type', 'Congele')
            ->value('id');

        $stock_frais_id = Stock::where('magasin_id', $id)
            ->where('type', 'Frais')
            ->value('id');




        return view('/admin/magasin/stock', [
            'magasins' => $magasins,
            'stock_frais' => $stock_frais,
            'stock_congele' => $stock_congele,
            'lesmagasins' => $lesmagasins,
            'frais_id' => $stock_frais_id,
            'congele_id' => $stock_congele_id,
            // 'categorie_frais' => $stcok_frais_categorie,

        ]);
    }


}
