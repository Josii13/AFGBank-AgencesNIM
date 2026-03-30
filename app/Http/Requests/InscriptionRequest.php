<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom_prenoms'     => ['required', 'string', 'max:255'],
            'telephone'       => ['required', 'string', 'max:30'],
            'email'           => ['required', 'email', 'max:255'],
            'est_client'      => ['required', 'in:oui_reactiver,non'],
            'numero_compte'   => ['nullable', 'string', 'max:100'],
            'souhaite_contact' => ['required', 'in:oui,non'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom_prenoms.required'      => 'Le nom et prénoms sont obligatoires.',
            'telephone.required'        => 'Le numéro de téléphone est obligatoire.',
            'email.required'            => 'L\'adresse email est obligatoire.',
            'email.email'               => 'Veuillez saisir une adresse email valide.',
            'est_client.required'       => 'Veuillez indiquer si vous êtes déjà client.',
            'souhaite_contact.required' => 'Veuillez indiquer si vous souhaitez être contacté.',
        ];
    }
}
