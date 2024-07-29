<!DOCTYPE html>
<html>
<head>
    <title>Paiement reçu</title>
</head>
<body>
<p><img src="{{ asset('assets/img/canvas.png') }}" alt="Sunulyce Logo"></p>
    <h1>Paiement reçu {{$etablissementNom}}</h1>
    <p>Le paiement de {{ $montant }} pour l'élève {{ $elevePrenoms }} {{ $eleveNom }} a été reçu.</p>
    <p>Merci pour votre confiance!</p>
</body>
</html>
