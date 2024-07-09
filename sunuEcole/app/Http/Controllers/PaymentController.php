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

    // public function __construct(PayDunyaService $payDunyaService)
    // {
    //     $this->payDunyaService = $payDunyaService;
    // }
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
        // dd( $etablissement->nom);
    
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
            Mail::to($eleve->email_tuteur)->send( new \App\Mail\PaymentReceived($eleve,$etablissement,30000));
        }
            // Redirection vers l'URL de la facture générée par PayDunya
            return redirect($co->getInvoiceUrl());
        } else {
            // Retourner une erreur JSON en cas d'échec de la création de la facture
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
    return view('elevesdashboard', compact('classes'));
}


public function callback(Request $request)
{
     // Vérifier que la méthode de la requête est POST
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
        // Retourner une erreur si la méthode de la requête n'est pas POST
        return response()->json(['error' => 'Method not allowed'], 405);
    }
}




// ...
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
