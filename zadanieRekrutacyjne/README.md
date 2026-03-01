# Zadanie Rekrutacyjne - Pokemon Manager

Aplikacja webowa do zarządzania pokemonami, zbudowana w oparciu o Laravel (backend) i AngularJS (frontend). Umożliwia przeglądanie informacji o pokemonach z PokeAPI, zarządzanie listą zakazanych pokemonów oraz listą własnych pokemonów.

## Uruchomienie

### Kroki instalacji

1. Sklonuj repozytorium i przejdź do katalogu projektu:

```bash
git clone <url-repozytorium>
cd PokemonsManagement
```

2. Zainstaluj zależności PHP:

```bash
composer install
```

3. Zainstaluj zależności frontendowe:

```bash
npm install
```

4. Skopiuj plik konfiguracyjny i wygeneruj klucz aplikacji:

```bash
cp .env.example .env
php artisan key:generate
```

5. Skonfiguruj bazę danych w pliku `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=zadanierekrutacyjne
DB_USERNAME=root
DB_PASSWORD=
```

6. Ustaw klucz API w pliku `.env`:

```
SUPER_SECRET_KEY=test123
```

7. Utwórz bazę danych MySQL:

```sql
CREATE DATABASE zadanierekrutacyjne;
```

8. Utwórz wymagane tabele:

```bash
php artisan migrate
```

9. Zbuduj pliki i zasoby frontendowe:

```bash
npm run build
```

10. Uruchom serwer:

```bash
php artisan serve
```

Aplikacja będzie dostępna pod adresem: `http://localhost:8000`

## Opis rozwiązania

### Autoryzacja

Endpointy modyfikujące dane (dodawanie/usuwanie) są chronione middleware `VerifySuperSecretKey`. Klucz jest przesyłany w nagłówku HTTP `X-SUPER-SECRET-KEY` i porównywany z wartością `SUPER_SECRET_KEY` z pliku `.env`. W przypadku braku lub nieprawidłowego klucza, API zwraca `401 Unauthorized`.

### Strony (routing webowy)

| `/` | Strona główna — nawigacja do podstron |
| `/banned` | Lista zakazanych pokemonów — dodawanie/usuwanie z autoryzacją |
| `/pokemons` | Informacje o pokemonach — wybór z listy i podgląd szczegółów z PokeAPI |
| `/userpokemons` | Własne pokemony — dodawanie/usuwanie z autoryzacją |

---

## Endpointy API

### Zakazane pokemony (Banned Pokemons)

#### `GET /api/banned/getAll`

Pobiera listę wszystkich zakazanych pokemonów.

**Nagłówki:** brak wymaganych

**Odpowiedź `200 OK`:**

```json
[
    {
        "id": 1,
        "name": "pikachu",
        "reason": "zbyt popularny",
        "created_at": "2026-03-01T12:00:00.000000Z",
        "updated_at": "2026-03-01T12:00:00.000000Z"
    }
]
```

---

#### `POST /api/banned/add`

Dodaje pokemona do listy zakazanych.

**Nagłówki:**

| Nagłówek | Wartość | Wymagany |
|---|---|---|
| `Content-Type` | `application/json` | Tak |
| `X-SUPER-SECRET-KEY` | Klucz API z `.env` | Tak |

**Body (JSON):**

| Pole | Typ | Wymagane | Opis |
|---|---|---|---|
| `name` | string | Tak | Nazwa pokemona (max 255 znaków) |
| `reason` | string | Nie | Powód zakazu (max 255 znaków) |

**Przykład:**

```json
{
    "name": "pikachu",
    "reason": "zbyt popularny"
}
```

**Odpowiedź `201 Created`:**

```json
{
    "id": 1,
    "name": "pikachu",
    "reason": "zbyt popularny",
    "created_at": "2026-03-01T12:00:00.000000Z",
    "updated_at": "2026-03-01T12:00:00.000000Z"
}
```

**Odpowiedź `401 Unauthorized`:**

```json
{
    "message": "Unauthorized. Invalid or missing X-SUPER-SECRET-KEY."
}
```

**Odpowiedź `422 Unprocessable Content`:**

```json
{
    "message": "The name field is required.",
    "errors": {
        "name": ["The name field is required."]
    }
}
```

---

#### `POST /api/banned/delete/{id}`

Usuwa pokemona z listy zakazanych.

**Parametry URL:**

| Parametr | Typ | Opis |
|---|---|---|
| `id` | integer | ID pokemona do usunięcia |

**Nagłówki:**

| Nagłówek | Wartość | Wymagany |
|---|---|---|
| `X-SUPER-SECRET-KEY` | Klucz API z `.env` | Tak |

**Odpowiedź `204 No Content`:** (puste body)

**Odpowiedź `401 Unauthorized`:**

