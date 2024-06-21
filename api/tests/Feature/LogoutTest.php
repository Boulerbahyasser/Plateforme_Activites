<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_can_logout()
    {
        // Créer un utilisateur
        $user = User::factory()->create();

        // Simuler l'authentification de l'utilisateur
        Sanctum::actingAs($user);

        // Vérifier que l'utilisateur est authentifié
        $this->assertNotNull(Auth::user());

        // Créer un token d'accès personnel pour l'utilisateur
        $token = $user->createToken('test-token');

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'tokenable_type' => get_class($user),
            'name' => 'test-token'
        ]);

        // Appeler la méthode de déconnexion
        $response = $this->postJson('/api/logout');

        // Vérifier que la réponse a un statut HTTP 200
        $response->assertStatus(200);

        // Vérifier la structure de la réponse JSON
        $response->assertJson([
            'status' => 200,
            'message' => 'you are successfully logout '
        ]);

        // Vérifier que les tokens de l'utilisateur sont supprimés
        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'tokenable_type' => get_class($user),
            'name' => 'test-token'
        ]);
    }
}
