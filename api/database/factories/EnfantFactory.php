<?php

namespace Database\Factories;

use App\Models\Enfant;
use App\Models\Father;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnfantFactory extends Factory

{
    protected $model = Enfant::class;

    public function definition(): array
    {
        // Récupérer tous les pères ayant moins de 4 enfants
        $fathersWithLessThanFourChildren = Father::has('enfants', '<', 4)->get();

        // Si aucun père n'a moins de 4 enfants, en créer un nouveau
        if ($fathersWithLessThanFourChildren->isEmpty()) {
            $father = Father::factory()->create();
        } else {
            // Sélectionner un père aléatoirement parmi ceux qui ont moins de 4 enfants
            $father = $fathersWithLessThanFourChildren->random();
        }

        // Déterminer l'âge basé sur le niveau scolaire
        $niveau = $this->faker->randomElement(['Maternelle', 'Primaire', 'Collège']);
        $age = 0;

        switch ($niveau) {
            case 'Maternelle':
                $age = $this->faker->numberBetween(3, 6);
                break;
            case 'Primaire':
                $age = $this->faker->numberBetween(6, 12);
                break;
            case 'Collège':
                $age = $this->faker->numberBetween(12, 15);
                break;
            default:
                $age = $this->faker->numberBetween(6, 15);
                break;
        }

        // Calculer la date de naissance en fonction de l'âge
        $dateDebut = '-'.$age.' years';
        $dateNaissance = $this->faker->dateTimeBetween($dateDebut, 'now');


        return [
            'father_id' => $father->id,
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'date_naissance' => $dateNaissance,
            'niveau' => $niveau,
            'photo' => $this->faker->imageUrl(),
        ];
    }
}
