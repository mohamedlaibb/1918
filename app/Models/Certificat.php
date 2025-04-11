<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificat extends Model
{
    protected $fillable = [
        'url',
        'verified',
        'stagiaire_id',
        'formation_id',
    ];
    public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class);
    }
    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

}
