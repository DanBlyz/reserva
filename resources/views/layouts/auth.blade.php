<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Acceso - Sistema de Reservas') }}</title>

        <!-- SCRIPT MODO OSCURO -->
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

        @livewireStyles
    </head>
    <body class="h-full font-sans antialiased text-slate-800 dark:text-slate-100 bg-slate-100 dark:bg-slate-950 flex items-center justify-center relative overflow-hidden py-10 transition-colors duration-200"
          x-data="{ 
              darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
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
        
        <!-- ELEMENTOS DECORATIVOS -->
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-500/10 dark:bg-indigo-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-blue-500/10 dark:bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>

        <!-- BOTON DE CAMBIO DE TEMA FLOTANTE -->
        <div class="absolute top-6 right-6 z-20">
            <button @click="toggleTheme()" 
                    type="button"
                    title="Alternar Tema Claro / Oscuro"
                    class="flex items-center justify-center p-2.5 rounded-xl border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-amber-400 bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800 shadow-md transition-all">
                <template x-if="!darkMode">
                    <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </template>
                <template x-if="darkMode">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </template>
            </button>
        </div>
        
        <div class="w-full max-w-md px-4 relative z-10">
            <!-- BRAND LOGO -->
            <div class="text-center mb-8">
                <a href="/" class="inline-flex flex-col items-center gap-3 group">
                    <div class="h-16 w-16 rounded-2xl bg-gradient-to-tr from-indigo-600 to-blue-500 flex items-center justify-center text-white font-bold shadow-xl shadow-indigo-500/25 group-hover:scale-105 transition duration-300">
                        <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">Reserva<span class="text-indigo-600 dark:text-indigo-400">Sys</span></h1>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium tracking-wide uppercase mt-0.5">Sistema de Reservas y Citas</p>
                    </div>
                </a>
            </div>

            <!-- CARD DE ACCESO -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-xl shadow-slate-200/50 dark:shadow-slate-950 transition-colors duration-200">
                {{ $slot }}
            </div>

            <!-- FOOTER -->
            <div class="mt-8 text-center text-xs text-slate-500 dark:text-slate-400">
                <p>&copy; {{ date('Y') }} Sistema de Reservas para Personal de Empresa</p>
            </div>
        </div>

        @livewireScripts
    </body>
</html>
