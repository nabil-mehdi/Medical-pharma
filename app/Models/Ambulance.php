<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambulance extends Model
{
    use HasFactory;

    protected $table = 'ambulances';
    protected $fillable = [
        'user_id',
        'nom',
        'ville_id',
        'tel',
        'disponible'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }
}
