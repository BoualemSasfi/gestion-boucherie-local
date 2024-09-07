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
    public function transfert($id_atl, $id_mag)
    {
        $stocks = DB::table('categories as c')
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
                            ->where('stocks.type', 'congele');
                    });
            })
            ->select(
                'c.nom as categorie',
                'p.nom_pr as produit',
                DB::raw('COALESCE(SUM(ls1.quantity), 0) AS poid_magasin_1'),
                DB::raw('COALESCE(SUM(ls2.quantity), 0) AS poid_magasin_2')
            )
            ->whereIn('c.id', function ($query) use ($id_mag) {
                $query->select('ls1.categorie_id')
                    ->from('lestocks as ls1')
                    ->join('stocks as s1', 's1.id', '=', 'ls1.stock_id')
                    ->where('s1.magasin_id', $id_mag)
                    ->distinct();
            })
            ->groupBy('c.nom', 'p.nom_pr')
            ->get();

        $magasins1 = Magasin::find($id_mag);
        $magasins2 = Magasin::find($id_atl);


        // Retourner les résultats à une vue ou directement
        return view('admin.transfert.transfert', ['stocks' => $stocks, 'magasins1' => $id_atl, 'magasins2' => $id_mag]);
    }
}
