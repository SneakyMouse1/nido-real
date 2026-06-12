@extends('public.user.layout')

@php $pageTitle = __('Ajustes de cuenta') . ' — NidoReal'; @endphp

@section('user-content')

    <div class="space-y-6">

        {{-- SECTION 1: Datos personales --}}
        <div
            class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 overflow-hidden">

            <div class="px-6 py-5 border-b border-neutral-100 dark:border-neutral-800">
                <h2 class="text-lg font-bold text-neutral-900 dark:text-white">{{ __('Datos personales') }}</h2>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">
                    {{ __('Actualiza tu nombre y correo electrónico') }}</p>
            </div>

            @if ($errors->hasBag('personal'))
                <div
                    class="mx-6 mt-5 p-4 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-600 dark:text-red-400 text-sm">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach ($errors->getBag('personal')->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('user.settings.personal.update') }}" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Nombre completo') }} <span class="text-red-500">*</span>
                        </label>
                        <input id="name" name="name" type="text" required value="{{ old('name', $user->name) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Correo electrónico') }} <span class="text-red-500">*</span>
                        </label>
                        <input id="email" name="email" type="email" required
                            value="{{ old('email', $user->email) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit"
                        class="bg-primary hover:bg-primary/90 text-white font-bold px-5 py-2.5 rounded-xl text-sm transition-colors">
                        {{ __('Guardar datos') }}
                    </button>
                </div>
            </form>
        </div>

        {{-- SECTION 2: Contacto --}}
        <div
            class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 overflow-hidden">

            <div class="px-6 py-5 border-b border-neutral-100 dark:border-neutral-800">
                <h2 class="text-lg font-bold text-neutral-900 dark:text-white">{{ __('Información de contacto') }}</h2>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">
                    {{ __('Teléfono, WhatsApp y cómo quieres que te contacten') }}</p>
            </div>

            @if ($errors->hasBag('contact'))
                <div
                    class="mx-6 mt-5 p-4 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-600 dark:text-red-400 text-sm">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach ($errors->getBag('contact')->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('user.settings.contact.update') }}" class="p-6 space-y-5">
                @csrf
                @method('PUT')

                {{-- Phone fields --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="phone" class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Teléfono principal') }}
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </span>
                            <input id="phone" name="phone" type="tel" value="{{ old('phone', $user->phone) }}"
                                placeholder="+34 600 000 000"
                                class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                        </div>
                    </div>

                    <div>
                        <label for="whatsapp" class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Número de WhatsApp') }}
                            <span
                                class="text-xs font-normal text-neutral-400 ml-1">{{ __('(si es distinto al teléfono)') }}</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                            </span>
                            <input id="whatsapp" name="whatsapp" type="tel"
                                value="{{ old('whatsapp', $user->whatsapp) }}" placeholder="+34 600 000 000"
                                class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                        </div>
                        <p class="mt-1 text-xs text-neutral-400 dark:text-neutral-500">
                            {{ __('Si lo dejas vacío, se usará el teléfono principal') }}</p>
                    </div>
                </div>

                {{-- Contact Preference --}}
                <div>
                    <p class="text-sm font-bold text-neutral-900 dark:text-white mb-1">
                        {{ __('¿Cómo prefieres que te contacten?') }}
                    </p>
                    <p class="text-xs text-neutral-400 dark:text-neutral-500 mb-3">
                        {{ __('Puedes seleccionar varias opciones. Sin selección, no aparecerán botones de contacto en tus anuncios.') }}
                    </p>

                    @php
                        $prefs = $user->contact_preferences ?? [];
                        $prefsJson = json_encode(array_values($prefs));
                    @endphp

                    <div x-data="{ selected: {{ $prefsJson }} }" class="grid grid-cols-1 sm:grid-cols-3 gap-3">

                        {{-- Email --}}
                        <button type="button"
                            @click="selected.includes('email') ? selected = selected.filter(v => v !== 'email') : selected.push('email')"
                            :class="selected.includes('email') ? 'border-primary bg-primary/5 dark:bg-primary/10' :
                                'border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 hover:border-neutral-300'"
                            class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all text-left w-full">
                            <input type="checkbox" name="contact_preferences[]" value="email" class="sr-only"
                                :checked="selected.includes('email')">
                            <div :class="selected.includes('email') ? 'bg-primary text-white' :
                                'bg-neutral-100 dark:bg-neutral-800 text-blue-500'"
                                class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span
                                class="text-sm font-semibold text-neutral-800 dark:text-neutral-200 flex-1">{{ __('Por correo') }}</span>
                            <svg x-show="selected.includes('email')" x-cloak class="w-4 h-4 text-primary shrink-0"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>

                        {{-- Phone --}}
                        <button type="button"
                            @click="selected.includes('phone') ? selected = selected.filter(v => v !== 'phone') : selected.push('phone')"
                            :class="selected.includes('phone') ? 'border-primary bg-primary/5 dark:bg-primary/10' :
                                'border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 hover:border-neutral-300'"
                            class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all text-left w-full">
                            <input type="checkbox" name="contact_preferences[]" value="phone" class="sr-only"
                                :checked="selected.includes('phone')">
                            <div :class="selected.includes('phone') ? 'bg-primary text-white' :
                                'bg-neutral-100 dark:bg-neutral-800 text-primary'"
                                class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <span
                                class="text-sm font-semibold text-neutral-800 dark:text-neutral-200 flex-1">{{ __('Por teléfono') }}</span>
                            <svg x-show="selected.includes('phone')" x-cloak class="w-4 h-4 text-primary shrink-0"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>

                        {{-- WhatsApp --}}
                        <button type="button"
                            @click="selected.includes('whatsapp') ? selected = selected.filter(v => v !== 'whatsapp') : selected.push('whatsapp')"
                            :class="selected.includes('whatsapp') ? 'border-primary bg-primary/5 dark:bg-primary/10' :
                                'border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 hover:border-neutral-300'"
                            class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all text-left w-full">
                            <input type="checkbox" name="contact_preferences[]" value="whatsapp" class="sr-only"
                                :checked="selected.includes('whatsapp')">
                            <div :class="selected.includes('whatsapp') ? 'bg-primary text-white' :
                                'bg-neutral-100 dark:bg-neutral-800'"
                                class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                            </div>
                            <span
                                class="text-sm font-semibold text-neutral-800 dark:text-neutral-200 flex-1">WhatsApp</span>
                            <svg x-show="selected.includes('whatsapp')" x-cloak class="w-4 h-4 text-primary shrink-0"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>

                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit"
                        class="bg-primary hover:bg-primary/90 text-white font-bold px-5 py-2.5 rounded-xl text-sm transition-colors">
                        {{ __('Guardar contacto') }}
                    </button>
                </div>
            </form>
        </div>

        {{-- SECTION 3: Contraseña --}}
        <div
            class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 overflow-hidden">

            <div class="px-6 py-5 border-b border-neutral-100 dark:border-neutral-800">
                <h2 class="text-lg font-bold text-neutral-900 dark:text-white">{{ __('Cambiar contraseña') }}</h2>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">
                    {{ __('Deja los campos vacíos si no quieres cambiarla') }}</p>
            </div>

            @if ($errors->hasBag('password'))
                <div
                    class="mx-6 mt-5 p-4 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-600 dark:text-red-400 text-sm">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach ($errors->getBag('password')->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('user.settings.password.update') }}" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="current_password"
                            class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">{{ __('Contraseña actual') }}</label>
                        <input id="current_password" name="current_password" type="password"
                            autocomplete="current-password"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>
                    <div>
                        <label for="new_password"
                            class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">{{ __('Nueva contraseña') }}</label>
                        <input id="new_password" name="new_password" type="password" autocomplete="new-password"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>
                    <div>
                        <label for="new_password_confirmation"
                            class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">{{ __('Repetir nueva contraseña') }}</label>
                        <input id="new_password_confirmation" name="new_password_confirmation" type="password"
                            autocomplete="new-password"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit"
                        class="bg-neutral-800 dark:bg-neutral-700 hover:bg-neutral-700 dark:hover:bg-neutral-600 text-white font-bold px-5 py-2.5 rounded-xl text-sm transition-colors">
                        {{ __('Cambiar contraseña') }}
                    </button>
                </div>
            </form>
        </div>

        {{-- SECTION 4: Eliminar cuenta --}}
        <div x-data="{ showModal: {{ $errors->hasBag('delete_account') ? 'true' : 'false' }} }"
            class="bg-red-50 dark:bg-red-950/10 rounded-2xl border border-red-200 dark:border-red-900/30 overflow-hidden">

            <div class="px-6 py-5 border-b border-red-100 dark:border-red-900/20">
                <h2 class="text-lg font-bold text-red-700 dark:text-red-400">{{ __('Eliminar cuenta') }}</h2>
                <p class="text-sm text-red-600 dark:text-red-500/80 mt-0.5">
                    {{ __('Esta acción eliminará de forma irreversible tu cuenta y todos tus anuncios publicados.') }}
                </p>
            </div>

            <div class="p-6 flex justify-between items-center flex-wrap gap-4">
                <div class="text-sm text-red-700 dark:text-red-400/90">
                    {{ __('Una vez eliminada la cuenta, no podrás recuperar la información ni las fotos subidas.') }}
                </div>
                <button type="button" @click="showModal = true"
                    class="bg-red-600 hover:bg-red-700 text-white font-bold px-5 py-2.5 rounded-xl text-sm transition-colors shadow-sm">
                    {{ __('Eliminar cuenta') }}
                </button>
            </div>

            {{-- Confirmation Modal --}}
            <template x-teleport="body">
                <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto"
                    x-cloak>

                    {{-- Backdrop --}}
                    <div x-show="showModal" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-neutral-950/60 backdrop-blur-sm transition-opacity"
                        @click="showModal = false"></div>

                    {{-- Modal Card --}}
                    <div x-show="showModal" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative bg-white dark:bg-neutral-900 rounded-2xl max-w-md w-full p-6 shadow-2xl border border-neutral-200 dark:border-neutral-800 transition-all z-10">

                        <div class="flex items-start gap-4 mb-4">
                            <div
                                class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-500/10 flex items-center justify-center shrink-0 text-red-600">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                                    <line x1="12" y1="9" x2="12" y2="13" />
                                    <line x1="12" y1="17" x2="12.01" y2="17" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-neutral-900 dark:text-white">
                                    {{ __('¿Eliminar cuenta definitivamente?') }}</h3>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                                    {{ __('Para confirmar la eliminación, introduce tu contraseña actual. Esta acción no se puede deshacer.') }}
                                </p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('user.settings.account.delete') }}">
                            @csrf
                            @method('DELETE')

                            <div class="mb-5">
                                <label for="delete_password"
                                    class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                                    {{ __('Contraseña actual') }}
                                </label>
                                <input id="delete_password" name="delete_password" type="password" required
                                    autocomplete="current-password"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors @error('delete_password', 'delete_account') border-red-500 dark:border-red-500/50 @enderror"
                                    placeholder="••••••••">

                                @error('delete_password', 'delete_account')
                                    <p class="text-xs text-red-600 dark:text-red-400 mt-1.5 font-semibold">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-end gap-3">
                                <button type="button" @click="showModal = false"
                                    class="text-sm font-semibold text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300 px-4 py-2 transition-colors">
                                    {{ __('Cancelar') }}
                                </button>
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white font-bold px-5 py-2.5 rounded-xl text-sm transition-colors shadow-sm">
                                    {{ __('Confirmar eliminación') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </template>
        </div>

    @endsection
