<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
   <div class="container">
       <div class="row mt-5 ">
          <div class="mb-3">
           <h2>Formulaire D'inscription Pour Les Administrateurs</h2>
           </div>
          <div class="col-md-6">
            <form action="{{ route('administrateurs.store') }}" method="POST">
             @csrf

               <div class="mb-3">
                <label for="exampleInputEmail1" >Nom :</label>
                <input type="text" id="nom" name="nom"  class="form-control" required><br>
               </div>
                
               <div class="mb-3">
                <label for="exampleInputEmail1">Prénoms :</label>
                <input type="text" id="prenoms" name="prenoms" class="form-control" required><br>
                </div>

                <div class="mb-3">
                    <label  for="exampleInputEmail1"> Adresse :</label>
                    <input type="text" id="adresse" name="adresse" class="form-control" required><br>
                </div>

               <div class="mb-3">
                    <label   for="exampleInputEmail1" >Téléphone :</label>
                    <input type="number" id="telephone" name="telephone" class="form-control" required><br>
                </div>
               <div class="mb-3">
                    <label for="exampleInputEmail1">Email :</label>
                    <input type="email" id="email" name="email" class="form-control" required><br>
               </div>
                <div>
                    <label for="exampleInputPassword1" class="form-label">Mot de passe :</label>
                    <input type="password" id="password" name="password" class="form-control" required><br>
                </div>
                <button type="submit" class="btn btn-primary">S'inscrire </button>
            </form>
          </div>   
          <div class="col-md-6 mt-6" >
                    <img src="{{ asset('assets/img/inscription-administrateur.jpg') }}" alt="Image description" class="img-fluid">
                </div>   
      </div>      
   </div> 
</body>
</html>























