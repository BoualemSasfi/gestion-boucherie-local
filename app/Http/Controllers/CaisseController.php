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
use App\Models\Versement;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Psy\Readline\Hoa\Console;

use Carbon\Carbon;

use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGenerator;
use Illuminate\Support\Facades\Log;

use Barryvdh\DomPDF\Facade\Pdf;

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use PhpParser\Node\Expr\New_;
use TCPDF;





class CaisseController extends Controller
{


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
                    DB::raw('MIN(categories.photo) as photo'),
                    'categories.nombre as nombre'
                )
                ->groupBy('id')  // Grouper par categorie_id (alias id)
                ->orderBy('categories.nombre','ASC')
                ->get();

            $NouvelleFacture = $this->Nouvelle_Facture_Vide($IdMagasin, $IdUser, $IdCaisse);
            // $LastFacture = $this->Get_Last_Facture($IdMagasin, $IdUser);

            $clients = Client::all();

            return view('caisse.paccino', [
                'categories' => $categories,
                'magasin' => $magasin,
                'produits' => $LesStocks,
                'id_magasin' => $IdMagasin,
                'id_user' => $IdUser,
                'id_caisse' => $IdCaisse,
                'clients' => $clients
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

            Log::info('user_id:' . $IdUser);
            Log::info('magasin_id:' . $IdMagasin);

            $StocksFrai = Stock::where('magasin_id', $IdMagasin)->where('type', '=', 'Frais')->first();
            if (!$StocksFrai) {
                return response()->json(['error' => 'Stock not found'], 404);
            }
            $IdStock = $StocksFrai->id;

            Log::info('stock_id:' . $IdStock);

            $CategoryId = $id;


            $produits = Lestock::join('produits', 'produits.id', '=', 'lestocks.produit_id')
                ->select(
                    'lestocks.id as id',
                    'lestocks.produit_id as id_produit',
                    'produits.nom_pr as nom',
                    'produits.photo_pr as photo',
                    'produits.prix_vente as prix',
                    'produits.unite_mesure as mesure',
                    'produits.nombre as nombre'
                )
                ->where('lestocks.stock_id', $IdStock)->where('lestocks.categorie_id', $CategoryId)
                ->orderby('nombre','ASC')
                ->get();

            if ($produits->isEmpty()) {
                return response()->json(['message' => 'No products found'], 404);
            }

            return response()->json(['produits' => $produits]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    public function filtrage_des_produits_libre($id_categorie, $id_user, $id_magasin)
    {
        try {
            $IdMagasin = $id_magasin;

            Log::info('user_id:' . $id_user);
            Log::info('magasin_id:' . $IdMagasin);

            // Recherche du stock de type "Frais"
            $StocksFrai = Stock::where('magasin_id', $IdMagasin)->where('type', '=', 'Frais')->first();
            if (!$StocksFrai) {
                return response()->json(['error' => 'Stock not found'], 404);
            }

            $IdStock = $StocksFrai->id;
            Log::info('stock_id:' . $IdStock);

            $produits = Lestock::join('produits', 'produits.id', '=', 'lestocks.produit_id')
                ->select(
                    'lestocks.id as id',
                    'lestocks.produit_id as id_produit',
                    'produits.nom_pr as nom',
                    'produits.photo_pr as photo',
                    'produits.prix_vente as prix_detail',
                    'produits.semi_gros as prix_semigros',
                    'produits.gros as prix_gros',
                    'produits.unite_mesure as mesure',
                    'produits.nombre as nombre'
                )
                ->where('lestocks.stock_id', $IdStock)
                ->where('lestocks.categorie_id', $id_categorie)
                ->orderby('nombre','ASC')
                ->get();

            if ($produits->isEmpty()) {
                return response()->json(['message' => 'No products found'], 404);
            }

            return response()->json(['produits' => $produits]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    public function filtrage_des_sous_produits_libre($id_produit, $id_user, $id_magasin)
    {
        try {
            $IdMagasin = $id_magasin;

            Log::info('user_id:' . $id_user);
            Log::info('magasin_id:' . $IdMagasin);

            // Recherche du stock de type "Frais"
            $StocksFrai = Stock::where('magasin_id', $IdMagasin)->where('type', '=', 'Frais')->first();
            if (!$StocksFrai) {
                return response()->json(['error' => 'Stock not found'], 404);
            }

            $IdStock = $StocksFrai->id;
            Log::info('stock_id:' . $IdStock);

            $sousproduits = Lestock::join('produits', 'produits.id', '=', 'lestocks.produit_id')
                ->join('sousproduits', 'sousproduits.id_pr', '=', 'produits.id')
                ->select(
                    'lestocks.id as id',
                    'lestocks.produit_id as id_produit',
                    'sousproduits.nom_s_pr as nom',
                    'sousproduits.photo_s_pr as photo',
                    'sousproduits.prix_vente as prix_detail',
                    'sousproduits.prix_semi_gros as prix_semigros',
                    'sousproduits.prix_gros as prix_gros',
                    'sousproduits.unite_mesure as mesure'
                )
                ->where('lestocks.stock_id', $IdStock)
                ->where('lestocks.produit_id', $id_produit)
                ->get();

            $leproduit = Lestock::join('produits', 'produits.id', '=', 'lestocks.produit_id')
                ->select(
                    'lestocks.id as id',
                    'lestocks.produit_id as id_produit',
                    'produits.nom_pr as nom',
                    'produits.photo_pr as photo',
                    'produits.prix_vente as prix_detail',
                    'produits.semi_gros as prix_semigros',
                    'produits.gros as prix_gros',
                    'produits.unite_mesure as mesure'
                )
                ->where('lestocks.produit_id', $id_produit)
                ->where('lestocks.stock_id', $IdStock)
                ->first();

            if ($sousproduits->isEmpty()) {
                return response()->json(['message' => 'No products found'], 404);
            }

            return response()->json(['sousproduits' => $sousproduits, 'produit' => $leproduit]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }





    //
    /// factures 
    //

    public function Nouvelle_Facture_Vide($id_magasin, $id_user, $id_caisse)
    {
        $LastFacture = Facture::where('id_magasin', '=', $id_magasin)->where('id_user', '=', $id_user)->where('id_caisse', '=', $id_caisse)->where('total_facture', '=', 0)
            ->orderBy('id', 'desc')
            ->first();
        if (!$LastFacture) {
            $NewFacture = new Facture();
            $NewFacture->id_user = $id_user;
            $NewFacture->id_magasin = $id_magasin;
            $NewFacture->id_caisse = $id_caisse;
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
    }

    public function Get_Last_Facture($id_magasin, $id_user, $id_caisse)
    {
        $LastFacture = Facture::where('id_magasin', $id_magasin)->where('id_user', $id_user)->where('id_caisse', $id_caisse)
            ->where('total_facture', '=', 0)
            ->first();
        return $LastFacture;
    }



    public function Nouvelle_Vente($id_facture, $id_user, $id_lestock, $id_produit, $id_sousproduit, $nom_produit, $prix_unitaire, $qte, $prix_total)
    {
        try {
            $NewVente = new Vente();
            $NewVente->id_facture = $id_facture;
            $NewVente->id_user = $id_user;
            $NewVente->id_lestock = $id_lestock;
            $NewVente->id_produit = $id_produit;
            if ($id_sousproduit !== '0') {
                $NewVente->id_sousproduit = $id_sousproduit;
                $NewVente->produit = false;
                $NewVente->sous_produit = true;
            } else {
                $NewVente->produit = true;
                $NewVente->sous_produit = false;
            }
            $NewVente->designation_produit = $nom_produit;
            $NewVente->prix_unitaire = $prix_unitaire;
            $NewVente->quantite = $qte;
            $NewVente->total_vente = $prix_total;

            // calculer le benefice 
            $benefice = 0;
            $Produit = Produit::find($id_produit);
            if ($Produit) {
                $prix_achat = $Produit->prix_achat;
                $prix_vente = $Produit->prix_vente;
                $benefice = ($prix_vente - $prix_achat) * $qte;
                $mesure = $Produit->unite_mesure;
            }

            $NewVente->benefice = $benefice;
            $NewVente->unite_mesure = $mesure;
            $NewVente->save();
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'controller-function: Nouvelle_Vente ! erreur'], 500);
        }
    }

    public function Get_Liste_Ventes($id_facture)
    {
        try {
            $ventes = Vente::where('id_facture', $id_facture)
                ->select(
                    'id',
                    'designation_produit',
                    'prix_unitaire',
                    'quantite',
                    'total_vente',
                    'unite_mesure'
                )
                ->get();

            // // Vérification si des ventes existent pour cette facture
            // if ($ventes->isEmpty()) {
            //     return response()->json(['message' => 'Aucune vente trouvée pour cette facture'], 404);
            // }

            // Retour des ventes au format JSON
            return response()->json(['ventes' => $ventes], 200);
        } catch (\Exception $e) {
            // Enregistrement de l'erreur dans les logs
            Log::error('Erreur dans Get_Liste_Ventes : ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            // Retour d'une réponse JSON avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la récupération des ventes'], 500);
        }
    }


    public function Total_Facture($id_facture)
    {
        try {
            // Calculer la somme directement sans utiliser get() après sum()
            $total = Vente::where('id_facture', $id_facture)->sum('total_vente');

            return response()->json(['total' => $total]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'controller-function: Total_Facture ! erreur'], 500);
        }
    }


    public function Supprimer_Vente($id_vente)
    {
        try {
            $Vente = Vente::where('id', $id_vente)
                ->delete();
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'controller-function: Supprimer_Vente ! erreur'], 500);
        }
    }

    public function Create_Facture($id_user, $id_magasin, $id_caisse)
    {
        try {
            $NouvelleFacture = $this->Nouvelle_Facture_Vide($id_magasin, $id_user, $id_caisse);

            $LastFacture = $this->Get_Last_Facture($id_magasin, $id_user, $id_caisse);
            $LastFactureId = $LastFacture->id;
            return response()->json(['LastFactureId' => $LastFactureId]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'controller-function: Create_Facture ! erreur'], 500);
        }
    }






    public function Valider_Facture($id_user, $id_facture, $id_caisse, $id_client, $type_vente, $total, $versement, $credit, $etat)
    {
        try {
            $Facture = Facture::find($id_facture);

            if ($Facture) {
                // Mise à jour des informations de la facture
                $Facture->id_user = $id_user;
                $Facture->id_caisse = $id_caisse;
                $Facture->id_client = $id_client;
                $Facture->etat_facture = $etat;
                $Facture->total_facture = $total;
                $Facture->versement = $versement;
                $Facture->credit = $credit;
                if ($type_vente == 'details') {
                    $Facture->type_vente = 'Vente en détails';
                }
                if ($type_vente == 'semigros') {
                    $Facture->type_vente = 'Vente en semi-gros';
                }
                if ($type_vente == 'gros') {
                    $Facture->type_vente = 'Vente en gros';
                }
                $Facture->save();

                if ($credit > 0) {
                    $nvCredit = new Creditclient();
                    $nvCredit->id_client = $id_client;
                    $nvCredit->id_facture = $id_facture;
                    $nvCredit->total_facture = $total;
                    $nvCredit->versement = $versement;
                    $nvCredit->credit = $credit;
                    $nvCredit->save();
                }

                $Caisse = Caisse::find($id_caisse);

                // ajouter l'argent à la caisse 
                if ($Caisse) {
                    $Ancien_Solde = $Caisse->solde;
                    $Nouveau_Solde = $Ancien_Solde + $versement;
                    $Caisse->solde = $Nouveau_Solde;
                    $Caisse->save();
                }


                // Appeler la méthode 'ImprimerTicket'
                // $this->ImprimerTicket($Facture);

                $Ventes = Vente::where('id_facture', $Facture->id)->get();

                if ($Ventes) {
                    // gérer le stock magasin apres la vente 
                    foreach ($Ventes as $Vente) {
                        $id_lestock = $Vente->id_lestock;
                        $Quantite_vente = $Vente->quantite;
                        $LeStock = Lestock::find($id_lestock);
                        if ($LeStock) {
                            $Ancienne_Quantite = $LeStock->quantity;
                            $Nouvelle_Quantite = $Ancienne_Quantite - $Quantite_vente;
                            $LeStock->quantity = $Nouvelle_Quantite;
                            $LeStock->save();
                        }
                    }
                }
            } else {
                return response()->json(['error' => 'Facture non trouvée'], 404);
            }
        } catch (\Exception $e) {
            Log::error($e); // Log de l'erreur pour le débogage
            return response()->json(['error' => 'Erreur dans la fonction Valider_Facture'], 500);
        }
    }



    public function En_Attente_Facture($id_facture, $total)
    {
        try {
            // Recherche la facture par son ID
            $Facture = Facture::find($id_facture);

            // Vérifie si la facture existe
            if ($Facture) {

                $Facture->total_facture = $total;

                $Facture->save(); // Enregistre les modifications

            } else {
                // Gérer le cas où la facture n'existe pas, par exemple, en retournant une erreur
                return response()->json(['error' => 'Facture non trouvée'], 404);
            }
            
            $nombre_facture = Facture::where('etat_facture', '=' ,'en-attente')->where('total_facture', '!=', 0)->count();
            return response()->json(['numero' => $nombre_facture]);
            
            // return response()->json('success');
        } catch (\Exception $e) {
            Log::error($e); // Log de l'erreur pour le débogage
            return response()->json(['error' => 'Erreur dans la fonction En_Attente_Facture'], 500); // Retourne une erreur générique
        }
    }


    // public function test_pdf()
    // {

    //     $Facture = Facture::find(770);
    //     $code = $Facture->code_barres;

    //     // Chemin pour sauvegarder le code-barres
    //     $barcodePath = public_path('barcode.png'); // Changez en 'storage/barcode.png' si nécessaire

    //     // Créer une instance du générateur de code-barres
    //     $generator = new BarcodeGeneratorPNG();

    //     // Configurer les dimensions
    //     $widthFactor = 1; // Ajuste le facteur de largeur si nécessaire
    //     $height = 50;
    //     $type = BarcodeGenerator::TYPE_CODE_39; // Type de code-barres

    //     // Le code à encoder

    //     try {
    //         // Générer le code-barres et l'enregistrer dans le fichier
    //         $barcodeImage = $generator->getBarcode($code, $type, $widthFactor, $height);

    //         // Écrire l'image dans le fichier
    //         file_put_contents($barcodePath, $barcodeImage);

    //         Log::info('Code-barres généré avec succès à l\'emplacement : ' . $barcodePath);

    //         // return response()->json(['success' => 'Code-barres généré avec succès', 'path' => $barcodePath], 200);
    //     } catch (\Exception $e) {
    //         Log::error('Erreur lors de la génération du code-barres : ' . $e->getMessage());
    //         return response()->json(['error' => 'Erreur lors de la génération du code-barres : ' . $e->getMessage()], 500);
    //     }


    //     $Informtions = Information::first();
    //     $Ventes = Vente::join('produits', 'produits.id', '=', 'ventes.id_produit')
    //         ->join('categories', 'categories.id', '=', 'produits.categorie_id')
    //         ->select(
    //             'ventes.id as id',
    //             'categories.nom as nom_categorie',
    //             'produits.nom_pr as nom_produit',
    //             'ventes.prix_unitaire as prix_produit',
    //             'ventes.quantite as quantite',
    //             'ventes.total_vente as prix_total',
    //             'ventes.unite_mesure as unite_mesure'
    //         )
    //         ->where('id_facture', $Facture->id)
    //         ->get();

    //     $Client = Facture::join('clients', 'clients.id', '=', 'factures.id_client')
    //         ->select('clients.nom_prenom as nom',)
    //         ->where('factures.id', $Facture->id)
    //         ->first();

    //     $Vendeur = Facture::join('users', 'users.id', '=', 'factures.id_user')
    //         ->select('users.name as nom')
    //         ->where('factures.id', $Facture->id)
    //         ->first();

    //     $data = [
    //         'num_facture' => $Facture->id,
    //         'date_facture' => $Facture->created_at,
    //         'etat_facture' => $Facture->etat_facture,
    //         'magasin' => $Facture->id_magasin,
    //         'caisse' => $Facture->id_caisse,
    //         'total' => $Facture->total_facture,
    //         'versement' => $Facture->versement,
    //         'credit' => $Facture->credit,
    //         'ventes' => $Ventes,
    //         'client' => $Client->nom ?? 'Inconnu',
    //         'vendeur' => $Vendeur->nom ?? 'Inconnu',
    //         'informations' => $Informtions,
    //         'barcodePath' => $barcodePath,
    //         'code_barres_facture' => $Facture->code_barres,
    //     ];

    //     try {
    //         $titre = 'facture_vente_' . $Facture->id;
    //         // Définir les dimensions de ticket de caisse (80 mm de large et 200 mm de haut)
    //         $pdf = Pdf::loadView('caisse.ticket', $data)->setPaper([0, 0, 226.77, 566.93], 'portrait'); // 80 mm x 200 mm en points (1 mm = 2.83 points)
    //         // $pdf = Pdf::loadView('caisse.ticket', $data)->setPaper([0, 0, 500, 800], 'portrait'); // 80 mm x 200 mm en points (1 mm = 2.83 points)
    //         return $pdf->stream($titre . '.pdf', ['Attachment' => false]);
    //     } catch (\Exception $e) {
    //         Log::error('Erreur lors de la génération du PDF : ' . $e->getMessage());
    //         return response()->json(['error' => 'Erreur lors de la génération du PDF'], 500);
    //     }
    // }





    public function ImprimerTicket($id_facture)
    {


        $Facture = Facture::find($id_facture);

        $code = $Facture->code_barres; // Assurez-vous que le code est une chaîne de caractères

        // Chemin pour sauvegarder le code-barres
        $barcodePath = public_path('barcode.png'); // Changez en 'storage/barcode.png' si nécessaire

        // Créer une instance du générateur de code-barres
        $generator = new BarcodeGeneratorPNG();

        // Configurer les dimensions
        $widthFactor = 1; // Ajuste le facteur de largeur si nécessaire
        $height = 50;
        $type = BarcodeGenerator::TYPE_CODE_39; // Type de code-barres

        // Le code à encoder

        try {
            // Générer le code-barres et l'enregistrer dans le fichier
            $barcodeImage = $generator->getBarcode($code, $type, $widthFactor, $height);

            // Écrire l'image dans le fichier
            file_put_contents($barcodePath, $barcodeImage);

            Log::info('Code-barres généré avec succès à l\'emplacement : ' . $barcodePath);

            // return response()->json(['success' => 'Code-barres généré avec succès', 'path' => $barcodePath], 200);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la génération du code-barres : ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la génération du code-barres : ' . $e->getMessage()], 500);
        }

        $Informtions = Information::first();
        $Ventes = Vente::where('id_facture', $id_facture)
            ->select(
                'ventes.id as id',
                'ventes.designation_produit as nom_produit',
                'ventes.prix_unitaire as prix_produit',
                'ventes.quantite as quantite',
                'ventes.total_vente as prix_total',
                'ventes.unite_mesure as unite_mesure'
            )
            ->get();

        // Calculer le nombre de lignes
        $nombreDeLignes = $Ventes->count();


        $Client = Facture::join('clients', 'clients.id', '=', 'factures.id_client')
            ->select('clients.nom_prenom as nom', 'clients.id as id_client') // Sélectionnez aussi l'ID
            ->where('factures.id', $Facture->id)
            ->first();

        if ($Client) {
            $id_client = $Client->id_client;

            // Calculer la somme des crédits pour le client
            // $credit_client = Creditclient::where('id_client', $id_client)->sum('credit');
            // Récupérer les crédits et versements pour le client
            $credit_client = Client::leftJoin('creditclients', 'clients.id', '=', 'creditclients.id_client')
                ->leftJoin('versements', 'clients.id', '=', 'versements.id_client')
                ->select(
                    'clients.id as id',
                    'clients.nom_prenom as nom',
                    'clients.adresse as adresse',
                    'clients.details as details',
                    'clients.fix as tel_fix',
                    'clients.ooredoo as tel_ooredoo',
                    'clients.mobilis as tel_mobilis',
                    'clients.djezzy as tel_djezzy',
                    DB::raw('(SELECT IFNULL(SUM(credit), 0) FROM creditclients WHERE creditclients.id_client = clients.id) - (SELECT IFNULL(SUM(montant), 0) FROM versements WHERE versements.id_client = clients.id) as total_credit')
                )
                ->where('clients.id', $id_client)
                ->first();
        } else {
            $credit_client = 0; // Aucun client trouvé, donc crédit = 0
        }


        $Vendeur = Facture::join('users', 'users.id', '=', 'factures.id_user')
            ->select('users.name as nom')
            ->where('factures.id', $Facture->id)
            ->first();

        $id_magasin = $Facture->id_magasin;
        $Magasin = Magasin::find($id_magasin);

        $date_facture = $Facture->updated_at ? $Facture->updated_at : $Facture->created_at;

        $data = [
            'num_facture' => $Facture->id,
            'date_facture' => $date_facture,
            'etat_facture' => $Facture->etat_facture,
            'magasin' => $Facture->id_magasin,
            'caisse' => $Facture->id_caisse,
            'total' => $Facture->total_facture,
            'versement' => $Facture->versement,
            'credit' => $Facture->credit,
            'credit_client' => $credit_client->total_credit,
            'type_vente' => $Facture->type_vente,
            'ventes' => $Ventes,
            'nombre' => $nombreDeLignes,

            'client' => $Client->nom ?? 'Inconnu',
            'vendeur' => $Vendeur->nom ?? 'Inconnu',
            'informations' => $Informtions,
            'magasin' => $Magasin,
            'barcodePath' => $barcodePath,
            'code_barres_facture' => $Facture->code_barres,
        ];

        try {
            $titre = 'facture_vente_' . $Facture->id;
            // Définir les dimensions de ticket de caisse (80 mm de large et 200 mm de haut)
            $pdf = Pdf::loadView('caisse.ticket', $data)->setPaper([0, 0, 226.77, 566.93], 'portrait'); // 80 mm x 200 mm en points (1 mm = 2.83 points)
            // $pdf = Pdf::loadView('caisse.ticket', $data)->setPaper([0, 0, 500, 800], 'portrait'); // 80 mm x 200 mm en points (1 mm = 2.83 points)
            return $pdf->stream($titre . '.pdf', ['Attachment' => false]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la génération du PDF : ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la génération du PDF'], 500);
        }
    }



    public function ImprimerTicketCredit($id_facture)
    {

        $Facture = Facture::find($id_facture);

        $code = $Facture->code_barres; // Assurez-vous que le code est une chaîne de caractères

        // Chemin pour sauvegarder le code-barres
        $barcodePath = public_path('barcode.png'); // Changez en 'storage/barcode.png' si nécessaire

        // Créer une instance du générateur de code-barres
        $generator = new BarcodeGeneratorPNG();

        // Configurer les dimensions
        $widthFactor = 1; // Ajuste le facteur de largeur si nécessaire
        $height = 50;
        $type = BarcodeGenerator::TYPE_CODE_39; // Type de code-barres

        // Le code à encoder

        try {
            // Générer le code-barres et l'enregistrer dans le fichier
            $barcodeImage = $generator->getBarcode($code, $type, $widthFactor, $height);

            // Écrire l'image dans le fichier
            file_put_contents($barcodePath, $barcodeImage);

            Log::info('Code-barres généré avec succès à l\'emplacement : ' . $barcodePath);

            // return response()->json(['success' => 'Code-barres généré avec succès', 'path' => $barcodePath], 200);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la génération du code-barres : ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la génération du code-barres : ' . $e->getMessage()], 500);
        }

        $Informtions = Information::first();

        $Ventes = Vente::where('id_facture', $id_facture)
            ->select(
                'ventes.id as id',
                'ventes.designation_produit as nom_produit',
                'ventes.prix_unitaire as prix_produit',
                'ventes.quantite as quantite',
                'ventes.total_vente as prix_total',
                'ventes.unite_mesure as unite_mesure'
            )
            ->get();

        // Calculer le nombre de lignes
        $nombreDeLignes = $Ventes->count();

        $Client = Facture::join('clients', 'clients.id', '=', 'factures.id_client')
            ->select('clients.nom_prenom as nom', 'clients.id as id_client') // Sélectionnez aussi l'ID
            ->where('factures.id', $Facture->id)
            ->first();

        if ($Client) {
            $id_client = $Client->id_client;

            // Calculer la somme des crédits pour le client
            // $credit_client = Creditclient::where('id_client', $id_client)->sum('credit');
            // Récupérer les crédits et versements pour le client
            $credit_client = Client::leftJoin('creditclients', 'clients.id', '=', 'creditclients.id_client')
                ->leftJoin('versements', 'clients.id', '=', 'versements.id_client')
                ->select(
                    'clients.id as id',
                    'clients.nom_prenom as nom',
                    'clients.adresse as adresse',
                    'clients.details as details',
                    'clients.fix as tel_fix',
                    'clients.ooredoo as tel_ooredoo',
                    'clients.mobilis as tel_mobilis',
                    'clients.djezzy as tel_djezzy',
                    DB::raw('(SELECT IFNULL(SUM(credit), 0) FROM creditclients WHERE creditclients.id_client = clients.id) - (SELECT IFNULL(SUM(montant), 0) FROM versements WHERE versements.id_client = clients.id) as total_credit')
                )
                ->where('clients.id', $id_client)
                ->first();
        } else {
            $credit_client = 0; // Aucun client trouvé, donc crédit = 0
        }

        $Vendeur = Facture::join('users', 'users.id', '=', 'factures.id_user')
            ->select('users.name as nom')
            ->where('factures.id', $id_facture)
            ->first();

        $id_magasin = $Facture->id_magasin;
        $Magasin = Magasin::find($id_magasin);

        $date_facture = $Facture->updated_at ? $Facture->updated_at : $Facture->created_at;

        $data = [
            'num_facture' => $id_facture,
            'date_facture' => $date_facture,
            'etat_facture' => $Facture->etat_facture,
            'magasin' => $Facture->id_magasin,
            'caisse' => $Facture->id_caisse,
            'total' => $Facture->total_facture,
            'versement' => $Facture->versement,
            'credit' => $Facture->credit,
            'credit_client' => $credit_client->total_credit,
            'type_vente' => $Facture->type_vente,
            'ventes' => $Ventes,
            'nombre' => $nombreDeLignes,

            'client' => $Client->nom ?? 'Inconnu',
            'vendeur' => $Vendeur->nom ?? 'Inconnu',
            'informations' => $Informtions,
            'magasin' => $Magasin,
            'barcodePath' => $barcodePath,
            'code_barres_facture' => $Facture->code_barres,
        ];

        try {
            $titre = 'facture_vente_' . $id_facture;

            // Generate PDF for the client
            $pdfClient = Pdf::loadView('caisse.ticket', $data)->setPaper([0, 0, 226.77, 566.93], 'portrait');

            // If credit, generate an additional PDF for archive
            if ($Facture->etat_facture == 'Crédit') {
                // Archive copy (optional: modify content to include "Archive Copy")
                $data['archive'] = true; // Pass an extra variable for archive
                $pdfArchive = Pdf::loadView('caisse.ticket', $data)->setPaper([0, 0, 226.77, 566.93], 'portrait');

                // Stream or save both PDFs
                return $pdfClient->stream($titre . '_client.pdf', ['Attachment' => false])
                    ->with($pdfArchive->stream($titre . '_archive.pdf', ['Attachment' => false]));
            } else {
                // Stream the client ticket
                return $pdfClient->stream($titre . '.pdf', ['Attachment' => false]);
            }
        } catch (\Exception $e) {
            Log::error('Erreur lors de la génération du PDF : ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la génération du PDF'], 500);
        }
    }


    public function Liste_Factures_Enattente($id_magasin)
    {
        try {

            $Factures = Facture::where('id_magasin', $id_magasin)->where('etat_facture', '=', 'en-attente')
                ->where('total_facture', '!=', 0)->get();

            return response()->json(['factures' => $Factures]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    public function Get_Facture_Enattente($id_facture)
    {
        try {
            // Recherche de la facture par ID
            $Facture = Facture::where('id', $id_facture)->first();

            // Vérifiez si la facture existe
            if (!$Facture) {
                return response()->json(['error' => 'Facture non trouvée'], 404);
            }

            // Retour de la facture en JSON
            return response()->json(['facture' => $Facture]);
        } catch (\Exception $e) {
            // Log de l'erreur pour la traçabilité
            Log::error($e);

            // Retour d'une réponse d'erreur en JSON avec le code 500
            return response()->json(['error' => 'Erreur interne du serveur'], 500);
        }
    }

    public function Liste_Factures_Historique($id_magasin)
    {
        try {
            $date_courante = Carbon::now()->toDateString();  // Formater la date au format 'YYYY-MM-DD'

            $Factures = Facture::join('clients', 'clients.id', '=', 'factures.id_client')
                ->select(
                    'factures.id as id',
                    'factures.code_barres as code',
                    'clients.nom_prenom as client',
                    'factures.created_at as date',
                    'factures.etat_facture as etat',
                    'factures.total_facture as total',
                    'factures.versement as versement',
                    'factures.credit as credit',
                )
                ->where(function ($query) {
                    // Filtrer les factures dont l'état est soit 'Facture-Payée' soit 'Crédit'
                    $query->where('etat_facture', 'Facture-Payée')
                        ->orWhere('etat_facture', 'Crédit');
                })
                ->where('total_facture', '!=', 0)  // Filtrer les factures dont le total n'est pas égal à 0
                ->where('factures.id_magasin', $id_magasin)  // Filtrer par magasin
                // ->whereDate('factures.created_at', '=', $date_courante) // Comparer uniquement la date
                ->orderby('factures.created_at', 'DESC')  // Trier par la date de création (si vous le souhaitez)
                ->get();






            // return response()->json(['factures' => $Factures]);

            // Retour de la réponse avec le message de succès et les factures
            return response()->json([
                'message' => 'Factures récupérées avec succès.', // Message de succès
                'factures' => $Factures // Les données des factures
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage()); // Log plus explicite
            return response()->json(['error' => 'Une erreur interne est survenue.'], 500);
        }
    }


    public function Liste_Clients()
    {

        try {


            $Clients = Client::leftJoin('creditclients', 'clients.id', '=', 'creditclients.id_client')
                ->leftJoin('versements', 'clients.id', '=', 'versements.id_client')
                ->select(
                    'clients.id as id',
                    'clients.nom_prenom as nom',
                    'clients.adresse as adresse',
                    'clients.details as details',
                    'clients.fix as tel_fix',
                    'clients.ooredoo as tel_ooredoo',
                    'clients.mobilis as tel_mobilis',
                    'clients.djezzy as tel_djezzy',
                    DB::raw('(SELECT IFNULL(SUM(credit), 0) FROM creditclients WHERE creditclients.id_client = clients.id) - (SELECT IFNULL(SUM(montant), 0) FROM versements WHERE versements.id_client = clients.id) as total_credit')
                )
                ->groupBy(
                    'clients.id',
                    'clients.nom_prenom',
                    'clients.adresse',
                    'clients.details',
                    'clients.fix',
                    'clients.ooredoo',
                    'clients.mobilis',
                    'clients.djezzy'
                )
                ->orderBy('clients.created_at', 'DESC')
                ->get();




            // Retour de la réponse avec le message de succès et les clients
            return response()->json([
                'message' => 'liste clients récupérées avec succès.', // Message de succès
                'clients' => $Clients // Les données des clients
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage()); // Log plus explicite
            return response()->json(['error' => 'Une erreur interne est survenue.'], 500);
        }
    }


    public function Chercher_Facture($id_facture)
    {
        try {

            $Facture = Facture::where('id', $id_facture)->first();

            return response()->json(['facture' => $Facture]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    public function Prix_Vente($id_vente)
    {
        try {
            $Vente = Vente::where('id', $id_vente)->first();

            return response()->json(['vente' => $Vente]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    public function Valider_Prix_Vente($id_vente, $nv_prix)
    {
        try {
            $Vente = Vente::where('id', $id_vente)->first();

            $Vente->total_vente = $nv_prix;

            $Vente->save();
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    public function Calculer_Ventes($id_facture, $type_vente)
    {
        try {
            $Ventes = Vente::where('id_facture', $id_facture)->get();
            foreach ($Ventes as $Vente) {
                $Quantite = $Vente->quantite;
                $IdProduit = $Vente->id_produit;
                $LeProduit = Produit::find($IdProduit);
                if ($LeProduit) {
                    if ($type_vente == 'details') {
                        $NouveauPrix = $LeProduit->prix_vente;
                    }
                    if ($type_vente == 'semigros') {
                        $NouveauPrix = $LeProduit->semi_gros;
                    }
                    if ($type_vente == 'gros') {
                        $NouveauPrix = $LeProduit->gros;
                    }
                    $Total = $NouveauPrix * $Quantite;
                    $Vente->prix_unitaire = $NouveauPrix;
                    $Vente->total_vente = $Total;
                    $Vente->save();
                }
            }
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function ValiderVersementCredit($id_client, $nom_client, $montant_verse)
    {

        $versement_credit = new Versement();
        $versement_credit->id_client = $id_client;
        $versement_credit->montant = $montant_verse;
        $versement_credit->save();
    }

    public function ImprimerBonVersementCredit($id_client)
    {
        // Récupérer le dernier versement du client
        $Versement = Versement::where('id_client', $id_client)
            ->latest('created_at')  // Trier par la colonne 'created_at' (ou une autre colonne)
            ->first();  // Récupérer le dernier enregistrement

        // Vérifier si le versement existe
        if (!$Versement) {
            return response()->json(['error' => 'Aucun versement trouvé pour ce client'], 404);
        }

        // Récupérer les informations générales
        $Informations = Information::first();

        // Récupérer les informations du client
        $Client = Client::find($id_client);

        // Vérifier si le client existe
        if (!$Client) {
            return response()->json(['error' => 'Client non trouvé'], 404);
        }

        // Récupérer les crédits et versements pour le client
        $Credit = Client::leftJoin('creditclients', 'clients.id', '=', 'creditclients.id_client')
            ->leftJoin('versements', 'clients.id', '=', 'versements.id_client')
            ->select(
                'clients.id as id',
                'clients.nom_prenom as nom',
                'clients.adresse as adresse',
                'clients.details as details',
                'clients.fix as tel_fix',
                'clients.ooredoo as tel_ooredoo',
                'clients.mobilis as tel_mobilis',
                'clients.djezzy as tel_djezzy',
                DB::raw('(SELECT IFNULL(SUM(credit), 0) FROM creditclients WHERE creditclients.id_client = clients.id) - (SELECT IFNULL(SUM(montant), 0) FROM versements WHERE versements.id_client = clients.id) as total_credit')
            )
            ->where('clients.id', $id_client)
            ->first();

        // Vérifier si les données de crédit existent
        if (!$Credit) {
            return response()->json(['error' => 'Données de crédit non trouvées pour ce client'], 404);
        }

        // Obtenir la date courante
        $date_courante = Carbon::now()->toDateString();

        // Organiser les données à passer à la vue PDF
        $data = [
            'informations' => $Informations,
            'versement' => $Versement,
            'client' => $Client,
            'credit' => $Credit,
            'date' => $date_courante,
        ];

        try {
            // Titre du fichier PDF
            $titre = 'bon_versement_credit_' . $Versement->id;

            // Générer le PDF avec les dimensions du ticket de caisse (80 mm de large et 200 mm de haut)
            $pdf = Pdf::loadView('caisse.bon', $data)->setPaper([0, 0, 226.77, 566.93], 'portrait'); // 80 mm x 200 mm en points (1 mm = 2.83 points)

            // Retourner le PDF en streaming sans le télécharger
            return $pdf->stream($titre . '.pdf', ['Attachment' => false]);
        } catch (\Exception $e) {
            // Gérer les erreurs dans la génération du PDF
            Log::error('Erreur lors de la génération du PDF : ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la génération du PDF'], 500);
        }
    }


    // ---------------------------------------------------------------------------------

    public function OpenCashDrawer()
    {
        // Nom de l'imprimante, tel qu'il apparaît dans les Périphériques et imprimantes
        $printerName = "XP-80C"; // Assurez-vous que ce nom est correct

        try {
            // Créer un connecteur pour l'imprimante
            $connector = new WindowsPrintConnector($printerName);
            $printer = new Printer($connector);

            // Commande ESC/POS pour ouvrir la caisse
            $open_cash_drawer = chr(27) . chr(112) . chr(0) . chr(25) . chr(250);

            // Envoyer la commande à l'imprimante
            $printer->text($open_cash_drawer);
            $printer->cut();
            $printer->close();

            return response()->json(['message' => 'Caisse ouverte avec succès.']);
        } catch (\Exception $e) {
            // Enregistrez l'erreur dans les logs pour débogage
            \Log::error('Erreur lors de l\'ouverture de la caisse: ' . $e->getMessage());
            return response()->json(['error' => 'Impossible d\'ouvrir l\'imprimante: ' . $e->getMessage()], 500);
        }
    }
}
