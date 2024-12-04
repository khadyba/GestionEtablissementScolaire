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
        $admin = Auth::guard('admin')->user()->id;
        $classes = Classe::where('administrateur_id',   $admin)
                         ->where('is_delete', false)
                         ->get();
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


public function storeAssignedTeacher(Request $request, $id)
{
    $validatedData = $request->validate([
        'professeur_ids' => 'required|array',
        'professeur_ids.*' => 'exists:professeurs,id',
    ]);

    $classe = Classe::findOrFail($id);
    $classe->nom;
    $etablissementName = $classe->etablissement->nom;
    $errors = []; 
    $success = []; 

    foreach ($validatedData['professeur_ids'] as $professeurId) {
           $professeur = Professeur::find($professeurId);
        $professeurAffectation = DB::table('classe_professeur')
            ->where('professeur_id', $professeurId)
            ->first();
        if ($professeurAffectation) {
            if ($professeurAffectation->classe_id == $classe->id) {
                $errors[] = "Le professeur {$professeur->prenoms}  {$professeur->nom} est déjà affecté à cette classe.";
                continue;
            } else {
                $errors[] = "Le professeur {$professeur->prenoms} {$professeur->nom} est déjà affecté à une autre classe (Classe Numéro {$professeurAffectation->classe_id}). 
                Veuillez le retirer avant de le réaffecter.";
                continue; 
            }
        }
        DB::table('classe_professeur')->insert([
            'classe_id' => $classe->id,
            'professeur_id' => $professeurId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $success[] = "Le professeur {$professeur->prenoms} {$professeur->nom} a été affecté avec succès à la classe.";
     
        $user = $professeur->user; 
        if ($user && filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
            try {
                Mail::to($user->email)
                ->send(new ProfessorAssignedNotification($classe->nom, $etablissementName));
            } catch (\Exception $e) {
                $errors[] = "Échec de l'envoi de l'email au professeur {$professeur->prenoms} {$professeur->nom} ({$user->email}).";
                // dd($e);
            }
        } else {
            $errors[] = "Le professeur {$professeur->prenoms} {$professeur->nom} n'a pas d'adresse email valide.";
        }
    }

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
    return view('Administrateur.assign-eleves', compact('classe', 'eleve'));
}
public function storeAssignedStudents(Request $request, $id)
{
    $classe = Classe::findOrFail($id);  
    $validatedData = $request->validate([
        'eleve_ids' => 'required|array',  // Validation des élèves à affecter
        'eleve_ids.*' => 'exists:eleves,id',  // Vérification de l'existence des IDs des élèves
    ]);

    $errors = [];  // Liste pour collecter les erreurs
    $success = []; // Liste pour collecter les succès

    foreach ($validatedData['eleve_ids'] as $eleveId) {
        $eleve = Eleves::findOrFail($eleveId);  // Récupère l'élève à partir de son ID
        
        // Vérifier si l'élève est déjà affecté à la classe
        if ($eleve->classe_id && $eleve->classe_id == $classe->id) {
            // Si l'élève est déjà affecté à cette classe, on ajoute une erreur
            $errors[] = "L'élève {$eleve->prenoms} {$eleve->nom} est déjà affecté à cette classe. Veuillez d'abord le retirer avant de l'affecter à nouveau.";
            continue;  // Passe à l'élève suivant
        }

        // Si l'élève est affecté à une autre classe, envoyer un message d'erreur
        if ($eleve->classe_id && $eleve->classe_id != $classe->id) {
            // Message pour l'élève déjà affecté à une autre classe
            $errors[] = "L'élève {$eleve->prenoms} {$eleve->nom} est déjà affecté à une autre classe. Veuillez le retirer de l'autre classe avant de l'affecter à cette classe.";
            continue;  // Passe à l'élève suivant
        }

        // Si aucun problème, affecter l'élève à la classe
        $eleve->classe_id = $classe->id;
        $eleve->save();

        // Message de succès pour l'affectation
        $success[] = "L'élève {$eleve->prenoms} {$eleve->nom} a été affecté avec succès à la classe.";

        // Envoi de l'email au tuteur de l'élève
        if ($eleve->email_tuteur && filter_var($eleve->email_tuteur, FILTER_VALIDATE_EMAIL)) {
            try {
                Mail::to($eleve->email_tuteur)->send(new EmploiDuTempsMail($eleve));
            } catch (\Exception $e) {
                // En cas d'échec de l'envoi de l'email, on log l'erreur
                Log::error('Erreur lors de l\'envoi de l\'email pour l\'élève ' . $eleve->prenoms . ' ' . $eleve->nom . ' : ' . $e->getMessage());
            }
        } else {
            // Si l'email du tuteur est invalide ou absent, on log un avertissement
            Log::warning('Email tuteur non valide ou absent pour l\'élève ' . $eleve->prenoms . ' ' . $eleve->nom);
        }
    }

    // Affichage des messages d'erreur et de succès
    if (!empty($errors)) {
        session()->flash('error', implode('<br>', $errors));
    }

    if (!empty($success)) {
        session()->flash('success', implode('<br>', $success));
    }

    // Redirection vers la page de la classe
    return redirect()->route('classes.index', $classe->id);
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

