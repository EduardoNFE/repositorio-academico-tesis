<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("¡Bienvenido al panel de administración!") }}

                    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Tarjeta: Total de Tesis --}}
                        <div class="bg-indigo-100 p-6 rounded-lg shadow-md flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700">Total de Tesis</h3>
                                <p class="text-4xl font-bold text-indigo-700">{{ $totalTesis }}</p>
                            </div>
                            <i class="fa-solid fa-book-open text-indigo-500 text-5xl opacity-50"></i>
                        </div>

                        {{-- Tarjeta: Total de Carreras --}}
                        <div class="bg-green-100 p-6 rounded-lg shadow-md flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700">Total de Carreras</h3>
                                <p class="text-4xl font-bold text-green-700">{{ $totalCarreras }}</p>
                            </div>
                            <i class="fa-solid fa-graduation-cap text-green-500 text-5xl opacity-50"></i>
                        </div>

                        {{-- Tarjeta: Total de Usuarios --}}
                        <div class="bg-purple-100 p-6 rounded-lg shadow-md flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700">Total de Usuarios</h3>
                                <p class="text-4xl font-bold text-purple-700">{{ $totalUsuarios }}</p>
                            </div>
                            <i class="fa-solid fa-users text-purple-500 text-5xl opacity-50"></i>
                        </div>
                    </div>

                    {{-- Tesis Recientes --}}
                    <div class="mt-8">
                        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Tesis Recientes</h3>
                        @if ($recentTesis->isEmpty())
                            <p class="text-gray-600">No hay tesis recientes.</p>
                        @else
                            <ul class="space-y-4">
                                @foreach ($recentTesis as $tesi)
                                    <li class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200 flex justify-between items-center">
                                        <div>
                                            <p class="text-lg font-medium text-gray-900">{{ $tesi->titulo }}</p>
                                            <p class="text-sm text-gray-600">Autor: {{ $tesi->autor }}</p>
                                            <p class="text-sm text-gray-600">Carrera: {{ $tesi->carrera->nombre ?? 'N/A' }}</p>
                                            <p class="text-sm text-gray-600">Año: {{ $tesi->año_publicacion }}</p>
                                        </div>
                                        <a href="{{ route('tesis.show', $tesi->id_tesis) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">Ver</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    {{-- Opcional: Distribución de Tesis por Carrera (Solo para Admin) --}}
                    @if (Auth::check() && Auth::user()->role === 'admin')
                        <div class="mt-8">
                            <h3 class="text-2xl font-semibold text-gray-800 mb-4">Tesis por Carrera</h3>
                            @if ($tesisByCarrera->isEmpty())
                                <p class="text-gray-600">No hay datos de tesis por carrera.</p>
                            @else
                                <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200">
                                    <ul class="space-y-2">
                                        @foreach ($tesisByCarrera as $data)
                                            <li class="flex justify-between items-center text-gray-700">
                                                <span>{{ $data->nombre }}</span>
                                                <span class="font-bold text-lg">{{ $data->count }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    {{-- Font Awesome para iconos (añadir al final del body si no está ya en tu layout general) --}}
    @push('scripts')
        <script src="https://kit.fontawesome.com/your-font-awesome-kit-id.js" crossorigin="anonymous"></script> {{-- Reemplaza 'your-font-awesome-kit-id.js' con tu propio kit --}}
    @endpush
</x-app-layout>
