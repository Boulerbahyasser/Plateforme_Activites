<?php

namespace Database\Factories;

use App\Models\Devis;
use App\Models\Demande;
use App\Models\Facture;
use Illuminate\Database\Eloquent\Factories\Factory;

class DevisFactory extends Factory
{
    protected $model = Devis::class;

    public function definition(): array
    {
        // Sélectionner ou créer une demande et une facture si elles n'existent pas
        $demande = Demande::inRandomOrder()->first() ?? Demande::factory()->create();
        $facture = Facture::inRandomOrder()->first() ?? Facture::factory()->create();

        // Liste de motifs significatifs pour le devis
        $motifs = [
            'Demande validée par le client.',
            'Besoin urgent de prestation.',
            'Validation suite à la réception de la facture.',
            'Confirmation après discussion avec le service client.',
            'Accord de paiement reçu.',
        ];

        // Construction du contenu PDF
        $pdfContent = "Demande ID: {$demande->id}\n" .
            "Facture ID: {$facture->id}\n" .
            "Date: " . now()->format('Y-m-d H:i:s') . "\n" .
            "Total HT: " . $this->faker->randomFloat(2, 100, 1000) . " EUR\n" .
            "Total TTC: " . $this->faker->randomFloat(2, 120, 1200) . " EUR\n" .
            "Statut: " . $this->faker->randomElement(['payé', 'non payé']) . "\n" .
            "État: " . $this->faker->randomElement(['payé', 'non payé']) . "\n" .
            "Motif: " . $this->faker->randomElement($motifs) . "\n";

        return [
            'demande_id' => $demande->id,
            'facture_id' => $facture->id,
            'date' => now(),
            'totale_ht' => $this->faker->randomFloat(2, 100, 1000),
            'totale_ttc' => $this->faker->randomFloat(2, 120, 1200),
            'statut' => $this->faker->randomElement(['payé', 'non payé']),
            'pdf' => $pdfContent,
            'etat' => $this->faker->randomElement(['payé', 'non payé']),
            'motif' => $this->faker->randomElement($motifs),
        ];
    }
}
