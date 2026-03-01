<?php

namespace App\Http\Controllers;

use App\Models\BannedPokemon;
use Illuminate\Http\Request;

class BannedPokemonController extends Controller
{
    public function getAll()
    {
        return response()->json(BannedPokemon::all());
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'reason' => 'nullable|string|max:255',
        ]);

        $banned = BannedPokemon::create($validated);

        return response()->json($banned, 201);
    }

    public function delete(string $id)
    {
        $banned = BannedPokemon::findOrFail($id);
        $banned->delete();

        return response()->json(null, 204);
    }
}
