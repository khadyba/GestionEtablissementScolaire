<?php
namespace App\Http\Controllers;
use App\Models\Cours;
use App\Models\Classe;
use App\Models\Eleves;
use App\Models\Professeur;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Mail\EmploiDuTempsMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProfessorAssignedNotification;
use App\Mail\ProfessorDetachedNotification;
use Illuminate\Support\Facades\Log; // Import de Log

class ClasseController extends Controller
{

    public function __construct()
{
    $this->middleware('auth:admin');

}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Classe::where('is_delete', false)->get();
        return view('Administrateur.Classe.listDesClasses', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $etablissements = Etablissement::all();

        return view('Administrateur.Classe.formulaireAjoutClasse', compact('etablissements'));
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
        'niveau' => 'required|string|max:255',
        'etablissement_id' => 'required|exists:etablissements,id',
     
    ]);
    $validatedData['administrateur_id'] = auth('admin')->id();
    Classe::create($validatedData);
    return redirect()->route('classes.index')->with('success', 'Classe créée avec succès.');
}
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Http\Response
     */
  
    public function show($id)
{
    $classe = Classe::with(['eleve', 'professeurs', 'emploisDuTemps'])->findOrFail($id);
    $this->authorize('view', $classe); 
    $eleve = Eleves::whereNull('classe_id')->get();
    $professeursAssignes = $classe->professeurs;
    return view('Administrateur.Classe.classesDetail', compact('classe','professeursAssignes','eleve'));
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Http\Response
     */
  
     public function edit($id)
     {
        $classe = Classe::findOrFail($id);
       return view('Administrateur.Classe.modifierClasses', compact('classe'));
     }
     


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Http\Response
     */
   // ClasseController.php

public function update(Request $request, $id)
{
    $classe = Classe::findOrFail($id);

    $request->validate([
        'nom' => 'required|string|max:255',
        'niveau' => 'required|string|max:255',
    ]);

    $classe->update($request->only(['nom', 'niveau']));

    return redirect()->route('classes.index')->with('success', 'Classe mise à jour avec succès.');
}



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    $classe = Classe::findOrFail($id);

    if ($classe->administrateur_id !== auth('admin')->id()) {
        return redirect()->route('classes.index')->with('error', 'Vous n\'êtes pas autorisé à supprimer cette classe.');
    }
    
    $classe->is_delete = true;
    $classe->save();

    return redirect()->route('classes.index')->with('success', 'Classe supprimée avec succès.');
}

public function assignTeachers($id)
{

    $classe = Classe::findOrFail($id);
    $professeurs = Professeur::all();
    return view('Administrateur.assign-professeurs', compact('classe', 'professeurs'));
}

// public function storeAssignedTeacher(Request $request, $id)
// {
//     $validatedData = $request->validate([
//         'professeur_ids' => 'required|array',
//         'professeur_ids.*' => 'exists:professeurs,id',
//     ]);
//     $classe = Classe::findOrFail($id);
//      $etablissementName = $classe->etablissement->nom;
//     foreach ($validatedData['professeur_ids'] as $professeurId) {
//         DB::table('classe_professeur')->insert([
//             'classe_id' => $classe->id,
//             'professeur_id' => $professeurId,
//             'created_at' => now(),
//             'updated_at' => now(),
//         ]);
//     }
//     $professeur = Auth::user()->professeur;

//             if ($professeur && $professeur->email) {
//             Mail::to($professeur->email)->send(new ProfessorAssignedNotification($classe->nom, $etablissementName));
//         } else {
//             return redirect()->route('classes.index')->with('error', 'Le professeur n\'a pas d\'email.');
//         }

