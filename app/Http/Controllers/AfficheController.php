<?php

namespace App\Http\Controllers;



use App\Models\Magasin;
use App\Models\Stock;
use App\Models\Lestock;
use App\Models\Facture;
use App\Models\Vendeur;
use App\Models\Client;
use App\Models\Caisse;
use App\Models\User;
use App\Models\Vente;


use Illuminate\Support\Facades\Auth;
use Psy\Readline\Hoa\Console;


use Carbon\Carbon;

use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGenerator;
use Illuminate\Support\Facades\Log;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class AfficheController extends Controller
{
    public function magasin()
    {
        $magasins = Magasin::all();
        return view('affiche', ['magasins' => $magasins]);
    }

    public function caisse($id)
    {
        $caisses = Caisse::where('id_magasin', $id)->get();

        return view('caisseaffiche', ['caisses' => $caisses]);
    }



    public function lacaisse($id)
    {

        $caisse = Caisse::find($id);

        // L'utilisateur est connecté

        $leuser = User::find(17);
        $IdUser = $leuser->id;
        $Vendeur = Vendeur::where('id_user', $IdUser)->first();
        $IdMagasin = $caisse->id_magasin;
        $IdCaisse = $id;
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

        // $NouvelleFacture = $this->Nouvelle_Facture_Vide($IdMagasin, $IdUser, $IdCaisse);

        $newfacture = new Facture();
        $newfacture->id_user = $IdUser;
        $newfacture->id_magasin = $IdMagasin;
        $newfacture->id_caisse = $IdCaisse;
        $newfacture->id_client = 0;
        $newfacture->code_barres = 00000000;
        $newfacture->save();



        // $LastFacture = $this->Get_Last_Facture($IdMagasin, $IdUser);
        // $LastFacture = Facture::where('id',$newfacture->id)->get();
        // $LastFacture = Facture::latest()->first();

        $LastFacture = Facture::where('id_magasin', $IdMagasin)->where('id_user', $IdUser)->where('total_facture', '=', 0)
            ->orderBy('id', 'desc')
            ->first();
        if (!$LastFacture) {
            $NewFacture = new Facture();
            $NewFacture->id_user = $IdUser;
            $NewFacture->id_magasin = $IdMagasin;
            $NewFacture->id_caisse = $id;
            $NewFacture->id_client = 0;
            $NewFacture->etat_facture = "en-attente";
            $NewFacture->total_facture = 0;
            $NewFacture->versement = 0;
            $NewFacture->credit = 0;
            //code barres
            do {
                // Générer un nombre de 14 chiffres
                $code = str_pad(mt_rand(1, 99999999999999), 14, '0', STR_PAD_LEFT);
                // Vérifier si ce numéro existe déjà dans la base de données
                $exists = Facture::where('code_barres', $code)->exists();
            } while ($exists);
            $NewFacture->code_barres = $code;
            $NewFacture->save();
        } else {
            $Ventes = Vente::where('id_facture', $LastFacture->id)->delete();
        }

        $LastFacture = Facture::where('id_magasin', $IdMagasin)->where('id_user', $IdUser)
            ->orderBy('id', 'desc')
            ->first();
    

        $clients = Client::all();

        return view('lacaisse', [
            'categories' => $categories,
            'magasin' => $magasin,
            'produits' => $LesStocks,
            'id_magasin' => $IdMagasin,
            'id_user' => $IdUser,
            'id_caisse' => $IdCaisse,
            'clients' => $clients,
            'lasfacture' => $LastFacture
        ]);



    }
}
