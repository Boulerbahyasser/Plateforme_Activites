<?php

namespace App\Http\Controllers;

use App\Models\ActiviteOffre;
use App\Models\DemandeInscription;
use App\Models\Devis;
use App\Models\Hda;
use App\Models\Horaire;
use App\Models\PlanningEnf;
use Illuminate\Http\Request;

class AdminPlanningController extends Controller
{
    static public function insertEnfantInPlanning($lesDevis){
        foreach ($lesDevis as $devis){
            $devis_row = Devis::find($devis->id);
            $demandes = DemandeInscription::where('demande_id',$devis_row->demande_id)
                ->where('etat','accepte')->get();
            foreach ($demandes as $demande){
                $horaire = explode(',',$demande->horaire);
                $horaire_id1 = Horaire::where('jour',$horaire[0])
                    ->where('heure_debut',$horaire[1])
                    ->where('heure_fin',$horaire[2])
                    ->first()->id;
                $activite_id =ActiviteOffre::find($demande->activite_offre_id)->activite_id;
                PlanningEnf::create([
                        'enfant_id' => $demande->enfant_id,
                        'activite_id' => $activite_id,
                        'horaire_id' => $horaire_id,
                ]);
            }
        }
    }
}
