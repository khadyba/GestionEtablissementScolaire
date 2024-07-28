<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etablissement;
use Illuminate\Support\Facades\Auth;

class EtablissementController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     return view('Administrateur.etablissementFormulaire');
    // }
    public function create()
{
    $administrateur = auth()->user();
    // $etablissementExist = $administrateur->etablissement;
    // if ($etablissementExist) {
    //     return redirect()->route('admin.dashboard')->with('error', 'Vous avez déjà ajouté un établissement.');
    // }
    return view('Administrateur.etablissementFormulaire');
}
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $administrateur = Auth::guard('admin')->user();
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'directeur' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'type' => 'required|string|max:50',
        ]);
        $etablissement = Etablissement::create([
            'nom' => $validatedData['nom'],
            'directeur' => $validatedData['directeur'],
            'adresse' => $validatedData['adresse'],
            'telephone' => $validatedData['telephone'],
            'email' => $validatedData['email'],
            'type' => $validatedData['type'],
            'administrateur_id' => $administrateur->id, 
        ]);
        return redirect()->route('admin.dashboard')->with('success', 'Établissement ajouté avec succès.');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Etablissement  $etablissement
     * @return \Illuminate\Http\Response
     */
    public function show(Etablissement $etablissement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Etablissement  $etablissement
     * @return \Illuminate\Http\Response
     */
    public function edit(Etablissement $etablissement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Etablissement  $etablissement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Etablissement $etablissement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Etablissement  $etablissement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Etablissement $etablissement)
    {
        //
    }
}
