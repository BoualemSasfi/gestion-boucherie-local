<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prod_trans extends Model
{
    // use HasFactory;
    protected $table = 'prod_trans';
    protected $fillable = [
        'id_trans',
        'category',
        'produit',
        'quantity',
    ];
}
