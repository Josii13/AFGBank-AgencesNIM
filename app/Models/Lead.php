<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'nom_prenoms',
        'telephone',
        'email',
        'est_client',
        'numero_compte',
        'souhaite_contact',
        'statut',
        'notes',
    ];

    public function getEstClientLabelAttribute(): string
    {
        return match($this->est_client) {
            'oui_reactiver' => 'Oui – réactivation',
            'non'           => 'Non',
            default         => $this->est_client,
        };
    }

    public function getStatutLabelAttribute(): string
    {
        return match($this->statut) {
            'nouveau'  => 'Nouveau',
            'en_cours' => 'En cours',
            'traite'   => 'Traité',
            default    => $this->statut,
        };
    }

    public function getStatutColorAttribute(): string
    {
        return match($this->statut) {
            'nouveau'  => 'bg-blue-100 text-blue-800',
            'en_cours' => 'bg-yellow-100 text-yellow-800',
            'traite'   => 'bg-green-100 text-green-800',
            default    => 'bg-gray-100 text-gray-800',
        };
    }
}