```json
{
    "message": "Unauthorized. Invalid or missing X-SUPER-SECRET-KEY."
}
```

**Odpowiedź `404 Not Found`:** gdy pokemon o podanym ID nie istnieje

---

### Własne pokemony (User Pokemons)

#### `POST /api/userpokemons/add`

Dodaje pokemona do listy własnych.

**Nagłówki:**

| Nagłówek | Wartość | Wymagany |
|---|---|---|
| `Content-Type` | `application/json` | Tak |
| `X-SUPER-SECRET-KEY` | Klucz API z `.env` | Tak |

**Body (JSON):**

| Pole | Typ | Wymagane | Opis |
|---|---|---|---|
| `name` | string | Tak | Nazwa pokemona (max 255 znaków) |

**Przykład:**

```json
{
    "name": "bulbasaur"
}
```

**Odpowiedź `201 Created`:**

```json
{
    "id": 1,
    "name": "bulbasaur",
    "created_at": "2026-03-01T12:00:00.000000Z",
    "updated_at": "2026-03-01T12:00:00.000000Z"
}
```

**Odpowiedź `401 Unauthorized`:**

```json
{
    "message": "Unauthorized. Invalid or missing X-SUPER-SECRET-KEY."
}
```

---

#### `POST /api/userpokemons/delete/{id}`

Usuwa pokemona z listy własnych.

**Parametry URL:**

| Parametr | Typ | Opis |
|---|---|---|
| `id` | integer | ID pokemona do usunięcia |

**Nagłówki:**

| Nagłówek | Wartość | Wymagany |
|---|---|---|
| `X-SUPER-SECRET-KEY` | Klucz API z `.env` | Tak |

**Odpowiedź `204 No Content`:** (puste body)

**Odpowiedź `401 Unauthorized`:**

```json
{
    "message": "Unauthorized. Invalid or missing X-SUPER-SECRET-KEY."
}
```

---

### Informacje o pokemonach (Pokemon Info)

#### `GET /api/info/get`

Pobiera szczegółowe informacje o wybranych pokemonach z PokeAPI.

**Nagłówki:** brak wymaganych

**Parametry query:**

| Parametr | Typ | Wymagane | Opis |
|---|---|---|---|
| `selectedPokemons[]` | array of string | Tak | Nazwy pokemonów do pobrania |

**Przykładowe wywołanie:**

```
GET /api/info/get?selectedPokemons[]=bulbasaur&selectedPokemons[]=pikachu
```

**Odpowiedź `200 OK`:**

```json
[
    {
        "name": "bulbasaur",
        "id": 1,
        "height": 7,
        "weight": 69,
        "types": ["grass", "poison"],
        "stats": [
            { "name": "hp", "value": 45 },
            { "name": "attack", "value": 49 },
            { "name": "defense", "value": 49 },
            { "name": "special-attack", "value": 65 },
            { "name": "special-defense", "value": 65 },
            { "name": "speed", "value": 45 }
        ],
        "sprite": "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/1.png"
    }
]
```

**Odpowiedź `422 Unprocessable Content`:**

```json
{
    "message": "The selected pokemons field is required.",
    "errors": {
        "selectedPokemons": ["The selected pokemons field is required."]
    }
}
```

---

## Struktura projektu

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── BannedPokemonController.php   # CRUD zakazanych pokemonów
│   │   ├── InfoPokemonController.php     # Pobieranie info z PokeAPI
│   │   └── UserPokemonsController.php    # CRUD własnych pokemonów
│   └── Middleware/
│       └── VerifySuperSecretKey.php       # Autoryzacja nagłówkiem X-SUPER-SECRET-KEY
├── Models/
│   ├── BannedPokemon.php                 # Model: tabela banned_pokemons
│   └── UserPokemon.php                   # Model: tabela user_pokemons
routes/
├── api.php                               # Endpointy REST API
└── web.php                               # Routing stron (widoki Blade)
public/js/
├── app.js                                # Moduł AngularJS + filtr capitalize
├── controllers/
│   ├── BannedPokemonsController.js       # Kontroler listy zakazanych
│   ├── PokemonInfoController.js          # Kontroler informacji o pokemonach
│   └── UserPokemonsController.js         # Kontroler własnych pokemonów
└── services/
    ├── BannedService.js                  # Serwis API zakazanych pokemonów
    ├── InfoService.js                    # Serwis API informacji
    └── UserPokemonsService.js            # Serwis API własnych pokemonów
resources/
├── css/app.css                           # Style aplikacji
└── views/
    ├── welcome.blade.php                 # Strona główna
    ├── bannedpokemons/banned_list.blade.php
    ├── pokemons/pokemon_info.blade.php
    └── userpokemons/user_pokemons.blade.php
```
