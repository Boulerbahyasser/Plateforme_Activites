<?php

namespace Tests\Feature;

use App\Http\Controllers\NotificationController;
use App\Models\Demande;
use App\Models\DemandeInscription;
use App\Models\Devis;
use App\Models\Enfant;
use App\Models\Father;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function testNotifyDevisCreated()
    {
        // Configuration initiale des variables et des modèles
        $user = User::factory()->create();
        $parent = Father::factory()->create(['user_id'=>$user->id]);
        $enfant = Enfant::factory()->create(['father_id'=>$parent->id]);
        $demande = Demande::factory()->create();
        $devis = Devis::factory()->create(['demande_id'=>$demande->id]);
        $totale_ttc = $devis->totale_ttc;
        $totale_ttc = number_format($totale_ttc, 2, ',', ' ');
        $demande_inscription = DemandeInscription::factory()->create([
            'demande_id'=>$demande->id,
            'enfant_id'=>$enfant->id,
        ]);

        // Appel de la méthode notifyDevisCreated du contrôleur
        NotificationController::notifyDevisCreated($demande->id, $devis);

        // Vérification que la notification a été créée dans la base de données
        $this->assertDatabaseHas('notifications', [
            'user_id' => $user->id,
            'contenu' => 'Vous avez une nouvelle devis :'.$totale_ttc .' DH',
            'type' => 'nouveau devis'
        ]);
    }

    public function testNotifyDemandeHandled()
    {
        // Configuration initiale des variables et des modèles
        $user = User::factory()->create();
        $parent = Father::factory()->create(['user_id'=>$user->id]);
        $enfant = Enfant::factory()->create(['father_id'=>$parent->id]);
        $demande = Demande::factory()->create();
        $demande_inscription = DemandeInscription::factory()->create([
            'demande_id'=>$demande->id,
            'enfant_id'=>$enfant->id,
        ]);
        // Appel de la méthode notifyDemandeHandled du contrôleur
        NotificationController::notifyDemandeHandled($demande->id);

        // Vérification que la notification a été créée dans la base de données
        $this->assertDatabaseHas('notifications', [
            'user_id' => $user->id,
            'contenu' => 'La demande ' . $demande->id . ' a été traitée avec succès',
            'type' => 'traitement de demande'
        ]);
    }
}
