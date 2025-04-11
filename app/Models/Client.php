<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['raison_sociale'];
    protected $primaryKey = 'client_id';
    public function formations()
    {
        return $this->hasMany(Formation::class);
    }
}
