<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $professeur = auth()->user()->professeur;
        $notes = Notes::where('professeur_id', $professeur->id)
            ->where('is_deleted', false) 
            ->get();
        
        return view('Professeurs.Evaluations.noteslist', compact('notes'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notes  $notes
     * @return \Illuminate\Http\Response
     */
    public function show(Notes $notes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notes  $notes
     * @return \Illuminate\Http\Response
     */
    public function edit(Notes $note)
    {
        return view('Professeurs.Evaluations.notesedit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notes  $notes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notes $note)
    {
        if ($note->professeur_id !== Auth::user()->professeur->id) {
            return redirect()->route('notes.edit', $note)->with('error', 'Vous n\'avez pas la permission de modifier cette note.');
        }
    
        $request->validate([
            'valeur' => 'required|numeric|min:0|max:20',
            'appreciations' => 'nullable|string|max:255',
        ]);
    
        $note->update([
            'valeur' => $request->input('valeur'),
            'appreciations' => $request->input('appreciations'),
        ]);
    
        return redirect()->route('professeurs.notes.list', $note)->with('success', 'Note mise à jour avec succès.');
    }
    
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notes  $notes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notes $notes)
    {
        $notes->update(['is_deleted' => true]);
    
        return redirect()->route('professeurs.notes.list')->with('success', 'Note supprimée avec succès.');
    }
    




    public function moyenneSemestrielle($semestre)
{
    $notes = $this->notes()->where('semestre', $semestre)->get();
    if ($notes->isEmpty()) {
        return null; 
    }

    $total = 0;
    $totalCoefficients = 0;

    foreach ($notes as $note) {
        $total += $note->valeur * $note->coefficient;
        $totalCoefficients += $note->coefficient;
    }

    return $totalCoefficients ? $total / $totalCoefficients : null;
}

}

