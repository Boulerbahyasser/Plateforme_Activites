<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition(): array
    {
        // Récupérer un utilisateur avec un rôle spécifique
        $userRole = $this->faker->randomElement(['admin', 'parent', 'animateur']);
        $userId = User::where('role', $userRole)->inRandomOrder()->value('id') ?? User::factory()->create(['role' => $userRole])->id;

        // Générer le contenu et le type en fonction du rôle de l'utilisateur
        $contenu = '';
        $type = '';

        switch ($userRole) {
            case 'admin':
                $contenu = 'Nouvelle notification pour l\'administrateur.';
                $type = 'administratif';
                break;
            case 'parent':
                $contenu = 'Notification pour un parent.';
                $type = 'parental';
                break;
            case 'animateur':
                $contenu = 'Notification pour un animateur.';
                $type = 'animation';
                break;
            default:
                $contenu = 'Notification générique.';
                $type = 'général';
                break;
        }

        return [
            'user_id' => $userId,
            'date' => $this->faker->date(),
            'contenu' => $contenu,
            'type' => $type,
        ];
    }
}

