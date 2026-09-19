<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistema de Reservas') }}</title>

    <!-- SCRIPT PARA PREVENIR PARPADEO DE MODO OSCURO -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS Compilado -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/sweetalert2/sweetalert2.all.min.js') }}"></script>

    @livewireStyles
</head>

<body class="h-full font-sans antialiased text-slate-800 dark:text-slate-100 bg-slate-100 dark:bg-slate-950 transition-colors duration-200"
    x-data="{ 
              darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches), 
              sidebarOpen: true, 
              mobileSidebarOpen: false,
              toggleTheme() {
                  this.darkMode = !this.darkMode;
                  localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
                  if (this.darkMode) {
                      document.documentElement.classList.add('dark');
                  } else {
                      document.documentElement.classList.remove('dark');
                  }
              }
          }">

    <div class="min-h-screen flex flex-col">
        <!-- LAYOUT CONTENEDOR -->
        <div class="flex flex-1 overflow-hidden">

            <!-- MOBILE OVERLAY -->
            <div x-show="mobileSidebarOpen"
                x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="mobileSidebarOpen = false"
                class="fixed inset-0 bg-slate-900/80 z-40 lg:hidden" x-cloak></div>

            <!-- SIDEBAR DEDICADO -->
            @include('layouts.partials.sidebar')

            <!-- MAIN WRAPPER -->
            <div class="flex-1 flex flex-col min-w-0 bg-slate-100 dark:bg-slate-950 overflow-y-auto transition-colors duration-200">

                <!-- HEADER DEDICADO CON CAMBIO DE TEMA CLARO/OSCURO -->
                @include('layouts.partials.header')

                <!-- CONTENIDO DE LA PAGINA -->
                <main class="flex-1 p-4 lg:p-6">
                    <!-- HEADER SECCIONAL (SI EXISTE) -->
                    @isset($header)
                    <div class="mb-6 bg-white dark:bg-slate-900 p-4 lg:p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4 transition-colors duration-200">
                        {{ $header }}
                    </div>
                    @endisset

                    <!-- MENSAJES DE ALERTA -->
                    @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 rounded-xl text-sm flex items-center gap-3 shadow-sm">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 rounded-xl text-sm flex items-center gap-3 shadow-sm">
                        <svg class="w-5 h-5 text-rose-600 dark:text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                    @endif

                    <!-- MAIN SLOT -->
                    {{ $slot }}
                </main>

                <!-- FOOTER DEDICADO -->
                @include('layouts.partials.footer')
            </div>

        </div>
    </div>

    @livewireScripts

    <!-- INTEGRACIÓN GLOBAL DE SWEETALERT2 PARA MENSAJES DE ÉXITO Y ERROR -->
    <script>
        function mostrarSweetAlert(icon, title, text) {
            const esOscuro = document.documentElement.classList.contains('dark');
            
            Swal.fire({
                icon: icon,
                title: title,
                text: text,
                timer: icon === 'success' ? 3500 : undefined,
                timerProgressBar: icon === 'success',
                showConfirmButton: icon !== 'success',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#4f46e5',
                background: esOscuro ? '#0f172a' : '#ffffff',
                color: esOscuro ? '#f8fafc' : '#0f172a',
                customClass: {
                    popup: 'rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl',
                    title: 'text-base font-bold text-slate-900 dark:text-white',
                    htmlContainer: 'text-xs text-slate-600 dark:text-slate-300',
                    confirmButton: 'px-5 py-2.5 rounded-xl font-semibold text-xs shadow-md transition-all hover:scale-105',
                }
            });
        }

        // 1. Mensajes de sesión Blade (carga de página o redirecciones)
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                mostrarSweetAlert('success', '¡Operación Exitosa!', @json(session('success')));
            @endif

            @if(session('error'))
                mostrarSweetAlert('error', 'Atención / Error', @json(session('error')));
            @endif
        });

        // 2. Eventos reactivos despachados desde cualquier componente Livewire ($this->dispatch('swal', ...))
        window.addEventListener('swal', function (event) {
            const data = Array.isArray(event.detail) ? event.detail[0] : (event.detail || {});
            const icon = data.icon || 'info';
            const title = data.title || (icon === 'success' ? '¡Operación Exitosa!' : (icon === 'error' ? 'Atención / Error' : 'Notificación'));
            const text = data.text || data.message || '';
            mostrarSweetAlert(icon, title, text);
        });
    </script>
</body>

</html>