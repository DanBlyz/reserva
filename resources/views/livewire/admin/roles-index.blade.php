<div>
    <div class="space-y-6">

        <!-- CABECERA -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="p-2.5 bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </span>
                <div>
                    <h1 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">Roles y Permisos del Sistema</h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Control de perfiles de acceso y matriz de autorizaciones del personal</p>
                </div>
            </div>

            <!-- BOTON CREAR ROL -->
            <button wire:click="abrirModalCrear" 
                    type="button"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-sm font-semibold rounded-xl shadow-sm shadow-indigo-500/30 transition-all transform hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Nuevo Rol</span>
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

        <!-- GRID DE ROLES EXISTENTES -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($roles as $rol)
                <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col justify-between hover:border-indigo-300 dark:hover:border-indigo-800 transition">
                    <div>
                        <div class="flex items-start justify-between gap-2 mb-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ in_array($rol->slug, $rolesProtegidos) ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/60 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800' : 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300' }}">
                                @if(in_array($rol->slug, $rolesProtegidos))
                                    <svg class="w-3 h-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    Sistema
                                @else
                                    Personalizado
                                @endif
                            </span>

                            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                                {{ $rol->usuarios_count }} usuarios
                            </span>
                        </div>

                        <h3 class="font-bold text-slate-900 dark:text-white text-base">{{ $rol->nombre }}</h3>
                        <p class="text-xs font-mono text-slate-400 mt-0.5">{{ $rol->slug }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 line-clamp-2">{{ $rol->descripcion ?? 'Sin descripción' }}</p>
                    </div>

                    <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between gap-2">
                        <!-- Toggle Estado Rol -->
                        <button wire:click="toggleEstado({{ $rol->id }})"
                                type="button" 
                                @if($rol->slug === 'admin') disabled @endif
                                title="{{ $rol->slug === 'admin' ? 'El rol de Administrador siempre está activo' : ($rol->activo ? 'Click para desactivar rol' : 'Click para activar rol') }}"
                                class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full text-xs font-semibold transition-all border shadow-2xs {{ $rol->slug === 'admin' ? 'opacity-80 cursor-not-allowed' : 'cursor-pointer' }} {{ $rol->activo ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800' : 'bg-slate-100 text-slate-500 border-slate-200 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700' }}">
                            <span class="relative inline-flex h-4 w-7 shrink-0 rounded-full transition-colors duration-200 ease-in-out {{ $rol->activo ? 'bg-emerald-500' : 'bg-slate-300 dark:bg-slate-600' }}">
                                <span class="inline-block h-3 w-3 transform rounded-full bg-white shadow-xs transition duration-200 ease-in-out mt-0.5 {{ $rol->activo ? 'translate-x-3.5' : 'translate-x-0.5' }}"></span>
                            </span>
                            <span>{{ $rol->activo ? 'Activo' : 'Inactivo' }}</span>
                        </button>

                        <div class="flex items-center gap-1.5">
                            <button wire:click="abrirModalEditar({{ $rol->id }})" 
                                    title="Editar Rol"
                                    class="p-1.5 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-slate-800 rounded-lg transition cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>

                            @if(!in_array($rol->slug, $rolesProtegidos))
                                <button wire:click="confirmarEliminar({{ $rol->id }})" 
                                        title="Eliminar Rol"
                                        class="p-1.5 text-slate-500 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-slate-800 rounded-lg transition cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- MATRIZ GENERAL DE PERMISOS REGISTRADOS -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-5">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Catálogo de Permisos Granulares del Sistema</h2>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">
                Estos permisos pueden asignarse de manera directa a usuarios específicos en el módulo de Personal para extender o acotar sus privilegios.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($permisosPorModulo as $modulo => $permisos)
                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/80">
                        <div class="flex items-center justify-between pb-2 mb-3 border-b border-slate-200 dark:border-slate-700">
                            <span class="text-xs uppercase font-extrabold text-indigo-600 dark:text-indigo-400 tracking-wider">
                                Módulo: {{ $modulo }}
                            </span>
                            <span class="text-[11px] font-semibold text-slate-400">
                                {{ $permisos->count() }} permisos
                            </span>
                        </div>
                        <ul class="space-y-2">
                            @foreach($permisos as $permiso)
                                <li class="text-xs">
                                    <div class="flex items-start gap-2">
                                        <svg class="w-3.5 h-3.5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <div>
                                            <p class="font-bold text-slate-800 dark:text-slate-200">{{ $permiso->nombre }}</p>
                                            <p class="text-[11px] font-mono text-indigo-500 dark:text-indigo-400">{{ $permiso->clave }}</p>
                                            <p class="text-[11px] text-slate-400 dark:text-slate-500">{{ $permiso->descripcion }}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- MODAL CREAR / EDITAR ROL -->
    @if($mostrarModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div wire:click="$set('mostrarModal', false)" class="fixed inset-0 bg-slate-900/75 dark:bg-slate-950/80 backdrop-blur-sm"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-200 dark:border-slate-800">
                    
                    <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">
                            {{ $modoEdicion ? 'Editar Rol' : 'Nuevo Rol de Usuario' }}
                        </h3>
                        <button wire:click="$set('mostrarModal', false)" class="text-slate-400 hover:text-slate-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form wire:submit="guardar">
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Nombre del Rol <span class="text-rose-500">*</span></label>
                                <input wire:model.live="nombre" type="text" placeholder="Ej: Terapeuta Senior, Asistente..." class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500">
                                @error('nombre') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Identificador Slug <span class="text-rose-500">*</span></label>
                                <input wire:model="slug" type="text" placeholder="ej: terapeuta_senior" class="w-full px-3.5 py-2.5 rounded-xl text-sm font-mono bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500">
                                @error('slug') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Descripción</label>
                                <textarea wire:model="descripcion" rows="2" placeholder="Funciones y alcance de este rol..." class="w-full px-3.5 py-2.5 rounded-xl text-sm bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-indigo-500"></textarea>
                                @error('descripcion') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700">
                                <div>
                                    <span class="text-xs font-semibold text-slate-800 dark:text-slate-200 block">Rol Activo</span>
                                    <span class="text-[11px] text-slate-400">Permite asignar este rol a usuarios del sistema</span>
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
                                {{ $modoEdicion ? 'Actualizar Rol' : 'Guardar Rol' }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endif

    <!-- MODAL ELIMINAR ROL -->
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
                            <h3 class="text-base font-bold text-slate-900 dark:text-white">¿Eliminar Rol?</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                Estás por eliminar el rol personalizado <span class="font-bold text-slate-700 dark:text-slate-200">"{{ $rolAEliminarNombre }}"</span>.
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
