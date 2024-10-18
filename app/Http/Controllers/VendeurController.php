<?php

namespace App\Http\Controllers;

use App\Models\Vendeur;
use App\Models\User;


use Illuminate\Http\Request;

class VendeurController extends Controller
{
    public function index()
    {


        $listes = Vendeur::join('users', 'vendeurs.id_user', '=', 'users.id')
            ->join('magasins', 'vendeurs.id_magasin', '=', 'magasins.id')
            ->join('caisses', 'vendeurs.id_caisse', '=', 'caisses.id')
            ->select(
                'vendeurs.id as id',
                'users.name as nom',
                'magasins.nom as magasin',
                'caisses.code_caisse as caisse'
            )
            ->get();


        return view('admin.vendeur.index', ['listes' => $listes]);

    }
}
