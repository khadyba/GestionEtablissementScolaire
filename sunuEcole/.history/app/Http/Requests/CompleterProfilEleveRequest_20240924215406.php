<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompleterProfilEleveRequest extends FormRequest
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
           'adresse' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\pN\s,.\'-]+$/u'
            ],
            'non_de_votre_tuteur' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s-]+$/u'
            ],
            
           'email_tuteur' => [
                'required',
                'string',
                'max:255',
                'unique:eleves',
                'regex:/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,}$/', 
            ],
            'dateDeNaissance' => [
                'required',
                'string',
                'max:10',
                'regex:/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/',
            ],
            'classe_id' => 'nullable|integer|exists:classes,id',
J
        ];
    }
    public function messages()
    {
        return [
            'nom.regex' => 'Mettez un nom valide.',
            'prenoms.regex' => 'Mettez un prénom valide.',
            'adresse.regex' => 'Mettez une adresse valide.',
            'non_de_votre_tuteur.regex' => 'Mettez un nom de tuteur  valide.',
            'email.required' => 'L\'adresse e-mail est obligatoire.',
            'email.unique' => 'L\'adresse e-mail existe déjà.',
            'email_tuteur.regex' => 'L\'adresse email du tuteur fournie est invalide.',
            'dateDeNaissance.regex' => 'La Date doit être sous le format jj/mm/aaaa.',
        ];
    }
    


}
