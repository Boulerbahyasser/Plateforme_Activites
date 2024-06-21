<?php

namespace App\Http\Controllers;

use App\Models\ActiviteOffre;
use App\Models\Demande;
use App\Models\Devis;
use App\Models\Pack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DevisController extends Controller
{
    static public function createDevis($demande_id,$user){
        $activiteOffreIds = DB::table('demande_inscriptions')
            ->where('demande_id', $demande_id)
            ->where('etat','accepte')
            ->pluck('activite_offre_id');
        $totale_ht = 0;
        foreach( $activiteOffreIds as $activiteOffreId){
            $activiteOffre = ActiviteOffre::find($activiteOffreId);
            $totale_ht+=$activiteOffre->tarif_remise;
        }
        $demande = Demande::find($demande_id);
        if($demande->pack_id) {
            $pack = Pack::find($demande->pack_id);
            $totale_ht = $totale_ht + ($totale_ht * ($pack->remise / 100));
        }
        $totale_ttc = $totale_ht + ($totale_ht*(11/100)); // (tva = 11%)
        $date = now();
        $pdf = PDFController::generatePDF($demande_id,$date,$totale_ht,$totale_ttc,$user);
        $devis = Devis::create([
            'demande_id'=>$demande_id,
            'date'=>$date,
            'totale_ht'=>$totale_ht,
            'totale_ttc'=>$totale_ttc,
            'pdf'=>$pdf,
            'statut'=>'en cours',
            'etat'=>'non paye'
        ]);
        NotificationController::notifyDevisCreated($demande_id,$devis);
    }
    public function UpdateDevis(Request $request,Devis $devis){
        $msg = "votre devis est accepte";
        $devis->update([
            'statut'=>$request->statut
        ]);
        if($request->has('motif')){
            $msg = "votre devis est refuse";
            $devis->update([
                'motif'=>$request->motif
            ]);
        }
        return response()->json(['message'=>$msg,200]);
    }
}
