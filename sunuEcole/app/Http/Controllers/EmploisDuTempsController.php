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
        return view('emplois-du-temps.index', compact('emploisDuTemps'));
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
            'file_path' => $filePath,
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
