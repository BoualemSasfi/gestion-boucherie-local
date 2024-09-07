<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Category;
use App\Models\Magasin;
use App\Models\Lestock;


class StockController extends Controller
{    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $stocks = Stock::join('magasins', 'stocks.magasin_id', '=', 'magasins.id')
            ->select('stocks.id', 'magasins.nom', 'stocks.type')
            ->get();

        return view('admin.stock.index', ['stocks' => $stocks]);
    }

    public function create()
    {
        $nv_stock = new Stock();
        $nv_stock->save();

        return redirect('/admin/stock/addup');
    }

    public function addup()
    {
        $magasins = Magasin::all();
        $categorys = Category::all();

        $last_stock = Stock::latest()->first();
        $id = $last_stock->id;

        return view('admin.stock.add', ['magasins' => $magasins, 'categorys' => $categorys, 'id' => $id]);
    }
    public function update_affich($id)
    {
        $stock = Stock::find($id);
        $magasins = Magasin::all();
        $categorys = Category::all();

        return view('admin.stock.update', ['magasins' => $magasins, 'categorys' => $categorys, 'stock' => $stock]);
    }


    public function update(Request $request, $id)
    {
        $stock = Stock::find($id);
        $stock->magasin_id = $request->input('magasin_id');
        $stock->type = $request->input('type');

        $stock->save();

        session()->flash('success');

        return redirect('/admin/stock');
    }

    public function delet_add($id)
    {
        Lestock::where('stock_id', $id)->delete();

        Stock::find($id)->delete();

        session()->flash('error', 'le stock a bien été supprimer ');

        return redirect('/admin/stock');
    }


    public function cat_list($id)
    {
        $cat_list = Lestock::join('categories', 'lestocks.categorie_id', '=', 'categories.id')
            ->select(
                'lestocks.stock_id as stock_id',
                'categories.nom as nom',
                'categories.photo as photo'
            )
            ->where('lestocks.stock_id', $id)
            ->get();

        return response()->json(['category_liste' => $cat_list]);


        // $stock_lestocks = Lestock::where('stock_id', $id)->get();
        // return response()->json(['stock_lestocks' => $stock_lestocks]);
    }




    public function addcat($id_stock, $category)
    {
        try {
            $list_cat = Lestock::where('stock_id', $id_stock)
                ->where('categorie_id', $category)
                ->count();

            if ($list_cat > 0) {
                return response()->json(['error' => 'La catégorie existe déjà.'], 400); // Utilisez le code d'erreur HTTP 400 pour les requêtes incorrectes
            }

            $add_cat = new Lestock();
            $add_cat->stock_id = $id_stock;
            $add_cat->categorie_id = $category;
            $add_cat->produit_id = 6; // Assurez-vous que cette valeur est correcte
            $add_cat->save();

            return response()->json(['success' => 'La catégorie a bien été ajoutée.'], 200); // Utilisez le code d'erreur HTTP 200 pour une réussite

        } catch (\Exception $e) {
            \Log::error($e->getMessage()); // Affichez le message d'erreur pour aider au débogage
            return response()->json(['error' => 'Erreur interne du serveur.'], 500); // Utilisez le code d'erreur HTTP 500 pour une erreur interne du serveur
        }
    }
}
