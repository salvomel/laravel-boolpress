<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lead;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewContactMail;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    // Funzione store per contatto utente
    public function store(Request $request) {
        $data = $request->all();

        // Validazione dati form (senza redirect, voglio risposta dell'Api)
        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'message' => 'required',
        ]);

        // Se ci sono errori torno risposta
        if ($validator->fails()) {
            
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }
        
        // (1) Salvo la nuova lead nel db
        $new_lead = new Lead();
        $new_lead->fill($data);
        $new_lead->save();

        // (2) Invio la mail al reponsabile cs
        Mail::to('customerservice@boolpress.it')->send(new NewContactMail($new_lead));

        return response()->json([
            'success' => true
        ]);
    }
}
