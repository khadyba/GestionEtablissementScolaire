<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classe;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\Administrateur;
use App\Models\EmploisDuTemps;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdministrateurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $elevesInscrits = Payment::where('statut', 1)->with('eleve')->get();
        $emploisDuTemps = EmploisDuTemps::all();
        $classeId = Classe::first();
        $classeId = $classeId ? $classeId->id : null;
        return view('admindashboard',compact('elevesInscrits','emploisDuTemps','classeId'));
    }

    public function listeElevesInscrits()
    {
        $elevesInscrits = Payment::where('statut', 1)->with('eleve')->get();

        return view('admindashboard', compact('elevesInscrits'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('formulaireAdministrateur');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // Validation des données du formulaire
         $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'required|string|email|unique:administrateurs|max:255',
            'password' => 'required|string|min:8',
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Création d'un nouvel administrateur avec les données validées
        Administrateur::create($validatedData);

        // Redirection avec un message de succès
        return redirect()->route('admin.login')->with('success', 'Administrateur créé avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Administrateur  $administrateur
     * @return \Illuminate\Http\Response
     */
    public function show(Administrateur $administrateur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Administrateur  $administrateur
     * @return \Illuminate\Http\Response
     */
    public function edit(Administrateur $administrateur)
    
       
        {
            $admin = auth()->user();
            return view('updateProfil', compact('admin'));
        }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Administrateur  $administrateur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Administrateur $administrateur)
    {
        $admin = Administrateur::find(auth()->id()); 

        $validatedData = $request->validate([
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);
    
        $admin->adresse = $validatedData['adresse'];
        $admin->telephone = $validatedData['telephone'];
        $admin->email = $validatedData['email'];

        $admin->save();
    
        return redirect()->route('admin.profile.edit')->with('success', 'Profil mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Administrateur  $administrateur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Administrateur $administrateur)
    {
        //
    }
      public function formulaire()
      {
        $etablissements = Etablissement::all(); 
        return view('formulaireAjouProf', compact('etablissements'));
      }

    public function ajouterProfesseur(Request $request)
    {
        

     // Validation des données du formulaire
     $validatedData = $request->validate([
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'nullable|string|min:8', 
        'etablissement_id' => 'required|exists:etablissements,id',
        'typecompte' => 'required|string|in:professeurs,eleves,parents',
    ]);

    // Génération d'un mot de passe si non fourni
    if (empty($validatedData['password'])) {
        $validatedData['password'] = Str::random(8);
    }

    // Hachage du mot de passe
    $hashedPassword = Hash::make($validatedData['password']);

    // Création d'un nouvel utilisateur avec les données validées
    $user = User::create([
        'email' => $validatedData['email'],
        'password' => $hashedPassword,
        'etablissement_id' => $validatedData['etablissement_id'],
    ]);

    // Déterminer l'ID du rôle basé sur le type de compte
    $roleId = null;
    switch ($request->typecompte) {
        case 'professeurs':
            $roleId = 1;
            break;
        case 'eleves':
            $roleId = 2;
            break;
        case 'parents':
            $roleId = 3;
            break;
    }

    // Vérifier que l'ID du rôle est défini
    if ($roleId) {
        // Insérer les informations dans la table pivot usersroles
        DB::table('usersroles')->insert([
            'user_id' => $user->id,
            'role_id' => $roleId,
        ]);
    }

    // Retourner les identifiants pour l'administrateur
    $identifiants = [
        'email' => $validatedData['email'],
        'password' => $validatedData['password'],
    ];

    // Redirection avec un message de succès et les identifiants
    return redirect()->route('list.index')->with([
        'success' => 'Utilisateur créé avec succès.',
        'identifiants' => $identifiants,
    ]);
}
}