<?php

namespace App\Http\Controllers;

use App\Models\UserPokemon;
use Illuminate\Http\Request;

class UserPokemonsController extends Controller
{
    public function add(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $userPokemon = UserPokemon::create($validated);

        return response()->json($userPokemon, 201);
    }

    public function delete(string $id)
    {
        $userPokemon = UserPokemon::findOrFail($id);
        $userPokemon->delete();

        return response()->json(null, 204);
    }
}
