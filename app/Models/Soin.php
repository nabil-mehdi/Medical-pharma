<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soin extends Model
{
    use HasFactory;
    public function infirmier()
    {
        return $this->hasMany(Infirmiere::class);
    }
}
