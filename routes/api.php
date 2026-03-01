<?php

use App\Http\Controllers\BannedPokemonController;
use App\Http\Controllers\InfoPokemonController;
use App\Http\Controllers\UserPokemonsController;
use App\Http\Middleware\VerifySuperSecretKey;
use Illuminate\Support\Facades\Route;

Route::middleware(VerifySuperSecretKey::class)->group(function () {
    Route::post('banned/add', [BannedPokemonController::class, 'add']);
    Route::post('banned/delete/{id}', [BannedPokemonController::class, 'delete']);
    Route::post('userpokemons/add', [UserPokemonsController::class, 'add']);
    Route::post('userpokemons/delete/{id}', [UserPokemonsController::class, 'delete']);
});

Route::get('banned/getAll', [BannedPokemonController::class, 'getAll']);
Route::get('info/get', [InfoPokemonController::class, 'getInfo']);
