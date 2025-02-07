<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magasin extends Model
{
    protected $table = 'magasins';
    protected $fillable = [
        'nom',
        'N_reg',
        'adresse',
        'tel',
        'type',
        'loca',
        
        
    ];
}
