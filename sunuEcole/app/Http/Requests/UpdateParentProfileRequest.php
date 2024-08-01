<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateParentProfileRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette demande.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Assurez-vous que cela est configuré selon vos besoins d'autorisation
    }

    /**
     * Obtenez les règles de validation qui s'appliquent à la demande.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nom' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s-]+$/u'
            ],
            'prenoms' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s-]+$/u'
            ],
            'telephone' => [
                'required',
                'string',
                Rule::unique('parents'),
                'regex:/^(77|76|75|78|33)\s\d{3}\s\d{2}\s\d{2}$/'
            ],
            'non_de_votre_élève' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s-]+$/u'
            ],
        ];
    }
    public function messages()
    {
        return [
            'nom.regex' => 'Mettez un nom valide.',
            'prenoms.regex' => 'Mettez un prénom valide.',
            'telephone.unique' => 'Le numéro de téléphone exist déjat',
            'telephone.regex' => 'Le numéro de téléphone doit être sous le format 77/76/75/78 ou 33 XXX XX XX.',
            'non_de_votre_élève.regex' => 'Mettez un nom éleves  valide.',
        ];
    }
}
