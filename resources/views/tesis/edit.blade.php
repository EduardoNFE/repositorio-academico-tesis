<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Tesis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('tesis.update', $tesis->id_tesis) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT') {{-- Esto es crucial para las actualizaciones --}}

                        <div>
                            <x-input-label for="titulo" :value="__('Título')" />
                            <x-text-input id="titulo" class="block mt-1 w-full" type="text" name="titulo" :value="old('titulo', $tesis->titulo)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('titulo')" />
                        </div>

                        <div>
                            <x-input-label for="autor" :value="__('Autor')" />
                            <x-text-input id="autor" class="block mt-1 w-full" type="text" name="autor" :value="old('autor', $tesis->autor)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('autor')" />
                        </div>

                        <div>
                            <x-input-label for="carrera_id" :value="__('Carrera')" />
                            <select id="carrera_id" name="carrera_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Selecciona una Carrera</option>
                                @foreach($carreras as $carrera)
                                    <option value="{{ $carrera->id_carrera }}" {{ old('carrera_id', $tesis->carrera_id) == $carrera->id_carrera ? 'selected' : '' }}>
                                        {{ $carrera->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('carrera_id')" />
                        </div>

                        <div>
                            <x-input-label for="asesor" :value="__('Asesor')" />
                            <x-text-input id="asesor" class="block mt-1 w-full" type="text" name="asesor" :value="old('asesor', $tesis->asesor)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('asesor')" />
                        </div>

                        <div>
                            <x-input-label for="año_publicacion" :value="__('Año de Publicación')" />
                            <x-text-input id="año_publicacion" class="block mt-1 w-full" type="number" name="año_publicacion" :value="old('año_publicacion', $tesis->año_publicacion)" required min="1900" max="{{ date('Y') }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('año_publicacion')" />
                        </div>

                        <div>
                            <x-input-label for="palabras_clave" :value="__('Palabras Clave (separadas por comas)')" />
                            <textarea id="palabras_clave" name="palabras_clave" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('palabras_clave', $tesis->palabras_clave) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('palabras_clave')" />
                        </div>

                        <div>
                            <x-input-label for="resumen" :value="__('Resumen')" />
                            <textarea id="resumen" name="resumen" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('resumen', $tesis->resumen) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('resumen')" />
                        </div>

                        <div>
                            <x-input-label for="archivo_pdf" :value="__('Archivo PDF (dejar en blanco para mantener el actual)')" />
                            <input id="archivo_pdf" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" type="file" name="archivo_pdf" accept="application/pdf" />
                            <x-input-error class="mt-2" :messages="$errors->get('archivo_pdf')" />
                            @if ($tesis->archivo_pdf)
                                <p class="text-sm text-gray-600 mt-1">Archivo actual: <a href="{{ Storage::url($tesis->archivo_pdf) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">Ver PDF actual</a></p>
                            @endif
                        </div>

                        <div>
                            <x-input-label for="fecha_registro" :value="__('Fecha de Registro')" />
                            <x-text-input id="fecha_registro" class="block mt-1 w-full" type="date" name="fecha_registro" :value="old('fecha_registro', \Carbon\Carbon::parse($tesis->fecha_registro)->format('Y-m-d'))" required />
                            <x-input-error class="mt-2" :messages="$errors->get('fecha_registro')" />
                        </div>


                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Actualizar Tesis') }}</x-primary-button>
                            <a href="{{ route('tesis.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Cancelar') }}
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>