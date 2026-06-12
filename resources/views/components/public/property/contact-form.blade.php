@props(['property'])

<div id="contact-agent"
    class="bg-white dark:bg-neutral-900 border border-neutral-100 dark:border-neutral-800 rounded-2xl shadow-sm p-6">
    <h3 class="text-sm font-bold text-neutral-900 dark:text-white mb-5 uppercase tracking-wide">
        {{ __('Aquí su mensaje') }}</h3>

    <form action="#" method="POST" class="space-y-4">
        @csrf

        <div>
            <label
                class="block text-xs font-bold text-neutral-500 dark:text-neutral-400 mb-1.5">{{ __('Nombre') }}</label>
            <input type="text" name="first_name" required
                class="w-full px-3 py-2 bg-neutral-50 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg text-sm text-neutral-900 dark:text-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
        </div>

        <div>
            <label
                class="block text-xs font-bold text-neutral-500 dark:text-neutral-400 mb-1.5">{{ __('Apellidos') }}</label>
            <input type="text" name="last_name" required
                class="w-full px-3 py-2 bg-neutral-50 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg text-sm text-neutral-900 dark:text-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
        </div>

        <div>
            <label
                class="block text-xs font-bold text-neutral-500 dark:text-neutral-400 mb-1.5">{{ __('Correo electrónico') }}</label>
            <input type="email" name="email" required
                class="w-full px-3 py-2 bg-neutral-50 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg text-sm text-neutral-900 dark:text-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
        </div>

        <div class="grid grid-cols-3 gap-3">
            <div class="col-span-1">
                <label
                    class="block text-xs font-bold text-neutral-500 dark:text-neutral-400 mb-1.5">{{ __('Prefijo') }}</label>
                <select name="phone_prefix"
                    class="w-full px-3 py-2 bg-neutral-50 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg text-sm text-neutral-900 dark:text-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors appearance-none">
                    <option value="+34">+34</option>
                    <option value="+1">+1</option>
                    <option value="+44">+44</option>
                </select>
            </div>
            <div class="col-span-2">
                <label
                    class="block text-xs font-bold text-neutral-500 dark:text-neutral-400 mb-1.5">{{ __('Teléfono') }}</label>
                <input type="tel" name="phone" required
                    class="w-full px-3 py-2 bg-neutral-50 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg text-sm text-neutral-900 dark:text-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
            </div>
        </div>

        <div>
            <label
                class="block text-xs font-bold text-neutral-500 dark:text-neutral-400 mb-1.5">{{ __('Mensaje') }}</label>
            <textarea name="message" rows="4" required
                class="w-full px-3 py-2 bg-neutral-50 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg text-sm text-neutral-900 dark:text-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors resize-none placeholder-neutral-400"
                placeholder="{{ __('Hola, me interesa este inmueble...') }}"></textarea>
        </div>

        <div class="flex items-start gap-2 pt-1">
            <input type="checkbox" id="terms" required
                class="mt-1 w-4 h-4 text-primary bg-neutral-50 border-neutral-300 rounded focus:ring-primary dark:bg-neutral-800 dark:border-neutral-700">
            <label for="terms" class="text-xs text-neutral-500 dark:text-neutral-400 leading-tight">
                {{ __('He leído y acepto la política de privacidad.') }}
            </label>
        </div>

        {{-- Turnstile placeholder --}}
        <div
            class="bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded p-4 text-center text-xs text-neutral-400 dark:text-neutral-500 mt-2">
            [Cloudflare Turnstile Widget - someday somehow]
        </div>

        <button type="submit"
            class="w-full bg-primary hover:bg-primary/90 text-white font-bold text-sm py-3 rounded-xl transition-colors shadow-sm mt-4">
            {{ __('Enviar') }}
        </button>
    </form>
</div>
