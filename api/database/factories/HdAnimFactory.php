<?php

namespace Database\Factories;

use App\Models\HdAnim;
use App\Models\Animateur;
use App\Models\Horaire;
use Illuminate\Database\Eloquent\Factories\Factory;

class HdAnimFactory extends Factory
{
    protected $model = HdAnim::class;

    public function definition(): array
    {
        // Récupérer un animateur sans conflit pour l'horaire choisi
        $animateur = Animateur::whereDoesntHave('hdAnims')->whereDoesntHave('planningAnims')->inRandomOrder()->first();

        if (!$animateur) {
            $animateur = Animateur::factory()->create();
        }

        // Récupérer un horaire sans conflit pour cet animateur
        $horaire = Horaire::whereDoesntHave('hdAnims', function ($query) use ($animateur) {
            $query->where('animateur_id', $animateur->id);
        })->whereDoesntHave('planningAnims', function ($query) use ($animateur) {
            $query->where('animateur_id', $animateur->id);
        })->inRandomOrder()->first();

        if (!$horaire) {
            // Si tous les horaires ont des conflits, créer un nouvel horaire
            $horaire = Horaire::factory()->create();
        }

        return [
            'animateur_id' => $animateur->id,
            'horaire_id' => $horaire->id,
        ];
    }
}
