<?php

namespace App\Http\Controllers;
use App\Models\Classe;
use App\Models\Eleves;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Mail\PaymentReceived;
use Illuminate\Support\Facades\Mail;
use Paydunya\Setup as PaydunyaSetup;
use Paydunya\Checkout\CheckoutInvoice;
use Paydunya\Checkout\Store as PaydunyaStore;

class PaymentController extends Controller
{

    protected $payDunyaService;

   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    // public function redirectToPayment()
    // {
    //         $eleve = Eleves::where('user_id', auth()->id())->firstOrFail();
        
    //     // Récupérer l'établissement associé à l'élève
    //     $etablissement = $eleve->user->etablissement; 

    //     $co = new CheckoutInvoice();
        
    //     // Ajouter les détails de l'article à l'invoice
    //     $co->addItem(
    //         "Frais de scolarité pour " . $eleve->prenoms . " " . $eleve->nom,
    //         "Frais de scolarité pour l'établissement " . $etablissement->nom,
    //         1,
    //         30000, 
    //         30000 
    //     );

    //     $co->setTotalAmount(30000); 

    //     // Créer la facture via PayDunya
    //     if ($co->create()) {
    //         Payment::create([
    //             'montant' => 30000, 
    //             'statut' => 1, 
    //             'date' => now(),
    //             'eleve_id' => $eleve->id
    //         ]);

    //         if (!empty($eleve->email_tuteur)) {
    //             Mail::to($eleve->email_tuteur)->send(new \App\Mail\PaymentReceived($eleve, 30000, $etablissement));
    //         }
    //         return redirect($co->getInvoiceUrl());
    //     } else {
    //         return response()->json(['error' => $co->response_text], 500);
    //     }
    // }
    



    public function redirectToPayment()
    {
        // Récupérer l'élève authentifié
        $eleve = Eleves::where('user_id', auth()->id())->firstOrFail();
        
        // Récupérer l'établissement associé à l'élève
        $etablissement = $eleve->user->etablissement;
    
        // Vérification si l'établissement est public
        if ($etablissement->type == 'public') {
            // Vérifier si l'élève a déjà payé son inscription
            $payment = Payment::where('eleve_id', $eleve->id)
                              ->where('statut', 1) // Statut 1 signifie payé
                              ->first();
    
            if ($payment) {
                // Si l'élève a déjà payé
                return redirect()->route('eleves.dashboard')->with('succes', 'Inscription déjà payée.');
            } else {
                // Si l'élève n'a pas payé, on redirige pour le paiement
                return $this->processPayment($eleve, $etablissement);
            }
        }
    
        // Si l'établissement est privé, on laisse l'élève passer à l'étape de paiement
        return $this->processPayment($eleve, $etablissement);
    }
    
    private function processPayment($eleve, $etablissement)

    {
        // Création de la facture
        $co = new CheckoutInvoice();
        
        // Ajouter les détails de l'article à l'invoice
        $co->addItem(
            "Frais de scolarité pour " . $eleve->prenoms . " " . $eleve->nom,
            "Frais de scolarité pour l'établissement " . $etablissement->nom,
            1,
            30000, // Montant par défaut
            30000  // Montant total
        );
    
        $co->setTotalAmount(30000);
    
        // Créer la facture via PayDunya
        if ($co->create()) {
            // Enregistrement du paiement
            Payment::create([
                'montant' => 30000, 
                'statut' => 1,  // Paiement réussi
                'date' => now(),
                'eleve_id' => $eleve->id
            ]);
    
            // Envoi de l'email de confirmation au tuteur
            if (!empty($eleve->email_tuteur)) {
                Mail::to($eleve->email_tuteur)->send(new \App\Mail\PaymentReceived($eleve, 30000, $etablissement));
            }
    
            // Redirection vers PayDunya pour effectuer le paiement
            return redirect($co->getInvoiceUrl());
        } else {
            // Si la facture n'a pas pu être créée, retourne une erreur
            return response()->json(['error' => $co->response_text], 500);
        }
    }
    





    public function success()
    {
        return view('payment.success');
    }
    public function cancel()
    {
        $classes = Classe::all();
        return view('Eleves.elevesdashboard', compact('classes'));
    }
    public function callback(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            if ($data['status'] == 'completed') {
                $eleve = Eleves::where('user_id', auth()->id())->firstOrFail();
                Payment::create([
                    'montant' => $data['total_amount'],
                    'date' => now(),
                    'status' => $data['status'],
                    'eleves_id' => $eleve->id
                ]);

                return response()->json(['status' => 'success'], 200);
            } else {
                return response()->json(['status' => 'failure', 'message' => 'Payment not completed'], 400);
            }
        } else {
            return response()->json(['error' => 'Method not allowed'], 405);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
