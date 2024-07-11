<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classe;
use App\Models\Cours;
use App\Models\Eleves;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\returnSelf;

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
        return view('elevesdashboard', compact('classes', 'parents','cours'));
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
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenoms' => 'required|string|max:255',
        'adresse' => 'required|string|max:255',
        'email_tuteur' => 'required|string|max:255',
        'non_de_votre_tuteur' => 'required|string|max:255',
        'dateDeNaissance' => 'required|date',
        'classe_id' => 'nullable|exists:classes,id',
        'parent_id' => 'nullable|exists:parents,id', 
    ]);
    $user = Auth::user();
   
    $eleve = new Eleves();
    $eleve->nom = $request->input('nom');
    $eleve->prenoms = $request->input('prenoms');
    $eleve->adresse = $request->input('adresse');
    $eleve->non_de_votre_tuteur = $request->input('non_de_votre_tuteur');
    $eleve->email_tuteur = $request->input('email_tuteur');
    $eleve->dateDeNaissance = $request->input('dateDeNaissance');
    $eleve->classe_id = $request->input('classe_id');
    $eleve->parent_id = $request->input('parent_id'); 
    $eleve->user_id = Auth::id(); 
    $eleve->is_completed = true;
    $eleve->save();

    return redirect()->route('eleve.dashboard')->with('success', 'Profil complété avec succès.');
}

    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Eleves  $eleves
     * @return \Illuminate\Http\Response
     */
    public function show(Cours $cours)
    {
        $cours=Cours::FindOrfail();
        return view('Cours.coursDetail');
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
