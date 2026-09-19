<!-- SIDEBAR (ADMINLTE MODERN STYLE) -->
<aside :class="{
            'w-64': sidebarOpen, 
            'w-20': !sidebarOpen,
            'translate-x-0': mobileSidebarOpen,
            '-translate-x-full lg:translate-x-0': !mobileSidebarOpen
        }"
    class="fixed lg:static inset-y-0 left-0 z-50 bg-slate-900 dark:bg-slate-950 text-slate-300 flex flex-col transition-all duration-300 ease-in-out shadow-xl flex-shrink-0 select-none border-r border-slate-800">

    <!-- BRAND / LOGO BANNER -->
    <div class="h-16 flex items-center justify-between px-4 bg-slate-950 dark:bg-slate-900 border-b border-slate-800/80">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 overflow-hidden">
            <div class="h-10 w-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-blue-500 flex items-center justify-center text-white font-bold shadow-lg shadow-indigo-500/30 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200" class="whitespace-nowrap">
                <span class="font-extrabold text-lg text-white tracking-wide">Reserva<span class="text-indigo-400">Sys</span></span>
                <span class="block text-[10px] uppercase font-semibold text-indigo-300 tracking-wider">AdminLTE Panel</span>
            </div>
        </a>
        <button @click="mobileSidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white p-1 rounded-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- PANEL DE USUARIO -->
    @auth
    <div class="p-3 mx-2 my-3 rounded-xl bg-slate-800/60 dark:bg-slate-900/60 border border-slate-700/60 flex items-center gap-3 overflow-hidden">
        <div class="h-9 w-9 rounded-lg bg-indigo-600/30 text-indigo-300 border border-indigo-500/30 flex items-center justify-center font-bold text-sm shrink-0">
            {{ substr(Auth::user()->name, 0, 2) }}
        </div>
        <div x-show="sidebarOpen" class="min-w-0 flex-1 whitespace-nowrap">
            <p class="text-xs font-semibold text-white truncate">{{ Auth::user()->name }}</p>
            <div class="flex items-center gap-1.5 mt-0.5">
                <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-[11px] text-slate-400 truncate">Usuario Empresa</span>
            </div>
        </div>
    </div>
    @endauth

    <!-- MENU DE NAVEGACION -->
    <nav class="flex-1 px-2 py-2 space-y-1 overflow-y-auto custom-scrollbar">
        <!-- SECCION PRINCIPAL -->
        <div x-show="sidebarOpen" class="px-3 pt-3 pb-1 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
            Principal
        </div>

        <!-- DASHBOARD -->
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap">Dashboard</span>
        </a>

        <!-- AGENDA DE RESERVAS -->
        <a href="{{ Route::has('reservations.index') ? route('reservations.index') : '#' }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('reservations.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap">Agenda de Citas</span>
        </a>

        <!-- SECCION GESTION -->
        <div x-show="sidebarOpen" class="px-3 pt-4 pb-1 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
            Gestión de Datos
        </div>

        <!-- SERVICIOS -->
        <a href="{{ route('services.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('services.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('services.*') ? 'text-white' : 'text-sky-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
            </svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap">Servicios de Fisioterapia</span>
        </a>

        <!-- CLIENTES -->
        <a href="{{ Route::has('clients.index') ? route('clients.index') : '#' }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('clients.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap">Clientes / Pacientes</span>
        </a>

        <!-- SECCION ADMINISTRACION -->
        @if(Auth::user()?->esAdmin() || Auth::user()?->tienePermiso('sucursales.ver') || Auth::user()?->tienePermiso('usuarios.ver') || Auth::user()?->tienePermiso('roles.ver'))
            <div x-show="sidebarOpen" class="px-3 pt-4 pb-1 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                Administración
            </div>

            <!-- SUCURSALES -->
            @if(Auth::user()?->esAdmin() || Auth::user()?->tienePermiso('sucursales.ver'))
                <a href="{{ route('admin.sucursales') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.sucursales') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.sucursales') ? 'text-white' : 'text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Sedes y Sucursales</span>
                </a>
            @endif

            <!-- ROLES Y PERMISOS -->
            @if(Auth::user()?->esAdmin() || Auth::user()?->tienePermiso('roles.ver'))
                <a href="{{ route('admin.roles') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.roles') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.roles') ? 'text-white' : 'text-purple-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Roles y Permisos</span>
                </a>
            @endif

            <!-- USUARIOS Y PERSONAL -->
            @if(Auth::user()?->esAdmin() || Auth::user()?->tienePermiso('usuarios.ver'))
                <a href="{{ route('admin.usuarios') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.usuarios') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.usuarios') ? 'text-white' : 'text-amber-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Personal y Usuarios</span>
                </a>
            @endif
        @endif

        <!-- SECCION SISTEMA -->
        <div x-show="sidebarOpen" class="px-3 pt-4 pb-1 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
            Cuenta
        </div>

        <a href="{{ route('profile.edit') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('profile.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span x-show="sidebarOpen" class="whitespace-nowrap">Mi Perfil</span>
        </a>
    </nav>

    <!-- FOOTER DEL SIDEBAR -->
    <div class="p-3 bg-slate-950/80 border-t border-slate-800/80 text-center">
        <div x-show="sidebarOpen" class="text-xs text-slate-400">
            <span>ReservaSys &copy; {{ date('Y') }}</span>
        </div>
    </div>
</aside>