<?php

namespace App\Http\Controllers;

use App\Models\Horaire;
use Illuminate\Http\Request;

class AdminHoraireController extends Controller
{
    public function createHoraire(Request $request){
        $formFields = $request->validate([
            'jour' => ['required','in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'],
            'heure_debut' => ['required', 'date_format:H:i'],
            'heure_fin' => ['required', 'date_format:H:i']
        ]);
        Horaire::create($formFields);
        return response()->json(['message'=>'the horaire has been created'],201);
    }
    public function updateHoraire(Request $request,Horaire $horaire){
        $formFields = $request->validate([
            'jour' => ['required', 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'],
            'heure_debut' => ['required', 'date_format:H:i'],
            'heure_fin' => ['required', 'date_format:H:i']
        ]);
        $horaire->update($formFields);
        return response()->json(['message'=>'the horaire has been updated'],200);
    }
    public function deleteHoraire(Horaire $horaire){
        $horaire->delete();
        return response()->json(['message'=>'the horaire has been deleted'],200);
    }

}

