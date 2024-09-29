<?php

namespace App\Http\Controllers;
use App\Models\Classe;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\EmploisDuTemps;

class EmploisDuTempsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récupérer tous les fichiers d'emploi du temps depuis la base de données
        $elevesInscrits = Payment::where('statut', 1)->with('eleve')->get();
        $emploisDuTemps = EmploisDuTemps::where('classe_id')->with;
        return view('Administrateur.admindashboard', compact('emploisDuTemps','elevesInscrits'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($classeId)
{
    $classe = Classe::findOrFail($classeId);
    return view('Administrateur.uploadEmploiDuTemps', compact('classe'));
}
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$classeId)
    {
        $request->validate([
            'emplois_du_temps' => 'required|file|mimes:pdf,doc,docx,xlsx',
        ]);

        $file = $request->file('emplois_du_temps');
       $filePath = $file->store('schedules', 'public');
       $originalFileName = $file->getClientOriginalName();

        EmploisDuTemps::create([
            'emplois_du_temps' => $filePath,
            'nom_original' => $originalFileName,
            'administrateur_id' => auth('admin')->id(),
            'classe_id' => $classeId,
        ]);

        return redirect()->route('emplois_du_temps.index')->with('success', 'Emploi du temps importer avec succès.');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmploisDuTemps  $emploisDuTemps
     * @return \Illuminate\Http\Response
     */
    public function show(EmploisDuTemps $emploisDuTemps)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmploisDuTemps  $emploisDuTemps
     * @return \Illuminate\Http\Response
     */
    public function edit(EmploisDuTemps $emploisDuTemps)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmploisDuTemps  $emploisDuTemps
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmploisDuTemps $emploisDuTemps)
    {
        //
    }
    public function download($id)
    {
        $emploiDuTemps = EmploisDuTemps::findOrFail($id);
    
        // Récupérez le chemin du fichier
        $filePath = storage_path('app/public/' . $emploiDuTemps->emplois_du_temps);
    
        // Récupérez le nom du fichier sans le chemin
        $fileName = basename($emploiDuTemps->emplois_du_temps);
    
        // Vérifiez si le fichier existe
        if (file_exists($filePath)) {
            // Téléchargez le fichier
            return response()->download($filePath, $fileName);
        } else {
            // Gérez l'erreur si le fichier n'existe pas
            abort(404, "Le fichier d'emploi du temps n'existe pas.");
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmploisDuTemps  $emploisDuTemps
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmploisDuTemps $emploisDuTemps)
    {
        //
    }
}
