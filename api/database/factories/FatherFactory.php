<?php

namespace Database\Factories;

use App\Models\Father;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FatherFactory extends Factory
{
    protected $model = Father::class;

    public function definition(): array
    {
        // Rechercher les ID des utilisateurs qui ne sont pas associés à un Father et ont le rôle "parent"
        $unusedUserIds = User::doesntHave('father')
            ->where('role', 'parent')
            ->pluck('id')
            ->toArray();

        return [
            'user_id' => count($unusedUserIds) > 0 ? $this->faker->randomElement($unusedUserIds) : User::factory()->create(['role' => 'parent'])->id,
            'fonction' => $this->faker->jobTitle,
        ];
    }
}
