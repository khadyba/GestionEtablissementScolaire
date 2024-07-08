<?php

namespace App\Http\Controllers;

use App\Models\Eleves;
use Paydunya\Checkout\Store as PaydunyaStore;
use Paydunya\Checkout\CheckoutInvoice;
use App\Models\Payment;

use Illuminate\Http\Request;

use Paydunya\Setup as PaydunyaSetup;

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
        // PaydunyaStore::setLogoUrl("http://localhost/logo.png");
    }
    public function redirectToPayment()
    {
        $eleve = Eleves::where('user_id', auth()->id())->firstOrFail();
        $etablissement = auth()->user()->etablissement; 

        $co = new CheckoutInvoice();

          // Ajouter les détails de l'article à l'invoice
          $co->addItem(
            "Frais de scolarité pour " . $eleve->nom,
            "Frais de scolarité pour l'établissement " . $etablissement->nom,
            1,
            30000, // Prix de l'article
            0,
            30000 // Prix total
        );

        $co->setTotalAmount(30000); // Montant total de la facture

        if ($co->create()) {
            return redirect($co->getInvoiceUrl()); // Redirection vers l'URL de la facture
        } else {
            return response()->json(['error' => $co->response_text], 500); // Retourner une erreur JSON en cas d'échec
        }
    }
    

    

public function success()
{
    return view('payment.success');
}

public function cancel()
{
    return view('payment.cancel');
}


public function callback(Request $request)
{
    // Vérifier si le paiement a réussi (par exemple en vérifiant le statut de la réponse de PayDunya)
    $status = $request->input('status'); // Assurez-vous d'adapter cette ligne à votre logique exacte

    if ($status === 'success') {
        // Récupérer l'ID de l'élève depuis les données personnalisées (adapté à votre logique de création de facture)
        $studentId = $request->input('custom_data.student_id');

        // Enregistrer le paiement dans la base de données
        $montant = $request->input('invoice.total_amount'); // Adapter cette ligne selon votre structure de données
        $payment = new Payment([
            'montant' => $montant,
            'statut' => true, // Paiement réussi
            'eleve_id' => $studentId,
        ]);
        $payment->save();

        return redirect()->route('payment.success')->with('success', 'Paiement effectué avec succès.');
    } else {
        return redirect()->route('payment.cancel')->with('error', 'Échec du paiement.');
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
