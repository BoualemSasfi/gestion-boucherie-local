<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    // use HasFactory;
    protected $table = 'informations';

    protected $fillable = [
        'nom_entr',
        'N_registre',
        'date_registre',
        'adresse',
        'map',
        'tel',
        'email',
        'logo',
    ];
}
