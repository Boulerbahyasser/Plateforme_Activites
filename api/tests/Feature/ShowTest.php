<?php

namespace Tests\Feature;

use App\Models\Activite;
use App\Models\ActiviteOffre;
use App\Models\Administrateur;
use App\Models\Demande;
use App\Models\DemandeInscription;
use App\Models\Offre;
use App\Models\User;
use App\Models\Father;
use App\Models\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;
    public function testShowActivities(){
        $activity1 = Activite::factory()->create();
        $activity2 = Activite::factory()->create();
        $activity3 = Activite::factory()->create();

        $response = $this->getJson('api/show/activities/');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                    '*'=>['id','image_pub','description','lien_youtube','objectifs','domaine']
                 ])
                ->assertJsonCount(3);
    }

    public function testShowOffers()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $offre1=Offre::factory()->create();
        $offre2=Offre::factory()->create();

        $response = $this->getJson('/api/show/offers/');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    '*' => ['id','admin_id','titre', 'date_debut', 'date_fin', 'description', 'remise'],
                ])
                 ->assertJsonCount(2); 
   } 
   
   public function testShowOffer()
   {
        $offer = Offre::factory()->create();
        
        $response = $this->getJson("/api/show/offer/{$offer->id}");

        $response->assertStatus(200)
                 ->assertJsonStructure(['id','admin_id','titre', 'date_debut', 'date_fin', 'description', 'remise']);
    }

    public function testShowDemandesOfAdmin(){
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $admin1 = Administrateur::factory()->create([
            'user_id'=>$user1->id
        ]);

        $admin2 = Administrateur::factory()->create([
            'user_id'=>$user2->id
        ]);

        $this->actingAs($user1);

        $demande1 = Demande::factory()->create([
            'admin_id' => $admin1->id,
            'statut' => 'valide',
        ]);
        $demandeInscription1 = DemandeInscription::factory()->create([
            'demande_id' => $demande1->id,
            'etat' => 'en cours',    
        ]);

        $demande2 = Demande::factory()->create([
            'admin_id' => $admin1->id,
            'statut' => 'non valide',
        ]);
        $demandeInscription2 = DemandeInscription::factory()->create([
            'demande_id' => $demande2->id,
            'etat' => 'en cours',
        ]);

        $demande3 = Demande::factory()->create([
            'admin_id' => $admin2->id,
            'statut' => 'valide',
        ]);
        $demandeInscription3 = DemandeInscription::factory()->create([
            'demande_id' => $demande3->id,
            'etat' => 'en cours',    
        ]);

        $response = $this->getJson('api/show/demandes/admin');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                    '*' => ['id', 'date'],
                 ])
                 ->assertJsonCount(1);
    }

    public function testShowTopOffers()
   {
        $offer = Offre::factory()->count(5)->create();
        $response = $this->getJson("api/show/offers/top");
        $response->assertStatus(200)
                 ->assertJsonStructure([
                    '*'=>['id','admin_id','titre', 'date_debut', 'date_fin', 'description', 'remise']])
                 ->assertJsonCount(3);
    }

    public function testShowRemainingOffers(){
        $offer = Offre::factory()->count(5)->create();
        $response = $this->getJson("api/show/offers/remaining");
        $response->assertStatus(200)
                 ->assertJsonStructure([
                    '*'=>['id','admin_id','titre', 'date_debut', 'date_fin', 'description', 'remise']])
                 ->assertJsonCount(2);
    }

    public function testShowActivitiesOfferInOffer(){
        $offer = Offre::factory()->create();
        $activities_offer = ActiviteOffre::factory()->count(3)->create([
            'offre_id'=>$offer->id,
        ]);

        $response = $this->getJson("api/show/offer/activities/more/{$offer->id}");
        $response->assertStatus(200)
                 ->assertJsonStructure([
                    '*'=>['id','offre_id','activite_id','tarif','tarif_remise','age_min','age_max','nbr_seance','volume_horaire','option_paiement']])
                 ->assertJsonCount(3);
    }

    public function testShowTopParentNotifications()
    {
        // Crée un utilisateur de test et l'authentifie
        $user = User::factory()->create();
        $parent = Father::factory()->create(['user_id'=> $user->id]);
        $this->actingAs($user);

        // Crée 10 notifications pour cet utilisateur
        Notification::factory()->count(10)->create(['user_id' => $user->id]);

        // Appelle la méthode showTopParentNotifications
        $response = $this->getJson('/api/show/notification/parent/top/');

        // Vérifie que la réponse a un statut HTTP 200
        $response->assertStatus(200);

        // Vérifie que seulement 7 notifications sont retournées
        $response->assertJsonCount(7);

        // Vérifie que les notifications sont ordonnées par date décroissante
        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get();
        $response->assertJson($notifications->toArray());
    }

    public function test_showRemainingParentNotifications()
    {
        // Crée un utilisateur de test et l'authentifie
        $user = User::factory()->create();
        $parent = Father::factory()->create();
        $this->actingAs($user);

        // Crée 10 notifications pour cet utilisateur
        Notification::factory()->count(10)->create(['user_id' => $user->id]);

        // Appelle la méthode showRemainingParentNotifications
        $response = $this->getJson('/api/show/notification/parent/remaining');

        // Vérifie que la réponse a un statut HTTP 200
        $response->assertStatus(200);

        // Vérifie que 3 notifications sont retournées (les notifications restantes après les 7 premières)
        $response->assertJsonCount(3);

        // Vérifie que les notifications sont ordonnées par date décroissante
        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->skip(7)
            ->take(PHP_INT_MAX)
            ->get();
        $response->assertJson($notifications->toArray());
    }

}
