<?php

namespace Database\Factories;

use App\Models\Animateur;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnimateurFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Animateur::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        // Récupérer un utilisateur existant avec le rôle "animateur" ou en créer un si aucun n'existe
        $userId = User::where('role', 'animateur')->inRandomOrder()->first();

        if (!$userId) {
            $userId = User::factory()->create(['role' => 'animateur']);
        }

        // Liste de domaines significatifs pour un animateur
        $domaines = [
            'Arts plastiques',
            'Sciences',
            'Technologie',
            'Sport',
            'Musique',
            'Théâtre',
            'Environnement',
            'Mathématiques',
            'Langues',
            'Histoire'
        ];

        return [
            'domaine' => $this->faker->randomElement($domaines),
            'user_id' => $userId,
        ];
    }
}


