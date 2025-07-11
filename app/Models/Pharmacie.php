<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacie extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'nom_pharmacie',
        'adresse',
        'ouvert',
        'latitude',
        'longitude',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
