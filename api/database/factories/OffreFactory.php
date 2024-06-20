<?php

namespace Database\Factories;

use App\Models\Offre;
use App\Models\Administrateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class OffreFactory extends Factory
{
    protected $model = Offre::class;

    public function definition(): array
    {
        // Récupérer un administrateur disponible ou en créer un nouveau
        $adminId = Administrateur::inRandomOrder()->value('id') ?? Administrateur::factory()->create()->id;

        // Générer une date de début aléatoire dans l'année en cours
        $dateDebut = $this->faker->dateTimeThisYear();

        // Générer une date de fin aléatoire dans l'année en cours
        $dateFin = $this->faker->dateTimeThisYear();

        // Vérifier si la date de début est après la date de fin, inverser les dates si nécessaire
        if ($dateDebut > $dateFin) {
            [$dateDebut, $dateFin] = [$dateFin, $dateDebut];
        }

        // Calculer la différence en jours entre la date de début et la date de fin
        $differenceDays = ($dateFin->getTimestamp() - $dateDebut->getTimestamp()) / (60 * 60 * 24);

        // Assurer que la durée d'inscription est d'au moins une semaine
        if ($differenceDays < 7) {
            $dateFin = date_modify($dateDebut, '+7 days');
        }


        // Liste étendue des domaines disponibles
        $domaines = [
            'Robotique', 'Mathématiques', 'Art', 'Science', 'Littérature', 'Musique', 'Sport',
            'Informatique', 'Programmation', 'Physique', 'Chimie', 'Biologie', 'Histoire',
            'Géographie', 'Arts dramatiques', 'Peinture', 'Dessin', 'Danse', 'Langues étrangères',
            'Cuisine', 'Écologie', 'Astronomie', 'Ingénierie', 'Médias numériques', 'Philosophie'
        ];

        // Tableau de titres et de descriptions variés pour les offres
        $offres = [
            [
                'titre' => 'Offre de printemps',
                'description' => 'Profitez de notre offre spéciale de printemps pour découvrir de nouvelles activités et passer du bon temps en famille. Réductions exceptionnelles et activités enrichissantes vous attendent !',
            ],
            [
                'titre' => 'Offre de vacances d\'été',
                'description' => 'Inscrivez vos enfants à nos programmes d\'été et laissez-les explorer de nouveaux horizons avec nos activités estivales. Offrez-leur des vacances inoubliables remplies de jeux, de découvertes et d\'apprentissage.',
            ],
            [
                'titre' => 'Promotion rentrée scolaire',
                'description' => 'Préparez la rentrée scolaire de vos enfants avec notre promotion spéciale. Choisissez parmi une gamme d\'activités éducatives et ludiques conçues pour enrichir leur expérience académique et sociale.',
            ],
            [
                'titre' => 'Offre de Noël',
                'description' => 'Célébrez les fêtes de fin d\'année avec notre offre spéciale de Noël. Offrez à vos proches des moments magiques avec nos activités festives et créatives pour tous les âges.',
            ],
            [
                'titre' => 'Offre de remise en forme',
                'description' => 'Reprenez une activité physique régulière avec notre offre de remise en forme. Profitez de nos installations modernes et des conseils de nos coachs pour atteindre vos objectifs de santé.',
            ],
            [
                'titre' => 'Offre de stage intensif',
                'description' => 'Boostez vos compétences avec notre programme de stage intensif. Apprenez de manière intensive et efficace sous la guidance d\'experts dans votre domaine.',
            ],
        ];

        // Choisir aléatoirement une offre parmi celles définies
        $offre = $this->faker->randomElement($offres);

        return [
            'admin_id' => $adminId,
            'titre' => $offre['titre'],
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'domaine' => $this->faker->randomElement($domaines),  // Sélection aléatoire d'un domaine
            'description' => $offre['description'],
            'remise' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
