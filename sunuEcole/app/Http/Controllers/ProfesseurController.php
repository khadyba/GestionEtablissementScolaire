<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Professeur;
use Illuminate\Http\Request;

class ProfesseurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('complete-profile');
    }


    public function showCompleteProfileForm()
    {
        return view('professeurs.complete-profile');
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
    
        // Sauvegarder les données dans la table professeurs
        $professeur = new Professeur();
        $professeur->nom = $validatedData['nom'];
        $professeur->prenoms = $validatedData['prenoms'];
        $professeur->spécialiter = $validatedData['spécialiter'];
        $professeur->adresse = $validatedData['adresse'];
        $professeur->telephone = $validatedData['telephone'];
        $professeur->user_id = auth()->user()->id;
        $professeur->save();
    
        // Redirection avec un message de succès
        return redirect()->route('professeurs.complete-profile')->with('success', 'Profil complété avec succès.');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function create()
    {
        // Récupérer les classes auxquelles le professeur est assigné
        $classes = auth()->user()->professeur->classes;

        return view('cours.create', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // Valider les données du formulaire
       $validatedData = $request->validate([
        'titre' => 'required|string|max:255',
        'descriptions' => 'required|string',
        'jours' => 'required|date',
        'heure_debut' => 'required|date_format:H:i',
        'heure_fin' => 'required|date_format:H:i',
        'fichier_cours' => 'required|string',
        'classe_id' => 'required|exists:classes,id',
    ]);

    // Créer un nouveau cours
    Cours::create([
        'titre' => $validatedData['titre'],
        'descriptions' => $validatedData['descriptions'],
        'jours' => $validatedData['jours'],
        'heure_debut' => $validatedData['heure_debut'],
        'heure_fin' => $validatedData['heure_fin'],
        'fichier_cours' => $validatedData['fichier_cours'],
        'professeur_id' => auth()->user()->professeur->id,
        'classe_id' => $validatedData['classe_id'],
    ]);

    // Redirection avec un message de succès
    return redirect()->route('cours.index')->with('success', 'Cours créé avec succès.');
}
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Professeur  $professeur
     * @return \Illuminate\Http\Response
     */
    public function show(Professeur $professeur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Professeur  $professeur
     * @return \Illuminate\Http\Response
     */
    public function edit(Professeur $professeur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Professeur  $professeur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Professeur $professeur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Professeur  $professeur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Professeur $professeur)
    {
        //
    }
}
