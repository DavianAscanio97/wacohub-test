<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>WACO LARAVEL</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <!-- Styles -->

        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <header class="pokemon-header text-center py-5">
        <img src="https://1000marcas.net/wp-content/uploads/2020/01/Logo-Pokemon.png" alt="Pokémon Logo" class="pokemon-logo img-fluid">
        <h1 class="pokemon-title">Bienvenido a Pokémon WACO LARAVEL | DAVIAN ASCANIO</h1>
        <p class="pokemon-description">¡Explora un mundo lleno de aventuras y entrenadores Pokémon!</p>
    </header>

    <section class="pokemon-section bg-light py-5">
        <div class="container">
            <h2 class="section-title text-center mb-4">Únete al Equipo</h2>
            <p class="section-text text-center">Conviértete en un entrenador Pokémon y hazte amigo de criaturas asombrosas. Explora rutas, desafía gimnasios y atrapa a todos los Pokémon.</p>

            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                    <a href="{{ url('/home/users') }}" class="pokemon-btn d-block text-center mt-3">Volver a la dashboard</a>
                    @else
                        <a href="{{ url('/login') }}" class="pokemon-btn d-block text-center mt-3">Iniciar sesión</a>

                        @if (Route::has('register'))
                            <a href="{{ url('/register') }}" class="pokemon-btn d-block text-center mt-3">Registrarse</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </section>
    <section class="pokemon-section bg-light py-5">
        <div class="container">
            <h2 class="section-title text-center mb-4">Explora la Región Pokémon</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="pokemon-card text-center p-4">
                        <img src="https://www.pngmart.com/files/13/Charmander-PNG-Clipart.png" width="230" alt="Charmander" class="pokemon-image img-fluid">
                        <h3 class="pokemon-name">Charmander</h3>
                        <p class="pokemon-info">Tipo: Fuego</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pokemon-card text-center p-4">
                        <img src="https://assets.pokemon.com/assets/cms2/img/pokedex/full/001.png" width="250" alt="Bulbasaur" class="pokemon-image img-fluid">
                        <h3 class="pokemon-name">Bulbasaur</h3>
                        <p class="pokemon-info">Tipo: Planta/Veneno</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pokemon-card text-center p-4">
                        <img src="https://assets.stickpng.com/images/580b57fcd9996e24bc43c32a.png" width="250" alt="Squirtle" class="pokemon-image img-fluid">
                        <h3 class="pokemon-name">Squirtle</h3>
                        <p class="pokemon-info">Tipo: Agua</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="pokemon-footer text-center py-3">
        <p>&copy; 2023 Pokémon Waco Laravel. Todos los derechos reservados.</p>
    </footer>
    </div>
        </div>
    </body>
</html>
