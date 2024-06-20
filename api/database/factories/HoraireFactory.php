<?php

namespace Database\Factories;

use App\Models\Horaire;
use Illuminate\Database\Eloquent\Factories\Factory;

class HoraireFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Horaire::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $heureDebut = $this->faker->time();
        $heureFin = $this->faker->time();

        // Vérifier que l'heure de début n'est pas après l'heure de fin
        if ($heureDebut > $heureFin) {
            // Inverser les valeurs si l'heure de début est après l'heure de fin
            $temp = $heureDebut;
            $heureDebut = $heureFin;
            $heureFin = $temp;
        }

        return [
            'jour' => $this->faker->randomElement(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']),
            'heure_debut' => $heureDebut,
            'heure_fin' => $heureFin,
        ];
    }
}

