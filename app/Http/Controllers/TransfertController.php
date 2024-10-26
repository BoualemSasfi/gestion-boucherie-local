<?php

namespace App\Http\Controllers;

use App\Models\Magasin;
use App\Models\Lestock;
use App\Models\Stock;
use App\Models\Categorie;
use App\Models\Produit;
use App\Models\Transfert;
use App\Models\Ajuste;
use App\Models\prod_trans;
use Illuminate\Support\Facades\DB; // Importez la façade DB
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransfertController extends Controller
{

    public function liste()
    {
        $lists = Transfert::all();
        return view('admin.transfert.index', ['listes' => $lists]);
    }

    public function ajste_liste()
    {
        $lists = Ajuste::all();
        return view('admin.transfert.ajuste.index', ['lists' => $lists]);
    }


    public function details($id)
    {

        $info = Transfert::find($id);
        $details = prod_trans::where('id_trans', '=', $id)->get();

        return view('admin.transfert.details', ['info' => $info, 'details' => $details]);

    }


    public function transfert($id_atl, $id_mag, $id_magasin)
    {

        $stocks = DB::table('categories as c')
            ->select(
                'c.id as id_cat',
                'c.nom as categorie',
                'p.nom_pr as produit',
                'ls1.id as id_stock_1',
                DB::raw('COALESCE(SUM(ls1.quantity), 0) as poid_magasin_1'),
                'ls2.id as id_stock_2',
                DB::raw('COALESCE(SUM(ls2.quantity), 0) as poid_magasin_2')
            )
            ->join('produits as p', 'p.categorie_id', '=', 'c.id')
            ->leftJoin('lestocks as ls1', function ($join) use ($id_mag) {
                $join->on('ls1.produit_id', '=', 'p.id')
                    ->on('ls1.categorie_id', '=', 'c.id')
                    ->whereExists(function ($query) use ($id_mag) {
                        $query->select(DB::raw(1))
                            ->from('stocks as s1')
                            ->whereColumn('s1.id', 'ls1.stock_id')
                            ->where('s1.magasin_id', $id_mag);
                    });
            })
            ->leftJoin('lestocks as ls2', function ($join) use ($id_magasin, $id_atl) {
                $join->on('ls2.produit_id', '=', 'p.id')
                    ->on('ls2.categorie_id', '=', 'c.id')
                    ->whereExists(function ($query) use ($id_magasin, $id_atl) {
                        $query->select(DB::raw(1))
                            ->from('stocks as s2')
                            ->whereColumn('s2.id', 'ls2.stock_id')
                            ->where('s2.magasin_id', $id_magasin)
                            ->where('s2.type', 'frais');
                    });
            })
            ->whereIn('c.id', function ($query) use ($id_mag) {
                $query->select(DB::raw('DISTINCT ls1.categorie_id'))
                    ->from('lestocks as ls1')
                    ->join('stocks as s1', 's1.id', '=', 'ls1.stock_id')
                    ->where('s1.magasin_id', $id_mag);
            })
            ->groupBy('ls1.id', 'ls2.id', 'c.id', 'c.nom', 'p.nom_pr')
            ->get();

        // a changer utiliser une surl function ....

        $liste_cats = DB::table('categories as c')
            ->join('produits as p', 'p.categorie_id', '=', 'c.id')
            ->leftJoin('lestocks as ls1', function ($join) use ($id_mag) {
                $join->on('ls1.produit_id', '=', 'p.id')
                    ->on('ls1.categorie_id', '=', 'c.id')
                    ->whereExists(function ($query) use ($id_mag) {
                        $query->select(DB::raw('1'))
                            ->from('stocks')
                            ->whereColumn('stocks.id', 'ls1.stock_id')
                            ->where('stocks.magasin_id', $id_mag);
                    });
            })
            ->leftJoin('lestocks as ls2', function ($join) use ($id_atl) {
                $join->on('ls2.produit_id', '=', 'p.id')
                    ->on('ls2.categorie_id', '=', 'c.id')
                    ->whereExists(function ($query) use ($id_atl) {
                        $query->select(DB::raw('1'))
                            ->from('stocks')
                            ->whereColumn('stocks.id', 'ls2.stock_id')
                            ->where('stocks.magasin_id', $id_atl)
                            ->where('stocks.type', 'frais');
                    });
            })
            ->select(
                'c.id as categorie_id',
                'c.nom as categorie'

            )
            ->whereIn('c.id', function ($query) use ($id_mag) {
                $query->select('ls1.categorie_id')
                    ->from('lestocks as ls1')
                    ->join('stocks as s1', 's1.id', '=', 'ls1.stock_id')
                    ->where('s1.magasin_id', $id_mag)
                    ->distinct();
            })
            ->groupBy('c.id', 'c.nom')
            ->get();


        // ------------------------

        $magasins1 = Magasin::find($id_mag);
        $magasins2 = Magasin::find($id_atl);
        $lemagasin = Magasin::find($id_magasin);


        // Retourner les résultats à une vue ou directement
        return view('admin.transfert.transfert', ['stocks' => $stocks, 'magasins1' => $magasins1, 'magasins2' => $magasins2, 'lemagasin' => $lemagasin, 'liste_cats' => $liste_cats]);

    }
    public function transfert_congele($id_atl, $id_mag, $id_magasin)
    {

        $stocks = DB::table('categories as c')
            ->select(
                'c.id as id_cat',
                'c.nom as categorie',
                'p.nom_pr as produit',
                'ls1.id as id_stock_1',
                DB::raw('COALESCE(SUM(ls1.quantity), 0) as poid_magasin_1'),
                'ls2.id as id_stock_2',
                DB::raw('COALESCE(SUM(ls2.quantity), 0) as poid_magasin_2')
            )
            ->join('produits as p', 'p.categorie_id', '=', 'c.id')
            ->leftJoin('lestocks as ls1', function ($join) use ($id_mag) {
                $join->on('ls1.produit_id', '=', 'p.id')
                    ->on('ls1.categorie_id', '=', 'c.id')
                    ->whereExists(function ($query) use ($id_mag) {
                        $query->select(DB::raw(1))
                            ->from('stocks as s1')
                            ->whereColumn('s1.id', 'ls1.stock_id')
                            ->where('s1.magasin_id', $id_mag);
                    });
            })
            ->leftJoin('lestocks as ls2', function ($join) use ($id_magasin, $id_atl) {
                $join->on('ls2.produit_id', '=', 'p.id')
                    ->on('ls2.categorie_id', '=', 'c.id')
                    ->whereExists(function ($query) use ($id_magasin, $id_atl) {
                        $query->select(DB::raw(1))
                            ->from('stocks as s2')
                            ->whereColumn('s2.id', 'ls2.stock_id')
                            ->where('s2.magasin_id', $id_magasin)
                            ->where('s2.type', 'congele');
                    });
            })
            ->whereIn('c.id', function ($query) use ($id_mag) {
                $query->select(DB::raw('DISTINCT ls1.categorie_id'))
                    ->from('lestocks as ls1')
                    ->join('stocks as s1', 's1.id', '=', 'ls1.stock_id')
                    ->where('s1.magasin_id', $id_mag);
            })
            ->groupBy('ls1.id', 'ls2.id', 'c.id', 'c.nom', 'p.nom_pr')
            ->get();

        // a changer utiliser une surl function ....

        $liste_cats = DB::table('categories as c')
            ->join('produits as p', 'p.categorie_id', '=', 'c.id')
            ->leftJoin('lestocks as ls1', function ($join) use ($id_mag) {
                $join->on('ls1.produit_id', '=', 'p.id')
                    ->on('ls1.categorie_id', '=', 'c.id')
                    ->whereExists(function ($query) use ($id_mag) {
                        $query->select(DB::raw('1'))
                            ->from('stocks')
                            ->whereColumn('stocks.id', 'ls1.stock_id')
                            ->where('stocks.magasin_id', $id_mag);
                    });
            })
            ->leftJoin('lestocks as ls2', function ($join) use ($id_atl) {
                $join->on('ls2.produit_id', '=', 'p.id')
                    ->on('ls2.categorie_id', '=', 'c.id')
                    ->whereExists(function ($query) use ($id_atl) {
                        $query->select(DB::raw('1'))
                            ->from('stocks')
                            ->whereColumn('stocks.id', 'ls2.stock_id')
                            ->where('stocks.magasin_id', $id_atl)
                            ->where('stocks.type', 'frais');
                    });
            })
            ->select(
                'c.id as categorie_id',
                'c.nom as categorie'

            )
            ->whereIn('c.id', function ($query) use ($id_mag) {
                $query->select('ls1.categorie_id')
                    ->from('lestocks as ls1')
                    ->join('stocks as s1', 's1.id', '=', 'ls1.stock_id')
                    ->where('s1.magasin_id', $id_mag)
                    ->distinct();
            })
            ->groupBy('c.id', 'c.nom')
            ->get();


        // ------------------------

        $magasins1 = Magasin::find($id_mag);
        $magasins2 = Magasin::find($id_atl);
        $lemagasin = Magasin::find($id_magasin);


        // Retourner les résultats à une vue ou directement
        return view('admin.transfert.transfert', ['stocks' => $stocks, 'magasins1' => $magasins1, 'magasins2' => $magasins2, 'lemagasin' => $lemagasin, 'liste_cats' => $liste_cats]);

    }


    public function retour($id_atl, $id_mag, $id_magasin)
    {



        $stocks = DB::table('categories as c')
            ->select(
                'c.id as id_cat',
                'c.nom as categorie',
                'p.nom_pr as produit',
                'ls1.id as id_stock_1',
                DB::raw('COALESCE(SUM(ls1.quantity), 0) as poid_magasin_1'),
                'ls2.id as id_stock_2',
                DB::raw('COALESCE(SUM(ls2.quantity), 0) as poid_magasin_2')
            )
            ->join('produits as p', 'p.categorie_id', '=', 'c.id')
            ->leftJoin('lestocks as ls1', function ($join) use ($id_magasin) {
                $join->on('ls1.produit_id', '=', 'p.id')
                    ->on('ls1.categorie_id', '=', 'c.id')
                    ->whereExists(function ($query) use ($id_magasin) {
                        $query->select(DB::raw(1))
                            ->from('stocks as s1')
                            ->whereColumn('s1.id', 'ls1.stock_id')
                            ->where('s1.magasin_id', $id_magasin);
                    });
            })
            ->leftJoin('lestocks as ls2', function ($join) use ($id_mag, $id_atl) {
                $join->on('ls2.produit_id', '=', 'p.id')
                    ->on('ls2.categorie_id', '=', 'c.id')
                    ->whereExists(function ($query) use ($id_mag, $id_atl) {
                        $query->select(DB::raw(1))
                            ->from('stocks as s2')
                            ->whereColumn('s2.id', 'ls2.stock_id')
                            ->where('s2.magasin_id', $id_mag)
                            ->where('s2.type', 'frais');
                    });
            })
            ->whereIn('c.id', function ($query) use ($id_magasin) {
                $query->select(DB::raw('DISTINCT ls1.categorie_id'))
                    ->from('lestocks as ls1')
                    ->join('stocks as s1', 's1.id', '=', 'ls1.stock_id')
                    ->where('s1.magasin_id', $id_magasin);
            })
            ->groupBy('ls1.id', 'ls2.id', 'c.id', 'c.nom', 'p.nom_pr')
            ->get();

        // a changer utiliser une surl function ....

        $liste_cats = DB::table('categories as c')
            ->join('produits as p', 'p.categorie_id', '=', 'c.id')
            ->leftJoin('lestocks as ls1', function ($join) use ($id_magasin) {
                $join->on('ls1.produit_id', '=', 'p.id')
                    ->on('ls1.categorie_id', '=', 'c.id')
                    ->whereExists(function ($query) use ($id_magasin) {
                        $query->select(DB::raw('1'))
                            ->from('stocks')
                            ->whereColumn('stocks.id', 'ls1.stock_id')
                            ->where('stocks.magasin_id', $id_magasin);
                    });
            })
            ->leftJoin('lestocks as ls2', function ($join) use ($id_atl) {
                $join->on('ls2.produit_id', '=', 'p.id')
                    ->on('ls2.categorie_id', '=', 'c.id')
                    ->whereExists(function ($query) use ($id_atl) {
                        $query->select(DB::raw('1'))
                            ->from('stocks')
                            ->whereColumn('stocks.id', 'ls2.stock_id')
                            ->where('stocks.magasin_id', $id_atl)
                            ->where('stocks.type', 'frais');
                    });
            })
            ->select(
                'c.id as categorie_id',
                'c.nom as categorie'

            )
            ->whereIn('c.id', function ($query) use ($id_magasin) {
                $query->select('ls1.categorie_id')
                    ->from('lestocks as ls1')
                    ->join('stocks as s1', 's1.id', '=', 'ls1.stock_id')
                    ->where('s1.magasin_id', $id_magasin)
                    ->distinct();
            })
            ->groupBy('c.id', 'c.nom')
            ->get();


        // ------------------------

        $magasins1 = Magasin::find($id_mag );
        $magasins2 = Magasin::find($id_atl);
        $lemagasin = Magasin::find($id_magasin);


        // Retourner les résultats à une vue ou directement
        return view('admin.transfert.retour', ['stocks' => $stocks, 'magasins1' => $magasins1, 'magasins2' => $magasins2, 'lemagasin' => $lemagasin, 'liste_cats' => $liste_cats]);

    }





    public function validTransfert(Request $request)
    {
        // Récupérer les données JSON envoyées via la clé 'donne'
        // $donnees = $request->input('donne'); 

        // $donnees = $request->all();


        $donnees = $request->input('stockData');
        $poidData = $request->input('poid');



        // Vérifier si les données sont reçues correctement
        if (!$donnees || !is_array($donnees)) {
            return response()->json(['success' => false, 'message' => 'Données invalides.'], 400);
        }

        if (!$poidData || !is_array($poidData)) {
            return response()->json(['success' => false, 'message' => 'Données invalides.'], 400);
        }

        // Récupérer les valeurs de $atl, $mag, et $user
        $atl = $donnees[count($donnees) - 1]['atl'];
        $mag = $donnees[count($donnees) - 1]['mag'];
        $user = $donnees[count($donnees) - 1]['user'];


        $nv_transfert = new Transfert();
        $nv_transfert->user = $user;
        $nv_transfert->atl = $atl;
        $nv_transfert->mag = $mag;
        $nv_transfert->save();

        // Récupérer l'ID du transfert nouvellement créé
        // $id_trans = $nv_transfert->id;


        $last_transfert = Transfert::latest()->first();
        $id_trans = $last_transfert->id;


        // Parcourir chaque ligne des données envoyées
        foreach ($donnees as $stockEnvoye) {
            // Vérifier si l'ID et le poids sont bien envoyés
            if (isset($stockEnvoye['id'], $stockEnvoye['poid'])) {
                // Parcourir les enregistrements dans la table Lestock
                $stocks = Lestock::all(); // Récupère tous les enregistrements de la table Lestock
                foreach ($stocks as $stock) {
                    // Si l'ID envoyé correspond à un ID dans la table Lestock
                    if ($stock->id == $stockEnvoye['id']) {
                        // Mise à jour du poids
                        $stock->quantity = $stockEnvoye['poid'];
                        $stock->save(); // Sauvegarde de la modification
                        break; // On sort de la boucle une fois l'ID trouvé et mis à jour
                    }
                }
            }
        }


        foreach ($poidData as $poid) {
            $nv_prod = new prod_trans();
            $nv_prod->id_trans = $id_trans;
            $nv_prod->category = $poid['categorie'];
            $nv_prod->produit = $poid['produit'];
            $nv_prod->quantity = $poid['poid'];
            $nv_prod->save();
        }

        // Si tout est correct, retourner une réponse positive
        return response()->json(['success' => true, 'message' => 'Transfert validé et stocks mis à jour avec succès.']);
    }



}
