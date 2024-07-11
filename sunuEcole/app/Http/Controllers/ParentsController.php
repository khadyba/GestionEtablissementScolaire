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
        $user = Auth::user();
        $parent = new Parents();
        $parent->nom = $request->input('nom');
        $parent->prenoms = $request->input('prenoms');
        $parent->non_de_votre_éléve = $request->input('non_de_votre_éléve');
        $parent->telephone = $request->input('telephone');
        $parent->user_id = Auth::id(); 
        $parent->is_completed = true;
        $parent->save();
        return redirect()->route('eleve.dashboard')->with('success', 'Profil complété avec succès.');
    }
}
