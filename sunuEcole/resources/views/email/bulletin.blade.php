@component('mail::message')
# Bonjour {{ $eleve->prenoms }} {{ $eleve->nom }},

Votre bulletin est maintenant disponible.

@component('mail::button', ['url' => $bulletinUrl])
Voir le Bulletin
@endcomponent

Merci d'utiliser notre application !

{{ config('app.name') }}
@endcomponent
