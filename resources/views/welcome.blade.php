<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }} - Inicio</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Asegúrate de que tu kit de Font Awesome esté correctamente enlazado aquí o en app.blade.php --}}
        {{-- <script src="https://kit.fontawesome.com/TU_KIT_DE_FONT_AWESOME.js" crossorigin="anonymous"></script> --}}

    </head>
    <body class="font-sans antialiased bg-gray-100 text-gray-900">
        <div class="min-h-screen flex flex-col justify-between">
            <nav class="bg-white border-b border-gray-100 shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="shrink-0 flex items-center">
                                <a href="{{ url('/') }}">
                                    {{-- Aquí podrías poner tu logo. Reemplaza con tu imagen o componente si tienes uno --}}
                                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                                    {{-- O simplemente un texto si no tienes logo: --}}
                                    {{-- <span class="text-xl font-bold text-gray-800">Sistema de Tesis</span> --}}
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center ml-auto">
                            @if (Route::has('login'))
                                <div class="space-x-4">
                                    @auth
                                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                                    @else
                                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Iniciar Sesión</a>

                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Registrarse</a>
                                        @endif
                                    @endauth
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </nav>

            <main class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl w-full">
                    <h1 class="text-5xl font-extrabold text-gray-900 sm:text-6xl lg:text-7xl leading-tight mb-6">
                        “Repositorio Académico de Tesis (RAT)
                    </h1>
                    <p class="mt-4 text-xl text-gray-600 leading-relaxed mb-8">
                        Explora una vasta colección de trabajos de investigación, proyectos de titulación y tesis académicas. Encuentra la información que necesitas para tus estudios y contribuye al conocimiento.
                    </p>

                    <!-- {{-- Opcional: Barra de búsqueda rápida --}}
                    <form action="{{ route('tesis.index') }}" method="GET" class="max-w-xl mx-auto mb-10">
                        <div class="flex items-center border border-gray-300 rounded-lg shadow-sm focus-within:ring-2 focus-within:ring-laravel-blue-button"> {{-- Ajuste del focus ring --}}
                            <input type="text" name="search" placeholder="Buscar tesis por título, autor o palabras clave..."
                                class="flex-grow p-4 rounded-l-lg focus:outline-none border-none text-lg"
                                value="{{ request('search') }}">
                            {{-- CAMBIO AQUÍ: Botón de búsqueda blanco con texto azul --}}
                            <button type="submit" class="bg-white text-laravel-blue-button p-4 rounded-r-lg hover:bg-gray-100 transition duration-300">
                                <i class="fa-solid fa-magnifying-glass mr-2"></i> Buscar
                            </button>
                        </div>
                    </form> -->

                    {{-- Opcional: Destacados o estadísticas simples (si se pasan desde el controlador) --}}
                    @isset($totalTesis)
                        <div class="mt-6 flex flex-wrap justify-center gap-6">
                            <div class="bg-blue p-6 rounded-lg shadow-md border border-gray-200">
                                <h3 class="text-xl font-semibold text-gray-700">Tesis Publicadas</h3>
                                <p class="text-4xl font-bold text-indigo-700 mt-2">{{ $totalTesis }}</p>
                            </div>
                        </div>
                    @endisset

                    <!-- <div class="mt-12">
                        <a href="{{ route('tesis.index') }}" class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300">
                            Explorar Todas las Tesis
                            <i class="fa-solid fa-arrow-right ml-3"></i>
                        </a>
                    </div> -->
                </div>
            </main>

            <footer class="bg-gray-800 text-white py-6 mt-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <p>&copy; {{ date('Y') }} {{ config('app.name', 'Sistema de Tesis') }}. Todos los derechos reservados.</p>
                    <p class="mt-2 text-sm">Desarrollado con Laravel y Tailwind CSS</p>
                </div>
            </footer>
        </div>
    </body>
</html>