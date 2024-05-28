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
         $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        
        $response->assertJsonStructure([
            'message',
            'role',
            'token',
        ]);
      
       $this->assertArrayHasKey('token', $response->json());

       $token = $response->json()['token'];
        $plainTextToken = explode('|', $token, 2)[1] ?? null;

       $this->assertNotNull(
            PersonalAccessToken::where('token', hash('sha256', $plainTextToken))->first()
     );
    }

    /** @test */
    public function test_invalid_login()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'invalid@example.com',
            'password' => 'invalidpassword',
        ]);
        //dd($response->json());
        $response->assertStatus(401);
        $response->assertJsonStructure([
            'message',
        ]);

        $response->assertJson([
            'message' => 'Invalid Credentials',
        ]);
    }

}
