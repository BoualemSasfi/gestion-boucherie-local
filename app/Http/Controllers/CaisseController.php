<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Information;
use App\Models\Category;

class CaisseController extends Controller
{
    public function caisse(){
        $categorys = Category::all();
        $informtions = Information::first();

        return view('caisse.test',['categorys'=>$categorys , 'informations'=>$informtions]);
    }
}
