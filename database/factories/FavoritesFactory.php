<?php

// database/factories/FavoritesFactory.php

namespace Database\Factories;

use App\Models\Favorites;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoritesFactory extends Factory
{
    protected $model = Favorites::class;

    public function definition()
    {
        return [
            'id_user' => \App\Models\User::factory(),
            'ref_api' => $this->faker->word,
        ];
    }
}
