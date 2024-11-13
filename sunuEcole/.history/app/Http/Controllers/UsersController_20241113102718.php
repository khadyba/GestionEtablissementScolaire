<?php

namespace App\Http\Controllers;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
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


public function LoginForm(LoginRequest $request)
{
   
    $credentials = $request->only('email', 'password');
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
                        return redirect()->route('professeurs.complete-profile');
                    }
                    return redirect()->route('professeurs.dashboard');

                case 2: // Élève
                    $eleve = Eleves::where('user_id', $user->id)->first();
                    if (!$eleve || !$eleve->is_completed) {
                        return redirect()->route('eleves.completeProfileForm');
                    }
                    return redirect()->route('eleves.dashboard');

                case 3: // Parent
                    $parent = Parents::where('user_id', $user->id)->first();
                    if (!$parent || !$parent->is_completed) {
                        return redirect()->route('parents.completeProfileForm');
                    }
                    return redirect()->route('parents.dashboard');

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
            'credentials' => 'Les informations d\'identification fournies sont incorrectes.',
        ])->onlyInput('email');
    }
}



    
    public function create()
    {
        $etablissements = Etablissement::all(); 
     
        return view('formulaireInscription', compact('etablissements'));
    }

    public function store(RegisterRequest $request)
    {
        $validatedData = $request->validated();
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
        return redirect()->route('users.login')->with('success', 'Compte  créé avec succès.');
    }
    
    

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('users.login')->with('success','Déconnexion reuisis avec succès.');
       
    }


                       public function editpassword()
                       {
                               return view('professeur');
                       }

                    public function updatePassword(Request $request)
                    {
 
                    // Valider les données du formulaire
                    $validated = $request->validate([
                        'current_password' => 'required|string',
                        'new_password' => 'required|string|min:8|confirmed', // Minimum 8 caractères et confirmation
                    ]);

                    // Vérifier si le mot de passe actuel correspond à celui de l'utilisateur
                    if (!Hash::check($validated['current_password'], Auth::user()->password)) {
                        return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
                    }

                    // Mettre à jour le mot de passe
                    $user = Auth::user();
                    $user->password = Hash::make($validated['new_password']);
                    $user->save();

                    // Rediriger avec un message de succès
                    return redirect()->route('professeurs.dashboard')->with('success', 'Votre mot de passe a été modifié avec succès.');

                    }



}