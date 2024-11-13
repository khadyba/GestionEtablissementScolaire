<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use App\Models\Classe;
use App\Models\Evaluations;
use Illuminate\Http\Request;
use App\Models\Eleves; 
use Illuminate\Support\Facades\Auth;

class EvaluationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function listEvaluations($classeId)
{
    $classe = Classe::findOrFail($classeId);
    $professeur = auth()->user()->professeur;

    // Vérifiez si le professeur est affecté à la classe
    if (!$professeur->classes->contains($classe)) {
        return redirect()->route('professeurs.classes.index')
            ->with('error', 'Vous n\'êtes pas autorisé à voir les évaluations de cette classe.');
    }

    // Si le professeur est affecté à la classe, récupérez les évaluations
    $evaluations = Evaluations::where('classe_id', $classeId)->get();
    return view('Professeurs.Evaluations.listEvaluation', compact('classe', 'evaluations'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($classeId)
    {
        $professeur = auth()->user()->professeur;
        $classe = Classe::findOrFail($classeId);
        if (!$professeur->classes->contains($classe)) {
            return redirect()->route('professeurs.classes.index')->with('error', 'Vous n\'êtes pas autorisé à programmer une évaluation pour cette classe.');

        }
    
        return view('Professeurs.Evaluations.evaluationCreate', compact('classe'));
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
            'type' => 'required|string|max:255',
            'jours' => 'required|date',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i',
            'classe_id' => 'required|exists:classes,id',
        ]);
    
        try {
            $professeur = auth()->user()->professeur;
            $classe = Classe::findOrFail($validatedData['classe_id']);
                if (!$professeur->classes->contains($classe)) {
                return back()->withErrors(['error' => 'Vous n\'êtes pas autorisé à programmer une évaluation pour cette classe.']);
            }
            $evaluation = new Evaluations();
            $evaluation->titre = $validatedData['titre'];
            $evaluation->type = $validatedData['type'];
            $evaluation->jours = $validatedData['jours'];
            $evaluation->heure_debut = $validatedData['heure_debut'];
            $evaluation->heure_fin = $validatedData['heure_fin'];
            $evaluation->professeur_id = $professeur->id;
            $evaluation->classe_id = $validatedData['classe_id'];
            $evaluation->save();
    
            return redirect()->route('professeurs.classes.index')
                             ->with('success', 'Évaluation programmée avec succès.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la programmation de l\'évaluation.']);
        }
    }
    

    public function showAddNotesForm($classeId, $evaluationId)
{
    $classe = Classe::findOrFail($classeId);
    $evaluation = Evaluations::findOrFail($evaluationId);
    $professeurId = Auth::user()->professeur->id;

    // Récupérer les élèves qui n'ont pas encore de notes pour cette évaluation spécifique
    $eleves = $classe->eleve()->whereDoesntHave('notes', function($query) use ($evaluation) {
        $query->where('evaluation_id', $evaluation->id);
    })->get();

    return view('Professeurs.Evaluations.add_notes', compact('classe', 'evaluation', 'eleves'));
}
public function storeNotes(Request $request, $classeId)
{
    // Récupérer l'utilisateur (professeur)
    $professeur = auth()->user()->professeur;

    // Récupérer les données envoyées via le formulaire
    $data = $request->input('notes', []); // Utiliser une valeur par défaut si nécessaire

    // Vérifier si la classe existe
    $classe = Classe::find($classeId);
    if (!$classe) {
        return redirect()->back()->withErrors('Classe non trouvée.');
    }
    // Parcourir les données de notes pour les enregistrer ou mettre à jour
    foreach ($data as $eleveId => $noteData) {
        // Ajouter explicitement la classe_id dans les données avant l'insertion
        $noteData['classe_id'] = $classeId;
        // Insertion ou mise à jour des notes
        Notes::updateOrCreate(
            [
                'eleve_id' => $noteData['eleve_id'],
                'evaluation_id' => $noteData['evaluation_id'],
            ],
            [
                'valeur' => $noteData['valeur'] ?? null,
                'coefficient' => $noteData['coefficient'] ?? null,
                'appreciations' => $noteData['appreciations'] ?? '',
                'professeur_id' => $professeur->id,
                'classe_id' => $noteData['classe_id'] ?? '',
            ]
        );
    }
    return redirect()->route('professeurs.notes.list', $classeId)
        ->with('success', 'Notes enregistrées avec succès.');
}



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Evaluations  $evaluations
     * @return \Illuminate\Http\Response
     */
    public function show(Evaluations $evaluations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Evaluations  $evaluations
     * @return \Illuminate\Http\Response
     */
    public function edit(Evaluations $evaluations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Evaluations  $evaluations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evaluations $evaluations)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Evaluations  $evaluations
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evaluations $evaluations)
    {
        //
    }
}
