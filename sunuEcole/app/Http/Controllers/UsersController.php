<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;






class UsersController extends Controller
{

    public function connection()
{
    return  view('LoginForm');
}
public function LoginForm(Request $request)
{
    // Validation des données du formulaire
    $credentials = $request->validate([
        'email' => 'required|string|email|max:255',
        'password' => 'required|string|min:8',
    ]);

    // Tenter de connecter l'utilisateur
    if (Auth::attempt($credentials)) {
        // dd($credentials);
        // Authentification réussie
        $user = Auth::user();

        // Vérifier le rôle de l'utilisateur dans la table pivot
        $role = DB::table('usersroles')
            ->where('user_id', $user->id)
            ->first();

        // Redirection basée sur le rôle
        if ($role) {
            switch ($role->role_id) {
                case 1:
                    return redirect()->route('prof.dashboard');
                case 2:
                    return redirect()->route('eleve.dashboard');
                case 3:
                    return redirect()->route('/parent/dashboard');
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
    
    
}