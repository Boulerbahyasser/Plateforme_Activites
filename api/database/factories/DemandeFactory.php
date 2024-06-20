<?php

namespace Database\Factories;

use App\Models\Demande;
use App\Models\Pack;
use App\Models\Administrateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class DemandeFactory extends Factory
{
    protected $model = Demande::class;

    public function definition(): array
    {
        // Vérifier s'il existe des Packs, sinon en créer un nouveau
        $pack = Pack::exists()
            ? Pack::inRandomOrder()->first()
            : Pack::factory()->create();

        // Vérifier s'il existe des Administrateurs, sinon en créer un nouveau
        $admin = Administrateur::exists()
            ? Administrateur::inRandomOrder()->first()
            : Administrateur::factory()->create();

        return [
            'pack_id' => $pack->id,
            'admin_id' => $admin->id,
            'date' => $this->faker->dateTime,
            'statut' => $this->faker->randomElement(['brouillon', 'valide']),
        ];
    }
}

