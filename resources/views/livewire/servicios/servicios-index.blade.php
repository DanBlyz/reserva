<div>
    <div class="space-y-6">

        <!-- MENSAJE FLASH DE ÉXITO -->
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                 class="flex items-center justify-between p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 shadow-sm transition">
                <div class="flex items-center gap-3">
                    <span class="p-1.5 bg-emerald-100 dark:bg-emerald-900 rounded-lg text-emerald-600 dark:text-emerald-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </span>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 dark:hover:text-emerald-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        <!-- CABECERA DE LA SECCIÓN -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center gap-3.5">
                <span class="p-3 bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 rounded-2xl ring-1 ring-indigo-500/10 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </span>
                <div>
                    <h1 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">Servicios de Fisioterapia</h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Catálogo de terapias, tiempos de sesión, tarifas y colores de agenda</p>
                </div>
            </div>

            <!-- BOTÓN NUEVO SERVICIO -->
            <button wire:click="abrirModalCrear" 
                    type="button"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-sm font-semibold rounded-xl shadow-sm shadow-indigo-500/30 transition-all transform hover:-translate-y-0.5 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Nuevo Servicio</span>
            </button>
        </div>

        <!-- TARJETAS DE MÉTRICAS RÁPIDAS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400 block">Total Catálogo</span>
                    <span class="text-lg font-extrabold text-slate-900 dark:text-white">{{ $totalServicios }}</span>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400 block">Servicios Activos</span>
                    <span class="text-lg font-extrabold text-emerald-600 dark:text-emerald-400">{{ $totalActivos }}</span>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-cyan-50 dark:bg-cyan-950/50 text-cyan-600 dark:text-cyan-400 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400 block">Duración Promedio</span>
                    <span class="text-lg font-extrabold text-slate-900 dark:text-white">{{ $duracionPromedio }} min</span>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400 block">Precio Promedio</span>
                    <span class="text-lg font-extrabold text-slate-900 dark:text-white">Bs. {{ number_format($precioPromedio, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- FILTROS, BÚSQUEDA Y PAGINACIÓN PERPAGE -->
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="relative flex-1 max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" 
                       type="text" 
                       placeholder="Buscar por nombre o descripción de servicio..." 
                       class="w-full pl-10 pr-9 py-2 rounded-xl text-xs sm:text-sm bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-slate-400">
                @if($search)
                    <button wire:click="$set('search', '')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                @endif
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <!-- Filtro de estado -->
                <div class="flex items-center gap-2">
                    <label class="text-xs font-medium text-slate-500 dark:text-slate-400">Estado:</label>
                    <select wire:model.live="filtroActivo" class="py-1.5 px-3 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500">
                        <option value="">Todos</option>
                        <option value="1">Activos</option>
                        <option value="0">Inactivos</option>
                    </select>
                </div>

                <!-- Selector de registros por página [10, 25, 50] -->
                <div class="flex items-center gap-2">
                    <label class="text-xs font-medium text-slate-500 dark:text-slate-400">Ver:</label>
                    <select wire:model.live="perPage" class="py-1.5 px-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>

                @if($search || $filtroActivo !== '')
                    <button wire:click="limpiarFiltros" class="text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
                        Limpiar filtros
                    </button>
                @endif
            </div>
        </div>

        <!-- TABLA DE SERVICIOS -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm text-slate-600 dark:text-slate-300">
                    <thead class="bg-slate-50 dark:bg-slate-800/60 text-slate-600 dark:text-slate-300 font-semibold border-b border-slate-200 dark:border-slate-800 text-[11px] uppercase tracking-wider">
                        <tr>
                            <th scope="col" class="py-3.5 px-4">
                                <button wire:click="ordenarPor('nombre')" class="flex items-center gap-1.5 hover:text-indigo-600 dark:hover:text-indigo-400 cursor-pointer">
                                    <span>Servicio</span>
                                    @if($ordenarPor === 'nombre')
                                        <span>{{ $ordenDireccion === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </button>
                            </th>
                            <th scope="col" class="py-3.5 px-4 text-center">Color Agenda</th>
                            <th scope="col" class="py-3.5 px-4 text-center">
                                <button wire:click="ordenarPor('duracion_minutos')" class="inline-flex items-center gap-1.5 hover:text-indigo-600 dark:hover:text-indigo-400 cursor-pointer">
                                    <span>Duración</span>
                                    @if($ordenarPor === 'duracion_minutos')
                                        <span>{{ $ordenDireccion === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </button>
                            </th>
                            <th scope="col" class="py-3.5 px-4 text-right">
                                <button wire:click="ordenarPor('precio_base')" class="inline-flex items-center gap-1.5 hover:text-indigo-600 dark:hover:text-indigo-400 cursor-pointer">
                                    <span>Precio Base</span>
                                    @if($ordenarPor === 'precio_base')
                                        <span>{{ $ordenDireccion === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </button>
                            </th>
                            <th scope="col" class="py-3.5 px-4 text-center">Estado</th>
                            <th scope="col" class="py-3.5 px-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800 font-normal">
                        @forelse($servicios as $servicio)
                            <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition">
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-3.5 h-3.5 rounded-full shrink-0 shadow-sm ring-1 ring-black/10" style="background-color: {{ $servicio->color }}"></div>
                                        <div>
                                            <span class="font-semibold text-slate-900 dark:text-white block">{{ $servicio->nombre }}</span>
                                            @if($servicio->descripcion)
                                                <span class="text-xs text-slate-500 dark:text-slate-400 line-clamp-1 max-w-md">{{ $servicio->descripcion }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-mono font-medium border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                                        <span class="w-2.5 h-2.5 rounded-full" style="background-color: {{ $servicio->color }}"></span>
                                        {{ strtoupper($servicio->color) }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 border border-indigo-200/60 dark:border-indigo-800/60">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $servicio->duracion_minutos }} min
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right font-semibold text-slate-900 dark:text-white">
                                    Bs. {{ number_format($servicio->precio_base, 2) }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <button wire:click="toggleEstado({{ $servicio->id }})"
                                            type="button"
                                            title="{{ $servicio->activo ? 'Click para desactivar servicio' : 'Click para activar servicio' }}"
                                            class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full text-xs font-semibold cursor-pointer transition-all border shadow-2xs {{ $servicio->activo ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800' : 'bg-slate-100 text-slate-500 border-slate-200 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700' }}">
                                        <span class="relative inline-flex h-4 w-7 shrink-0 rounded-full transition-colors duration-200 ease-in-out {{ $servicio->activo ? 'bg-emerald-500' : 'bg-slate-300 dark:bg-slate-600' }}">
                                            <span class="inline-block h-3 w-3 transform rounded-full bg-white shadow-xs transition duration-200 ease-in-out mt-0.5 {{ $servicio->activo ? 'translate-x-3.5' : 'translate-x-0.5' }}"></span>
                                        </span>
                                        <span>{{ $servicio->activo ? 'Activo' : 'Inactivo' }}</span>
                                    </button>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <div class="inline-flex items-center gap-1">
                                        <!-- Editar -->
                                        <button wire:click="abrirModalEditar({{ $servicio->id }})"
                                                type="button"
                                                title="Editar Servicio"
                                                class="p-1.5 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-950/50 dark:text-slate-400 dark:hover:text-indigo-400 transition cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <!-- Eliminar -->
                                        <button wire:click="confirmarEliminar({{ $servicio->id }})"
                                                type="button"
                                                title="Eliminar Servicio"
                                                class="p-1.5 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/50 dark:text-slate-400 dark:hover:text-rose-400 transition cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 px-4 text-center">
                                    <div class="max-w-xs mx-auto text-slate-400 dark:text-slate-500 flex flex-col items-center">
                                        <svg class="w-12 h-12 mb-3 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-sm font-medium text-slate-600 dark:text-slate-300">No se encontraron servicios</p>
                                        <p class="text-xs mt-1 text-slate-400">Intenta cambiar los términos de búsqueda o registra un nuevo servicio.</p>
                                        @if($search || $filtroActivo !== '')
                                            <button wire:click="limpiarFiltros" class="mt-3 text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                                                Restablecer filtros
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINACIÓN -->
            @if($servicios->hasPages())
                <div class="p-4 border-t border-slate-200 dark:border-slate-800">
                    {{ $servicios->links() }}
                </div>
            @endif
        </div>

    </div>

    <!-- MODAL DE CREACIÓN / EDICIÓN -->
    @if($mostrarModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Fondo oscuro -->
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" wire:click="cerrarModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Contenedor del Modal -->
                <div class="relative inline-block align-bottom bg-white dark:bg-slate-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200 dark:border-slate-800">
                    <form wire:submit="guardar">
                        <!-- Cabecera Modal -->
                        <div class="flex items-center justify-between p-6 border-b border-slate-100 dark:border-slate-800">
                            <div class="flex items-center gap-3">
                                <span class="p-2.5 bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 rounded-xl">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </span>
                                <div>
                                    <h3 class="text-base font-bold text-slate-900 dark:text-white" id="modal-title">
                                        {{ $modoEdicion ? 'Editar Servicio' : 'Nuevo Servicio de Fisioterapia' }}
                                    </h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Complete los datos de la terapia para la agenda de turnos</p>
                                </div>
                            </div>
                            <button wire:click="cerrarModal" type="button" class="text-slate-400 hover:text-slate-500 dark:hover:text-slate-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Cuerpo del Formulario -->
                        <div class="p-6 space-y-4">
                            <!-- Nombre del Servicio -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                    Nombre del Servicio <span class="text-rose-500">*</span>
                                </label>
                                <input wire:model="nombre" 
                                       type="text" 
                                       placeholder="Ej: Fisioterapia Deportiva Avanzada"
                                       class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-slate-50 dark:bg-slate-800 border @error('nombre') border-rose-500 @else border-slate-200 dark:border-slate-700 @enderror text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('nombre')
                                    <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Duración y Precio (2 columnas) -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Duración en Minutos -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                        Duración (minutos) <span class="text-rose-500">*</span>
                                    </label>
                                    <input wire:model="duracion_minutos" 
                                           type="number" 
                                           min="5" 
                                           max="480"
                                           placeholder="30"
                                           class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-slate-50 dark:bg-slate-800 border @error('duracion_minutos') border-rose-500 @else border-slate-200 dark:border-slate-700 @enderror text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500">
                                    @error('duracion_minutos')
                                        <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                                    @enderror

                                    <!-- Chips de duración rápida -->
                                    <div class="flex flex-wrap gap-1.5 mt-2">
                                        @foreach($duracionesSugeridas as $min)
                                            <button type="button" 
                                                    wire:click="seleccionarDuracion({{ $min }})"
                                                    class="px-2 py-0.5 text-[11px] rounded-md font-medium transition cursor-pointer {{ (int)$duracion_minutos === $min ? 'bg-indigo-600 text-white shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200' }}">
                                                {{ $min }}m
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Precio Base (Bs.) -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                        Precio Base (Bs.) <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-bold text-slate-400">
                                            Bs.
                                        </span>
                                        <input wire:model="precio_base" 
                                               type="number" 
                                               step="0.01" 
                                               min="0"
                                               placeholder="150.00"
                                               class="w-full pl-10 pr-3.5 py-2.5 rounded-xl text-sm bg-slate-50 dark:bg-slate-800 border @error('precio_base') border-rose-500 @else border-slate-200 dark:border-slate-700 @enderror text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                    @error('precio_base')
                                        <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Color Identificador para Agenda -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                    Color de la Agenda <span class="text-rose-500">*</span>
                                </label>
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center gap-2">
                                        <input wire:model="color" 
                                               type="color" 
                                               class="w-10 h-10 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer p-0.5 bg-white dark:bg-slate-800">
                                        <input wire:model="color" 
                                               type="text" 
                                               placeholder="#4f46e5"
                                               class="w-28 px-3 py-2 rounded-xl text-xs font-mono uppercase bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white">
                                    </div>

                                    <!-- Paleta sugerida rápida -->
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($coloresSugeridos as $hex)
                                            <button type="button" 
                                                    wire:click="seleccionarColor('{{ $hex }}')"
                                                    title="{{ $hex }}"
                                                    class="w-6 h-6 rounded-full border-2 transition transform hover:scale-110 cursor-pointer {{ strtolower($color) === strtolower($hex) ? 'border-slate-900 dark:border-white ring-2 ring-indigo-500 ring-offset-1' : 'border-white dark:border-slate-900' }}"
                                                    style="background-color: {{ $hex }}">
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                                @error('color')
                                    <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Descripción -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                    Descripción o Indicaciones Clínicas
                                </label>
                                <textarea wire:model="descripcion" 
                                          rows="3" 
                                          placeholder="Detalle clínico del servicio, patologías tratadas, instrumental necesario..."
                                          class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500"></textarea>
                                @error('descripcion')
                                    <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Estado Activo -->
                            <div class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                                <div>
                                    <span class="text-xs font-semibold text-slate-800 dark:text-slate-200 block">
                                        Servicio Habilitado
                                    </span>
                                    <span class="text-[11px] text-slate-400">
                                        Disponible en la agenda para reservas y citas de pacientes
                                    </span>
                                </div>
                                <button type="button" 
                                        wire:click="$toggle('activo')"
                                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 {{ $activo ? 'bg-indigo-600' : 'bg-slate-300 dark:bg-slate-700' }}" 
                                        role="switch" 
                                        aria-checked="{{ $activo ? 'true' : 'false' }}">
                                    <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow-md ring-0 transition duration-200 ease-in-out {{ $activo ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                </button>
                            </div>
                        </div>

                        <!-- Pie del Formulario -->
                        <div class="p-6 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                            <button wire:click="cerrarModal" 
                                    type="button" 
                                    class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition cursor-pointer">
                                Cancelar
                            </button>
                            <button type="submit" 
                                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-xl text-xs sm:text-sm font-semibold shadow-sm shadow-indigo-500/30 transition cursor-pointer">
                                {{ $modoEdicion ? 'Actualizar Servicio' : 'Guardar Servicio' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN -->
    @if($mostrarModalEliminar)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-eliminar-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" wire:click="cancelarEliminar"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="relative inline-block align-bottom bg-white dark:bg-slate-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-200 dark:border-slate-800 p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900 dark:text-white" id="modal-eliminar-title">
                                ¿Eliminar Servicio?
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                Estás a punto de dar de baja el servicio <span class="font-semibold text-slate-800 dark:text-slate-200">"{{ $servicioAEliminarNombre }}"</span>. Esta acción aplicará borrado lógico.
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-3">
                        <button wire:click="cancelarEliminar" 
                                type="button" 
                                class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition cursor-pointer">
                            Cancelar
                        </button>
                        <button wire:click="eliminar" 
                                type="button" 
                                class="px-4 py-2.5 bg-rose-600 hover:bg-rose-700 active:bg-rose-800 text-white rounded-xl text-xs sm:text-sm font-semibold shadow-sm shadow-rose-500/30 transition cursor-pointer">
                            Sí, Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
