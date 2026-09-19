<div>
    @if($esAdmin && $sucursales->count() > 0)
        <!-- SELECTOR DE SUCURSAL PARA ADMINISTRADOR -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" 
                    type="button"
                    class="flex items-center gap-2 px-3 py-1.5 rounded-xl border border-indigo-200 dark:border-indigo-800/60 bg-indigo-50/60 dark:bg-indigo-950/40 text-indigo-950 dark:text-indigo-200 hover:bg-indigo-100/80 dark:hover:bg-indigo-900/50 transition-all text-xs font-medium shadow-sm focus:outline-none">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                
                <svg class="w-3.5 h-3.5 text-indigo-600 dark:text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>

                <div class="text-left">
                    <span class="block text-[10px] uppercase font-bold text-indigo-500 dark:text-indigo-400 tracking-wider">Sucursal Activa</span>
                    <span class="font-bold text-slate-800 dark:text-slate-100 truncate max-w-[140px] block">
                        {{ $sucursalActual?->nombre ?? 'Seleccionar Sucursal' }}
                    </span>
                </div>

                <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 ml-1" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- DROPDOWN -->
            <div x-show="open" 
                 @click.outside="open = false"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                 class="absolute left-0 mt-2 w-64 bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-800 py-2 z-50 divide-y divide-slate-100 dark:divide-slate-800"
                 x-cloak>
                <div class="px-3 py-1.5 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                    Cambiar Sede de Operación
                </div>
                <div class="py-1 max-h-60 overflow-y-auto">
                    @foreach($sucursales as $sucursal)
                        <button wire:click="cambiarSucursal({{ $sucursal->id }})" 
                                @click="open = false"
                                type="button"
                                class="w-full text-left px-3 py-2 flex items-center justify-between text-xs hover:bg-indigo-50/80 dark:hover:bg-slate-800 transition {{ $sucursalActual?->id === $sucursal->id ? 'bg-indigo-50 dark:bg-slate-800/80 font-bold text-indigo-600 dark:text-indigo-400' : 'text-slate-700 dark:text-slate-300' }}">
                            <div class="flex items-center gap-2.5 truncate">
                                <div class="w-2 h-2 rounded-full {{ $sucursalActual?->id === $sucursal->id ? 'bg-indigo-600 dark:bg-indigo-400' : 'bg-slate-300 dark:bg-slate-600' }}"></div>
                                <div class="truncate">
                                    <p class="truncate font-medium">{{ $sucursal->nombre }}</p>
                                    <p class="text-[10px] text-slate-400 truncate">{{ $sucursal->ciudad ?? 'Sede' }} - {{ $sucursal->codigo }}</p>
                                </div>
                            </div>
                            @if($sucursalActual?->id === $sucursal->id)
                                <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400 shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    @elseif($sucursalActual)
        <!-- SUCURSAL FIJA PARA OTROS ROLES -->
        <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-100/80 dark:bg-slate-800/70 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-700 dark:text-slate-300">
            <svg class="w-3.5 h-3.5 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <div class="text-left">
                <span class="block text-[9px] uppercase font-bold text-slate-400 tracking-wider">Sucursal</span>
                <span class="font-semibold text-slate-800 dark:text-slate-200 text-xs">{{ $sucursalActual->nombre }}</span>
            </div>
        </div>
    @endif
</div>
