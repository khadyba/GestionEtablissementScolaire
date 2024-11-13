<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Classe;
use App\Models\ElevesCours;
use App\Models\Evaluations;
use App\Models\Notes;
use Illuminate\Http\Request;

class ElevesCoursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Classe::all();
        return view('Eleves.classes.index', compact('classes'));
    }

    public function listCours($id)
    {
        
        $classe = Classe::findOrFail($id);
        $cours = Cours::where('classe_id', $id)->get();
        return view('Eleves.classes.cours', compact('classe','cours'));
    }


    public function listEvaluations($classeId)
    {
        $classe = Classe::findOrFail($classeId);
        $evaluations = Evaluations::where('classe_id', $classeId)->get();
        return view('Eleves.Evaluations.listEvaluation', compact('classe', 'evaluations'));
    }


    public function listNotes()
    {
        $user = auth()->user();
    
        if (!$user->eleve) {
            return redirect()->route('eleves.dashboard')->withErrors('Aucune relation élève trouvée pour cet utilisateur.');
        }
        $eleve = $user->eleve;
        $classe = $eleve->classe;
        $notes = Notes::where('eleve_id', $eleve->id)->get();
    
        return view('Eleves.Evaluations.listNotes', compact('notes','classe','eleve'));
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
     * @param  \App\Models\ElevesCours  $elevesCours
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     $classe = Classe::findOrFail($id);
    //     $eleve = auth()->user()->eleve;
        
    //     if ($eleve->classe_id !== $classe->id) {
    //         return redirect()->back()->withErrors(['error' => 'Vous n\'êtes pas autorisé à accéder à cette classe.']);
    //     }

    //     return view('Eleves.classes.detail', compact('classe'));
    // }

            public function show($id)
        {
            $classe = Classe::findOrFail($id);
            $eleve = auth()->user()->eleve;

            // Vérifier si l'élève est affecté à cette classe
            if (!$eleve || $eleve->classe_id !== $classe->id) {
                return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à accéder à cette classe.');
            }

            return view('Eleves.classes.detail', compact('classe'));
    }
    public function detailCours($id)
    {
        $cours = Cours::findOrFail($id);
        $classe= $cours->classe->id;
        return view('Eleves.classes.detailCours', compact('cours'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ElevesCours  $elevesCours
     * @return \Illuminate\Http\Response
     */
    public function edit(ElevesCours $elevesCours)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ElevesCours  $elevesCours
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ElevesCours $elevesCours)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ElevesCours  $elevesCours
     * @return \Illuminate\Http\Response
     */
    public function destroy(ElevesCours $elevesCours)
    {
        //
    }
}
