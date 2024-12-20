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
use App\Models\Client;
use App\Models\Caisse;
use App\Models\Creditclient;
use App\Models\AtlVent;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGenerator;
use Illuminate\Support\Facades\Log;

use Barryvdh\DomPDF\Facade\Pdf;

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class VenteController extends Controller
{
    public function newfact()
    {
        $new_facture = new Facture();
        $new_facture->etat_facture = "en-attente";
        $new_facture->total_facture = 0;
        $new_facture->versement = 0;
        $new_facture->credit = 0;
        $new_facture->code_barres = str_pad(mt_rand(1, 99999999999999), 14, '0', STR_PAD_LEFT);
        $new_facture->save();
        // Rediriger vers la méthode fact avec l'ID de la facture
        return redirect()->route('fact', ['id' => $new_facture->id]);
    }
    public function fact($id)
    {
        $facture = Facture::find($id);
        // Vérifier si la facture existe
        if (!$facture) {
            abort(404, "Facture introuvable.");
        }
        $categories = Category::all();
        $produits = Produit::all();
        $atelier = Magasin::where('type', 'Atelier')->get();
        $clients = Client::all();
        $caisses = Caisse::all();
        $listes = AtlVent::where('id_fact', $id)->get();
        return view('admin.vente.new', [
            'categories' => $categories,
            'produits' => $produits,
            'ateliers' => $atelier,
            'clients' => $clients,
            'caisses' => $caisses,
            'facture' => $facture,
            'listes' => $listes
        ]);
    }
    // liste des categorie par atelier
    public function getCategoriesByStock($stockId)
    {
        // Requête SQL avec jointure pour récupérer les catégories et leurs noms
        $categories = Lestock::join('categories as c', 'lestocks.categorie_id', '=', 'c.id') // Jointure avec la table `categories`
            ->select('lestocks.categorie_id as id', 'c.nom as categorie_nom') // Sélectionner les colonnes nécessaires
            ->where('lestocks.stock_id', $stockId) // Filtrer par `stock_id`
            ->groupBy('lestocks.categorie_id', 'c.nom') // Grouper par `categorie_id` et `nom`
            ->get();
        // Retourner les résultats sous forme de JSON
        return response()->json($categories);
    }
    // liste des produits by catetorier
    public function getProduitsByCategorie($categoryId, $type_sId)
    {
        // Récupérer les produits correspondant à la catégorie
        // $produits = Produit::where('categorie_id', $categoryId)->get();
        $produits = Lestock::join('produits as p', 'lestocks.produit_id', '=', 'p.id')
            ->select(
                'lestocks.id as le_stock_id', // Alias pour l.id
                'p.id as id',                // Alias pour p.id
                'p.nom_pr as produit',       // Nom du produit
                'p.prix_vente',              // Prix de vente
                'p.semi_gros'                // Prix semi-gros
            )
            ->where('lestocks.stock_id', $type_sId) // Filtrer par stock_id
            ->where('lestocks.categorie_id', $categoryId) // Filtrer par categorie_id
            ->get();
        // Retourner les produits en JSON
        return response()->json($produits);
    }
    // liste des caisses by magasin 
    public function getcaissesByAtelier($atelierId)
    {
        // Récupérer les caisses correspondant à l'atelier
        $caisses = Caisse::where('id_magasin', $atelierId)->get();
        // Retourner les caisses en JSON
        return response()->json($caisses);
    }
    public function gettypeByAtelier($atelierId)
    {
        // Récupérer les caisses correspondant à l'atelier
        $types = Stock::where('magasin_id', $atelierId)->get();
        // Retourner les caisses en JSON
        return response()->json($types);
    }
    // credet  by client 
    public function getcredetByClient($clientId)
    {
        // Calculer la somme des crédits pour un client
        $credet = CreditClient::where('id_client', $clientId)->sum('credit');
        // Retourner la somme en JSON
        return response()->json($credet);
    }
    public function getPrixById($id)
    {
        $produit = Produit::find($id);
        if (!$produit) {
            // Si le produit n'existe pas, retourner un message d'erreur et un code 404
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }
        // Retourner les différents prix disponibles
        return response()->json([
            'prix_vente' => $produit->prix_vente ?? null,
            'semi_gros' => $produit->semi_gros ?? null, // Assurez-vous que ces colonnes existent
            'gros' => $produit->gros ?? null
        ]);
    }
    // liste des vent by facture 
    public function list_ventes($id_facture)
    {
        // Récupérer les ventes liées à la facture par son ID
        $listes = AtlVent::where('id_fact', $id_facture)->get();
        // Vérifiez si des ventes sont trouvées
        if ($listes->isEmpty()) {
            return response()->json(['message' => 'Aucune vente trouvée pour cette facture.'], 404);
        }
        // Retourner les ventes sous forme de JSON
        return response()->json($listes);
    }
    // ajouter une vente
    public function add_vente(Request $request)
    {
        // Validation des données
        $request->validate([
            'id_fact' => 'required|integer',
            'id_type' => 'required|integer',
            'id_categorie' => 'required|integer',
            'id_produit' => 'required|integer',
            'prix' => 'required|numeric',
            'quantite' => 'required|integer',
            'total' => 'required|numeric',
        ]);
        // Récupération du stock
        $id_stock = Lestock::where('stock_id', $request->id_type)
            ->where('categorie_id', $request->id_categorie)
            ->where('produit_id', $request->id_produit)
            ->first();
        if (!$id_stock) {
            return response()->json(['message' => 'Stock non trouvé'], 404);
        }
        // Récupérer la catégorie et le produit
        $categorie = Category::where('id', $request->id_categorie)->first();
        $produit = Produit::where('id', $request->id_produit)->first();
        if (!$categorie) {
            return response()->json(['message' => 'Catégorie non trouvée'], 404);
        }
        if (!$produit) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }
        // Création de la vente
        $nw_vente = new AtlVent();
        $nw_vente->id_fact = $request->id_fact;
        $nw_vente->id_lestock = $id_stock->id;  // Utilisation de l'ID du stock
        $nw_vente->categorie = $categorie->nom;
        $nw_vente->produit = $produit->nom_pr;
        $nw_vente->PU = $request->prix;
        $nw_vente->Q = $request->quantite;
        $nw_vente->total = $request->total;
        $nw_vente->save();
        return response()->json([
            'message' => 'Produit ajouté avec succès.',
            'success' => 'Facture supprimée avec succès.'
        ]);
        // return response()->json(['message' => 'Produit ajouté avec succès.']);
    }
    public function delet_vente($id)
    {
        try {
            // Trouver la vente par son ID
            $sup_vente = AtlVent::findOrFail($id);

            $sup_vente->delete();

            return response()->json(['message' => 'Vente supprimée avec succès.'], 200);
        } catch (\Exception $e) {
            // Retourner une erreur si la vente n'est pas trouvée ou si une erreur survient
            return response()->json(['message' => 'Erreur lors de la suppression de la vente.'], 500);
        }
    }
    public function total_fact($id_facture)
    {
        $total = AtlVent::where('id_fact', $id_facture)->sum('total');
        return response()->json(['total' => $total]);
    }
    public function valid_vente(Request $request)
    {

        $request->validate([
            'id_fact' => 'required|integer',
            'id_magasin' => 'required|integer',
            'id_caisse' => 'required|integer',
            'id_client' => 'required|integer',
            'id_type_s' => 'nullable|integer',
            'total' => 'required|numeric|min:0',
            'montant' => 'required|numeric|min:0|max:' . $request->input('total'),
            'credet' => 'required|numeric|min:0',
            'livaison' => 'nullable|string',
            'type_vent' => 'nullable|string',
            'id_user' => 'nullable|string',
        ]);

        try {
            // Récupération de la facture à mettre à jour
            $update_fact = Facture::findOrFail($request->id_fact);

            $update_fact->id_user = $request->id_user;
            $update_fact->id_magasin = $request->id_magasin;
            $update_fact->id_caisse = $request->id_caisse;
            $update_fact->id_client = $request->id_client;
            $update_fact->etat_facture = 'Facture-Payée';
            $update_fact->total_facture = $request->total;
            $update_fact->versement = $request->montant;
            $update_fact->credit = $request->credet;
            $update_fact->type_vente = $request->type_vent;
            $update_fact->type_fact = 'a';

            $update_fact->save();

            // $total = floatval($request->total); // Convertir en nombre à virgule flottante
            // $montant = floatval($request->montant); // Convertir en nombre à virgule flottante
            // $credit = $total - $montant; // Calculer le crédit

            $credit = $request->total - $request->montant;

            if ($credit > 0) {
                $nw_credit = new Creditclient();
                $nw_credit->id_client = $request->id_client;
                $nw_credit->id_facture = $request->id_fact;
                $nw_credit->total_facture = $request->total;
                $nw_credit->versement = $request->montant;
                $nw_credit->credit = $credit;
                $nw_credit->etat_credit = 'impayé';
                $nw_credit->save();
            }



            // Récupérer toutes les lignes liées à la facture
            $listes = AtlVent::where('id_fact', $request->id_fact)->get();

            // Vérifier si des lignes existent
            if ($listes->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => "Aucune donnée trouvée pour la facture ID {$request->id_fact}.",
                ], 404);
            }
            foreach ($listes as $liste) {
                $lestock = Lestock::find($liste->id_lestock);
                if ($lestock) {
                    $newQuantity = $lestock->quantity - $liste->Q;

                    $lestock->quantity = $newQuantity;
                    $lestock->save();
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => "L'article ID {$liste->id_lestock} n'existe pas dans le stock.",
                    ], 404);
                }
            }



            // return redirect()->route('Admin_Home')->with('success', 'Facture valide avec succès.');
            return response()->json([
                'success' => true,
                'message' => 'Facture mise à jour avec succès.',
            ]);

        } catch (\Exception $e) {

            \Log::error('Erreur dans la validation de la vente: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue : ' . $e->getMessage(),
            ], 500);

        }
    }

    public function liste_fact()
    {
        $listes = Facture::where('type_fact', 'a')->get();
        $clients = Client::all();
        return view('admin.vente.liste', ['listes' => $listes, 'clients' => $clients]);
    }

    public function details_fact($id)
    {
        $listes = AtlVent::where('id_fact', $id)->get();
        $facture = Facture::find($id);
        $magasins = Magasin::all();
        $clients = Client::all();
        $credits = Creditclient::all();
        return view('admin.vente.details', [
            'listes' => $listes,
            'facture' => $facture,
            'magasins' => $magasins,
            'clients' => $clients,
            'credits' => $credits
        ]);

    }

    // Partie de récupération des données conservée
    public function imprimer_facteur($id)
    {
        $user = Auth::user();
        $date = date('d-m-Y'); // Remplacer les barres obliques par des tirets
    
        $facture = Facture::find($id);
    
        if (!$facture) {
            return response()->json(['error' => 'Facture introuvable'], 404);
        }
    
        $listes = AtlVent::where('id_fact', $id)->get();
        $magasins = Magasin::all();
        $clients = Client::all();
        $credits = Creditclient::all();
        $informations = Information::first(); // Utiliser `first()` au lieu de `all()->first()` pour optimiser
    
        $id_client = $facture->id_client;
        $le_client = Client::find($id_client);
    
        if (!$le_client) {
            return response()->json(['error' => 'Client introuvable'], 404);
        }
    
        $lenom = $le_client->nom_prenom;
        $code_facture = $facture->code_facture;
    
        $data = [
            'listes' => $listes,
            'facture' => $facture,
            'magasins' => $magasins,
            'clients' => $clients,
            'credits' => $credits,
            'informations' => $informations,
            'date' => $date,
        ];
    
        // Génération du PDF
        try {
            $pdf = PDF::loadView('admin.vente.facture', $data)
                ->setPaper('A4', 'portrait'); // Format A4 et orientation portrait
    
            // Réponse avec le PDF pour affichage dans le navigateur
            return response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="facture_' . $lenom . '_facture_' . $code_facture . '_' . $date . '.pdf"',
            ]);
        } catch (\Exception $e) {
            // Gestion des erreurs
            Log::error('Erreur lors de la génération du PDF : ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la génération du PDF : ' . $e->getMessage()], 500);
        }
    }
    

    public function annuler_fact($id)
    {
        // Suppression des enregistrements dans la table AtlVent
        AtlVent::where('id_fact', $id)->delete();
        // Suppression de la facture
        Facture::where('id', $id)->delete();
        // Ajout d'un message flash et redirection
        return redirect()->route('Admin_Home')->with('success', 'Facture supprimée avec succès.');
    }
    public function livr_total($id_facture)
    {
        $total = AtlVent::where('id_fact', $id_facture)->sum('Q');
        return response()->json(['total' => $total]);
    }

}
