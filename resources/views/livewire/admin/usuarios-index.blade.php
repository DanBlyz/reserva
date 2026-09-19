<div>
    <div class="space-y-6">

        <!-- CABECERA -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="p-2.5 bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </span>
                <div>
                    <h1 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">Personal y Usuarios</h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Control de fisioterapeutas, recepcionistas, cajeros y permisos individuales</p>
                </div>
            </div>

            <!-- BOTON CREAR USUARIO -->
            <button wire:click="abrirModalCrear" 
                    type="button"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-sm font-semibold rounded-xl shadow-sm shadow-indigo-500/30 transition-all transform hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                <span>Nuevo Usuario</span>
            </button>
        </div>

        <!-- ALERTAS -->
        @if(session('error'))
            <div class="p-4 bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 rounded-2xl text-xs flex items-center gap-3 shadow-sm">
                <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- FILTROS Y BUSCADOR -->
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <!-- Buscador -->
            <div class="relative flex-1 max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" 
                       type="text" 
                       placeholder="Buscar por nombre, email, cédula..." 
                       class="w-full pl-10 pr-9 py-2 rounded-xl text-xs sm:text-sm bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500">
                @if($search)
                    <button wire:click="$set('search', '')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                @endif
            </div>

            <!-- Filtros combinados -->
            <div class="flex items-center flex-wrap gap-2.5">
                <!-- Filtro Rol -->
                <select wire:model.live="filtroRol" class="py-1.5 px-3 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200">
                    <option value="">Todos los Roles</option>
                    @foreach($roles as $rol)
                        <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                    @endforeach
                </select>

                <!-- Filtro Sucursal -->
                <select wire:model.live="filtroSucursal" class="py-1.5 px-3 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200">
                    <option value="">Todas las Sedes</option>
                    @foreach($sucursales as $sucursal)
                        <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                    @endforeach
                </select>

                <!-- Filtro Estado -->
                <select wire:model.live="filtroEstado" class="py-1.5 px-3 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200">
                    <option value="">Todos los Estados</option>
                    <option value="1">Activos</option>
                    <option value="0">Inactivos</option>
                </select>

                <!-- Elementos por página -->
                <div class="flex items-center gap-1.5">
                    <label class="text-xs font-medium text-slate-500 dark:text-slate-400">Ver:</label>
                    <select wire:model.live="perPage" class="py-1.5 px-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- TABLA DE USUARIOS -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm text-slate-600 dark:text-slate-300">
                    <thead class="bg-slate-50 dark:bg-slate-800/60 text-slate-600 dark:text-slate-300 font-semibold border-b border-slate-200 dark:border-slate-800 text-[11px] uppercase tracking-wider">
                        <tr>
                            <th scope="col" class="py-3.5 px-4">
                                <button wire:click="ordenar('name')" class="flex items-center gap-1.5 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <span>Usuario / Personal</span>
                                    @if($ordenarPor === 'name')
                                        <span>{{ $ordenDireccion === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </button>
                            </th>
                            <th scope="col" class="py-3.5 px-4">Rol Asignado</th>
                            <th scope="col" class="py-3.5 px-4">Sede / Sucursal</th>
                            <th scope="col" class="py-3.5 px-4 text-center">Permisos Extra</th>
                            <th scope="col" class="py-3.5 px-4 text-center">Estado</th>
                            <th scope="col" class="py-3.5 px-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                        @forelse($usuarios as $user)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                <!-- Nombre y Avatar -->
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-xs shrink-0 border border-indigo-200/50 dark:border-indigo-800/50">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800 dark:text-slate-100 text-sm">{{ $user->nombre_completo }}</p>
                                            <p class="text-xs text-slate-400">{{ $user->email }}</p>
                                            @if($user->cedula)
                                                <p class="text-[11px] text-slate-500 font-mono">CI: {{ $user->cedula }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Rol -->
                                <td class="py-3.5 px-4">
                                    @if($user->rol)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $user->rol->slug === 'admin' ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/60 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800' : 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300' }}">
                                            {{ $user->rol->nombre }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-xs italic">Sin Rol</span>
                                    @endif
                                </td>

                                <!-- Sucursal -->
                                <td class="py-3.5 px-4">
                                    @if($user->sucursal)
                                        <span class="inline-flex items-center gap-1.5 text-xs text-slate-700 dark:text-slate-300">
                                            <svg class="w-3.5 h-3.5 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            {{ $user->sucursal->nombre }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-xs italic">Todas / Global</span>
                                    @endif
                                </td>

                                <!-- Permisos Granulares -->
                                <td class="py-3.5 px-4 text-center">
                                    @if($user->esAdmin())
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                                            Total (Admin)
                                        </span>
                                    @else
                                        <button wire:click="abrirModalPermisos({{ $user->id }})" 
                                                type="button"
                                                class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 hover:bg-indigo-100 dark:bg-indigo-950/60 dark:text-indigo-300 dark:hover:bg-indigo-900/60 border border-indigo-200 dark:border-indigo-800 transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                            </svg>
                                            <span>{{ $user->permisos->count() }} directos</span>
                                        </button>
                                    @endif
                                </td>

                                <!-- Estado Toggle -->
                                <td class="py-3.5 px-4 text-center">
                                    <button wire:click="toggleEstado({{ $user->id }})"
                                            type="button" 
                                            @if($user->id === auth()->id()) disabled @endif
                                            title="{{ $user->id === auth()->id() ? 'No puedes desactivar tu propia cuenta' : ($user->activo ? 'Click para desactivar usuario' : 'Click para activar usuario') }}"
                                            class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full text-xs font-semibold transition-all border shadow-2xs {{ $user->id === auth()->id() ? 'opacity-80 cursor-not-allowed' : 'cursor-pointer' }} {{ $user->activo ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800' : 'bg-slate-100 text-slate-500 border-slate-200 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700' }}">
                                        <span class="relative inline-flex h-4 w-7 shrink-0 rounded-full transition-colors duration-200 ease-in-out {{ $user->activo ? 'bg-emerald-500' : 'bg-slate-300 dark:bg-slate-600' }}">
                                            <span class="inline-block h-3 w-3 transform rounded-full bg-white shadow-xs transition duration-200 ease-in-out mt-0.5 {{ $user->activo ? 'translate-x-3.5' : 'translate-x-0.5' }}"></span>
                                        </span>
                                        <span>{{ $user->activo ? 'Activo' : 'Inactivo' }}</span>
                                    </button>
                                </td>

                                <!-- Acciones -->
                                <td class="py-3.5 px-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <!-- Permisos botón directo -->
                                        @if(!$user->esAdmin())
                                            <button wire:click="abrirModalPermisos({{ $user->id }})" 
                                                    title="Gestionar Permisos Granulares"
                                                    class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-slate-800 rounded-lg transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                                </svg>
                                            </button>
                                        @endif

                                        <!-- Editar -->
                                        <button wire:click="abrirModalEditar({{ $user->id }})" 
                                                title="Editar Datos"
                                                class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-slate-800 rounded-lg transition cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <!-- Cambiar Contraseña -->
                                        <button wire:click="abrirModalPassword({{ $user->id }})" 
                                                type="button"
                                                title="Modificar Contraseña"
                                                class="p-2 text-slate-500 hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-slate-800 rounded-lg transition cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </button>

                                        <!-- Eliminar -->
                                        @if($user->id !== auth()->id())
                                            <button wire:click="confirmarEliminar({{ $user->id }})" 
                                                    title="Dar de baja usuario"
                                                    class="p-2 text-slate-500 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-slate-800 rounded-lg transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400 dark:text-slate-500">
                                    <p class="text-sm font-semibold">No se encontraron usuarios</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($usuarios->hasPages())
                <div class="p-4 border-t border-slate-200 dark:border-slate-800">
                    {{ $usuarios->links() }}
                </div>
            @endif
        </div>

    </div>

    <!-- MODAL CREAR / EDITAR USUARIO -->
    @if($mostrarModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div wire:click="$set('mostrarModal', false)" class="fixed inset-0 bg-slate-900/75 dark:bg-slate-950/80 backdrop-blur-sm"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-200 dark:border-slate-800">
                    
                    <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">
                            {{ $modoEdicion ? 'Editar Personal / Usuario' : 'Nuevo Personal / Usuario' }}
                        </h3>
                        <button wire:click="$set('mostrarModal', false)" class="text-slate-400 hover:text-slate-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form wire:submit="guardar">
                        <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">

                            <!-- Nombre completo / de cuenta -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Nombre para mostrar en el sistema <span class="text-rose-500">*</span></label>
                                <input wire:model="name" type="text" placeholder="Ej: Dr. Carlos Ramos" class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500">
                                @error('name') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Nombres y Apellidos Desglosados -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Nombres</label>
                                    <input wire:model="nombres" type="text" placeholder="Carlos" class="w-full px-3 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Apellido Paterno</label>
                                    <input wire:model="ap_paterno" type="text" placeholder="Ramos" class="w-full px-3 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Apellido Materno</label>
                                    <input wire:model="ap_materno" type="text" placeholder="Gutiérrez" class="w-full px-3 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500">
                                </div>
                            </div>

                            <!-- Cédula y Teléfono -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Cédula / Documento</label>
                                    <input wire:model="cedula" type="text" placeholder="7894561" class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Celular / Teléfono</label>
                                    <input wire:model="celular" type="text" placeholder="71234567" class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500">
                                </div>
                            </div>

                            <!-- Rol y Sucursal -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Rol en el Sistema <span class="text-rose-500">*</span></label>
                                    <select wire:model="rol_id" class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500">
                                        <option value="">Seleccionar Rol...</option>
                                        @foreach($roles as $r)
                                            <option value="{{ $r->id }}">{{ $r->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('rol_id') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Sucursal Asignada</label>
                                    <select wire:model="sucursal_id" class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500">
                                        <option value="">Sin Sucursal Fija (Global)</option>
                                        @foreach($sucursales as $s)
                                            <option value="{{ $s->id }}">{{ $s->nombre }} ({{ $s->codigo }})</option>
                                        @endforeach
                                    </select>
                                    @error('sucursal_id') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Email y Contraseña -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Correo Electrónico <span class="text-rose-500">*</span></label>
                                    <input wire:model="email" type="email" placeholder="usuario@consultorio.com" class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500">
                                    @error('email') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                        Contraseña {{ $modoEdicion ? '(Dejar en blanco para no cambiar)' : '*' }}
                                    </label>
                                    <input wire:model="password" type="password" placeholder="••••••••" class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500">
                                    @error('password') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Estado Activo -->
                            <div class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700">
                                <div>
                                    <span class="text-xs font-semibold text-slate-800 dark:text-slate-200 block">Usuario Activo</span>
                                    <span class="text-[11px] text-slate-400">Si está inactivo, no podrá iniciar sesión en el sistema</span>
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

                        <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/80 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                            <button wire:click="$set('mostrarModal', false)" type="button" class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-200/70 rounded-xl transition">Cancelar</button>
                            <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm transition">
                                {{ $modoEdicion ? 'Actualizar Personal' : 'Guardar Personal' }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endif

    <!-- MODAL GESTION DE PERMISOS GRANULARES -->
    @if($mostrarModalPermisos)
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div wire:click="$set('mostrarModalPermisos', false)" class="fixed inset-0 bg-slate-900/75 dark:bg-slate-950/80 backdrop-blur-sm"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-200 dark:border-slate-800">
                    
                    <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <div>
                            <h3 class="text-base font-bold text-slate-900 dark:text-white">
                                Permisos Granulares Directos
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Asignando permisos específicos para: <span class="font-bold text-indigo-600 dark:text-indigo-400">{{ $usuarioPermisosNombre }}</span>
                            </p>
                        </div>
                        <button wire:click="$set('mostrarModalPermisos', false)" class="text-slate-400 hover:text-slate-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-6 max-h-[60vh] overflow-y-auto space-y-6">
                        @foreach($permisosPorModulo as $modulo => $permisos)
                            <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/80">
                                <div class="flex items-center justify-between pb-2 mb-3 border-b border-slate-200 dark:border-slate-700">
                                    <span class="text-xs uppercase font-extrabold text-indigo-600 dark:text-indigo-400 tracking-wider">
                                        Módulo: {{ $modulo }}
                                    </span>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                    @foreach($permisos as $permiso)
                                        <label class="flex items-start gap-2.5 p-2 rounded-xl hover:bg-white dark:hover:bg-slate-800 transition cursor-pointer border border-transparent hover:border-slate-200 dark:hover:border-slate-700">
                                            <input wire:model="permisosSeleccionados" 
                                                   type="checkbox" 
                                                   value="{{ $permiso->id }}"
                                                   class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500 mt-0.5">
                                            <div>
                                                <span class="text-xs font-semibold text-slate-800 dark:text-slate-200 block">{{ $permiso->nombre }}</span>
                                                <span class="text-[10px] text-slate-400 block">{{ $permiso->descripcion }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/80 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                        <button wire:click="$set('mostrarModalPermisos', false)" type="button" class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-200/70 rounded-xl transition">Cancelar</button>
                        <button wire:click="guardarPermisos" type="button" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm transition">
                            Guardar Permisos
                        </button>
                    </div>

                </div>
            </div>
        </div>
    @endif

    <!-- MODAL ELIMINAR USUARIO -->
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
                            <h3 class="text-base font-bold text-slate-900 dark:text-white">¿Dar de baja Usuario?</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                Estás por dar de baja al usuario <span class="font-bold text-slate-700 dark:text-slate-200">"{{ $usuarioAEliminarNombre }}"</span>. Sus registros históricos permanecerán guardados.
                            </p>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center justify-end gap-3">
                        <button wire:click="$set('mostrarModalEliminar', false)" type="button" class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 rounded-xl transition cursor-pointer">Cancelar</button>
                        <button wire:click="eliminar" type="button" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm transition cursor-pointer">Sí, dar de baja</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL MODIFICAR CONTRASEÑA -->
    @if($mostrarModalPassword)
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true" aria-labelledby="modal-password-title">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div wire:click="cerrarModalPassword" class="fixed inset-0 bg-slate-900/75 dark:bg-slate-950/80 backdrop-blur-sm transition-opacity"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-200 dark:border-slate-800">
                    <form wire:submit="cambiarPassword">
                        <!-- Cabecera -->
                        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-slate-900 dark:text-white" id="modal-password-title">
                                        Modificar Contraseña
                                    </h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">
                                        Usuario: <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $usuarioPasswordNombre }}</span>
                                    </p>
                                </div>
                            </div>
                            <button wire:click="cerrarModalPassword" type="button" class="text-slate-400 hover:text-slate-500 dark:hover:text-slate-300 cursor-pointer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Contenido -->
                        <div class="p-6 space-y-4">
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300">
                                        Nueva Contraseña <span class="text-rose-500">*</span>
                                    </label>
                                    <button type="button" 
                                            wire:click="generarPassword" 
                                            class="text-[11px] font-semibold text-indigo-600 dark:text-indigo-400 hover:underline inline-flex items-center gap-1 cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        <span>Generar aleatoria</span>
                                    </button>
                                </div>

                                <div x-data="{ show: false }" class="relative">
                                    <input wire:model="nuevaPassword" 
                                           :type="show ? 'text' : 'password'" 
                                           placeholder="Ingresa mínimo 8 caracteres"
                                           autocomplete="new-password"
                                           class="w-full pl-3.5 pr-10 py-2.5 rounded-xl text-sm bg-slate-50 dark:bg-slate-800 border @error('nuevaPassword') border-rose-500 @else border-slate-200 dark:border-slate-700 @enderror text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500">
                                    <button type="button" 
                                            @click="show = !show" 
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 cursor-pointer">
                                        <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="show" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                                @error('nuevaPassword')
                                    <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                                @enderror
                                <p class="mt-1.5 text-[11px] text-slate-500 dark:text-slate-400">
                                    El usuario podrá utilizar esta contraseña de inmediato para iniciar sesión en el sistema.
                                </p>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/60 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                            <button wire:click="cerrarModalPassword" type="button" class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/60 rounded-xl transition cursor-pointer">
                                Cancelar
                            </button>
                            <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm shadow-indigo-500/30 transition cursor-pointer">
                                Actualizar Contraseña
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
