<img src="{{ asset('assets/img/canvas.png') }}" alt="Sunulyce Logo">

@component('mail::message')
# Notification d'affectation de professeur

Bonjour,

Vous avez été affecté à la classe suivante : {{ $classeName }} à l'établissement {{ $etablissementName }}.

Merci.

Cordialement,
l'administrateur
@endcomponent
