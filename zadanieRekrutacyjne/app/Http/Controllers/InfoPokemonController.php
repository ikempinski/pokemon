<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InfoPokemonController extends Controller
{
    public function getInfo(Request $request)
    {
        $validated = $request->validate([
            'selectedPokemons' => 'required|array',
            'selectedPokemons.*' => 'string|max:255',
        ]);

        $results = [];

        foreach ($validated['selectedPokemons'] as $name) {
            $response = Http::withoutVerifying()
                ->get('https://pokeapi.co/api/v2/pokemon/' . urlencode($name));

            if ($response->successful()) {
                $data = $response->json();
                $results[] = [
                    'name' => $data['name'],
                    'id' => $data['id'],
                    'height' => $data['height'],
                    'weight' => $data['weight'],
                    'types' => array_map(function ($t) {
                        return $t['type']['name'];
                    }, $data['types']),
                    'stats' => array_map(function ($s) {
                        return [
                            'name' => $s['stat']['name'],
                            'value' => $s['base_stat'],
                        ];
                    }, $data['stats']),
                    'sprite' => $data['sprites']['front_default'],
                ];
            }
        }

        return response()->json($results);
    }
}
