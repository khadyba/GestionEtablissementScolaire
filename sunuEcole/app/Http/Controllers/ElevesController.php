<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cours;
use App\Models\Classe;
use App\Models\Eleves;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\returnSelf;
use App\Http\Requests\CompleterProfilEleveRequest;

class ElevesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Classe::all();
        $parents = User::whereHas('roles', function ($query) {
            $query->where('role_id', 3);
        })->get();
        $cours = Cours::all();
        return view('Eleves.elevesdashboard', compact('classes', 'parents','cours'));
    }
     public function completerProfil()
     {
        $classes = Classe::all();
        $parents = User::whereHas('roles', function ($query) {
            $query->where('role_id', 3);
        })->get();
        return view('Eleves.classes.completerProfil',compact('classes','parents'));
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
    public function store(CompleterProfilEleveRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();
        $eleve = new Eleves();
        $eleve->nom = $validated['nom'];
        $eleve->prenoms = $validated['prenoms'];
        $eleve->adresse = $validated['adresse'];
        $eleve->non_de_votre_tuteur = $validated['non_de_votre_tuteur'];
        $eleve->email_tuteur = $validated['email_tuteur'];
        $eleve->dateDeNaissance = $validated['dateDeNaissance'];
        $eleve->classe_id = $validated['classe_id'];
        $eleve->parent_id = $validated['parent_id'];
        $eleve->user_id = $user->id; 
        $eleve->is_completed = true;
        $eleve->save();
        return redirect()->route('eleves.eleve.dashboard')->with('success', 'Profil complété avec succès.');
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
    
        return view('Eleves.Evaluations.BulletinShow', compact('eleve', 'classe', 'etablissement', 'moyenne'));
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Eleves  $eleves
     * @return \Illuminate\Http\Response
     */
    public function show(Cours $cours)
    {
        $cours=Cours::FindOrfail($cours);
        return view('Eleves.classes.detailCours',compact('cours'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Eleves  $eleves
     * @return \Illuminate\Http\Response
     */
    public function edit(Eleves $eleves)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Eleves  $eleves
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Eleves $eleves)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Eleves  $eleves
     * @return \Illuminate\Http\Response
     */
    public function destroy(Eleves $eleves)
    {
        //
    }
}
