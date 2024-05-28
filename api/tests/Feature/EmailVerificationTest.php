<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function testVerifyEmailSuccess()
    {
        // Crée un utilisateur avec un jeton de validation
        $user = User::factory()->create([
            'remember_token' => Str::random(40),
            'email_verified_at' => null,
        ]);

        // Appelle la méthode du contrôleur avec le jeton de validation de l'utilisateur
        $response = $this->getJson("/api/verify-email/{$user->remember_token}");

        // Vérifie que la réponse a un statut HTTP 200
        $response->assertStatus(200);
        // Vérifie que la réponse JSON contient les données attendues
        $response->assertJson([
            'status' => 200,
            'message' => 'Email verified successfully'
        ]);

        // Recharge l'utilisateur depuis la base de données
        $user->refresh();

        // Vérifie que la date de vérification de l'email a été définie
        $this->assertNotNull($user->email_verified_at);
    }

    public function testVerifyEmailFailure()
    {
        // Utilise un jeton invalide pour appeler la méthode du contrôleur
        $invalidToken = Str::random(40);

        // Appelle la méthode du contrôleur avec un jeton invalide
        $response = $this->getJson("/api/verify-email/{$invalidToken}");

        // Vérifie que la réponse a un statut HTTP 404
        $response->assertStatus(404);
        // Vérifie que la réponse JSON contient les données attendues
        $response->assertJson([
            'status' => 404,
            'message' => 'User not found or token expired'
        ]);
    }
}
