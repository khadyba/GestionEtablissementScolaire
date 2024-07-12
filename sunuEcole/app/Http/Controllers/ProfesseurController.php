<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Classe;
use App\Models\Eleves;
use App\Models\Professeur;
use Illuminate\Http\Request;
use App\Models\SalleDeClasse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfesseurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Classe::where('is_delete', false)->get();
        return view('profdashboard', compact('classes'));
    }


    public function showCompleteProfileForm()
    {
        return view('complete-profile');
    }

    public function completeProfile(Request $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'spécialiter' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
        ]);
    
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();
    
        // Vérifier le rôle de l'utilisateur dans la table pivot
        $role = DB::table('usersroles')
            ->where('user_id', $user->id)
            ->first();
    
        // Assurez-vous que l'utilisateur a le rôle de professeur (role_id = 1 pour professeur)
        if ($role && $role->role_id == 1) {
            // Sauvegarder les données dans la table professeurs
            $professeur = Professeur::where('user_id', $user->id)->first();
    
            if (!$professeur) {
                $professeur = new Professeur();
                $professeur->user_id = $user->id;
            }
    
            $professeur->nom = $validatedData['nom'];
            $professeur->prenoms = $validatedData['prenoms'];
            $professeur->spécialiter = $validatedData['spécialiter'];
            $professeur->adresse = $validatedData['adresse'];
            $professeur->telephone = $validatedData['telephone'];
            $professeur->is_completed = true; // Marquer le profil comme complété
    
            // Sauvegarder le profil du professeur
            $professeur->save();
    
            // Redirection avec un message de succès
            return redirect()->route('prof.dashboard')->with('success', 'Profil complété avec succès.');
        }
    
        // Si l'utilisateur n'a pas le rôle de professeur, redirigez ou affichez un message d'erreur
        return redirect()->route('home')->with('error', 'Vous n\'avez pas les droits nécessaires pour compléter ce profil.');
    }
    
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create($classes)
    {
        $sallesDeClasses = SalleDeClasse::all();
        $classes = auth()->user()->professeur->classes;
        return view('Cours.coursCreate', compact('classes','sallesDeClasses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    // Validation des données de la requête
    $validatedData = $request->validate([
        'titre' => 'required|string|max:255',
        'descriptions' => 'required|string',
        'jours' => 'required|date',
        'heure_debut' => 'required|date_format:H:i',
        'heure_fin' => 'required|date_format:H:i',
        'fichier_cours' => 'required|file|mimes:pdf,doc,docx,ppt,pptx',
        'classe_id' => 'required|exists:classes,id',
    ]);

    try {
        // Récupérer l'utilisateur connecté (le professeur)
        $professeur = auth()->user()->professeur;

        // Téléchargement du fichier du cours
        $filePath = $request->file('fichier_cours')->store('public/cours_fichiers');

        // Création du cours
        $cours = new Cours();
        $cours->titre = $validatedData['titre'];
        $cours->descriptions = $validatedData['descriptions'];
        $cours->jours = $validatedData['jours'];
        $cours->heure_debut = $validatedData['heure_debut'];
        $cours->heure_fin = $validatedData['heure_fin'];
        $cours->fichier_cours = $filePath; // Enregistrez le chemin complet du fichier
        $cours->professeur_id = $professeur->id;
        $cours->classe_id = $validatedData['classe_id'];
        $cours->save();

        // Rediriger vers la page de détails de la classe avec un message de succès
        return redirect()->route('professeurs.cours.list.prof', $validatedData['classe_id'])
                         ->with('success', 'Cours créé avec succès.');
    } catch (\Exception $e) {
        // Gérer les erreurs de manière appropriée
        return back()->withErrors(['error' => 'Une erreur est survenue lors de la création du cours.']);
    }
}


 // Méthode pour télécharger un cours
//  public function download($id)
//  {
//      $cours = Cours::findOrFail($id);
//      return Storage::disk('public')->download($cours->fichier_cours);
//  }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Professeur  $professeur
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $classe = Classe::with(['eleves', 'professeurs', 'emploisDuTemps'])->findOrFail($id);
        $eleves = Eleves::whereNull('classe_id')->get();
        $professeursAssignes = $classe->professeurs;
        return view('Classe.classesDetail', compact('classe','professeursAssignes','eleves'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Professeur  $professeur
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cours = Cours::find($id);

    if (!$cours) {
        return redirect()->route('professeurs.cours.index')->with('error', 'Le cours demandé n\'existe pas.');
    }
    return view('Cours.editCours', compact('cours'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Professeur  $professeur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cours = Cours::find($id);
    
        if (!$cours) {
            return redirect()->route('professeurs.cours.list.prof')->with('error', 'Le cours demandé n\'existe pas.');
        }
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'descriptions' => 'required|string',
            'jours' => 'required|date',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i',
            'fichier_cours' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx',
        ]);
        
    
        if ($request->hasFile('fichier_cours')) {
            $filePath = $request->file('fichier_cours')->store('cours_fichiers', 'public');
            $cours->fichier_cours = $filePath;
        }
    
        $cours->titre = $validatedData['titre'];
        $cours->descriptions = $validatedData['descriptions'];
        $cours->jours = $validatedData['jours'];
        $cours->heure_debut = $validatedData['heure_debut'];
        $cours->heure_fin = $validatedData['heure_fin'];
        $cours->save();
    
        return redirect()->route('professeurs.cours.list.prof')->with('success', 'Cours mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Professeur  $professeur
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cours = Cours::find($id);

        if (!$cours) {
            return redirect()->route('professeurs.cours.list.prof')->with('error', 'Le cours demandé n\'existe pas.');
        }

        $cours->is_deleted = true;
        $cours->save();

    return redirect()->route('professeurs.cours.list.prof')->with('success', 'Cours supprimé avec succès.');
    }


    public function listeCours()
    {
        $cours = Cours::where('is_deleted', false)->get();
        return view('Cours.listCours', compact('cours'));
    }

    public function detailCours($id)
    {
       $cours = Cours::find($id);
       $classe= Classe::find($id);

    if (!$cours) {
        return redirect()->route('cours.index')->with('error', 'Le cours demandé n\'existe pas.');
    }
        return  view('Cours.coursDetail',compact('cours','classe'));
    }
    


}
