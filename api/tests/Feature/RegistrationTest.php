<?php

namespace Tests\Feature;

use App\Http\Requests\RequestUser;
use App\Mail\SendEmails;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    // Teste le processus d'inscription d'un parent avec des données valides.
    public function testRegisterParentValid()
    {
        // Simule l'envoie d'un email
        Mail::fake();

        // Simule les données de la requête.
        $requestData = [
            'name' => 'Said Idrissi',
            'email' => 'testparent@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];
        
        // Appelle la méthode du contrôleur.
        $response = $this->postJson('/api/register-parent', $requestData);
       
        // Vérifie le statut et la structure de la réponse.
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 200,
            'message' => 'verify your email ,link sent to your inbox'
        ]);

        // Vérifie que l'utilisateur a été créé.
        $this->assertDatabaseHas('users', [
            'name' => 'Said Idrissi',
            'email' => 'testparent@example.com',
            'role' => 'parent',
        ]);

        // Vérifie que le mot de passe a été hashé.
        $user = User::where('email', 'testparent@example.com')->first();
        $this->assertTrue(Hash::check('password123', $user->password));

        // Vérifie que l'entrée Father a été créée.
        $this->assertDatabaseHas('fathers', [
            'user_id' => $user->id,
        ]);

        // Vérifie que le mail a été envoyé
        Mail::assertSent(SendEmails::class, function($mail) use ($user){
            return $mail->hasTo($user->email);
        });
    }

    public function testRegisterParentInvalid()
    {
        // Simule l'envoie d'un email
        Mail::fake();
        
        // Simule des données de requête invalides.
        $requestData = [
            'name' => 'Soukaina Slimani',
            'email' => 'invalid-email@gmail.com',
            'password' => '1234',
            'password_confirmation' => 'confirmation_invalide',
        ];

        // Appelle la méthode du contrôleur.
        $response = $this->postJson('/api/register-parent', $requestData);

        // Vérifie le statut et la structure de la réponse.
        $response->assertStatus(422);  
        $this->assertDatabaseMissing('users', [
            'name' => 'Soukaina Slimani',
            'email' => 'invalid-email@gmail.com',
            'role' => 'parent',
        ]);
    }
}