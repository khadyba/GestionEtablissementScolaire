<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Classe;
use Illuminate\Http\Request;
use App\Models\SalleDeClasse;
use Illuminate\Support\Facades\Auth;

class SalleDeClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // afficher la liste des salle que l'admin a créer 
    public function index()
    {
        $admin = Auth::guard('admin')->user()->id;
        $sallesDeClasse = SalleDeClasse::where('is_deleted', false,  $admin )->get();
        return view('Administrateur.Salle.sallesDeClasse', compact('sallesDeClasse'));
    }

public function afficherSallesDisponibles($id)
{
    $classe=Classe::findOrFail($id);
    $cours = Cours::findOrFail($id);
    $salles = SalleDeClasse::where('statut', 'libre')->get();

    return view('Administrateur.Salle.listSalles', compact('salles', 'cours','classe'));
}
        public function assignSalle($coursId, $salleId)
    {
        $cours = Cours::find($coursId);
        $salle = SalleDeClasse::find($salleId);
        if (!$cours || !$salle) {
            return redirect()->route('cours.index')->with('error', 'Le cours ou la salle de classe demandée n\'existe pas.');
        }
        $cours->salle_de_classe_id = $salle->id;
        $cours->save();
        $salle->statut = 'occupée';
        $salle->save();
        return redirect()->route('professeurs.cours.detail', $coursId)->with('success', 'Salle de classe assignée avec succès.');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Administrateur.Salle.createSalle');
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
            'numéro' => 'required|integer',
            'capaciter' => 'required|integer',
        ]);
    
        SalleDeClasse::create([
            'numéro' => $validatedData['numéro'],
            'capaciter' => $validatedData['capaciter'],
            'statut' => 'libre',
        ]);
    
        return redirect()->route('admin.salles-de-classe.index')->with('success', 'Salle de classe ajoutée avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SalleDeClasse  $salleDeClasse
     * @return \Illuminate\Http\Response
     */
    public function show(SalleDeClasse $salleDeClasse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SalleDeClasse  $salleDeClasse
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $salle = SalleDeClasse::findOrFail($id);
        return view('Administrateur.Salle.sallesDeClasseEdit', compact('salle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SalleDeClasse  $salleDeClasse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'numéro' => 'required|integer',
            'capaciter' => 'required|integer',
            'statut' => 'required|in:libre,occupe',
        ]);
    
        $salle = SalleDeClasse::findOrFail($id);
        $salle->update($validatedData);
    
        return redirect()->route('admin.salles-de-classe.index')->with('success', 'Salle de classe mise à jour avec succès.');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SalleDeClasse  $salleDeClasse
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $salle = SalleDeClasse::findOrFail($id);
        $salle->is_deleted = true;
        $salle->save();
    
        return redirect()->route('admin.salles-de-classe.index')->with('success', 'Salle de classe supprimée avec succès.');
    }
}
