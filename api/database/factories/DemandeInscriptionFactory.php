<?php

namespace Database\Factories;

use App\Models\DemandeInscription;
use App\Models\Enfant;
use App\Models\ActiviteOffre;
use App\Models\Demande;
use Illuminate\Database\Eloquent\Factories\Factory;

class DemandeInscriptionFactory extends Factory
{
    protected $model = DemandeInscription::class;

    public function definition(): array
    {
        $motifs = [
            'Mon enfant est très intéressé par cette activité.',
            'Nous voulons encourager son développement social.',
            'Il a toujours montré un intérêt pour ce domaine.',
            'Nous pensons que cette activité l’aidera à s’épanouir.',
            'Nous souhaitons qu’il développe de nouvelles compétences.',
            'Cette activité est fortement recommandée par son enseignant.',
            'Nous cherchons à l’occuper après l’école de manière constructive.',
            'Nous croyons que cette activité l’aidera à se détendre.',
            'Nous voulons qu’il explore de nouveaux centres d’intérêt.',
            'Nous pensons que cela l’aidera dans son parcours scolaire.',
        ];

        return [
            'enfant_id' => Enfant::inRandomOrder()->first()->id ?? Enfant::factory(),
            'activite_offre_id' => ActiviteOffre::inRandomOrder()->first()->id ?? ActiviteOffre::factory(),
            'demande_id' => Demande::inRandomOrder()->first()->id ?? Demande::factory(),
            'horaire' => $this->faker->randomElement(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']).
                ','.$this->faker->time().','.$this->faker->time(),
            'etat' => $this->faker->randomElement(['en cours', 'accepte', 'refuse']),
            'motif' => $this->faker->randomElement($motifs),
        ];
    }
}


