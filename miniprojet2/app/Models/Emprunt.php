<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Emprunt extends Model
{
    protected $fillable = [
        'user_id', 
        'livre_id', 
        'date_emprunt', 
        'date_retour_prevue', 
        'date_retour_effective'
    ];

    // Pour que Laravel gère automatiquement ces champs comme des dates complètes
    protected $casts = [
        'date_emprunt' => 'datetime',
        'date_retour_prevue' => 'date',
        'date_retour_effective' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function livre(): BelongsTo
    {
        return $this->belongsTo(Livre::class);
    }
}