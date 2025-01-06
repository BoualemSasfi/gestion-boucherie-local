<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Information;
use App\Http\Requests\InformationRequest;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;


class InformationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $information = Information::firstOrCreate([], [
            'nom_entr' => '',
            'N_registre' => '',
            'date_registre' => '',
            'adresse' => '',
            'map' => '',
            'tel' => '',
            'email' => '',
            'logo' => ''
        ]);

        return view('admin.information.index', ['information' => $information]);
    }

    public function update(Request $request, $id)
    {
        $information = information::find($id);

        $information->nom_entr = $request->input('nom_entr');
        $information->N_registre = $request->input('N_registre');
        $information->date_registre = $request->input('date_registre');
        $information->adresse = $request->input('adresse');
        $information->map = $request->input('map');
        $information->tel = $request->input('tel');
        $information->email = $request->input('email');

       // Gestion du logo
    if ($request->hasFile('logo')) {
        // Supprimer l'ancien logo s'il existe
        if ($information->logo) {
            Storage::delete($information->logo);
        }

        // Stocker le nouveau logo et obtenir son chemin
        $path = $request->file('logo')->store('public/images/logo');

        // Enregistrer le chemin relatif dans la base de données
        $information->logo = str_replace('public/', '', $path);
    }
        $information->save();

        // Message de succès
        Alert::success('Les informations ont été modifiées avec succèsdfdf !')->position('center')->autoClose(2000);

        return redirect('/admin/information');
    }
}
