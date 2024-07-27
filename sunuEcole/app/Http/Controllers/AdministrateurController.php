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
use App\Mail\NouveauCompteMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\AjoutProfRequest;
use App\Http\Requests\AdminRegisterRequest;

class AdministrateurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $elevesInscrits = Payment::where('statut', 1)
        ->with('eleve')
        ->get()
        ->unique('eleve_id');
        $emploisDuTemps = EmploisDuTemps::all();
        $classeId = Classe::first();
        $classeId = $classeId ? $classeId->id : null;
        return view('Administrateur.admindashboard',compact('elevesInscrits','emploisDuTemps','classeId'));
    }

    public function listeElevesInscrits()
    {
        $elevesInscrits = Payment::where('statut', 1)->with('eleve')->get();
        // $emploisDuTemps = EmploisDuTemps::all();
        return view('Administrateur.admindashboard', compact('elevesInscrits'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Administrateur.formulaireAdministrateur');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRegisterRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);

        Administrateur::create($validatedData);
        return redirect()->route('admin.login')->with('success', 'Inscription réussie, veuillez vous connecter !');
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
            return view('Administrateur.updateProfil', compact('admin'));
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
        return view('Administrateur.formulaireAjouProf', compact('etablissements'));
      }

    public function ajouterProfesseur(AjoutProfRequest $request)
    {
        $validatedData = $request->validated();

    if (empty($validatedData['password'])) {
        $validatedData['password'] = Str::random(8);
    }
    $hashedPassword = Hash::make($validatedData['password']);

    // Création d'un nouvel utilisateur avec les données validées
    $user = User::create([
        'email' => $validatedData['email'],
        'password' => $hashedPassword,
        'etablissement_id' => $validatedData['etablissement_id'],
    ]);
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
    if ($roleId) {
        DB::table('usersroles')->insert([
            'user_id' => $user->id,
            'role_id' => $roleId,
        ]);
    }

   
    $identifiants = [
        'email' => $validatedData['email'],
        'password' => $validatedData['password'],
    ];

    Mail::to($validatedData['email'])->send(new NouveauCompteMail($identifiants));
    // Redirection avec un message de succès et les identifiants
    return redirect()->route('list.index')->with([
        'success' => 'Utilisateur créé avec succès.',
        'identifiants' => $identifiants,
    ]);
}
}