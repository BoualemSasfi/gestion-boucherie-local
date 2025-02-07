<?php

namespace App\Http\Controllers;

use App\Models\Vendeur;
use App\Models\magasin;


use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

use App\Models\User;


use Illuminate\Http\Request;

class VendeurController extends Controller
{
    public function index()
    {

        $listes = Vendeur::join('users', 'vendeurs.id_user', '=', 'users.id')
            ->join('magasins', 'vendeurs.id_magasin', '=', 'magasins.id')
            // ->join('caisses', 'vendeurs.id_caisse', '=', 'caisses.id')
            ->select(
                'vendeurs.id as id',
                'users.name as nom',
                'magasins.nom as magasin'
                // 'caisses.code_caisse as caisse'
            )
            ->get();


        return view('admin.vendeur.index', ['listes' => $listes]);

    }

    public function create()
    {

        $magasins = Magasin::all();
        return view('admin.vendeur.add', ['magasins' => $magasins]);
    }

    public function stor(Request $request)
    {

        $new_user = new User();
        $new_user->name = $request->user_name;
        $new_user->password = $request->user_name;
        $new_user->password = $request->password;
        $new_user->email = $request->user_name . '@gmail.com';
        $new_user->save();

        $id_user = $new_user->id;

        $new_vendeur = new Vendeur();
        $new_vendeur->id_user = $id_user;
        $new_vendeur->id_p = $request->n_p;
        $new_vendeur->nom = $request->nom;
        $new_vendeur->prenom = $request->prenom;
        $new_vendeur->tel = $request->tel;
        $new_vendeur->details = $request->details;
        $new_vendeur->id_magasin = $request->magasin_id;
        $new_vendeur->save();

        // $nom = $new_vendeur->nom + '' + $ne
        session()->flash('success', 'le vendeur  a bien ete ajouter  ');
        return redirect('/admin/vendeur');


    }

    public function edit($id)
    {
        $vendeur = Vendeur::find($id);
        $user_id = $vendeur->id_user;
        $utilisateur = User::find($user_id);
        $magasins = Magasin::all();

        return view('admin.vendeur.edit', ['vendeur' => $vendeur, 'utilisateur' => $utilisateur, 'magasins' => $magasins, 'user_id' => $user_id]);
    }

    public function save(Request $request, $id)
    {
        $user = User::where('id = ', $request->user_id);

        $vendeur = Vendeur::find($id);
        
        $vendeur->nom = $request->nom;
        $vendeur->prenom = $request->prenom;
        $vendeur->tel = $request->tel;
        $vendeur->details = $request->details;
        $vendeur->id_p = $request->id_p;
        $vendeur->id_magasin = $request->magasin->id;

        $vendeur->save();

        $user->name = $request->user_name;
        $user->password = $request->password;
        $user->save();

        session()->flash('success', 'le vendeur a bien ete modifier .');
        return redirect('/admin/vendeur');

    }
}
