<?php

namespace Database\Factories;

use App\Models\Administrateur;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdministrateurFactory extends Factory
{
    protected $model = Administrateur::class;

    public function definition(): array
    {
        // Récupérer un utilisateur existant avec le rôle "admin" ou en créer un si aucun n'existe
        $user = User::where('role', 'admin')->inRandomOrder()->first();

        if (!$user) {
            $user = User::factory()->create(['role' => 'admin']);
        }

        return [
            'user_id' => $user->id,
        ];
    }
}


