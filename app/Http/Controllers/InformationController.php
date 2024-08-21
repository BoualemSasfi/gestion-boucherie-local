<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Information;
use App\Http\Requests\InformationRequest;
use RealRashid\SweetAlert\Facades\Alert;

class InformationController extends Controller
{
 
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

    public function update(InformationRequest $request, $id)
    {
        $information = information::find($id);

        $information->nom_entr = $request->input('nom_entr');
        $information->N_registre = $request->input('N_registre');
        $information->date_registre = $request->input('date_registre');
        $information->adresse = $request->input('adresse');
        $information->map = $request->input('map');
        $information->tel = $request->input('tel');
        $information->email = $request->input('email');

        if ($request->hasFile('logo')) {
            // $information->logo = $request->logo->store('app/images/logo');
            $information->logo = $request->file('logo')->store('app/images/logo');
        }

        $information->save();

        // Message de succès
        Alert::success('Les informations ont été modifiées avec succès !')->position('center')->autoClose(2000);

        return redirect('/admin/information');
    }
}
