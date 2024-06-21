<?php

namespace App\Http\Controllers;

use App\Models\Animateur;
use App\Models\HdAnim;
use Illuminate\Http\Request;

class AnimatorController extends Controller
{
    public function addAvailableHour(Request $request){
        $horaires = $request->json()->all();
        $user_id = auth()->id();
        $animateur_id = Animateur::where('user_id',$user_id)->first()->id;
        foreach ($horaires as $horaire)
            HdAnim::create(['animateur_id'=>$animateur_id,'horaire_id'=>$horaire['id']]);
        return response()->json(['message'=>'addition successful'],200);
    }
}