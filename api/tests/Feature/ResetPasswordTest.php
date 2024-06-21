<?php

namespace Tests\Feature;

use App\Mail\SendResetPassword;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\ResetPasswordToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testRessetPasswordEmailValide()
    {
        // Fake the mail sending
        Mail::fake();

        // Crée un utilisateur
        $user = User::factory()->create([
            'email' => 'utilisateur@test.com',
        ]);

        // Simule les données de la requête
        $requestData = ['email' => 'utilisateur@test.com'];

        // Appelle la méthode du contrôleur
        $response = $this->postJson('/api/forget-password', $requestData);

        // Vérifie le statut et la structure de la réponse
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 200,
            'message' => 'check you email inbox,we sent ressset password linck'
        ]);

        // Vérifie que le jeton de réinitialisation a été créé
        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => 'utilisateur@test.com',
        ]);

        // Vérifie que l'email a été envoyé
        Mail::assertSent(SendResetPassword::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    public function testRessetPasswordEmailInvalide()
    {
        // Simule des données de requête invalides
        $requestData = ['email' => 'invalid-email'];

        // Appelle la méthode du contrôleur
        $response = $this->postJson('/api/forget-password', $requestData);

        // Vérifie le statut et la structure de la réponse
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'status',
            'errors',
        ]);
    }

    public function testResetPasswordValide()
    {
        // Crée un utilisateur
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('oldpassword'),
        ]);

        // Crée un jeton de réinitialisation
        $token = Str::random(64);
        ResetPasswordToken::create([
            'email' => 'test@example.com',
            'token' => $token,
            'created_at' => now(),
        ]);

        // Simule les données de la requête
        $requestData = [
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ];

        // Appelle la méthode du contrôleur
        $response = $this->postJson("/api/reset-password/{$token}", $requestData);

        // Vérifie le statut et la structure de la réponse
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 200,
            'message' => 'Password reset successfully',
        ]);

        // Vérifie que le mot de passe de l'utilisateur a été mis à jour
        $user->refresh();
        $this->assertTrue(Hash::check('newpassword', $user->password));

        // Vérifie que le jeton de réinitialisation a été supprimé
        $this->assertDatabaseMissing('password_reset_tokens', [
            'email' => 'test@example.com',
            'token' => $token,
        ]);

        $this->assertDatabaseHas('users',$user->toArray());
    }

    public function testResetPasswordUserNonExist()
    {
        // Crée un jeton de réinitialisation sans utilisateur correspondant
        $token = Str::random(64);
        ResetPasswordToken::create([
            'email' => 'nonexistent@example.com',
            'token' => $token,
            'created_at' => now(),
        ]);

        // Simule les données de la requête
        $requestData = [
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ];

        // Appelle la méthode du contrôleur
        $response = $this->postJson("/api/reset-password/{$token}", $requestData);

        // Vérifie le statut et la structure de la réponse
        $response->assertStatus(404);
        $response->assertJson([
            'status' => 404,
            'message' => 'User not found',
        ]);
    }

    public function testResetPasswordInvalide()
    {
        // Crée un utilisateur
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('oldpassword'),
        ]);

        // Crée un jeton de réinitialisation
        $token = Str::random(64);
        ResetPasswordToken::create([
            'email' => 'test@example.com',
            'token' => $token,
            'created_at' => now(),
        ]);

        // Simule des données de requête invalides (mots de passe ne correspondant pas)
        $requestData = [
            'password' => 'newpassword',
            'password_confirmation' => 'differentpassword',
        ];

        // Appelle la méthode du contrôleur
        $response = $this->postJson("/api/reset-password/{$token}", $requestData);

        // Vérifie le statut et la structure de la réponse
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => ['password'],
        ]);
    }
}
