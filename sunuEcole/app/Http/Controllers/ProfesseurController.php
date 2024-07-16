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
        return view('Professeurs.profdashboard', compact('classes'));
    }
    public function showCompleteProfileForm()
    {
        return view('Professeurs.complete-profile');
    }

    public function completeProfile(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'spécialiter' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
        ]);
        $user = Auth::user();
        $role = DB::table('usersroles')
            ->where('user_id', $user->id)
            ->first();
        if ($role && $role->role_id == 1) {
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
            $professeur->is_completed = true; 
            $professeur->save();
            return redirect()->route('professeurs.prof.dashboard')->with('success', 'Profil complété avec succès.');
        }

        return redirect()->route('home')->with('error', 'Vous n\'avez pas les droits nécessaires pour compléter ce profil.');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //  public function create($classes)
    // {
    //     $sallesDeClasses = SalleDeClasse::all();
    //     $classes = auth()->user()->professeur->classes;
    //     return view('Professeurs.Cours.coursCreate', compact('classes','sallesDeClasses'));
    // }
public function create($id)
{
    // Rechercher la classe par son ID
    $classe = Classe::find($id);

    // Vérifier si la classe a été trouvée
    if (!$classe) {
        // Gérer le cas où aucune classe n'est trouvée avec cet ID
        return redirect()->route('route.vers.une.page.d.erreur')->withErrors(['error' => 'Classe non trouvée']);
    }

    // Si une classe est trouvée, continuer
    $professeur = auth()->user()->professeur;
    $sallesDeClasses = SalleDeClasse::all(); // Supposons que vous avez besoin de salles de classe pour la création du cours

    return view('Professeurs.Cours.coursCreate', compact('classe', 'sallesDeClasses'));
}

    
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
            $professeur = auth()->user()->professeur;
            $classeId = $validatedData['classe_id'];
            $classe = Classe::findOrFail($classeId);
    
         
            if (!$professeur->classes->contains($classe)) {
                return back()->withErrors(['error' => 'Vous n\'êtes pas autorisé à ajouter un cours à cette classe.']);
            }
    
            $filePath = $request->file('fichier_cours')->store('public/cours_fichiers');
            $cours = new Cours();
            $cours->titre = $validatedData['titre'];
            $cours->descriptions = $validatedData['descriptions'];
            $cours->jours = $validatedData['jours'];
            $cours->heure_debut = $validatedData['heure_debut'];
            $cours->heure_fin = $validatedData['heure_fin'];
            $cours->fichier_cours = $filePath;
            $cours->professeur_id = $professeur->id;
            $cours->classe_id = $validatedData['classe_id'];
            $cours->save();
    
            return redirect()->route('professeurs.cours.list.prof', $validatedData['classe_id'])
                             ->with('success', 'Cours créé avec succès.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la création du cours.']);
        }
    }
    
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
        return view('Professeurs.Classes.classesDetail', compact('classe','professeursAssignes','eleves'));
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
    return view('Professeurs.Cours.editCours', compact('cours'));
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


    // public function listeCours()
    // {
    //     $cours = Cours::where('is_deleted', false)->get();
    //     return view('Professeurs.Cours.listCours', compact('cours'));
    // }

    public function listeCours($classeId)
    {
        $professeur = auth()->user()->professeur;
        $classe = Classe::findOrFail($classeId);
    
        // Vérifier si le professeur est assigné à la classe
        if (!$professeur->classes->contains($classe)) {
            return redirect()->back()->withErrors(['error' => 'Vous n\'êtes pas autorisé à voir les cours de cette classe.']);
        }
    
        $cours = Cours::where('classe_id', $classeId)->where('is_deleted', false)->get();
    
        return view('Professeurs.Cours.listCours', compact('classe', 'cours'));
    }
    

    
    public function detailCours($id)
    {
       $cours = Cours::find($id);
       $classe= Classe::find($id);

    if (!$cours) {
        return redirect()->route('cours.index')->with('error', 'Le cours demandé n\'existe pas.');
    }
        return  view('Professeurs.Cours.coursDetail',compact('cours','classe'));
    }
    


}