//         return redirect()->route('classes.index')->with('success', 'Professeurs assignés avec succès à la classe.');
// }
public function storeAssignedTeacher(Request $request, $id)
{
    $validatedData = $request->validate([
        'professeur_ids' => 'required|array',
        'professeur_ids.*' => 'exists:professeurs,id',
    ]);

    $classe = Classe::findOrFail($id);
    $classe->nom;
    // dd($classe->nom);
    $etablissementName = $classe->etablissement->nom;
    dd( $etablissementName);


    $errors = [];  // Pour collecter les messages d'erreur
    $success = []; // Pour collecter les messages de succès

    foreach ($validatedData['professeur_ids'] as $professeurId) {
        // Vérification si le professeur est déjà affecté à une classe
        $professeurAffectation = DB::table('classe_professeur')
            ->where('professeur_id', $professeurId)
            ->first();

        if ($professeurAffectation) {
            if ($professeurAffectation->classe_id == $classe->id) {
                $errors[] = "Le professeur Numéro {$professeurId} est déjà affecté à cette classe.";
                continue; // Passer au prochain professeur
            } else {
                $errors[] = "Le professeur Numéro {$professeurId} est déjà affecté à une autre classe (Classe Numéro {$professeurAffectation->classe_id}). 
                Veuillez le désaffecter avant de le réaffecter.";
                continue; // Passer au prochain professeur
            }
        }

        // Si le professeur n'est pas affecté, on l'ajoute à la classe
        DB::table('classe_professeur')->insert([
            'classe_id' => $classe->id,
            'professeur_id' => $professeurId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $success[] = "Le professeur Numéro {$professeurId} a été affecté avec succès à la classe.";

        // Récupération de l'utilisateur associé au professeur pour l'envoi d'email
        $professeur = Professeur::find($professeurId);
        $user = $professeur->user; // Relation avec la table `users`
        // dd( $user);

        if ($user && filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
            try {
                Mail::to($user->email);
                // ->send(new ProfessorAssignedNotification($classe->nom, $etablissementName));
            } catch (\Exception $e) {
                $errors[] = "Échec de l'envoi de l'email au professeur {$professeur->prenoms} {$professeur->nom} ({$user->email}).";
            }
        } else {
            $errors[] = "Le professeur Numéro {$professeurId} n'a pas d'adresse email valide.";
        }
    }

    // Gestion des messages d'erreur et de succès
    if (!empty($errors)) {
        session()->flash('error', implode('<br>', $errors));
    }

    if (!empty($success)) {
        session()->flash('success', implode('<br>', $success));
    }

    return redirect()->route('classes.index', $classe->id);
}




public function assignStudents($id)
{
    $classe = Classe::findOrFail($id);
    $eleves = Eleves::all();
    return view('Administrateur.assign-eleves', compact('classe', 'eleves'));
}
// public function storeAssignedStudents(Request $request, $id)
// {
//     $classe = Classe::findOrFail($id);
//     $validatedData = $request->validate([
//         'eleve_ids' => 'required|array',
//         'eleve_ids.*' => 'exists:eleves,id', 
//     ]);
    
//     foreach ($validatedData['eleve_ids'] as $eleveId) {
//         $eleve = Eleves::findOrFail($eleveId);
//         $classe->eleve()->save($eleve);
//     }
//     if (filter_var($eleve->email_tuteur, FILTER_VALIDATE_EMAIL)) {
//         // dd( Mail::to($eleve->email_tuteur)->send(new EmploiDuTempsMail($eleve)));
//         Mail::to($eleve->email_tuteur)->send(new EmploiDuTempsMail($eleve));
//     } else {
//         // Gérer les cas où l'email est invalide ou manquant
//         return redirect()->back()->withErrors(['email' => 'L\'email du tuteur est invalide.']);
//     }
    


//     return redirect()->route('classes.index', $classe->id)->with('success', 'Élèves assignés avec succès à la classe.');
// }


public function storeAssignedStudents(Request $request, $id)
{
    $classe = Classe::findOrFail($id);
    $validatedData = $request->validate([
        'eleve_ids' => 'required|array',
        'eleve_ids.*' => 'exists:eleves,id', 
    ]);

    foreach ($validatedData['eleve_ids'] as $eleveId) {
        $eleve = Eleves::findOrFail($eleveId);
        $classe->eleve()->save($eleve);
dd($eleve->email_tuteur);
        // Vérifier et envoyer l'email
        if ($eleve->email_tuteur && filter_var($eleve->email_tuteur, FILTER_VALIDATE_EMAIL)) {
            try {
                Mail::to($eleve->email_tuteur)->send(new EmploiDuTempsMail($eleve));
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'envoi de l\'email pour l\'élève ID ' . $eleve->id . ' : ' . $e->getMessage());
            }
        } else {
            Log::warning('Email tuteur non valide ou absent pour l\'élève ID : ' . $eleve->id);
        }
    }

    return redirect()->route('classes.index', $classe->id)
    ->with('success', 'Élèves assignés avec succès à la classe.');

}


public function detachProfesseurFromClasse($classeId, $professeurId)
{
    $classe = Classe::find($classeId);
    $professeur = Professeur::find($professeurId);

    if (!$classe || !$professeur) {
        return redirect()->route('admin.classes.index')->with('error', 'Classe ou Professeur non trouvé.');
    }

    $classe->professeurs()->detach($professeur->id);

    $etablissementName = $classe->etablissement->nom ?? 'Nom de l\'établissement par défaut';

    // Envoyer une notification par email au professeur
    if ($professeur && $professeur->email) {
        Mail::to($professeur->email)->send(new ProfessorDetachedNotification($classe->nom, $etablissementName));
    }

    return redirect()->route('classes.index')->with('success', 'Professeur retiré de la classe avec succès.');
}


public function detachEleveClasse($classeId, $eleveId)
{
    $classe = Classe::find($classeId);
    $eleve = Eleves::find($eleveId);

    if (!$eleve) {
        return redirect()->route('classes.index')->with('error', 'Élève non trouvé.');
    }
    if ($eleve->classe_id == $classeId) {
        $eleve->classe_id = null;
        $eleve->save();
        return redirect()->route('classes.index')->with('success', 'Élève retiré de la classe avec succès.');
    } else {
        return redirect()->route('classes.index')->with('error', 'Élève n\'est pas associé à cette classe.');
    }
}

public function manageProfessors($classeId)
{
    $classe = Classe::findOrFail($classeId);
    $professeurs = $classe->professeurs;
    return view('Administrateur.Classe.manageProfessors', compact('classe', 'professeurs'));
}

public function manageEleves($classeId)
{
    $classe = Classe::findOrFail($classeId);
    $eleves = $classe->eleve;
    // dd($eleves);
    return view('Administrateur.Classe.manageEleves', compact('classe', 'eleves'));
}


}

