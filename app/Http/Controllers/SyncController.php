<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SyncController extends Controller
{
    public function syncData(Request $request)
    {
        $data = $request->input('data');

        foreach ($data as $item) {
            // Enregistre les données dans la base de données
            Encaissement::create([
                'produit' => $item['produit'],
                'quantité' => $item['quantité'],
                'prix' => $item['prix'],
            ]);
        }

        return response()->json(['message' => 'Données synchronisées avec succès !'], 200);
    }

}
