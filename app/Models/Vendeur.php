<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendeur extends Model
{
    // use HasFactory;

    protected $table = 'vendeurs';
    protected $fillable = [
        'id_user',
        'id_magasin',
        'id_caisse',
        'nom',
        'prenom',
        'tel',
        'details',
    ];
}
