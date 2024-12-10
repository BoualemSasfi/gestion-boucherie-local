<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtlVent extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'atl_ventes';

    /**
     * Les attributs pouvant être remplis en masse.
     *
     * @var array
     */
    protected $fillable = [
        'id_fact',
        'id_lestock',
        'categorie',
        'produit',
        'PU',
        'Q',
        'total',
    ];

    /**
     * Relation avec le modèle Facture.
     */
    public function facture()
    {
        return $this->belongsTo(Facture::class, 'id_fact');
    }

    /**
     * Relation avec le modèle Lestock.
     */
    public function lestock()
    {
        return $this->belongsTo(Lestock::class, 'id_lestock');
    }
}
