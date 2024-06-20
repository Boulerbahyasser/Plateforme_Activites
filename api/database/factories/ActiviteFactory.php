<?php

namespace Database\Factories;

use App\Models\Activite;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActiviteFactory extends Factory
{
    protected $model = Activite::class;

    public function definition(): array
    {
        $titresActivites = [
            'Atelier de peinture',
            'Cours de robotique',
            'Séance de lecture interactive',
            'Expérience scientifique amusante',
            'Activité de jardinage',
            'Atelier de musique',
            'Classe de yoga pour enfants',
            'Jeux mathématiques',
            'Séance de théâtre',
            'Exploration de la nature',
        ];

        $descriptions = [
            'Une activité créative où les enfants apprendront les techniques de base de la peinture.',
            'Un cours interactif où les jeunes découvrent les bases de la robotique et construisent leurs propres robots.',
            'Une séance de lecture où les enfants participent activement en lisant des histoires et en discutant des personnages.',
            'Une expérience scientifique amusante pour explorer des phénomènes naturels et réaliser des expériences simples.',
            'Les enfants apprendront à planter et à entretenir des plantes, en découvrant l’importance de la nature.',
            'Un atelier où les enfants peuvent découvrir différents instruments de musique et apprendre les bases du rythme.',
            'Une classe de yoga conçue pour aider les enfants à se détendre, à se concentrer et à améliorer leur flexibilité.',
            'Des jeux mathématiques amusants pour renforcer les compétences en calcul et en logique.',
            'Une séance de théâtre où les enfants peuvent exprimer leur créativité à travers des jeux de rôle et des scénarios.',
            'Une exploration guidée de la nature pour découvrir les plantes, les insectes et les animaux locaux.',
        ];

        $objectifs = [
            'Développer la créativité et les compétences artistiques.',
            'Encourager la pensée logique et la résolution de problèmes.',
            'Améliorer les compétences en lecture et la compréhension.',
            'Foster curiosity and scientific thinking.',
            'Enseigner l’importance de la nature et de l’environnement.',
            'Encourager l’expression musicale et la coordination.',
            'Promouvoir le bien-être physique et mental.',
            'Renforcer les compétences en mathématiques de manière ludique.',
            'Développer la confiance en soi et les compétences sociales.',
            'Encourager l’exploration et la découverte de la nature.',
        ];

        $domaines = [
            'Arts',
            'Technologie',
            'Littérature',
            'Sciences',
            'Environnement',
            'Musique',
            'Santé et bien-être',
            'Mathématiques',
            'Théâtre',
            'Nature',
        ];

        return [
            'titre' => $this->faker->randomElement($titresActivites),
            'image_pub' => $this->faker->imageUrl(800, 600, 'activities', true, 'Faker'),
            'description' => $this->faker->randomElement($descriptions),
            'lien_youtube' => 'https://www.youtube.com/watch?v=' . $this->faker->regexify('[A-Za-z0-9_-]{10}'), // Lien YouTube factice
            'objectifs' => $this->faker->randomElement($objectifs),
            'domaine' => $this->faker->randomElement($domaines),
        ];
    }
}
