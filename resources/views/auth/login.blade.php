<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">Acceso al Sistema</h2>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Ingresa con tus credenciales de la empresa para administrar la agenda de atención.</p>
    </div>

    <!-- Estatus de Sesión -->
    @if(session('status'))
        <div class="mb-4 text-xs font-semibold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 p-3 rounded-xl border border-emerald-200 dark:border-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Correo Electrónico -->
        <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                Correo Electrónico
            </label>
            <div class="relative rounded-xl shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input id="email" 
                       type="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus 
                       autocomplete="username"
                       placeholder="usuario@empresa.com"
                       class="block w-full pl-11 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150" />
            </div>
            @if ($errors->get('email'))
                <p class="mt-1.5 text-xs text-rose-500 font-medium">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <!-- Contraseña -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                    Contraseña
                </label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline font-medium transition" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>
            <div class="relative rounded-xl shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password" 
                       type="password" 
                       name="password" 
                       required 
                       autocomplete="current-password"
                       placeholder="••••••••"
                       class="block w-full pl-11 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150" />
            </div>
            @if ($errors->get('password'))
                <p class="mt-1.5 text-xs text-rose-500 font-medium">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <!-- Recordar Sesión -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                <input id="remember_me" 
                       type="checkbox" 
                       name="remember" 
                       class="w-4 h-4 rounded border-slate-300 dark:border-slate-700 text-indigo-600 focus:ring-indigo-500 dark:bg-slate-800">
                <span class="ms-2 text-xs font-medium text-slate-600 dark:text-slate-400">Recordar sesión</span>
            </label>
        </div>

        <!-- Botón Iniciar Sesión -->
        <div class="pt-2">
            <button type="submit" 
                    class="w-full bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 text-white font-semibold py-2.5 px-4 rounded-xl shadow-lg shadow-indigo-500/25 active:scale-[0.99] transition duration-200 flex items-center justify-center gap-2 group text-sm">
                <span>Acceder al Sistema</span>
                <svg class="w-4 h-4 text-indigo-200 group-hover:translate-x-1 transition duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </button>
        </div>
    </form>
</x-guest-layout>
