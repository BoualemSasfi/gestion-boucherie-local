<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Caisse;
use App\Models\Magasin;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home(){
        return view('admin.home');
    }

    public function argent_caisse(){
        try {
        $Caisses = Caisse::join('magasins', 'magasins.id', '=', 'caisses.id_magasin')
        ->select(
            'caisses.id as caisse_id',
            'caisses.code_caisse as caisse_titre',
            'caisses.solde as caisse_solde',
            'caisses.fond_caisse as caisse_fond',
            'magasins.nom as magasin_nom',
            'magasins.id as magasin_id'
        )
        ->where('caisses.active','1')
        ->orderby('magasin_nom')
        ->get();
        return response()->json(['caisses' => $Caisses]);
    } catch (\Exception $e) {
        Log::error($e);
        return response()->json(['error' => 'caisses request Error'], 500);
    }
    }
}
