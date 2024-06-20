<?php

namespace Tests\Feature;

use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_valid_login()
    {
         // Crée un utilisateur avec des identifiants valides
         $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Simule une requête de connexion avec les identifiants valides
        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        // Vérifie que la connexion réussit avec un statut HTTP 200
        $response->assertStatus(200);
        
        // Vérifie la structure JSON de la réponse attendue
        $response->assertJsonStructure([
            'message',
            'role',
            'token',
        ]);
      
       // Vérifie que la réponse JSON contient une clé 'token'
       $this->assertArrayHasKey('token', $response->json());

       // Récupère le token d'accès personnel et vérifie qu'il est enregistré en base de données
       $token = $response->json()['token'];
       $plainTextToken = explode('|', $token, 2)[1] ?? null;

       $this->assertNotNull(
            PersonalAccessToken::where('token', hash('sha256', $plainTextToken))->first()
       );
    }

    /** @test */
    public function test_invalid_login()
    {
        // Simule une tentative de connexion avec des identifiants invalides
        $response = $this->postJson('/api/login', [
            'email' => 'invalid@example.com',
            'password' => 'invalidpassword',
        ]);
        
        // Vérifie que la connexion échoue avec un statut HTTP 401
        $response->assertStatus(401);
        
        // Vérifie la structure JSON de la réponse attendue
        $response->assertJsonStructure([
            'message',
        ]);

        // Vérifie que le message d'erreur indique des identifiants invalides
        $response->assertJson([
            'message' => 'Invalid Credentials',
        ]);
    }
}