<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => [
                'required',
                'string',
                'max:255',
                'unique:users',
                'regex:/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,}$/', // Expression régulière pour valider l'email
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d!@#$%^&*()_+={}\[\]|\\:;"\'<>,.?\/]{8,}$/', // Expression régulière pour valider le mot de passe
            ],
            'etablissement_id' => 'required|exists:etablissements,id',
            'typecompte' => 'required|string|in:professeurs,eleves,parents',
        ];
    }

    public function messages()
    {
        return [
            'email.required' =>'L\'adresse e-mail est obligatoire.',
            'email.string' =>'L\'adresse e-mail doit être une chaîne de caractères.',
            'email.max' =>'L\'adresse e-mail ne doit pas dépasser 255 caractères.',
            'email.unique' =>'L\'adresse e-mail est déjà utilisée.',
            'email.regex' =>'L\'adresse e-mail fournie est invalide.',
            'password.required' =>'Le mot de passe est obligatoire.',
            'password.string' =>'Le mot de passe doit être une chaîne de caractères.',
            'password.min' =>'Le mot de passe doit contenir au moins 8 caractères.',
            'password.regex' =>'Le mot de passe doit commencer par une lettre majuscule, contenir au moins un chiffre, et peut inclure des caractères spéciaux.',
            'etablissement_id.required' =>'L\'établissement est obligatoire.',
            'etablissement_id.exists' =>'L\'établissement sélectionné n\'existe pas.',
            'typecompte.required' => 'Le type de compte est obligatoire.',
            'typecompte.in' => 'Le type de compte doit être l\'un des suivants : professeurs, eleves, parents.',
        ];
    }
}
