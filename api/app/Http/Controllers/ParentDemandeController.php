<?php

namespace App\Http\Controllers;

use App\Models\ActiviteOffre;
use App\Models\Administrateur;
use App\Models\Demande;
use App\Models\DemandeInscription;
use App\Models\Hda;
use App\Models\Horaire;
use App\Models\Notification;
use App\Models\Offre;
use App\Models\Pack;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Event\Exception;

class ParentDemandeController extends Controller
{
    public function storeDemande(Request $request){
        $demandes = $request->json()->all();
    $activite_offre=ActiviteOffre::find($demandes[0]['activite_offre_id']);
    $offre = Offre::find($activite_offre->offre_id);
    $admin_id = $offre->admin_id;
        if ($request['pack']) {
            $pack_id = Pack::where('nom', $request['pack'])->first()->id;}
        else $pack_id = null;
    $demande_= Demande::create([
    'admin_id'=>  $admin_id,
    'date'=> now(),
    'statut'=>"valide",
        'pack_id'=>$pack_id
      ]);
    $demande_id = $demande_->id;
        foreach($demandes as $demande){
          $horaire = explode(',',$demande['horaire']);
//          $horaire2 = explode(',',$demande['horaire2']);
              $horaire_id = Horaire::where('jour', $horaire[0])->where('heure_debut', $horaire[1])
                  ->where('heure_fin', $horaire[2])->first()->id;

          //return response()->json($horaire_id,200);
//          $horaire2_id = Horaire::where('jour',$horaire2[0])->where('heure_debut',$horaire2[1])
//              ->where('horaires.heure_fin',$horaire2[1])->first()->id;
          $hda = Hda::find($horaire_id);
//          $hda2 = Hda::find($horaire2_id);
          $hda->update(['nbr_place_restant'=>$hda->nbr_place_restant-1]);
//          $hda2->update(['nbr_place_restant'=>$hda2->nbr_place_restant-1]);

          DemandeInscription::create([
          'enfant_id' => $demande['enfant_id'],
          'activite_offre_id' => $demande['activite_offre_id'],
          'demande_id' => $demande_id,
          'horaire' => $demande['horaire'],
//          'horaire2' => $demande['horaire2'],
          'etat' => "en cours",
          'motif' => ""
      ]);

        $this->createNotification($admin_id,$demande_id);
    }



    return response()->json(["message"=>"insertion successful"],201);
    }
    public function createNotification($admin_id,$demande_id){
        $user =(Administrateur::find($admin_id));
        $user_id = $user->id;
        Notification::create([
          'user_id'=>  $user_id,
         'date' =>now(),
         'contenu' => 'Demande '.$demande_id.' est bien cree',
         'type'=>'creation de demande'
        ]);

    }
}

