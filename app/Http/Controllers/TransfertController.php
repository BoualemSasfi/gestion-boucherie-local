<?php

namespace App\Http\Controllers;

use App\Models\Magasin;
use App\Models\Lestock;
use App\Models\Stock;
use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Support\Facades\DB; // Importez la façade DB
use Illuminate\Http\Request;

class TransfertController extends Controller
{
    public function transfert($id_atl, $id_mag , $id_magasin)
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
            ->leftJoin('lestocks as ls1', function ($join) {
                $join->on('ls1.produit_id', '=', 'p.id')
                    ->on('ls1.categorie_id', '=', 'c.id')
                    ->whereExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('stocks as s1')
                            ->whereColumn('s1.id', 'ls1.stock_id')
                            ->where('s1.magasin_id', 6);
                    });
            })
            ->leftJoin('lestocks as ls2', function ($join) {
                $join->on('ls2.produit_id', '=', 'p.id')
                    ->on('ls2.categorie_id', '=', 'c.id')
                    ->whereExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('stocks as s2')
                            ->whereColumn('s2.id', 'ls2.stock_id')
                            ->where('s2.magasin_id', 7);
                    });
            })
            ->whereIn('c.id', function ($query) {
                $query->select(DB::raw('DISTINCT ls1.categorie_id'))
                    ->from('lestocks as ls1')
                    ->join('stocks as s1', 's1.id', '=', 'ls1.stock_id')
                    ->where('s1.magasin_id', 6);
            })
            ->groupBy('ls1.id', 'ls2.id', 'c.id', 'c.nom', 'p.nom_pr')
            ->get();
        
// a changer utiliser une surl function ....

        $liste_cats =  DB::table('categories as c')
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
                        ->where('stocks.magasin_id', $id_atl);
                        // ->where('stocks.type', 'frais');
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
        ->groupBy('c.id','c.nom')
        ->get();


// ------------------------

        $magasins1 = Magasin::find($id_mag);
        $magasins2 = Magasin::find($id_atl);
        $lemagasin = Magasin::find($id_magasin);


        // Retourner les résultats à une vue ou directement
        return view('admin.transfert.transfert', ['stocks' => $stocks, 'magasins1' => $magasins1 , 'magasins2' => $magasins2 ,'lemagasin'=>$lemagasin ,'liste_cats'=>$liste_cats]);

    }

    public function validtransfert(Request $request)
    {
        // Récupération des données des champs input envoyés via AJAX
        $poidsAjouter = $request->input('poids_ajouter');
        $poidsMagasin1 = $request->input('poids_magasin_1');
        $poidsMagasin2 = $request->input('poids_magasin_2');
    
        // Exemple de traitement des données
        try {
            DB::beginTransaction();
    
            // Boucler à travers les poids envoyés et effectuer les mises à jour nécessaires
            foreach ($poidsAjouter as $index => $poids) {
                // Exemple de mise à jour des stocks
                // Assurez-vous que le stock existe avant de faire des modifications
                if (!empty($poids) && $poidsMagasin2[$index] > 0) {
                    $stock = Stock::find($index); // Ajustez cette partie en fonction de la structure réelle de votre base de données
                    if ($stock) {
                        // Mettre à jour le stock pour les magasins
                        $stock->poid_magasin_1 = $poidsMagasin1[$index] + $poids;
                        $stock->poid_magasin_2 = $poidsMagasin2[$index] - $poids;
                        $stock->save();
                    }
                }
            }
    
            DB::commit();
            return response()->json(['success' => true]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
}
