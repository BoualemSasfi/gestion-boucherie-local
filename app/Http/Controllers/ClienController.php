<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Facture;
use App\Models\Creditclient;


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

        $new_client = new Client();

        $new_client->nom_prenom = $request->input('nom_prenom');
        $new_client->fix = $request->input('fix');
        $new_client->details = $request->input('details');
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


        return view('admin.client.voir', ['client' => $client, 'listes' => $listes,'totalfacture'=>$totalFacture , 'credit'=>$credit]);
    }

    public function valider_p($id){

        $facture = Creditclient::where('id_facture' ,$id)->first();

        $credit =  $facture->credit ;
        $versement = $facture->versement;
        $id = $facture->id_facture;

        $facture->credit = 0;
        $facture->versement =  $credit + $versement;
        $facture->etat_credit = 'payé';
        $facture->save();

        $lafacture = Facture::find($id);
        $lafacture->versement = $credit + $versement;
        $lafacture->credit = 0;
        $lafacture->etat_facture = 'payé';
        $lafacture->save();



        return redirect()->back()->with('success', 'Le payement de la facture N°'.$id.' a bien été effectué  😎 !!');
    }

}
