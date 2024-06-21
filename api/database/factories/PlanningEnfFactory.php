<?php

namespace Database\Factories;

use App\Models\PlanningAnim;
use App\Models\PlanningEnf;
use App\Models\Enfant;
use App\Models\Activite;
use App\Models\Horaire;
use App\Models\Animateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanningEnfFactory extends Factory
{
    protected $model = PlanningEnf::class;

    public function definition(): array
    {
        // Trouver ou créer un Enfant sans conflits d'horaires
        $enfant = Enfant::all()->filter(function ($enfant) {
            // Vérifier les conflits d'horaires pour l'enfant
            return !PlanningEnf::where('enfant_id', $enfant->id)
                ->whereIn('horaire_id', Horaire::pluck('id'))
                ->exists();
        });

        if ($enfant->isEmpty()) {
            $enfant = Enfant::factory()->create();
        } else {
            $enfant = $enfant->random();
        }

        // Trouver ou créer un Horaire
        $horaire = Horaire::all()->filter(function ($horaire) use ($enfant) {
            // Assurer que l'enfant n'a pas de conflit à cet horaire
            return !PlanningEnf::where('enfant_id', $enfant->id)
                ->where('horaire_id', $horaire->id)
                ->exists();
        });

        if ($horaire->isEmpty()) {
            $horaire = Horaire::factory()->create();
        } else {
            $horaire = $horaire->random();
        }

        // Trouver ou créer une Activité avec Animateur existant à cet Horaire
        $activite = Activite::all()->filter(function ($activite) use ($horaire) {
            return PlanningAnim::where('activite_id', $activite->id)
                ->where('horaire_id', $horaire->id)
                ->exists();
        });

        if ($activite->isEmpty()) {
            $activite = Activite::factory()->create();
        } else {
            $activite = $activite->random();
        }

        // Si aucun animateur n'est associé à l'activité et à l'horaire, en créer un
        if (!PlanningAnim::where('activite_id', $activite->id)->where('horaire_id', $horaire->id)->exists()) {
            $animateur = Animateur::factory()->create();
            PlanningAnim::factory()->create([
                'animateur_id' => $animateur->id,
                'activite_id' => $activite->id,
                'horaire_id' => $horaire->id,
            ]);
        }

        return [
            'enfant_id' => $enfant->id,
            'activite_id' => $activite->id,
            'horaire_id' => $horaire->id,
        ];
    }
}
