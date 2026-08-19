<!-- HEADER (ADMINLTE NAVBAR CON CONMUTADOR CLARO / OSCURO) -->
<header class="h-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 sticky top-0 z-30 flex items-center justify-between px-4 lg:px-6 shadow-sm transition-colors duration-200">

    <!-- LADO IZQUIERDO: CONTROLES DE NAVEGACION -->
    <div class="flex items-center gap-3">
        <!-- Botón Toggle Desktop -->
        <button @click="sidebarOpen = !sidebarOpen"
            title="Alternar Sidebar"
            class="hidden lg:flex items-center justify-center p-2 rounded-lg text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
            </svg>
        </button>

        <!-- Botón Toggle Móvil -->
        <button @click="mobileSidebarOpen = !mobileSidebarOpen"
            title="Abrir Menú"
            class="lg:hidden flex items-center justify-center p-2 rounded-lg text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- BREADCRUMB / TITULO DE LA APLICACION -->
        <div class="hidden sm:flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
            <span class="font-medium text-slate-800 dark:text-slate-200">Sistema de Reservas</span>
            <span>/</span>
            <span class="text-indigo-600 dark:text-indigo-400 font-semibold">Panel de Atención</span>
        </div>
    </div>

    <!-- LADO DERECHO: ACCIONES, TOGGLE TEMA & USUARIO -->
    <div class="flex items-center gap-3">

        <!-- CONMUTADOR DE TEMA (CLARO / OSCURO) -->
        <button @click="toggleTheme()"
            type="button"
            title="Cambiar Modo Claro / Oscuro"
            class="flex items-center justify-center p-2 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-amber-400 bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 transition-all duration-200 shadow-sm">
            <!-- Icono Luna (para cuando está en Modo Claro) -->
            <template x-if="!darkMode">
                <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
            </template>
            <!-- Icono Sol (para cuando está en Modo Oscuro) -->
            <template x-if="darkMode">
                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </template>
        </button>

        <!-- BARRA DE FECHA ACTUAL -->
        <div class="hidden md:flex items-center gap-2 px-3 py-1.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-600 dark:text-slate-300 font-medium">
            <svg class="w-4 h-4 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span>{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}</span>
        </div>

        <!-- BOTON RAPIDO NUEVA CITA -->
        <a href="{{ Route::has('reservations.create') ? route('reservations.create') : '#' }}"
            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-indigo-500/30 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span class="hidden sm:inline">Nueva Cita</span>
        </a>

        <!-- DROPDOWN DE USUARIO AUTENTICADO -->
        @auth
        <div class="relative" x-data="{ userMenuOpen: false }">
            <button @click="userMenuOpen = !userMenuOpen"
                class="flex items-center gap-2 p-1 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition focus:outline-none">
                <div class="h-8 w-8 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold text-xs shadow-sm">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                <span class="hidden md:inline text-xs font-semibold text-slate-700 dark:text-slate-200">{{ Auth::user()->name }}</span>
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="userMenuOpen"
                @click.outside="userMenuOpen = false"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-2 w-52 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-200 dark:border-slate-700 py-1 z-50 divide-y divide-slate-100 dark:divide-slate-700" x-cloak>

                <div class="px-4 py-2 text-xs">
                    <p class="font-semibold text-slate-800 dark:text-slate-100 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-slate-500 dark:text-slate-400 truncate text-[11px]">{{ Auth::user()->email }}</p>
                </div>

                <div class="py-1">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-slate-700 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-slate-700 hover:text-indigo-600 transition">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Mi Perfil</span>
                    </a>
                </div>

                <div class="py-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-xs text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-slate-700 transition font-medium">
                            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Cerrar Sesión</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endauth

    </div>
</header>