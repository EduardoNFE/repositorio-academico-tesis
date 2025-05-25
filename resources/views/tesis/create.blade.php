<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Nueva Tesis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('tesis.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="titulo" :value="__('Título')" />
                            <x-text-input id="titulo" class="block mt-1 w-full" type="text" name="titulo" :value="old('titulo')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('titulo')" />
                        </div>

                        <div>
                            <x-input-label for="autor" :value="__('Autor')" />
                            <x-text-input id="autor" class="block mt-1 w-full" type="text" name="autor" :value="old('autor')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('autor')" />
                        </div>

                         <div>
                            <x-input-label for="carrera_id" :value="__('Carrera')" />
                            <select id="carrera_id" name="carrera_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Selecciona una Carrera</option>
                                {{-- ¡¡¡ESTAS LÍNEAS DE EJEMPLO DEBES ELIMINARLAS O MANTENERLAS COMENTADAS!!! --}}
                                {{-- Las opciones de carrera se cargarán dinámicamente desde el controlador --}}
                                {{-- Ejemplo: @foreach($carreras as $carrera) --}}
                                {{--    <option value="{{ $carrera->id_carrera }}">{{ $carrera->nombre }}</option> --}}
                                {{-- @endforeach --}}

                                {{-- ¡¡¡ESTE ES EL BUCLE REAL QUE DEBE ESTAR DESCOMENTADO!!! --}}
                                @foreach($carreras as $carrera)
                                    <option value="{{ $carrera->id_carrera }}" {{ old('carrera_id') == $carrera->id_carrera ? 'selected' : '' }}>
                                        {{ $carrera->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('carrera_id')" />
                        </div>

                        <div>
                            <x-input-label for="asesor" :value="__('Asesor')" />
                            <x-text-input id="asesor" class="block mt-1 w-full" type="text" name="asesor" :value="old('asesor')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('asesor')" />
                        </div>

                        <div>
                            <x-input-label for="año_publicacion" :value="__('Año de Publicación')" />
                            <x-text-input id="año_publicacion" class="block mt-1 w-full" type="number" name="año_publicacion" :value="old('año_publicacion')" required min="1900" max="{{ date('Y') }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('año_publicacion')" />
                        </div>

                        <div>
                            <x-input-label for="palabras_clave" :value="__('Palabras Clave (separadas por comas)')" />
                            <textarea id="palabras_clave" name="palabras_clave" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('palabras_clave') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('palabras_clave')" />
                        </div>

                        <div>
                            <x-input-label for="resumen" :value="__('Resumen')" />
                            <textarea id="resumen" name="resumen" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('resumen') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('resumen')" />
                        </div>

                        <div>
                            <x-input-label for="archivo_pdf" :value="__('Archivo PDF')" />
                            <input id="archivo_pdf" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" type="file" name="archivo_pdf" accept="application/pdf" />
                            <x-input-error class="mt-2" :messages="$errors->get('archivo_pdf')" />
                        </div>

                        <div>
                            <x-input-label for="fecha_registro" :value="__('Fecha de Registro')" />
                            <x-text-input id="fecha_registro" class="block mt-1 w-full" type="date" name="fecha_registro" :value="old('fecha_registro', date('Y-m-d'))" required />
                            <x-input-error class="mt-2" :messages="$errors->get('fecha_registro')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Registrar Tesis') }}</x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>