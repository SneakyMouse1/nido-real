@extends('layouts.public')

@section('title', __('Autenticación') . ' — NidoReal')

@section('content')

@section('navbar')
    <x-public.navbar :floating="false" />
@endsection

<div
    class="min-h-[calc(100vh-140px)] bg-neutral-50 dark:bg-neutral-950 flex flex-col items-center justify-center py-8 px-4 sm:px-6 lg:px-8">

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div
            class="max-w-3xl w-full mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-600 dark:text-red-400 text-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Flash Messages --}}
    @if (session('success'))
        <div
            class="max-w-3xl w-full mb-6 p-4 rounded-xl bg-green-50 dark:bg-green-500/10 border border-green-200 dark:border-green-500/20 text-green-600 dark:text-green-400 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Main Container --}}
    <div class="max-w-md w-full bg-white dark:bg-neutral-900 rounded-2xl shadow-xl border border-neutral-100 dark:border-neutral-800 flex flex-col overflow-hidden"
        x-data="{ isLogin: true }" x-cloak>

        {{-- Navigation Panel --}}
        <div
            class="bg-neutral-50 dark:bg-neutral-800/50 border-b border-neutral-100 dark:border-neutral-800 p-4 shrink-0 flex flex-row gap-3">

            {{-- Login Toggle Button --}}
            <button type="button" @click="isLogin = true"
                :class="isLogin ? 'bg-white dark:bg-neutral-700 shadow-sm border-primary text-primary' :
                    'border-transparent text-neutral-500 dark:text-neutral-400 hover:bg-white/50 dark:hover:bg-neutral-800/50'"
                class="flex-1 flex flex-row items-center justify-center gap-2 p-3 rounded-xl border transition-all text-sm font-bold text-center">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                <span>{{ __('Iniciar Sesión') }}</span>
            </button>

            {{-- Register Toggle Button --}}
            <button type="button" @click="isLogin = false"
                :class="!isLogin ? 'bg-white dark:bg-neutral-700 shadow-sm border-primary text-primary' :
                    'border-transparent text-neutral-500 dark:text-neutral-400 hover:bg-white/50 dark:hover:bg-neutral-800/50'"
                class="flex-1 flex flex-row items-center justify-center gap-2 p-3 rounded-xl border transition-all text-sm font-bold text-center">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                <span>{{ __('Crear Cuenta') }}</span>
            </button>

        </div>

        {{-- CONTENT AREA --}}
        <div class="flex-1 p-6 sm:p-8">

            {{-- ── LOGIN FORM ── --}}
            <div x-show="isLogin">
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-6">
                    {{ __('Iniciar Sesión') }}
                </h2>

                <form method="POST" action="{{ route('auth.login.submit') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="login_field"
                            class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Login') }}
                        </label>
                        <input id="login_field" name="login" type="text" required value="{{ old('login') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white placeholder-neutral-400 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors text-sm"
                            placeholder="Email o teléfono">
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password_login"
                                class="block text-sm font-bold text-neutral-900 dark:text-white">
                                {{ __('Contraseña') }}
                            </label>
                            <a href="#"
                                class="text-xs text-red-500 hover:text-red-600 font-medium transition-colors">
                                {{ __('¿Olvidó su contraseña?') }}
                            </a>
                        </div>
                        <input id="password_login" name="password" type="password" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white placeholder-neutral-400 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors text-sm">
                    </div>

                    <div class="flex items-center gap-2 text-sm pt-1 pb-1">
                        <input type="checkbox" id="remember" name="remember"
                            class="w-4 h-4 rounded border-neutral-300 text-primary focus:ring-primary bg-white dark:bg-neutral-900 dark:border-neutral-700">
                        <label for="remember"
                            class="text-neutral-500 dark:text-neutral-400 cursor-pointer">{{ __('Recordarme en este dispositivo') }}</label>
                    </div>

                    <div class="relative py-2">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-neutral-200 dark:border-neutral-800"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span
                                class="px-4 text-xs text-neutral-500 dark:text-neutral-400 bg-white dark:bg-neutral-900">
                                {{ __('o entra con') }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
                        <button type="button"
                            class="flex sm:flex-col items-center justify-center gap-3 sm:gap-2 py-3 border border-neutral-200 dark:border-neutral-700 rounded-xl bg-white dark:bg-neutral-900 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors"
                            title="Facebook">
                            <svg class="w-5 h-5 text-[#1877F2]" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                            <span
                                class="sm:hidden text-sm font-semibold text-neutral-700 dark:text-neutral-300">Facebook</span>
                        </button>

                        <button type="button"
                            class="flex sm:flex-col items-center justify-center gap-3 sm:gap-2 py-3 border border-neutral-200 dark:border-neutral-700 rounded-xl bg-white dark:bg-neutral-900 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors"
                            title="Google">
                            <svg class="w-5 h-5" viewBox="0 0 24 24">
                                <path
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                    fill="#4285F4" />
                                <path
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                    fill="#34A853" />
                                <path
                                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                                    fill="#FBBC05" />
                                <path
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                    fill="#EA4335" />
                            </svg>
                            <span
                                class="sm:hidden text-sm font-semibold text-neutral-700 dark:text-neutral-300">Google</span>
                        </button>

                        <button type="button"
                            class="flex sm:flex-col items-center justify-center gap-3 sm:gap-2 py-3 border border-neutral-200 dark:border-neutral-700 rounded-xl bg-white dark:bg-neutral-900 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors"
                            title="Twitter">
                            <svg class="w-5 h-5 text-[#1DA1F2]" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                            <span
                                class="sm:hidden text-sm font-semibold text-neutral-700 dark:text-neutral-300">Twitter</span>
                        </button>
                    </div>

                    <button type="submit"
                        class="w-full mt-2 bg-accent hover:bg-accent/90 text-white font-bold py-3 rounded-xl transition-colors text-sm">
                        {{ __('Entrar') }}
                    </button>
                </form>
            </div>

            {{-- REGISTER FORM --}}
            <div x-show="!isLogin" style="display: none;">
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-1">
                    {{ __('Registrarse') }}
                </h2>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">
                    {{ __('public.auth.role_subtitle') }}
                </p>

                <form method="POST" action="{{ route('auth.register.submit') }}" class="space-y-4"
                    x-data="{ selectedRole: '{{ old('role') }}' }">
                    @csrf

                    {{-- Role selector --}}
                    <div>
                        <p class="block text-sm font-bold text-neutral-900 dark:text-white mb-3">
                            {{ __('public.auth.role_title') }}
                        </p>
                        <div class="grid grid-cols-2 gap-3">

                            {{-- Buyer card --}}
                            <button type="button" @click="selectedRole = 'buyer'"
                                :class="selectedRole === 'buyer'
                                    ? 'border-primary bg-primary/5 dark:bg-primary/10 shadow-sm'
                                    : 'border-neutral-200 dark:border-neutral-700 hover:border-neutral-300 dark:hover:border-neutral-600'"
                                class="relative flex flex-col items-center text-center gap-2.5 py-5 px-3 rounded-xl border-2 transition-all cursor-pointer w-full">

                                {{-- Check mark --}}
                                <span x-show="selectedRole === 'buyer'"
                                    class="absolute top-2 right-2 w-5 h-5 rounded-full bg-primary flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>

                                {{-- Icon --}}
                                <span
                                    :class="selectedRole === 'buyer' ? 'bg-primary/10 dark:bg-primary/20 text-primary' : 'bg-neutral-100 dark:bg-neutral-800 text-neutral-500'"
                                    class="w-11 h-11 rounded-xl flex items-center justify-center transition-colors shrink-0">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
                                    </svg>
                                </span>

                                {{-- Title --}}
                                <span
                                    :class="selectedRole === 'buyer' ? 'text-primary' : 'text-neutral-900 dark:text-white'"
                                    class="text-sm font-bold leading-none transition-colors">
                                    {{ __('public.auth.role_buyer_title') }}
                                </span>
                            </button>

                            {{-- Owner card --}}
                            <button type="button" @click="selectedRole = 'owner'"
                                :class="selectedRole === 'owner'
                                    ? 'border-primary bg-primary/5 dark:bg-primary/10 shadow-sm'
                                    : 'border-neutral-200 dark:border-neutral-700 hover:border-neutral-300 dark:hover:border-neutral-600'"
                                class="relative flex flex-col items-center text-center gap-2.5 py-5 px-3 rounded-xl border-2 transition-all cursor-pointer w-full">

                                {{-- Check mark --}}
                                <span x-show="selectedRole === 'owner'"
                                    class="absolute top-2 right-2 w-5 h-5 rounded-full bg-primary flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>

                                {{-- Icon --}}
                                <span
                                    :class="selectedRole === 'owner' ? 'bg-primary/10 dark:bg-primary/20 text-primary' : 'bg-neutral-100 dark:bg-neutral-800 text-neutral-500'"
                                    class="w-11 h-11 rounded-xl flex items-center justify-center transition-colors shrink-0">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v9a1 1 0 001 1h4v-5h4v5h4a1 1 0 001-1v-9" />
                                    </svg>
                                </span>

                                {{-- Title --}}
                                <span
                                    :class="selectedRole === 'owner' ? 'text-primary' : 'text-neutral-900 dark:text-white'"
                                    class="text-sm font-bold leading-none transition-colors">
                                    {{ __('public.auth.role_owner_title') }}
                                </span>
                            </button>

                        </div>

                        {{-- Hidden role input --}}
                        <input type="hidden" name="role" :value="selectedRole">

                        {{-- Inline error for role --}}
                        @error('role')
                            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Full Name --}}
                    <div>
                        <label for="register_name"
                            class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Nombre completo') }}
                        </label>
                        <input id="register_name" name="name" type="text" required
                            value="{{ old('name') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white placeholder-neutral-400 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors text-sm"
                            placeholder="{{ __('Ej. Juan Pérez') }}">
                    </div>

                    {{-- Email / Phone --}}
                    <div>
                        <label for="register_login"
                            class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Usuario o Email') }}
                        </label>
                        <input id="register_login" name="login" type="text" required
                            value="{{ old('login') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white placeholder-neutral-400 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors text-sm">
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="register_password"
                                class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                                {{ __('Contraseña') }}
                            </label>
                            <input id="register_password" name="password" type="password" required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white placeholder-neutral-400 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors text-sm">
                        </div>

                        <div>
                            <label for="register_password_confirmation"
                                class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                                {{ __('Confirmar contraseña') }}
                            </label>
                            <input id="register_password_confirmation" name="password_confirmation" type="password"
                                required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white placeholder-neutral-400 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors text-sm">
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pt-1 pb-1">
                        <input id="terms" type="checkbox" name="terms" required
                            class="w-4 h-4 rounded border-neutral-300 text-primary focus:ring-primary bg-white dark:bg-neutral-900 dark:border-neutral-700">
                        <label for="terms" class="text-sm text-neutral-500 dark:text-neutral-400 cursor-pointer">
                            {{ __('Acepto los') }}
                            <a href="#"
                                class="font-bold text-neutral-800 dark:text-neutral-200 underline decoration-2 underline-offset-4 hover:text-primary transition-colors">
                                {{ __('Términos de uso.') }}
                            </a>
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full mt-2 bg-accent hover:bg-accent/90 text-white font-bold py-3 rounded-xl transition-colors text-sm">
                        {{ __('Registrarse') }}
                    </button>

                    {{-- Info block for Agents/Agencies --}}
                    <div
                        class="mt-4 pt-4 border-t border-neutral-200 dark:border-neutral-800 rounded-xl bg-neutral-50 dark:bg-neutral-800/50 p-4 flex gap-3 text-sm items-start">
                        <svg class="w-5 h-5 text-primary shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <strong
                                class="text-neutral-900 dark:text-white">{{ __('¿Eres un agente o una agencia?') }}</strong>
                            <p class="text-neutral-500 dark:text-neutral-400 mt-0.5 mb-1.5">Los perfiles comerciales
                                requieren verificación antes de acceder al panel.</p>
                            <a href="{{ route('pages.contacto') }}"
                                class="font-semibold text-primary hover:text-primary/80 transition-colors inline-block underline underline-offset-4">
                                {{ __('Contáctanos para habilitar tu cuenta profesional') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


@endsection
