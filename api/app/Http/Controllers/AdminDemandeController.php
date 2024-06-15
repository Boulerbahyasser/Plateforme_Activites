<?php

namespace App\Http\Controllers;

use App\Models\ActiviteOffre;
use App\Models\Demande;
use App\Models\DemandeInscription;
use App\Models\Devis;
use App\Models\Enfant;
use App\Models\Father;
use App\Models\Hda;
use App\Models\Horaire;
use App\Models\Notification;
use App\Models\Pack;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDemandeController extends Controller{
    public function gererDemande(Request $request,$demande_id,$activite_offre_id,$enfant_id){
        $demande = DemandeInscription::where('enfant_id', $enfant_id)
            ->where('activite_offre_id', $activite_offre_id)
            ->where('demande_id', $demande_id)
            ->update([
                'etat' => $request->etat,
                'motif' => $request->motif,
                'updated_at' => now()
            ]);
        $demande = DemandeInscription::where('enfant_id', $enfant_id)
            ->where('activite_offre_id', $activite_offre_id)
            ->where('demande_id', $demande_id)->first();
        if($request->etat == 'accepte')$msg = "the request is well accepted";
        else {

            $horaire = explode(',',$demande->horaire);
            $horaire_id = Horaire::where('jour',$horaire[0])->where('heure_debut',$horaire[1])
                ->where('horaires.heure_fin',$horaire[2])->first()->id;
            $hda = Hda::find($horaire_id);
            $hda->update(['nbr_place_restant'=>$hda->nbr_place_restant+1]);
            $msg = "the request is well denied";
        }
        $parent_id  = Enfant::find($enfant_id)->father_id;
        $parent= Father::find($parent_id);
        $user = User::find($parent->user_id);
        if(AdminDemandeController::isDemandeVerified($demande_id)) {
            NotificationController::notifyDemandeHandled($demande_id);
            DevisController::createDevis($demande_id,$user);
        }
        return response()->json(['message'=>$msg],200);

    }
    static public function isDemandeVerified($demande_id){
        $demandeInscriptions = DB::table('demande_inscriptions')
            ->where('demande_id', $demande_id)
            ->get();
        $result = true;
        foreach ($demandeInscriptions as $demandeInscription)
            if($demandeInscription->etat == 'en cours') $result = false;
        return $result;

    }

}
