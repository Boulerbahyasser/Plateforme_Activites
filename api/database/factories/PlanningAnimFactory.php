<?php

namespace Database\Factories;

use App\Models\PlanningAnim;
use App\Models\Activite;
use App\Models\Horaire;
use App\Models\Animateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanningAnimFactory extends Factory
{
    protected $model = PlanningAnim::class;

    public function definition(): array
    {
        // Récupérer un animateur sans conflit pour l'horaire choisi
        $animateur = Animateur::all()->filter(function ($animateur) {
            // Vérifier les conflits dans les tables hd_anims et planning_anims
            $hasHdAnimsConflict = $animateur->horaires()->exists();
            $hasPlanningAnimsConflict = $animateur->activiteshoraires()->exists();
            return !$hasHdAnimsConflict && !$hasPlanningAnimsConflict;
        })->random() ?? Animateur::factory()->create();

        // Récupérer un horaire sans conflit pour cet animateur
        $horaire = Horaire::all()->filter(function ($horaire) use ($animateur) {
            // Vérifier les conflits dans les tables hd_anims et planning_anims
            $hasHdAnimsConflict = $animateur->horaires()->where('horaire_id', $horaire->id)->exists();
            $hasPlanningAnimsConflict = $animateur->activiteshoraires()->wherePivot('horaire_id', $horaire->id)->exists();

            return !$hasHdAnimsConflict && !$hasPlanningAnimsConflict;
        })->random() ?? Horaire::factory()->create();

        // Récupérer ou créer une activité qui respecte la contrainte
        $activite = Activite::all()->filter(function ($activite) use ($horaire) {
            // Vérifier les conflits dans la table planning_anims
            $hasPlanningAnimsConflict = PlanningAnim::where('activite_id', $activite->id)
                ->where('horaire_id', $horaire->id)
                ->exists();
            return !$hasPlanningAnimsConflict;
        })->random() ?? Activite::factory()->create();

        return [
            'animateur_id' => $animateur->id,
            'activite_id' => $activite->id,
            'horaire_id' => $horaire->id,
        ];
    }
}
