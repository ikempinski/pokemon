<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPokemon extends Model
{
    protected $table = 'user_pokemons';
    protected $fillable = ['name'];
}
