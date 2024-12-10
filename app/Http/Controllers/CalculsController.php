<?php

namespace App\Http\Controllers;

use App\Models\Calculs_par_jour;
use App\Models\Calculs_transfert;
use App\Models\Calculs_list;
use App\Models\Transfert;
use App\Models\Stock;
use App\Models\Lestock;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Psy\Readline\Hoa\Console;
use Carbon\Carbon;

class CalculsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $calculs_par_jour = Calculs_par_jour::all();

        return view('admin.calculs.index', ['calculs' => $calculs_par_jour]);
    }

    public function voir($id_calculs_jour)
    {
        $calculs_par_jours = Calculs_par_jour::find($id_calculs_jour);

        $calculs_transferts = Calculs_Transfert::all();
        
        $calculs_lists = Calculs_list::all();

        return view('admin.calculs.voir', ['calculs_par_jours' => $calculs_par_jours, 'calculs_transferts' => $calculs_transferts, 'calculs_lists' => $calculs_lists]);
    }

    public function filtrage_calculs_list($id_calculs_transfert)
    {
        try {
            $calculs_list = Calculs_list::where('calculs_transfert_id', '=', $id_calculs_transfert)->get();
            if ($calculs_list->isEmpty()) {
                return response()->json(['message' => 'No calculs found'], 404);
            }
            return response()->json(['calculs_list' => $calculs_list]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
