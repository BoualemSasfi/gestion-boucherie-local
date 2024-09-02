<?php

namespace App\Http\Controllers;

use App\Models\Magasin;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;


class MagasinController extends Controller
{
    public function index()
    {
        $magasins = Magasin::all();
        return view('admin.magasin.index', ['magasins' => $magasins]);
    }

    public function create()
    {

        return view('admin.magasin.add');
    }

    public function store(Request $request)
    {
        $magasin = new Magasin();
        $magasin->nom = $request->input('nom');
        $magasin->tel = $request->input('tel');
        $magasin->N_reg = $request->input('N_reg');
        $magasin->type = $request->input('type');
        $magasin->adresse = $request->input('adresse');
        $magasin->loca = $request->input('loca');

        // Gestion du photo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancien photo s'il existe
            if ($magasin->photo) {
                Storage::delete($magasin->photo);
            }

            // Stocker la nouvelle photo et obtenir son chemin
            $path = $request->file('photo')->store('public/images/magasin');

            // Enregistrer le chemin relatif dans la base de données
            $magasin->photo = str_replace('public/', '', $path);
        }
        $magasin->save();

        // Message de succès
        // Alert::success('le nouveau magasin a bien été enregitrier !')->position('center')->autoClose(2000);
        session()->flash('success', 'le nouveau magasin a bien été eneregistrier');
        return redirect('/admin/magasin');

    }

    public function edit($id)
    {
        $magasins = Magasin::find($id);
        return view('admin.magasin.edit', ['magasins' => $magasins]);
    }

    public function update(Request $request, $id)
    {
        $magasins = Magasin::find($id);
        $magasins->nom = $request->input('nom');
        $magasins->N_reg = $request->input('N_reg');
        $magasins->adresse = $request->input('adresse');
        $magasins->loca = $request->input('loca');
        $magasins->tel = $request->input('tel');
        $magasins->type = $request->input('type');

        //  Gestion du photo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancien photo s'il existe
            if ($magasins->photo) {
                Storage::delete($magasins->photo);
            }

            // Stocker la nouvelle photo et obtenir son chemin
            $path = $request->file('photo')->store('public/images/magasin');

            // Enregistrer le chemin relatif dans la base de données
            $magasins->photo = str_replace('public/', '', $path);
        }
        $magasins->save();
        // Alert::success('le nouveau magasin a bien été enregitrier !')->position('center')->autoClose(9000);
        session()->flash('success', 'le magasin a bien été modifier   !');
        return redirect('/admin/magasin');

    }

    public function destroy ($id){
        $magasin = Magasin::find($id);
        $magasin->delete();
        session()->flash('success', 'le magasin est supprimet  !');
        return redirect('/admin/magasin');
    }

    public function stock($id){
        $magasins = Magasin::find($id);
        return view('/admin/magasin/stock',['magasins'=>$magasins]);
    }


}
