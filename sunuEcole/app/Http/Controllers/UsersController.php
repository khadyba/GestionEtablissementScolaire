<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Eleves;
use App\Models\Professeur;
use App\Models\Parents;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{

    public function connection()
{
    return  view('LoginForm');
}
public function LoginForm(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|string|email|max:255',
        'password' => 'required|string|min:8',
    ]);
    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $role = DB::table('usersroles')
            ->where('user_id', $user->id)
            ->first();
        if ($role) {
            switch ($role->role_id) {
                case 1: // Professeur
                    $professeur = Professeur::where('user_id', $user->id)->first();
                    if (!$professeur || !$professeur->is_completed) {
                        return redirect()->route('professeurs.professeurs.complete-profile');
                    }
                    return redirect()->route('professeurs.prof.dashboard');

                case 2: // Élève
                    $eleve = Eleves::where('user_id', $user->id)->first();
                    if (!$eleve || !$eleve->is_completed) {
                        return redirect()->route('eleves.eleves.completeProfileForm');
                    }
                    return redirect()->route('eleves.eleve.dashboard');

                case 3: // Parent
                    $parent = Parents::where('user_id', $user->id)->first();
                    if (!$parent || !$parent->is_completed) {
                        return redirect()->route('parents.parent.completeProfileForm');
                    }
                    return redirect()->route('parents.parent.dashboard');

                default:
                    return redirect()->route('home'); 
            }
        } else {
            // Gérer le cas où aucun rôle spécifique n'est défini
            return redirect()->route('home'); 
        }
    } else {
        // Authentification échouée
        return back()->withErrors([
            'email' => 'Les informations d\'identification fournies sont incorrectes.',
        ]);
    }
}



    
    public function create()
    {
        $etablissements = Etablissement::all(); 
     
        return view('formulaireInscription', compact('etablissements'));
    }

    public function store(Request $request)
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'etablissement_id' => 'required|exists:etablissements,id', 
            'typecompte' => 'required|string|in:professeurs,eleves,parents',
        ]);
    
        // Hachage du mot de passe
        $validatedData['password'] = Hash::make($validatedData['password']);
    
        // Création d'un nouvel utilisateur avec les données validées
        $user = User::create($validatedData);
    
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
            // Insérer les informations dans la table pivot usersrole
            DB::table('usersroles')->insert([
                'user_id' => $user->id,
                'role_id' => $roleId,
            ]);
        }
    
        // Redirection avec un message de succès
        return redirect()->route('users.login')->with('success', 'Utilisateur créé avec succès.');
    }
    
    

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('users.login')->with('success', 'Utilisateur créé avec succès.');
       
        // return redirect('users.login');
    }
}