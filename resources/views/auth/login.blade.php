<x-guest-layout>
    <x-auth-session-status class="mb-4 py-2 px-3 bg-blue-900/60 text-blue-200 rounded-md text-sm" :status="session('status')" />
    
    <p class="text-gray-300 text-center mb-6">
        Bienvenido al sistema de gestión. Accede para administrar cursos, alumnos y profesores de manera eficiente e intuitiva.
    </p>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf
        
        <div class="w-full">
            <x-input-label for="email" :value="__('Correo Electrónico')" class="input-label mb-1.5 block" />
            <div class="input-group">
                <i class="fas fa-envelope input-icon"></i>
                <x-text-input id="email" class="input-field block w-full rounded-lg shadow-sm" 
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-400 text-sm" />
        </div>
        
        <div class="w-full">
            <x-input-label for="password" :value="__('Contraseña')" class="input-label mb-1.5 block" />
            <div class="input-group">
                <i class="fas fa-lock input-icon"></i>
                <x-text-input id="password" class="input-field block w-full rounded-lg shadow-sm" 
                    type="password" name="password" required autocomplete="current-password" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-400 text-sm" />
        </div>
        
        <div class="flex items-center justify-between">
            <div class="block">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="checkbox-custom rounded border-gray-600 bg-gray-700 text-blue-500 shadow-sm focus:ring-blue-500" name="remember">
                    <span class="ml-2 text-sm text-gray-300">{{ __('Recordarme') }}</span>
                </label>
            </div>
            
            @if (Route::has('password.request'))
                <a class="forgot-link text-sm rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif
        </div>
        
        <div class="mt-6">
            <x-primary-button class="login-btn w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-sign-in-alt mr-2"></i> {{ __('Iniciar Sesión') }}
            </x-primary-button>
        </div>
        
        <div class="flex justify-center space-x-4 mt-6">
            <a href="#" class="text-gray-400 hover:text-white transition"><i class="fas fa-key text-lg"></i></a>
            <a href="#" class="text-gray-400 hover:text-white transition"><i class="fas fa-book text-lg"></i></a>
            <a href="#" class="text-gray-400 hover:text-white transition"><i class="fas fa-users text-lg"></i></a>
            <a href="#" class="text-gray-400 hover:text-white transition"><i class="fas fa-chalkboard-teacher text-lg"></i></a>
        </div>
    </form>
</x-guest-layout>