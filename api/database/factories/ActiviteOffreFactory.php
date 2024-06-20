<?php

namespace Database\Factories;

use App\Models\Activite;
use App\Models\ActiviteOffre;
use App\Models\Offre;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActiviteOffreFactory extends Factory
{
    protected $model = ActiviteOffre::class;

    public function definition(): array
    {
        // Récupérer un `offre_id` existant ou en créer un si aucun n'existe
        $offreId = Offre::inRandomOrder()->first()->id ?? Offre::factory()->create()->id;

        // Récupérer un `activite_id` existant ou en créer un si aucun n'existe
        $activiteId = Activite::inRandomOrder()->first()->id ?? Activite::factory()->create()->id;

        $optionsPaiement = [
            'Paiement complet',
            'Paiement mensuel',
            'Paiement à la séance'
        ];

        return [
            'offre_id' => $offreId,
            'activite_id' => $activiteId,
            'tarif' => $this->faker->randomFloat(2, 100, 1000),
            'tarif_remise' => $this->faker->randomFloat(2, 50, 900),
            'age_min' => $this->faker->numberBetween(3, 5),
            'age_max' => $this->faker->numberBetween(10, 15),
            'nbr_seance' => $this->faker->numberBetween(1, 3),
            'volume_horaire' =>  $this->faker->numberBetween(10, 40),
            'option_paiement' => $this->faker->randomElement($optionsPaiement),
        ];
    }
}


