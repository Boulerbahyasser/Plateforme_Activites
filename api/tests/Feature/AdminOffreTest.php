<?php

namespace Tests\Feature;

use App\Models\Administrateur;
use App\Models\Offre;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertJson;

class AdminOffreTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function testCreateOffer(){

        $user = User::factory()->create([
            'role'=>'admin',
            'email'=>'exemple@gmail.com',
            'password'=>bcrypt('1234'),
        ]);

        $admin = Administrateur::factory()->create([
            'user_id'=>$user->id,
        ]);
        
        $formData = [
            'titre' => 'Offre de test',
            'date_debut' => '2024-01-01',
            'date_fin' => '2024-12-31',
            'description' => 'Description de l\'offre de test',
            'domaine' => 'Programmation',
            'remise' => 15,
        ];

        $response = $this->actingAs($user)->postJson('api/create/offer',$formData);
       // dd($response);
        $response->assertStatus(201)
                 ->assertJson(['message'=>'the insertion was successful']);
        $this->assertDatabaseHas('offres',[
            'titre' => 'Offre de test',
            'date_debut' => '2024-01-01',
            'date_fin' => '2024-12-31',
            'description' => 'Description de l\'offre de test',
            'domaine' => 'Programmation',
            'remise' => 15,
            'admin_id' => $admin->id,
        ]);

    }

    public function testUpdateOffer()
    {
        // Crée un admin pour l'utiliser dans les tests

        $user = User::factory()->create([
            'role'=>'admin',
            'email'=>'exemple@gmail.com',
            'password'=>bcrypt('1234'),
        ]);

        $admin = Administrateur::factory()->create([
            'user_id'=>$user->id,
        ]);
        // Authentifie l'admin

        // Crée une offre existante
        $offer = Offre::factory()->create([
            'admin_id' => $admin->id,
            'titre' => 'Offre existante',
            'date_debut' => '2024-01-01',
            'date_fin' => '2024-12-31',
            'description' => 'Description de l\'offre existante',
          //  'domaine' => 'Programmation',
            'remise' => 10.00,
        ]);

        // Données du formulaire pour mettre à jour l'offre
        $formData = [
            'titre' => 'Offre mise à jour',
            'date_debut' => '2024-01-01',
            'date_fin' => '2024-12-31',
            'description' => 'Description mise à jour',
           // 'domaine' => 'Tests logiciels',
            'remise' => 20.00,
        ];

        // Effectue une requête PUT pour mettre à jour l'offre
        $response = $this->actingAs($user)->putJson("api/update/offer/{$offer->id}/", $formData);

        // Vérifie que la réponse est correcte
        $response->assertStatus(200)
                 ->assertJson(['message' => 'the update was successful']);

        // Vérifie que les données ont bien été mises à jour dans la base de données
        $this->assertDatabaseHas('offres', [
            'id' => $offer->id,
            'titre' => 'Offre mise à jour',
            'date_debut' => '2024-01-01',
            'date_fin' => '2024-12-31',
            'description' => 'Description mise à jour',
          //  'domaine' => 'Tests logiciels',
            'remise' => 20.00,
            'admin_id' => $admin->id,
        ]);
    }

    /** @test */
    public function testDestroyOffer()
    {
        // Crée une offre existante
        $offer = Offre::factory()->create();
        $this->assertDatabaseHas('offres',$offer->toArray());

        // Effectue une requête DELETE pour supprimer l'offre
        $response = $this->deleteJson("api/delete/offer/{$offer->id}");

        // Vérifie que la réponse est correcte
        $response->assertStatus(200)
                 ->assertJson(['message'=>'the delete was successful']);

        // Vérifie que les données ont bien été supprimées de la base de données
        $this->assertDatabaseMissing('offres', [
            'id' => $offer->id,
        ]);
    }
}
