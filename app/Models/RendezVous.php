<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    use HasFactory;
    protected $table = 'rendezvous';

    protected $fillable = [
        'patient_id',
        'type',
        'professionnel_id',
        'date',
        'heure',
        'statut',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function professionnel()
    {
        return $this->belongsTo(User::class, 'professionnel_id');
    }

    public function getTypeLabelAttribute()
    {
        return ucfirst($this->type); // "Medecin" ou "Infirmier"
    }

    public function getStatutLabelAttribute()
    {
        return match ($this->statut) {
            'en_attente' => 'En attente',
            'confirme' => 'Confirmé',
            'annule' => 'Annulé',
            default => 'En attente',
        };
    }
}
