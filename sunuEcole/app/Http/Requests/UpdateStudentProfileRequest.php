<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentProfileRequest extends FormRequest
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
                'regex:/^[\pL\s-]+$/u'
            ],
            'non_de_votre_tuteur' => [
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
            'adresse.regex' => 'Mettez une adresse valide',
            'non_de_votre_tuteur.regex' => 'Mettez un nom de tuteur valide.'
        ];
    }
}
