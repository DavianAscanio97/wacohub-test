<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Http;
use App\Models\Favorites;

class PokemonController extends Controller
{
    /**
     * Muestra una lista de pokémon utilizando DataTables.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                // Obtener datos de la API PokeAPI
                $response = Http::get('https://pokeapi.co/api/v2/pokemon?limit=20');
                $pokemonData = $response->json();

                $data = [];
                foreach ($pokemonData['results'] as $pokemon) {
                    $pokemonInfo = Http::get($pokemon['url'])->json();

                    // Verificar si el pokémon está marcado como favorito para el usuario actual
                    $isFavorited = Favorites::where('id_user', auth()->user()->id)
                        ->where('ref_api', $pokemon['name'])
                        ->exists();

                    $data[] = [
                        'name' => $pokemon['name'],
                        'image' => $pokemonInfo['sprites']['front_default'], // Obtener la URL de la imagen
                        'actions' => [
                            'actionUrl' => route('pokemon.favorite'),
                            'pokemonName' => $pokemon['name'],
                            'isFavorited' => $isFavorited,
                        ],
                    ];
                }

                return DataTables::of($data)->toJson();
            }

            return view('components.pokemon.pokemon'); // Mostrar la vista para la tabla de pokémon
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener la lista de pokémon'], 500);
        }
    }

    /**
     * Maneja la acción de agregar/quitar un pokémon a/de favoritos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function favorite(Request $request)
    {
        try {
            $pokemonName = $request->input('pokemon_name');
            $isFavorited = Favorites::where('id_user', auth()->user()->id)
                ->where('ref_api', $pokemonName)
                ->exists();

            if ($isFavorited) {
                // Eliminar de favoritos
                Favorites::where('id_user', auth()->user()->id)
                    ->where('ref_api', $pokemonName)->delete();
                $message = 'Pokémon eliminado de favoritos';
            } else {
                // Agregar a favoritos
                Favorites::create([
                    'id_user' => auth()->user()->id,
                    'ref_api' => $pokemonName
                ]);
                $message = 'Pokémon agregado a favoritos';
            }

            // Devolver una respuesta JSON con el estado actualizado y un mensaje
            return response()->json([
                'is_favorited' => !$isFavorited, // Cambiar el estado de favorito
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar el estado de favorito'], 500);
        }
    }
}
