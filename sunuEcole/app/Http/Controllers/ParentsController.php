<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompleterProfilParentRequest;
use Log;
use App\Models\Notes;
use App\Models\Classe;
use App\Models\Eleves;
use App\Models\Parents;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\EmploisDuTemps;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Paydunya\Setup as PaydunyaSetup;
use Paydunya\Checkout\CheckoutInvoice;
use Paydunya\Checkout\Store as PaydunyaStore;

class ParentsController extends Controller
{public function index()
    {
        $parent = Auth::user();
        $eleve = $parent->eleve;
    
        $emploiDuTemps = null;
    
        if ($eleve) {
            $emploiDuTemps = Classe::join('emplois_du_temps', 'classes.id', '=', 'emplois_du_temps.classe_id')
                ->where('classes.id', $eleve->classe_id)
                ->get(['emplois_du_temps.*']);
        }
        return view('Parents.parentsdashboard', compact('emploiDuTemps'));
    }
    
    public function completerProfil()
    {
        return view('Parents.completerProfil');
    }
    public function store(CompleterProfilParentRequest $request)
    {

    $validated = $request->validated();
        $user = Auth::user();
        $parent = new Parents();
        $parent->nom = $validated['nom'];
        $parent->prenoms = $validated['prenoms'];
        $parent->non_de_votre_éléve = $validated['non_de_votre_éléve'];
        $parent->telephone = $validated['telephone'];
        $parent->user_id = Auth::id(); 
        $parent->is_completed = true;
        $parent->save();
        return redirect()->route('parents.parent.dashboard')->with('success', 'Profil complété avec succès.');
    }




    public function __construct()
    {
        PaydunyaSetup::setMasterKey(config('paydunya.master_key'));
        PaydunyaSetup::setPublicKey(config('paydunya.public_key'));
        PaydunyaSetup::setPrivateKey(config('paydunya.private_key'));
        PaydunyaSetup::setMode(config('paydunya.mode'));
        PaydunyaSetup::setToken(config('paydunya.token'));

        // Configurer les informations de la boutique
        PaydunyaStore::setName("SunuLycee"); // Seul le nom est requis
        PaydunyaStore::setTagline("Payer n'importe ou n'importe comment!");
        PaydunyaStore::setPhoneNumber("773611172");
        PaydunyaStore::setPostalAddress("Dakar, Sénégal");
        PaydunyaStore::setWebsiteUrl("http://127.0.0.1:8000");
    
       
        
    }
    public function redirectToPayment()
    {
        $eleve = Eleves::where('user_id', auth()->id())->firstOrFail();
    
    // Récupérer l'établissement associé à l'élève
    $etablissement = $eleve->user->etablissement; 

    $co = new CheckoutInvoice();
    
    // Ajouter les détails de l'article à l'invoice
    $co->addItem(
        "Frais de scolarité pour " . $eleve->prenoms . " " . $eleve->nom,
        "Frais de scolarité pour l'établissement " . $etablissement->nom,
        1,
        30000, 
        30000 
    );

    $co->setTotalAmount(30000); 

    // Créer la facture via PayDunya
    if ($co->create()) {
        Payment::create([
            'montant' => 30000, 
            'statut' => 1, 
            'date' => now(),
            'eleve_id' => $eleve->id
        ]);

        if (!empty($eleve->email_tuteur)) {
            Mail::to($eleve->email_tuteur)->send(new \App\Mail\PaymentReceived($eleve, 30000, $etablissement));
        }
        return redirect($co->getInvoiceUrl());
    } else {
        return response()->json(['error' => $co->response_text], 500);
    }
    }



    public function showEmploiDuTemps($eleveId)
    {
        $eleve = Eleves::findOrFail($eleveId);
        $emploiDuTemps = $eleve->classe->emploiDuTemps; 

        return view('Parents.emploi_du_temps', compact('eleve', 'emploiDuTemps'));
    }
    public function showNotes(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur non connecté.');
        }
    
        $parentEmail = $user->email;
        $nomEleve = $request->input('non_de_votre_éléve');
    
        $eleve = Eleves::where('nom', $nomEleve)
            ->where('email_tuteur', $parentEmail)
            ->first();
    
        if (!$eleve) {
            return redirect()->back()->with('error', 'Aucun élève trouvé avec ce nom pour ce parent.');
        }
    
        $notes = Notes::where('eleve_id', $eleve->id)->get();
        $emploiDuTemps = EmploisDuTemps::where('classe_id', $eleve->classe_id)->latest()->first(); // Récupère le dernier emploi du temps de la classe de l'élève
    
        return view('Parents.notes', compact('notes', 'emploiDuTemps', 'eleve'));
    }
    

}
