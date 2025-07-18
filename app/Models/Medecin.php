<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medecin extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'specialite_id',
        'description',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function specialite()
    {
        return $this->belongsTo(Specialite::class);
    }
}
