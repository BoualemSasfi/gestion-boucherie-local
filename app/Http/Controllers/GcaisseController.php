<?php

namespace App\Http\Controllers;
use App\Models\Caisse;
use App\Models\Magasin;
use App\Models\Transfert_soldes;
use Illuminate\Http\Request;

class GcaisseController extends Controller
{
    public function index()
    {
        $listes = Caisse::all();
        $magasins = Magasin::all();
        return view('admin.gcaisse.index', ['listes' => $listes, 'magasins' => $magasins]);
    }


    public function voir($id)
    {
        $caisse = Caisse::find($id);
        $magasins = Magasin::all();

        return view('admin.gcaisse.voir', ['caisse' => $caisse, 'magasins' => $magasins]);
    }
    public function create()
    {
        $magasins = Magasin::all();
        return view('admin.gcaisse.add', ['magasins' => $magasins]);
    }

    public function stor(Request $request)
    {
        $new_caisse = new Caisse();

        $new_caisse->code_caisse = $request->code_caisse;
        $new_caisse->id_magasin = $request->id_magasin;
        $new_caisse->solde = 0;
        $new_caisse->fond_caisse = 0;
        $new_caisse->active = 1;
        $new_caisse->save();

        session()->flash('success', 'La nouvelle caisse a bien ete ajouter !');

        return redirect('/admin/caisse');
    }

    public function edit($id)
    {
        $caisse = Caisse::find($id);
        $magasins = Magasin::all();

        return view('admin.gcaisse.edit', ['caisse' => $caisse, 'magasins' => $magasins]);
    }

    public function update(Request $request, $id)
    {
        $caisse = Caisse::find($id);

        $caisse->code_caisse = $request->code_caisse;
        $caisse->id_magasin = $request->id_magasin;
        $caisse->btn_enc = $request->btn_encaissier;
        $caisse->solde = $request->solde;

        $caisse->save();

        session()->flash('success', 'La modification a été effectuée avec succès !');
        return redirect('/admin/caisse');
    }

    public function destroy($id)
    {
        Caisse::find($id)->delete();
        session()->flash('success', 'La caisse  a été supprimer  avec succès !');
        return redirect('/admin/caisse');
    }


    public function caisse_tranfert1($id)
    {
        $magasins = Magasin::all();
        $caisse = Caisse::find($id);

        return view('admin.gcaisse.transfert1', ['magasins' => $magasins, 'caisse' => $caisse]);
    }
    public function caisse_transfert2($id_liste, $id_magasin)
    {
        // Récupérer les ID de la liste (caisse) et du magasin à partir de la requête



        // Trouver le magasin correspondant à l'id_magasin
        $lemagasin = Magasin::find($id_magasin);

        // Récupérer les caisses liées à ce magasin
        $caisses = Caisse::where('id_magasin', $id_magasin)->get();

        // Trouver la caisse correspondant à l'id_liste
        $lacaisse = Caisse::find($id_liste);

        // Vérifier si le magasin et la caisse existent bien
        if (!$lemagasin || !$lacaisse) {
            return redirect()->back()->with('error', 'Le magasin ou la caisse spécifié n\'existe pas.');
        }

        // Retourner la vue avec les données du magasin et des caisses
        return view('admin.gcaisse.transfert2', [
            'lacaisse' => $lacaisse,
            'caisses' => $caisses,
            'lemagasin' => $lemagasin,

        ]);
    }

    public function letransfert($lacaisseId, $selectedCaisseId)
    {
        $caisse1 = Caisse::find($lacaisseId);
        $caisse2 = Caisse::find($selectedCaisseId);

        $magasins = Magasin::all();
        $caisses = Caisse::all();
        $magasin1 = Magasin::where('id', $caisse1->id_magasin)->get();
        $magasin2 = Magasin::where('id', $caisse2->id_magasin)->get();

        return view('admin.gcaisse.letransfert',
         ['caisse1' => $caisse1,
          'caisse2' => $caisse2, 
          'magasin1' => $magasin1, 
          'magasin2' => $magasin2,
           'magasins'=>$magasins,
           'caisses'=>$caisses
        ]);
    }

    public function valide_transfer(Request $request)
    {
        // Log des données reçues pour débogage
        \Log::info('Données de transfert:', $request->all());

        // Valider les données
        $request->validate([
            'caisse1_id' => 'required|integer',
            'caisse2_id' => 'required|integer',
            'solde_ajouter' => 'required|numeric|min:0',
            'user' => 'required|string',
        ]);

        // Récupérer les caisses à partir de la base de données
        $caisse1 = Caisse::find($request->caisse1_id);
        $caisse2 = Caisse::find($request->caisse2_id);
        $user = $request->user;

        // Vérifier si les caisses existent
        if (!$caisse1 || !$caisse2) {
            return response()->json(['success' => false, 'message' => 'Les caisses spécifiées n\'existent pas.'], 404);
        }

        // Vérifier si le solde à transférer est supérieur au solde disponible
        if ($request->solde_ajouter > $caisse1->solde) {
            return response()->json(['success' => false, 'message' => 'Le montant à transférer dépasse le solde disponible de la caisse source.'], 400);
        }

        // Récupérer les magasins associés aux caisses
        $lemagasin1 = Magasin::where('id', $caisse1->id_magasin)->first();
        $lemagasin2 = Magasin::where('id', $caisse2->id_magasin)->first();

        // Vérifier si les magasins existent
        if (!$lemagasin1 || !$lemagasin2) {
            \Log::error('Magasins non trouvés pour les caisses spécifiées.');
            return response()->json(['success' => false, 'message' => 'Les magasins associés aux caisses n\'existent pas.'], 404);
        }

        // Effectuer le transfert
        try {
            // Déduire le solde de la caisse source
            $caisse1->solde -= $request->solde_ajouter;
            // Ajouter le solde à la caisse cible
            $caisse2->solde += $request->solde_ajouter;

            // Sauvegarder les modifications dans la base de données
            $caisse1->save();
            $caisse2->save();

            // Log après la sauvegarde des caisses
            \Log::info('Caisses mises à jour avec succès.');



        } catch (\Exception $e) {
            // En cas d'erreur lors de la sauvegarde
            \Log::error('Erreur lors du transfert des soldes: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Une erreur s\'est produite lors de la mise à jour des soldes.'], 500);
        }

        try {
            // Enregistrer le transfert dans la table 'transfert_soldes'
            $transolde = new Transfert_soldes();
            $transolde->user = $user;
            $transolde->magasin1 = $lemagasin1->nom . ' | ' . $caisse1->code_caisse;
            $transolde->magasin2 = $lemagasin2->nom . ' | ' . $caisse2->code_caisse;
            $transolde->solde = $request->solde_ajouter; // Utiliser la propriété 'montant'
            $transolde->save();

            // Log après la sauvegarde du transfert
            \Log::info('Transfert enregistré avec succès.');
        } catch (\Exception $e) {
            // En cas d'erreur lors de la sauvegarde
            \Log::error('Erreur lors du transfert des soldes: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Une erreur s\'est produite lors de \'enregistrement de la trasabilité .'], 500);
        }

        // Retourner une réponse JSON de succès
        return response()->json([ 'success' => true, 'message' => 'Transfert effectué avec succès.']);

        // return response()->json(['success' => true, 'message' => 'Transfert effectué avec succès.', 'redirect' => url('/admin/caisse')]);

    }

    public function trans_solde(){
        $listes = Transfert_soldes::all();
        return view('admin.gcaisse.transfertliste',['listes'=>$listes]);

    }




}
