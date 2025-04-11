<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stagiaires extends Model
{
    protected $table = 'stagiaires';
    protected $fillable =[
        "nom","prenom","tel","foction","email","groupe_id"
    ];

    public function groupe(){
        return $this->belongsToMany('App\Models\Groupes');
    }
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
    public function certificats()
    {
        return $this->hasMany(Certificat::class);
    }



}
