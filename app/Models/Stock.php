<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    // use HasFactory;
   Protected $table = 'stocks';
   Protected $fillable = [
    'id',
    'magasin_id',
    'type',
   ];


}
