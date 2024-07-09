<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Classe;
use App\Models\Eleves;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\Administrateur;

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
        return view('listDesClasses', compact('classes'));
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

        return view('formulaireAjoutClasse', compact('etablissements'));
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
        $classe = Classe::with(['eleves', 'professeurs'])->findOrFail($id);
    
        return view('classesDetail', compact('classe'));
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
       return view('modifierClasses', compact('classe'));
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
    // Récupérer la classe par ID
    $classe = Classe::findOrFail($id);

    // Récupérer l'établissement associé à la classe
    $etablissementId = $classe->etablissement_id;

    // Récupérer les professeurs associés à cet établissement
    $roleProfesseur = Role::where('nom', 'professeurs')->first();
    $professeurs = User::where('etablissement_id', $etablissementId)
        ->whereHas('roles', function($query) use ($roleProfesseur) {
            $query->where('role_id', $roleProfesseur->id);
        })
        ->with('professeur') 
        ->get();

    // Retourner une vue avec les données nécessaires
    return view('assign-professeurs', compact('classe', 'professeurs'));
}

public function storeAssignedTeacher(Request $request, $id)
{
    // Valider les données du formulaire
    $validatedData = $request->validate([
        'professeur_id' => 'required|exists:professeurs,id',
    ]);

    // Récupérer la classe par ID
    $classe = Classe::findOrFail($id);

    // Assigner le professeur à la classe
    $classe->professeurs()->sync([$validatedData['professeur_id']]);

    // Redirection vers la liste des classes avec un message de succès
    return redirect()->route('classes.index')->with('success', 'Professeur assigné avec succès à la classe.');
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
        ->with('eleves') 
        ->get();

    // Retourner une vue avec les données nécessaires
    return view('assign-eleves', compact('classe', 'eleves'));
}




public function storeAssignedStudents(Request $request, $id)
{
    $classe = Classe::findOrFail($id);
    $request->validate([
        'eleves' => 'required|array',
        'eleves.*' => 'exists:eleves,id'
    ]);

    // Affecter les élèves à la classe
    foreach ($request->eleves as $eleveId) {
        $eleve = Eleves::findOrFail($eleveId);
        $eleve->classe_id = $classe->id;
        $eleve->save();
    }
    // dd( $eleve);
    return redirect()->route('classes.show', $classe->id)->with('success', 'Les élèves ont été affectés avec succès.');
}







}
