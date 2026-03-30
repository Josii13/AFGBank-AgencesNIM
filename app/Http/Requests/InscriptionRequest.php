<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;

class InscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom_prenoms'        => ['required', 'string', 'max:255'],
            'telephone'          => ['required', 'string', 'max:30'],
            'email'              => ['required', 'email', 'max:255'],
            'est_client'         => ['required', 'in:oui_reactiver,non'],
            'numero_compte'      => ['nullable', 'string', 'max:100'],
            'souhaite_contact'   => ['required', 'in:oui,non'],
            'g-recaptcha-response' => ['required'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $token      = $this->input('g-recaptcha-response');
            $secretKey  = env('RECAPTCHA_SECRET_KEY');

            if (empty($secretKey) || $secretKey === 'your_secret_key_here') {
                return; // reCAPTCHA non configuré, on laisse passer
            }

            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret'   => $secretKey,
                'response' => $token,
                'remoteip' => $this->ip(),
            ]);

            if (! ($response->json('success') === true)) {
                $validator->errors()->add('g-recaptcha-response', 'La vérification reCAPTCHA a échoué. Veuillez réessayer.');
            }
        });
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
