<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompleterProfilParentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
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
            'non_de_votre_éléve' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s-]+$/u'
            ],            
            'telephone' => [
                'required',
                'string',
                'regex:/^(77|76|75|78|33)\s\d{3}\s\d{2}\s\d{2}$/'
            ],
        ];
    }
    public function message(){

        [
            'nom.regex' => 'Mettez un nom valide.',
            'prenoms.regex' => 'Mettez un prénom valide.',
            'non_de_votre_éléver.regex' => 'Mettez un nom valide.',
            'telephone.regex' => 'Le numéro de téléphone doit être sous le format 77/76/75/78 ou 33 XXX XX XX.',
          
        ];
    }
}
