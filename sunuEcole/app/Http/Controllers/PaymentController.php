<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Services\PayDunyaService;

class PaymentController extends Controller
{




    protected $payDunyaService;

    public function __construct(PayDunyaService $payDunyaService)
    {
        $this->payDunyaService = $payDunyaService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function redirectToPayment()
    {
        $eleve = auth()->user();
        $etablissement = auth()->user()->etablissement; 
    
        //  les données de la facture avec les informations de l'établissement
        $invoiceData = [
            'invoice' => [
                'items' => [
                    [
                        'name' => 'Frais d\'inscription',
                        'quantity' => 1,
                        'unit_price' => 30000,
                        'total_price' => 30000,
                        'description' => 'Frais d\'inscription pour l\'année scolaire'
                    ]
                ],
                'total_amount' => 30000,
                'description' => 'Paiement des frais d\'inscription'
            ],
            'store' => [
                'name' => $etablissement->nom, 
                'tagline' => 'Une École d\'Excellence',
                'postal_address' => $etablissement->adresse,
                'phone' => $etablissement->telephone,
            ],
            'custom_data' => [
                'student_id' => $eleve->id
            ],
            'actions' => [
                'cancel_url' => route('payment.cancel'),
                'return_url' => route('payment.success'),
                'callback_url' => route('payment.callback')
            ]
        ];
    
        // Créer la facture via l'API PayDunya
        $response = $this->payDunyaService->createInvoice($invoiceData);
    
        if ($response['status'] === 'success') {
            return redirect($response['response_text']);
        } else {
            return redirect()->back()->with('error', 'Erreur lors de la création de la facture PayDunya.');
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
