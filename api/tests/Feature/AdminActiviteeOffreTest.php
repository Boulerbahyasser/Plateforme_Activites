<?php

namespace Tests\Feature;

use App\Models\Activite;
use App\Models\Offre;
use App\Models\ActiviteOffre;
use App\Models\Administrateur;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminActiviteeOffreTest extends TestCase
{
    use RefreshDatabase;

    public function testAddActivityToOffre(){
        $offre = Offre::factory()->create();
        $activite = Activite::factory()->create();

        $formData = [
            'tarif' => 100.00,
            'age_min' => 5,
            'age_max' => 15,
            'nbr_seance' => 10,
            'volume_horaire' => 20,
            'option_paiement' => 'mensuel',
        ];

        $response = $this->postJson("api/add/offer/activity/{$offre->id}/{$activite->id}",$formData);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'the insertion was successful']);

                 $this->assertDatabaseHas('activite_offres', [
                    'offre_id' => $offre->id,
                    'activite_id' => $activite->id,
                    'tarif' => 100.00,
                    'age_min' => 5,
                    'age_max' => 15,
                    'nbr_seance' => 10,
                    'volume_horaire' => 20,
                    'option_paiement' => 'mensuel',
                ]);
    }

    public function testUpdateActivityInOffer(){
        $activityOffer = ActiviteOffre::factory()->create([
            'tarif' => 50.00,
            'age_min' => 6,
            'nbr_seance' => 8,
            'volume_horaire' => 16,
            'option_paiement' => 'hebdomadaire',
            'age_max' => 12,
        ]);

        $newData = [
            'tarif' => 60.00,
            'age_min' => 7,
            'nbr_seance' => 10,
            'volume_horaire' => 20,
            'option_paiement' => 'mensuel',
            'age_max' => 14,    
        ];

        $response = $this->putJson("api/update/offer/activity/{$activityOffer->id}",$newData);
        $response->assertStatus(200)
                 ->assertJson(['message' => 'the update was successful']);

        $this->assertDatabaseHas('activite_offres', [
            'id' => $activityOffer->id,
            'tarif' => $newData['tarif'],
            'age_min' => $newData['age_min'],
            'nbr_seance' => $newData['nbr_seance'],
            'volume_horaire' => $newData['volume_horaire'],
            'option_paiement' => $newData['option_paiement'],
            'age_max' => $newData['age_max'],
        ]);
    }

    public function testDestroyActivity(){
        $activityOffer = ActiviteOffre::factory()->create();
        
        $this->assertDatabaseHas('activite_offres',$activityOffer->toArray());
        
        $response = $this->deleteJson("api/delete/offer/activity/{$activityOffer->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'the delete was successful']);
        
        $this->assertDatabaseMissing('activite_offres',$activityOffer->toArray());
    }
    
}
