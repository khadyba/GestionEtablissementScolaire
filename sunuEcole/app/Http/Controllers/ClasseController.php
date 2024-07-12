<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Classe;
use App\Models\Eleves;
use App\Models\Professeur;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\Administrateur;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProfessorAssignedNotification;
use App\Mail\ProfessorDetachedNotification;

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
        return view('Classe.listDesClasses', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Classe::class);
        $etablissements = Etablissement::all();

        return view('Classe.formulaireAjoutClasse', compact('etablissements'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $this->authorize('create', Classe::class);
    
    // Validation des données du formulaire
    $validatedData = $request->validate([
        'nom' => 'required|string|max:255',
        'niveau' => 'required|string|max:255',
        'etablissement_id' => 'required|exists:etablissements,id',
     
    ]);

    // Ajout de l'ID de l'administrateur connecté aux données validées
    $validatedData['administrateur_id'] = auth('admin')->id();
     // dd(  $validatedData['administrateur_id']);

    // Création d'une nouvelle classe avec les données validées
    Classe::create($validatedData);

    // Redirection avec un message de succès
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
        $classe = Classe::with(['eleves', 'professeurs', 'emploisDuTemps'])->findOrFail($id);
        $eleves = Eleves::whereNull('classe_id')->get();
        $professeursAssignes = $classe->professeurs;
        return view('Classe.classesDetail', compact('classe','professeursAssignes','eleves'));
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
        $this->authorize('update',  $classe);
       return view('Classe.modifierClasses', compact('classe'));
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
    $this->authorize('update', $classe);

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
    $this->authorize('delete', $classe);

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
    return view('assign-professeurs', compact('classe', 'professeurs'));
}

public function storeAssignedTeacher(Request $request, $id)
{
    $validatedData = $request->validate([
        'professeur_ids' => 'required|array',
        'professeur_ids.*' => 'exists:professeurs,id',
    ]);

    $classe = Classe::findOrFail($id);
     // Récupérer le nom de l'établissement associé à la classe
     $etablissementName = $classe->etablissement->nom;
    // Attacher les professeurs à la classe
    foreach ($validatedData['professeur_ids'] as $professeurId) {
        DB::table('classe_professeur')->insert([
            'classe_id' => $classe->id,
            'professeur_id' => $professeurId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    $professeur = Auth::user()->professeur;

            if ($professeur && $professeur->email) {
            Mail::to($professeur->email)->send(new ProfessorAssignedNotification($classe->nom, $etablissementName));
        } else {
            // Gérer le cas où le professeur n'a pas d'email
            return redirect()->route('classes.index')->with('error', 'Le professeur n\'a pas d\'email.');
        }


    return redirect()->route('classes.index')->with('success', 'Professeurs assignés avec succès à la classe.');
}







public function assignStudents($id)
{
    // Récupérer la classe par ID
    $classe = Classe::findOrFail($id);

    // Récupérer l'établissement associé à la classe
    $etablissementId = $classe->etablissement_id;

    // Récupérer les élèves associés à cet établissement
    $roleEleves = Role::where('nom', 'eleves')->first(); 
    $eleves = User::where('etablissement_id', $etablissementId)
        ->whereHas('roles', function($query) use ($roleEleves) {
            $query->where('role_id', $roleEleves->id);
        })
        ->with('eleves') // Assurez-vous que cette relation existe dans le modèle User
        ->get();
        // dd($eleves);

    // Retourner une vue avec les données nécessaires
    return view('assign-eleves', compact('classe', 'eleves'));
}





public function storeAssignedStudents(Request $request, $id)
{
     // Récupérer la classe par ID
    $classe = Classe::findOrFail($id);

    // Valider les données du formulaire
    $validatedData = $request->validate([
        'eleve_ids' => 'required|array',
        'eleve_ids.*' => 'exists:eleves,id', // Vérifier que tous les IDs d'élèves existent dans la table eleves
    ]);

    // Affecter les élèves à la classe
    $classe->eleves()->sync($validatedData['eleve_ids']);
    // Redirection avec un message de succès
    return redirect()->route('assign.eleves', $classe->id)->with('success', 'Élèves assignés avec succès à la classe.');

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





public function manageProfessors($classeId)
{
    $classe = Classe::findOrFail($classeId);
    $professeurs = $classe->professeurs;
    
    return view('classe.manageProfessors', compact('classe', 'professeurs'));
}




}

