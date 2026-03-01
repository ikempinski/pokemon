<?php

use App\Models\BannedPokemon;
use App\Models\UserPokemon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/banned', function () {
    $response = Http::withoutVerifying()->get('https://pokeapi.co/api/v2/pokemon');
    $pokemons = $response->successful() ? $response->json()['results'] : [];
    $bannedPokemons = BannedPokemon::all();

    return view('bannedpokemons.banned_list', compact('bannedPokemons', 'pokemons'));
});

Route::get('/pokemons', function () {
    $response = Http::withoutVerifying()->get('https://pokeapi.co/api/v2/pokemon');
    $pokemons = $response->successful() ? $response->json()['results'] : [];

    return view('pokemons.pokemon_info', compact('pokemons'));
});

Route::get('/userpokemons', function () {
    $response = Http::withoutVerifying()->get('https://pokeapi.co/api/v2/pokemon');
    $pokemons = $response->successful() ? $response->json()['results'] : [];
    $userPokemons = UserPokemon::all();
    return view('userpokemons.user_pokemons', compact('userPokemons', 'pokemons'));
});
