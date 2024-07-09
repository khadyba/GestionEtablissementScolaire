<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentsController extends Controller
{
    public function index()
    {
        return view('parentsdashboard');
    }




    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'non_de_votre_éléve' => 'required|string|max:255',
            'telephone' => 'requiered',
        ]);
    
        $eleve = new Parents();
        $eleve->nom = $request->input('nom');
        $eleve->prenoms = $request->input('prenoms');
        $eleve->non_de_votre_éléve = $request->input('non_de_votre_éléve');
        $eleve->telephone = $request->input('telephone');
        $eleve->user_id = Auth::id(); 
        $eleve->save();
        return redirect()->route('eleve.dashboard')->with('success', 'Profil complété avec succès.');
    }
}
