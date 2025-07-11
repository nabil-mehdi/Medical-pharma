<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infirmiere extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'soin_id',

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function soin()
    {
        return $this->belongsTo(Soin::class);
    }
}
