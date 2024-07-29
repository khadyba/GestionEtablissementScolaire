<!DOCTYPE html>
<html>
<head>
    <title>Création de votre compte sur SunuLycée</title>
</head>
<body>
    <h2>Bienvenue sur SunuLycée</h2>
<p><img src="{{ asset('assets/img/canvas.png') }}" alt="Sunulyce Logo"></p>
    
    <p>
        Un compte a été créé pour vous sur notre plateforme SunuLycée. Voici vos identifiants :
        <br>
        Email: {{ $email }}
        <br>
        Mot de passe: {{ $password }}
        <br>
        Vous pouvez vous connecter dès maintenant pour compléter votre profil.
    </p>
</body>
</html>
