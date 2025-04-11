<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
        'nbr_session',
        'groupe_id',
        'formation_id',
        'date_debut',
        'date_fin',
        'lieu'
    ];

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }
}
