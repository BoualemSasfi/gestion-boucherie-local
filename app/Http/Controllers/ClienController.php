<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Facture;
use App\Models\Creditclient;
use App\Models\Versement;
use App\Models\Information;

use Illuminate\Support\Facades\Auth;

use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGenerator;
use Illuminate\Support\Facades\Log;

use Barryvdh\DomPDF\Facade\Pdf;


class ClienController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('admin.client.index', ['clients' => $clients]);
    }

    public function create()
    {
        return view('admin.client.add');
    }
    public function stor(Request $request)
    {

        $code = strtoupper(uniqid('CL'));
        $code1 =  'CL' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
        $new_client = new Client();

        $new_client->code_client =  $code1 ;
        $new_client->nom_prenom = $request->input('nom_prenom');
        $new_client->fix = $request->input('fix');
        $new_client->details = $request->input('details');
        $new_client->adresse = $request->input('adresse');
        $new_client->n_rc = $request->input('n_rc');
        $new_client->NIF = $request->input('NIF');
        $new_client->NIS = $request->input('NIS');
        $new_client->save();
        $nom = $new_client->nom_prenom;
        session()->flash('success', 'Le client ' . $nom . ' a été ajouté avec succès! ');
        return redirect('/admin/client');
    }

    public function edit($id)
    {
        $client = Client::find($id);

        return view('admin.client.edit', ['client' => $client]);
    }

    public function update(Request $request, $id)
    {

        $up_client = Client::find($id);

        $up_client->nom_prenom = $request->nom_prenom;
        $up_client->fix = $request->fix;
        $up_client->details = $request->details;
        $up_client->adresse = $request->adresse;
        $up_client->n_rc = $request->n_rc;
        $up_client->NIF = $request->NIF;
        $up_client->NIS = $request->NIS;
        $up_client->save();
        session()->flash('success', 'le client a bien ete modifier  ');
        return redirect('/admin/client');

    }

    public function destroy($id)
    {

        $client = Client::find($id);
        $nom = $client->nom_prenom;
        $client->delete();
        session()->flash('success', 'le client ' . $nom . ' a bien ete supprimer  ');
        // return response()->json(['success' => true, 'message' => 'Le client a bien été supprimé.']);
        return redirect('/admin/client');
    }

    public function voir($id)
    {
        $client = Client::find($id);


        $listes = Creditclient::where('id_client', $id)
            ->select(
                'id_facture',
                'created_at',
                'total_facture',
                'versement',
                'credit',
                'etat_credit'
            )
            ->get();

        $totalFacture = Creditclient::where('id_client', $id)
            ->sum('total_facture');

        $credit = Creditclient::where('id_client', $id)
            ->sum('credit');


        return view('admin.client.voir', ['client' => $client, 'listes' => $listes, 'totalfacture' => $totalFacture, 'credit' => $credit]);
    }
    public function credit($id)
    {
        $client = Client::find($id);
        $versement = Versement::where('id_client', $id)->get();


        $listes = Creditclient::where('id_client', $id)
            ->select(
                'id_facture',
                'created_at',
                'total_facture',
                'versement',
                'credit',
                'etat_credit'
            )
            ->get();

        $totalFacture = Creditclient::where('id_client', $id)
            ->sum('total_facture');

        $credit = Creditclient::where('id_client', $id)
            ->sum('credit');


        return view('admin.client.credit', [
            'client' => $client,
            'listes' => $listes,
            'totalfacture' => $totalFacture,
            'credit' => $credit,
            'versements' => $versement
        ]);
    }


    public function valider_v($montant, $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return redirect()->back()->with('error', "Client introuvable.");
        }

        if ($montant <= 0 || $client->credit < $montant) {
            return redirect()->back()->with('error', "Montant invalide ou dépasse le crédit disponible.");
        }

        $client->credit -= $montant;
        $client->save();

        $code = strtoupper(uniqid('V-'));
        $code1 = strtoupper(bin2hex(random_bytes(5)));
        $versement = new Versement();
        $versement->id_client = $id;
        $versement->montant = $montant;
        $versement->code_vers = $code1;
        $versement->code_barre = $code1;
        $versement->save();


        $id_versement = $versement->id;
        // return redirect()->route('Admin_Home')->with('success', 'Facture valide avec succès.');
        // Retourner l'ID du versement avec la réponse JSON
        return response()->json([
            'success' => true,
            'message' => 'Le versement a bien été effectué 😎 !!',
            'id_versement' => $id_versement // Inclure l'ID du versement dans la réponse
        ]);

        return redirect()->back()->with('success', 'Le versement a bien été effectué 😎 !!');
    }

    public function imprim_recu($id)
    {
        $versement = Versement::find($id);
        $client = Client::find($versement->id_client);


        $barcodeDir = public_path('storage/barcodes');
        if (!file_exists($barcodeDir)) {
            mkdir($barcodeDir, 0777, true);
        }

        $barcodePath = $barcodeDir . '/' . $versement->code_barre . '.png';

        try {
            $generator = new BarcodeGeneratorPNG();
            $barcodeImage = $generator->getBarcode($versement->code_barre, BarcodeGenerator::TYPE_CODE_128, 1, 30);
            file_put_contents($barcodePath, $barcodeImage);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la génération du code-barres : ' . $e->getMessage());
            return redirect()->back()->with('error', "Erreur lors de la génération du code-barres.");
        }

        $user = Auth::user();
        $date = date('d-m-Y');
        $informations = Information::first();

        $data = [
            'client' => $client,
            'informations' => $informations,
            'code_barre' => $versement->code_barre,
            'barcodePath' => $barcodePath,
            'date' => $date,
            'versement' => $versement,
            'montant' => $versement->montant,
            'user' => $user
        ];

        try {
            $pdf = PDF::loadView('admin.client.recu', $data)
                ->setPaper('A4', 'portrait'); // Format A4 et orientation portrait

            // Réponse avec le PDF pour affichage dans le navigateur
            return response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="facture_' . $client->nom_prenom . '_recu_' . $versement->code_vers . '_' . $date . '.pdf"',
            ]);
        } catch (\Exception $e) {
            // Gestion des erreurs
            Log::error('Erreur lors de la génération du PDF : ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la génération du PDF : ' . $e->getMessage()], 500);
        }

    }

    public function valider_p($id)
    {

        $facture = Creditclient::where('id_facture', $id)->first();

        $credit = $facture->credit;
        $versement = $facture->versement;
        $id = $facture->id_facture;

        $facture->credit = 0;
        $facture->versement = $credit + $versement;
        $facture->etat_credit = 'payé';
        $facture->save();

        $lafacture = Facture::find($id);
        $lafacture->versement = $credit + $versement;
        $lafacture->credit = 0;
        $lafacture->etat_facture = 'payé';
        $lafacture->save();



        return redirect()->back()->with('success', 'Le payement de la facture N°' . $id . ' a bien été effectué  😎 !!');
    }

}
