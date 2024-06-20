<?php

namespace Database\Factories;

use App\Models\DemandeInscription;
use App\Models\Hda;
use App\Models\ActiviteOffre;
use App\Models\Horaire;
use Illuminate\Database\Eloquent\Factories\Factory;

class HdaFactory extends Factory
{
    protected $model = Hda::class;

    public function definition(): array
    {
        // Récupérer une activité offre disponible ou en créer une nouvelle
        $activiteOffreId = ActiviteOffre::inRandomOrder()->value('id') ?? ActiviteOffre::factory()->create()->id;

        // Récupérer un horaire disponible ou en créer un nouveau
        $horaireId = Horaire::inRandomOrder()->value('id') ?? Horaire::factory()->create()->id;

        // Récupérer les demandes d'inscription acceptées pour cette activité offre
        $demandesAcceptees = DemandeInscription::where('activite_offre_id', $activiteOffreId)
            ->where('etat', 'accepte')
            ->get();

        // Calculer le nombre de places restantes
        $effMax = $this->faker->numberBetween(10, 30); // Exemple de l'effectif maximum
        $placesOccupees = $demandesAcceptees->sum('nbr_places'); // Nombre total de places occupées

        $nbrPlacesRestant = max(0, $effMax - $placesOccupees);

        return [
            'activite_offre_id' => $activiteOffreId,
            'horaire_id' => $horaireId,
            'eff_min' => $this->faker->numberBetween(1, 10),
            'eff_max' => $effMax,
            'nbr_place_restant' => $nbrPlacesRestant,
        ];
    }
}



