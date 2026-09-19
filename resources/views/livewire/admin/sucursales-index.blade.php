<div>
    <div class="space-y-6">

        <!-- CABECERA -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="p-2.5 bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </span>
                <div>
                    <h1 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">Sedes y Sucursales</h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Administración de clínicas físicas del consultorio de fisioterapia</p>
                </div>
            </div>

            <!-- BOTON CREAR SUCURSAL -->
            <button wire:click="abrirModalCrear" 
                    type="button"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-sm font-semibold rounded-xl shadow-sm shadow-indigo-500/30 transition-all transform hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Nueva Sucursal</span>
            </button>
        </div>

        <!-- TARJETAS DE METRICAS -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400 block">Total Sucursales</span>
                    <span class="text-lg font-extrabold text-slate-900 dark:text-white">{{ $totalSucursales }}</span>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400 block">Sedes Operativas</span>
                    <span class="text-lg font-extrabold text-emerald-600 dark:text-emerald-400">{{ $totalActivas }}</span>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400 block">Ciudades</span>
                    <span class="text-lg font-extrabold text-slate-900 dark:text-white">{{ $ciudadesDistintas }}</span>
                </div>
            </div>
        </div>

        <!-- FILTROS -->
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="relative flex-1 max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" 
                       type="text" 
                       placeholder="Buscar por nombre, código, ciudad..." 
                       class="w-full pl-10 pr-9 py-2 rounded-xl text-xs sm:text-sm bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-slate-400">
                @if($search)
                    <button wire:click="$set('search', '')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                @endif
            </div>

            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2">
                    <label class="text-xs font-medium text-slate-500 dark:text-slate-400">Estado:</label>
                    <select wire:model.live="filtroEstado" class="py-1.5 px-3 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200">
                        <option value="">Todas</option>
                        <option value="1">Activas</option>
                        <option value="0">Inactivas</option>
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <label class="text-xs font-medium text-slate-500 dark:text-slate-400">Ver:</label>
                    <select wire:model.live="perPage" class="py-1.5 px-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- TABLA DE SUCURSALES -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm text-slate-600 dark:text-slate-300">
                    <thead class="bg-slate-50 dark:bg-slate-800/60 text-slate-600 dark:text-slate-300 font-semibold border-b border-slate-200 dark:border-slate-800 text-[11px] uppercase tracking-wider">
                        <tr>
                            <th scope="col" class="py-3.5 px-4">
                                <button wire:click="ordenar('nombre')" class="flex items-center gap-1.5 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <span>Sucursal</span>
                                    @if($ordenarPor === 'nombre')
                                        <span>{{ $ordenDireccion === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </button>
                            </th>
                            <th scope="col" class="py-3.5 px-4">Código</th>
                            <th scope="col" class="py-3.5 px-4">Ciudad / Dirección</th>
                            <th scope="col" class="py-3.5 px-4">Contacto</th>
                            <th scope="col" class="py-3.5 px-4 text-center">Personal</th>
                            <th scope="col" class="py-3.5 px-4 text-center">Estado</th>
                            <th scope="col" class="py-3.5 px-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                        @forelse($sucursales as $sucursal)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                <!-- Nombre -->
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-xs shrink-0">
                                            {{ substr($sucursal->nombre, 0, 2) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800 dark:text-slate-100 text-sm">{{ $sucursal->nombre }}</p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Código -->
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 font-mono text-xs font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                                        {{ $sucursal->codigo }}
                                    </span>
                                </td>

                                <!-- Ubicación -->
                                <td class="py-3.5 px-4">
                                    <p class="font-medium text-slate-800 dark:text-slate-200">{{ $sucursal->ciudad ?? 'Sin ciudad' }}</p>
                                    @if($sucursal->direccion)
                                        <p class="text-xs text-slate-400 truncate max-w-xs">{{ $sucursal->direccion }}</p>
                                    @endif
                                </td>

                                <!-- Teléfono -->
                                <td class="py-3.5 px-4">
                                    @if($sucursal->telefono)
                                        <span class="inline-flex items-center gap-1.5 text-xs text-slate-600 dark:text-slate-300">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            {{ $sucursal->telefono }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-xs italic">Sin teléfono</span>
                                    @endif
                                </td>

                                <!-- Personal Asignado -->
                                <td class="py-3.5 px-4 text-center">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-semibold">
                                        {{ $sucursal->usuarios_count }} usuarios
                                    </span>
                                </td>

                                <!-- Estado Toggle -->
                                <td class="py-3.5 px-4 text-center">
                                    <button wire:click="toggleEstado({{ $sucursal->id }})"
                                            type="button" 
                                            title="{{ $sucursal->activa ? 'Click para desactivar sucursal' : 'Click para activar sucursal' }}"
                                            class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full text-xs font-semibold cursor-pointer transition-all border shadow-2xs {{ $sucursal->activa ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800' : 'bg-slate-100 text-slate-500 border-slate-200 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700' }}">
                                        <span class="relative inline-flex h-4 w-7 shrink-0 rounded-full transition-colors duration-200 ease-in-out {{ $sucursal->activa ? 'bg-emerald-500' : 'bg-slate-300 dark:bg-slate-600' }}">
                                            <span class="inline-block h-3 w-3 transform rounded-full bg-white shadow-xs transition duration-200 ease-in-out mt-0.5 {{ $sucursal->activa ? 'translate-x-3.5' : 'translate-x-0.5' }}"></span>
                                        </span>
                                        <span>{{ $sucursal->activa ? 'Activa' : 'Inactiva' }}</span>
                                    </button>
                                </td>

                                <!-- Acciones -->
                                <td class="py-3.5 px-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button wire:click="abrirModalEditar({{ $sucursal->id }})" 
                                                title="Editar Sucursal"
                                                class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-slate-800 dark:text-slate-400 dark:hover:text-indigo-400 rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <button wire:click="confirmarEliminar({{ $sucursal->id }})" 
                                                title="Eliminar Sucursal"
                                                class="p-2 text-slate-500 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-slate-800 dark:text-slate-400 dark:hover:text-rose-400 rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-400 dark:text-slate-500">
                                    <p class="text-sm font-semibold">No se encontraron sucursales</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($sucursales->hasPages())
                <div class="p-4 border-t border-slate-200 dark:border-slate-800">
                    {{ $sucursales->links() }}
                </div>
            @endif
        </div>

    </div>

    <!-- MODAL CREAR / EDITAR SUCURSAL -->
    @if($mostrarModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div wire:click="$set('mostrarModal', false)" class="fixed inset-0 bg-slate-900/75 dark:bg-slate-950/80 transition-opacity backdrop-blur-sm"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200 dark:border-slate-800">
                    
                    <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">
                            {{ $modoEdicion ? 'Editar Sucursal' : 'Nueva Sucursal' }}
                        </h3>
                        <button wire:click="$set('mostrarModal', false)" class="text-slate-400 hover:text-slate-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form wire:submit="guardar">
                        <div class="p-6 space-y-4">
                            <!-- Nombre -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Nombre de la Sucursal <span class="text-rose-500">*</span></label>
                                <input wire:model="nombre" type="text" placeholder="Ej: Sucursal Central, Sede Miraflores..." class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500">
                                @error('nombre') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Código y Ciudad -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Código Identificador <span class="text-rose-500">*</span></label>
                                    <input wire:model="codigo" type="text" placeholder="Ej: SUC-01" class="w-full px-3.5 py-2.5 rounded-xl text-sm uppercase font-mono bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500">
                                    @error('codigo') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Ciudad</label>
                                    <input wire:model="ciudad" type="text" placeholder="Ej: La Paz, Santa Cruz..." class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500">
                                    @error('ciudad') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Dirección -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Dirección Completa</label>
                                <input wire:model="direccion" type="text" placeholder="Av. Principal #123..." class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500">
                                @error('direccion') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Teléfono -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Teléfono / Celular de Contacto</label>
                                <input wire:model="telefono" type="text" placeholder="71234567" class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500">
                                @error('telefono') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Estado Activa -->
                            <div class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700">
                                <div>
                                    <span class="text-xs font-semibold text-slate-800 dark:text-slate-200 block">Sucursal Operativa</span>
                                    <span class="text-[11px] text-slate-400">Permite agendar reservas y asignar personal a esta sede</span>
                                </div>
                                <button type="button" 
                                        wire:click="$toggle('activa')"
                                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 {{ $activa ? 'bg-indigo-600' : 'bg-slate-300 dark:bg-slate-700' }}" 
                                        role="switch" 
                                        aria-checked="{{ $activa ? 'true' : 'false' }}">
                                    <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow-md ring-0 transition duration-200 ease-in-out {{ $activa ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                </button>
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/80 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                            <button wire:click="$set('mostrarModal', false)" type="button" class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-200/70 dark:hover:bg-slate-700 rounded-xl transition">Cancelar</button>
                            <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm transition">
                                {{ $modoEdicion ? 'Actualizar Sucursal' : 'Guardar Sucursal' }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endif

    <!-- MODAL ELIMINAR SUCURSAL -->
    @if($mostrarModalEliminar)
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div wire:click="$set('mostrarModalEliminar', false)" class="fixed inset-0 bg-slate-900/75 dark:bg-slate-950/80 backdrop-blur-sm"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-200 dark:border-slate-800 p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-rose-50 dark:bg-rose-950/50 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900 dark:text-white">¿Eliminar Sucursal?</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                Se dará de baja la sucursal <span class="font-bold text-slate-700 dark:text-slate-200">"{{ $sucursalAEliminarNombre }}"</span>.
                            </p>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center justify-end gap-3">
                        <button wire:click="$set('mostrarModalEliminar', false)" type="button" class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 rounded-xl transition">Cancelar</button>
                        <button wire:click="eliminar" type="button" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm transition">Sí, eliminar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
