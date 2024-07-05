<?php

namespace App\Http\Controllers;

use App\Models\EmploisDuTemps;
use Illuminate\Http\Request;

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
        $emploisDuTemps = EmploisDuTemps::all();
    
        // Retourner la vue avec les données nécessaires
        return view('listeEmploisDuTemps', compact('emploisDuTemps'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('uploadEmploiDuTemps');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'schedule_file' => 'required|file|mimes:pdf,doc,docx,xlsx',
        ]);

        $filePath = $request->file('schedule_file')->store('schedules', 'public');

        EmploisDuTemps::create([
            'emplois_du_temps' => $filePath,
            'administrateur_id' => auth('admin')->id(),
        ]);

        return redirect()->route('emplois_du_temps.index')->with('success', 'Emploi du temps uploadé avec succès.');
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
