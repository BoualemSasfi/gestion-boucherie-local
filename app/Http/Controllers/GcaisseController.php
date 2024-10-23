<?php

namespace App\Http\Controllers;
use App\Models\Caisse;
use App\Models\Magasin;
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

    public function caisse_transfert2(Request $request, $id)
    {
        $magasin = Magasin::where('id', $request->id_magasin)->get();
        $caisses = Caisse::where('id_magasin',$request->id_magasin)->get();
        $caisse_id = $id;
        return view('admin.gcaisse.tranfert2', ['magasin' => $magasin,'caisses'=>$caisses ,'caisse_id' => $caisse_id]);
    }
}
