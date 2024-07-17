<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use App\Models\Classe;
use App\Models\Evaluations;
use Illuminate\Http\Request;
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
            return redirect()->back()->withErrors(['error' => 'Vous n\'êtes pas autorisé à programmer une évaluation pour cette classe.']);
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
    
            // Vérifier si le professeur est autorisé à programmer une évaluation pour cette classe
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
    
            return redirect()->route('professeurs.classes.index.prof')
                             ->with('success', 'Évaluation programmée avec succès.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la programmation de l\'évaluation.']);
        }
    }
    
    public function showAddNotesForm($classeId)
    {
        $classe = Classe::findOrFail($classeId);
        $professeurId = Auth::user()->professeur->id;

        // Récupérer les évaluations de ce professeur pour cette classe
        $evaluations = Evaluations::where('classe_id', $classeId)
            ->where('professeur_id', $professeurId)
            ->get();

        $eleves = $classe->eleves;

        return view('professeurs.evaluations.add_notes', compact('classe', 'evaluations', 'eleves'));
    }
   public function storeNotes(Request $request, $classeId)
{
    $professeur = auth()->user()->professeur;
    $validatedData = $request->validate([
        'notes.*.*.evaluation_id' => 'required|exists:evaluations,id',
        'notes.*.*.eleve_id' => 'required|exists:eleves,id',
        'notes.*.*.valeur' => 'required|integer|min:0|max:20',
        'notes.*.*.appreciations' => 'nullable|string',
    ]);
    foreach ($validatedData['notes'] as $eleveId => $evaluationNotes) {
        foreach ($evaluationNotes as $evaluationId => $noteData) {
            $noteData['professeur_id'] = $professeur->id;
            Notes::create($noteData);
        }
    }
    return redirect()->route('professeurs.notes.list')->with('success', 'Notes ajoutées avec succès.');
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
