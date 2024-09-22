<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Information;
use App\Models\Category;
use App\Models\Produit;
use App\Models\Magasin;
use App\Models\Stock;
use App\Models\Lestock;
use App\Models\Facture;
use App\Models\Vente;
use App\Models\Vendeur;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Psy\Readline\Hoa\Console;

class CaisseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function caisse()
    {
        $categorys = Category::all();
        $produits = Produit::all();
        $informtions = Information::first();

        return view('caisse.test', ['categorys' => $categorys, 'informations' => $informtions, 'produits' => $produits]);
    }
    public function caisse_paccino()
    {
        // Vérifier si un utilisateur est connecté
        if (Auth::check()) {
            // L'utilisateur est connecté
            $IdUser = Auth::id();
            $Vendeur = Vendeur::where('id_user', $IdUser)->first();
            $IdMagasin = $Vendeur->id_magasin;
            $IdCaisse = $Vendeur->id_caisse;
            $magasin = Magasin::find($IdMagasin);
            $StocksFrai = Stock::where('magasin_id', $IdMagasin)->where('type', '=', 'Frais')->first();
            $IdStock = $StocksFrai->id;
            $LesStocks = Lestock::where('stock_id', $IdStock)->get();
            // hadi tafichi man stock magasin 
            $categories = Lestock::where('stock_id', $IdStock)
                ->join('categories', 'categories.id', '=', 'lestocks.categorie_id')
                ->select(
                    DB::raw('MIN(lestocks.id) as id_lestock'),  // Obtenir la valeur minimum de id_lestock
                    'lestocks.categorie_id as id',               // Grouper par categorie_id (alias id)
                    DB::raw('MIN(categories.nom) as nom'),       // Utiliser MIN() ou MAX() pour les autres colonnes
                    DB::raw('MIN(categories.photo) as photo')
                )
                ->groupBy('id')  // Grouper par categorie_id (alias id)
                ->get();

            $NouvelleFacture = $this->Nouvelle_Facture_Vide($IdMagasin, $IdUser, $IdCaisse);
            // $LastFacture = $this->Get_Last_Facture($IdMagasin, $IdUser);

            return view('caisse.paccino', [
                'categories' => $categories,
                'magasin' => $magasin,
                'produits' => $LesStocks,
                'id_magasin' => $IdMagasin,
                'id_user' => $IdUser,
                'id_caisse' => $IdCaisse
            ]);
        } else {
            return "Utilisateur non connecté";
        }
    }

    public function filtrage_des_produits($id)
    {
        try {
            $IdUser = Auth::id();
            if (!$IdUser) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $Vendeur = Vendeur::where('id_user', $IdUser)->first();
            if (!$Vendeur) {
                return response()->json(['error' => 'Vendeur not found'], 404);
            }
            $IdMagasin = $Vendeur->id_magasin;

            \Log::info('user_id:' . $IdUser);
            \Log::info('magasin_id:' . $IdMagasin);

            $StocksFrai = Stock::where('magasin_id', $IdMagasin)->where('type', '=', 'Frais')->first();
            if (!$StocksFrai) {
                return response()->json(['error' => 'Stock not found'], 404);
            }
            $IdStock = $StocksFrai->id;

            \Log::info('stock_id:' . $IdStock);

            $CategoryId = $id;


            $produits = Lestock::join('produits', 'produits.id', '=', 'lestocks.produit_id')
                ->select(
                    'lestocks.id as id',
                    'lestocks.produit_id as id_produit',
                    'produits.nom_pr as nom',
                    'produits.photo_pr as photo',
                    'produits.prix_vent as prix'
                )
                ->where('lestocks.stock_id', $IdStock)->where('lestocks.categorie_id', $CategoryId)
                ->get();

            if ($produits->isEmpty()) {
                return response()->json(['message' => 'No products found'], 404);
            }

            return response()->json(['produits' => $produits]);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }






    //
    /// factures 
    //

    public function Nouvelle_Facture_Vide($id_magasin, $id_user, $id_caisse)
    {
        $NewFacture = new Facture();
        $NewFacture->id_user = $id_user;
        $NewFacture->id_magasin = $id_magasin;
        $NewFacture->id_caisse = $id_caisse;
        $NewFacture->id_client = 0;
        $NewFacture->etat_facture = "en-attente";
        $NewFacture->total_facture = 0;
        $NewFacture->versement = 0;
        $NewFacture->credit = 0;
        $NewFacture->save();
    }

    public function Get_Last_Facture($id_magasin, $id_user)
    {
        $LastFacture = Facture::where('id_magasin', $id_magasin)->where('id_user', $id_user)
            ->orderBy('id', 'desc')
            ->first();
        return $LastFacture;
    }



    public function Nouvelle_Vente($id_facture,$id_user,$id_lestock,$id_produit,$prix_unitaire,$qte,$prix_total)
    {
        try {
            $NewVente = new Vente();
            $NewVente->id_facture = $id_facture;
            $NewVente->id_user = $id_user;
            $NewVente->id_lestock = $id_lestock;
            $NewVente->id_produit = $id_produit;
            $NewVente->prix_unitaire = $prix_unitaire;
            $NewVente->quantite = $qte;
            $NewVente->total_vente = $prix_total;
            // calculer le benefice ici
            $NewVente->benefice = 0;
            $NewVente->save();
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['error' => 'controller-function: Nouvelle_Vente ! erreur'], 500);
        }
    }

    public function Get_Liste_Ventes($id_facture)
    {
        try {
            $ventes = Vente::join('produits', 'produits.id', '=', 'ventes.id_produit')
                ->select(
                    'ventes.id as id',
                    'produits.nom_pr as nom_produit',
                    'ventes.prix_unitaire as prix_produit',
                    'ventes.quantite as quantite',
                    'ventes.total_vente as prix_total'
                )
                ->where('id_facture', $id_facture)
                ->get();

            return response()->json(['ventes' => $ventes]);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['error' => 'controller-function: Get_Liste_Ventes ! erreur'], 500);
        }
    }

    public function Total_Facture($id_facture)
    {
        try {
            // Calculer la somme directement sans utiliser get() après sum()
            $total = Vente::where('id_facture', $id_facture)->sum('total_vente');
            
            return response()->json(['total' => $total]);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['error' => 'controller-function: Total_Facture ! erreur'], 500);
        }
    }

    public function Create_Facture($id_user,$id_magasin,$id_caisse)
    {
        try {
            $NouvelleFacture = $this->Nouvelle_Facture_Vide($id_magasin, $id_user, $id_caisse);
            $LastFacture = $this->Get_Last_Facture($id_magasin, $id_user);
            $LastFactureId = $LastFacture->id;
            return response()->json(['LastFactureId' => $LastFactureId]);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['error' => 'controller-function: Create_Facture ! erreur'], 500);
        }
    }
    
}
