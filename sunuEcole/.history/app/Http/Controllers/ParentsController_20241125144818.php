<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompleterProfilParentRequest;
use App\Http\Requests\UpdateParentProfileRequest;
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

{
    public function index()
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
        return redirect()->route('parents.dashboard')->with('success', 'Profil complété avec succès.');
    }




    public function __construct()
    {
        $this->middleware(['auth', 'parent']);
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
    // Vérifiez que l'utilisateur est bien un parent connecté
    $parent = auth()->user();

    if (!$parent) {
        return redirect()->back()->with('error', 'Utilisateur non connecté ou non autorisé.');
    }

    // Récupérer l'élève associé au parent
    $eleve = Eleves::where('email_tuteur', $parent->email)->first();

    if (!$eleve) {
        return redirect()->back()->with('error', 'Aucun élève trouvé pour ce parent.');
    }

    // Vérifier si l'inscription est déjà payée
    $paiementEffectue = Payment::where('eleve_id', $eleve->id)->where('statut', 1)->exists();
    if ($paiementEffectue) {
        return redirect()->back()->with('error', 'L\'inscription de cet élève a déjà été effectuée.');
    }

    // Récupérer l'établissement de l'élève
    $etablissement = $eleve->etablissement;

    // Vérifier si l'établissement est public
    if ($etablissement->type === 'public') {
        return redirect()->back()->with('info', 'Aucun paiement requis pour les établissements publics.');
    }

    // Si l'établissement est privé, préparer la redirection vers PayDunya
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
        // Enregistrer le paiement
        Payment::create([
            'montant' => 30000,
            'statut' => 1,
            'date' => now(),
            'eleve_id' => $eleve->id,
        ]);

        // Envoyer un email au tuteur
        Mail::to($parent->email)->send(new \App\Mail\PaymentReceived($eleve, 30000, $etablissement));

        // Rediriger vers la page de paiement
        return redirect($co->getInvoiceUrl());
    } else {
        // Gestion des erreurs de création de facture
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
                // Vérifiez que l'utilisateur est bien un parent connecté
                $user = auth()->user();
                // dd( $user);

                if (!$user) {
                    return redirect()->back()->with('error', 'Utilisateur non connecté.');
                }

                // Nettoyez les données saisies
                $parentEmail = trim($user->email);
                $nomEleve = trim($request->input('non_de_votre_éléve'));
                // dd($nomEleve, $parentEmail);
                // Recherche insensible à la casse
                $eleve = Eleves::whereRaw('LOWER(nom) = ?', [strtolower($nomEleve)])
                    ->whereRaw('LOWER(email_tuteur) = ?', [strtolower($parentEmail)])
                    ->first();

                // Vérifiez si l'élève existe
                if (!$eleve) {
                    return redirect()->back()->with('error', 'Aucun élève trouvé avec ce nom pour ce parent.');
                }

                // Récupérez les données nécessaires
                $notes = Notes::where('eleve_id', $eleve->id)->get();
                $classe = $eleve->classe;
                $emploiDuTemps = EmploisDuTemps::where('classe_id', $eleve->classe_id)->latest()->first();

                // Retournez la vue avec les données
                return view('Parents.notes', compact('notes', 'emploiDuTemps', 'eleve', 'classe'));

            }

    public function showBulletin($classeId, $eleveId)
    {
        $eleve = Eleves::with('notes.evaluation')->findOrFail($eleveId);
        $classe = Classe::with('etablissement')->findOrFail($classeId);
    
        $totalNotes = 0;
        $totalCoefficients = 0;
    
        foreach ($eleve->notes as $note) {
            $totalNotes += $note->valeur * $note->coefficient;
            $totalCoefficients += $note->coefficient;
        }
    
        if ($totalCoefficients > 0) {
            $moyenne = $totalNotes / $totalCoefficients;
        } else {
            $moyenne = 0;
        }
    
        $etablissement = $classe->etablissement;
    
        return view('Parents.BultinEleves', compact('eleve', 'classe', 'etablissement', 'moyenne'));
    }

    public function editProfile(Parents $parent)
    {
        $parent = Auth::user()->parent;
        return view('Parents.profileEdit', compact('parent'));
    }

    public function updateProfile(UpdateParentProfileRequest $request,Parents $parent)
    {

        $user = Auth::user();
        $parent = $user->parent;
        $data = $request->validated();
        $parent->update($data);
    return redirect()->route('parents.profile.edit')->with('success', 'Profil mis à jour avec succès');
    }
}
