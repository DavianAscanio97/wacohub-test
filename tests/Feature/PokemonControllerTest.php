<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Favorites;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

class PokemonControllerTest extends TestCase
{
    use RefreshDatabase; // Para resetear la base de datos antes de cada prueba

    /** @test */
    public function it_can_return_pokemon_list()
    {
        // Autenticar un usuario para acceder a la ruta
        $user = User::factory()->create();
        $this->actingAs($user);

        // Realizar una solicitud HTTP GET a la ruta de índice de pokémon
        $response = $this->get(route('pokemon.index'));

        // Asegurar que la respuesta sea exitosa (código 200)
        $response->assertOk();

        // Asegurar que la vista renderizada sea la correcta
        $response->assertViewIs('components.pokemon.pokemon');
    }

    /** @test */
    public function it_can_handle_favorite_action()
    {
        // Autenticar un usuario para acceder a la ruta
        $user = User::factory()->create();
        $this->actingAs($user);

        // Crear un pokémon de prueba en la base de datos
        $pokemon = Favorites::factory()->create(['id_user' => $user->id]);

        // Simular una solicitud HTTP POST para agregar/quitar un pokémon a/de favoritos
        $response = $this->post(route('pokemon.favorite'), ['pokemon_name' => $pokemon->ref_api]);

        // Asegurar que la respuesta sea exitosa (código 200)
        $response->assertOk();

        // Asegurar que el JSON retornado tenga el mensaje correcto
        $response->assertJson([
            'is_favorited' => false, // Cambiar el estado de favorito
            'message' => 'Pokémon eliminado de favoritos',
        ]);
    }
}
