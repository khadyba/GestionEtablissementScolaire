<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentsController extends Controller
{
    public function index()
    {
        $parent=Auth::user();
    $eleve = $parent->eleve;

    // Vérifier si l'élève existe et récupérer son emploi du temps s'il est disponible
    $emploiDuTemps = null;
    if ($eleve) {
        $emploiDuTemps = $eleve->emploisDuTemps;
    }
        return view('Parents.parentsdashboard', compact('emploiDuTemps'));
    }

    public function completerProfil()
    {
        return view('Parents.completerProfil');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'non_de_votre_éléve' => 'required|string|max:255',
            'telephone' => 'requiered',
        ]);
        $user = Auth::user();
        $parent = new Parents();
        $parent->nom = $request->input('nom');
        $parent->prenoms = $request->input('prenoms');
        $parent->non_de_votre_éléve = $request->input('non_de_votre_éléve');
        $parent->telephone = $request->input('telephone');
        $parent->user_id = Auth::id(); 
        $parent->is_completed = true;
        $parent->save();
        return redirect()->route('parents.parent.dashboard')->with('success', 'Profil complété avec succès.');
    }
}
