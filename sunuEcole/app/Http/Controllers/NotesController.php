<?php

namespace App\Http\Controllers;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Notes;
use App\Models\Classe;
use App\Models\Eleves;
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
    
    public function genererBulletin($classeId, $eleveId)
    {
        $eleve = Eleves::with('notes.evaluation')->findOrFail($eleveId);
        $classe = Classe::findOrFail($classeId);
    
        $totalNotes = 0;
        $totalCoefficients = 0;
    
        foreach ($eleve->notes as $note) {
            $totalNotes += $note->valeur * $note->coefficient;
            $totalCoefficients += $note->coefficient;
        }
    
        if ($totalCoefficients > 0) {
            $moyenne = $totalNotes / $totalCoefficients;
        } else {
            $moyenne = 0;
        }
    
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
    
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(view('Administrateur.classe.bulletin', compact('eleve', 'classe', 'moyenne'))->render());
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        return $dompdf->stream('bulletin_' . $eleve->id . '.pdf');
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
    public function showClassNotes($classeId)
    {
        $classe = Classe::with(['eleve.notes.evaluation'])->findOrFail($classeId);
        return view('Administrateur.classe.notes', compact('classe'));
    }
    
   
    public function showBulletin($classeId, $eleveId)
    {
        $eleve = Eleves::with('notes.evaluation')->findOrFail($eleveId);
        $classe = Classe::with('etablissement')->findOrFail($classeId);
    
        $totalNotes = 0;
        $totalCoefficients = 0;
    
        foreach ($eleve->notes as $note) {
            $totalNotes += $note->valeur * $note->coefficient;
            $totalCoefficients += $note->coefficient;
        }
    
        if ($totalCoefficients > 0) {
            $moyenne = $totalNotes / $totalCoefficients;
        } else {
            $moyenne = 0;
        }
    
        $etablissement = $classe->etablissement;
    
        return view('Administrateur.Classe.BulletinShow', compact('eleve', 'classe', 'etablissement', 'moyenne'));
    }
    




public function calculerMoyenne($eleveId)
{
    $eleve = Eleves::with('notes.evaluation')->findOrFail($eleveId);
    
    $totalNotes = 0;
    $totalCoefficients = 0;
    $coefficientsParEvaluation = [];

    foreach ($eleve->notes as $note) {
        $evaluationId = $note->evaluation_id;
        $valeur = $note->valeur;
        $coefficient = $note->coefficient;

        // Ajout de la note pondérée par le coefficient
        $totalNotes += $valeur * $coefficient;

        // Comptabilisation du coefficient une seule fois par évaluation
        if (!isset($coefficientsParEvaluation[$evaluationId])) {
            $coefficientsParEvaluation[$evaluationId] = $coefficient;
        }
    }

    // Calcul du total des coefficients uniques
    foreach ($coefficientsParEvaluation as $coef) {
        $totalCoefficients += $coef;
    }

    // Calcul de la moyenne
    if ($totalCoefficients > 0) {
        $moyenne = $totalNotes / $totalCoefficients;
        $moyenne = round($moyenne, 2); // Arrondir la moyenne à deux décimales
    } else {
        $moyenne = 0;
    }

    return back()->with('success', 'La moyenne de l\'élève est: ' . $moyenne);
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
    




    // public function calculerMoyenne($classeId, $eleveId)
    // {
    //     $eleve = Eleves::with('notes')->findOrFail($eleveId);
    //     $totalNotes = 0;
    //     $totalCoefficients = 0;

    //     foreach ($eleve->notes as $note) {
    //         $totalNotes += $note->valeur * $note->coefficient;
    //         $totalCoefficients += $note->coefficient;
    //     }

    //     if ($totalCoefficients > 0) {
    //         $moyenne = $totalNotes / $totalCoefficients;
    //     } else {
    //         $moyenne = 0;
    //     }

    //     return back()->with('success', 'La moyenne de l\'élève est: ' . $moyenne);
    // }


}

