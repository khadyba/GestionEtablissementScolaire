<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AdminRegisterRequest extends FormRequest
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
            'telephone' => [
                'required',
                'string',
                Rule::unique('administrateurs'),
                'regex:/^(77|76|75|78|33)\s\d{3}\s\d{2}\s\d{2}$/'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'unique:administrateurs',
                'max:255',
                'regex:/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,}$/',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d!@#$%^&*()_+={}\[\]|\\:;"\'<>,.?\/]{8,}$/', 
            ]
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'email.required' => 'L\'adresse e-mail est obligatoire.',
            'email.string' => 'L\'adresse e-mail doit être une chaîne de caractères.',
            'email.email' => 'L\'adresse e-mail doit être une adresse valide.',
            'email.max' => 'L\'adresse e-mail ne doit pas dépasser 255 caractères.',
            'email.regex'=>'Mettez un adresse email valide !',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.regex' => 'Le mot de passe doit contenir au moins une lettre majuscule, un chiffre, et peut inclure des caractères spéciaux.',
            'telephone.unique' => 'Le numéro de téléphone exist déjat',
            'telephone.regex' => 'Le numéro de téléphone doit être sous le format 77/76/75/78 ou 33 XXX XX XX.',
            'prenoms.regex' => 'Mettez un prénom valide.',
            'nom.regex' => 'Mettez un nom valide.',
            'adresse.regex' => 'Mettez une adresse valide.',
        ];
    }
}
