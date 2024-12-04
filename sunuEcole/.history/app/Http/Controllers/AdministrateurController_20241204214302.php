<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cours;
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
            $admin = Auth::guard('admin')->user();
            $etablissement = Etablissement::where('administrateur_id', $admin->id)->first();
            $elevesInscrits = collect();
            $emploisDuTemps = collect();
            $classeId = Classe::where('etablissement_id', $etablissement?->id)->first();
        
            if (!$etablissement) {
                return view('Administrateur.admindashboard', compact('elevesInscrits', 'emploisDuTemps', 'classeId'));
            }
        
            $elevesInscrits = Payment::where('statut', 1)
                ->with(['eleve.user.etablissement'])
                ->get()
                ->groupBy('eleve_id');
            $elevesInscrits = collect($elevesInscrits);
        
            $emploisDuTemps = EmploisDuTemps::whereHas('classe', function ($query) use ($etablissement) {
                $query->where('etablissement_id', $etablissement->id);
            })->get();
            $emploisDuTemps =  collect($emploisDuTemps);        
            return view('Administrateur.admindashboard', compact('elevesInscrits', 'emploisDuTemps', 'classeId'));
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

    public function listProfessors()
    {
        // Récupérer l'administrateur connecté
        $admin = Auth::guard('admin')->user();
        
        // Récupérer l'établissement de l'administrateur
        $etablissement = Etablissement::where('administrateur_id', $admin->id)->first();
    
        if (!$etablissement) {
            return redirect()->route('admin.dashboard')->with('error', 'Aucun établissement associé à cet administrateur.');
        }
        $professeurs = User::whereHas('roles', function ($query) {
            $query->where('nom', 'professeurs');
        })
        ->where('is_completed', false)
        ->where('etablissement_id', $etablissement->id) 
        ->get();
        return view('Administrateur.Professeurs.list', compact('professeurs'));
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
        $admin = Auth::guard('admin')->user();
        $etablissements = Etablissement::where('administrateur_id', $admin->id)->get();
        return view('Administrateur.formulaireAjouProf', compact('etablissements'));
    }
    
    public function ajouterProfesseur(AjoutProfRequest $request)
    {
        $admin = Auth::guard('admin')->user();
        $etablissement = Etablissement::where('id', $request->etablissement_id)
                                      ->where('administrateur_id', $admin->id)
                                      ->first();
        if (!$etablissement) {
            return redirect()->back()->with('error', 'L\'établissement sélectionné ne vous appartient pas ou n\'existe pas.');
        }
        $validatedData = $request->validated();
        if (empty($validatedData['password'])) {
            $validatedData['password'] = Str::random(8);
        }
        $hashedPassword = Hash::make($validatedData['password']);
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
    
        return redirect()->route('list.index')->with([
            'success' => 'Utilisateur créé avec succès.',
            'identifiants' => $identifiants,
        ]);
    }
    
public function destroyProfessor($id)
{
    $professeur = User::find($id);

    if ($professeur) {
        $professeur->is_completed = true;
        $professeur->save();
        return redirect()->route('professeurs.list')->with('success', 'Le compte du professeur a été désactivé avec succès.');
    }

    return redirect()->route('professeurs.list')->with('error', 'Le professeur n\'a pas été trouvé.');
}


}