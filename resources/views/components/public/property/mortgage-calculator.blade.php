@props(['property'])

<section class="mb-8" x-data="{
    price: {{ $property->price ?: 0 }},
    downPayment: {{ ($property->price ?: 0) * 0.2 }},
    years: 30,
    rate: 3.5,
    monthlyPayment: 0,
    totalInterest: 0,
    totalLoan: 0,
    calculate() {
        let p = this.price - this.downPayment;
        if (p <= 0 || isNaN(p)) {
            this.monthlyPayment = 0;
            this.totalInterest = 0;
            this.totalLoan = 0;
            return;
        }
        let r = (this.rate / 100) / 12;
        let n = this.years * 12;
        if (r === 0) {
            this.monthlyPayment = p / n;
        } else {
            this.monthlyPayment = p * (r * Math.pow(1 + r, n)) / (Math.pow(1 + r, n) - 1);
        }
        this.totalLoan = this.monthlyPayment * n;
        this.totalInterest = this.totalLoan - p;
    },
    format(val) {
        return new Intl.NumberFormat('es-ES', { minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(val) + ' €';
    }
}" x-init="calculate()">
    <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">{{ __('Calculadora de préstamos') }}</h2>

    <div
        class="bg-neutral-50 dark:bg-neutral-800/50 border border-neutral-100 dark:border-neutral-800 rounded-2xl p-5 sm:p-6 shadow-sm">
        <form @submit.prevent="calculate"
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 items-end mb-6">

            {{-- Importe total --}}
            <div>
                <label
                    class="block text-xs font-bold text-neutral-500 dark:text-neutral-400 mb-1.5 uppercase tracking-wide">{{ __('Importe total €') }}</label>
                <input type="number" x-model.number="price"
                    class="w-full px-3 py-2 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 rounded-lg text-sm text-neutral-900 dark:text-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
            </div>

            {{-- Cuota de entrada --}}
            <div>
                <label
                    class="block text-xs font-bold text-neutral-500 dark:text-neutral-400 mb-1.5 uppercase tracking-wide">{{ __('Cuota de entrada') }}</label>
                <input type="number" x-model.number="downPayment"
                    class="w-full px-3 py-2 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 rounded-lg text-sm text-neutral-900 dark:text-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
            </div>

            {{-- Periodo --}}
            <div>
                <label
                    class="block text-xs font-bold text-neutral-500 dark:text-neutral-400 mb-1.5 uppercase tracking-wide">{{ __('Periodo') }}</label>
                <select x-model.number="years"
                    class="w-full px-3 py-2 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 rounded-lg text-sm text-neutral-900 dark:text-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors appearance-none">
                    <option value="10">10 {{ __('Años') }}</option>
                    <option value="15">15 {{ __('Años') }}</option>
                    <option value="20">20 {{ __('Años') }}</option>
                    <option value="25">25 {{ __('Años') }}</option>
                    <option value="30">30 {{ __('Años') }}</option>
                    <option value="35">35 {{ __('Años') }}</option>
                </select>
            </div>

            {{-- Interés --}}
            <div>
                <label
                    class="block text-xs font-bold text-neutral-500 dark:text-neutral-400 mb-1.5 uppercase tracking-wide">{{ __('Interés %') }}</label>
                <input type="number" step="0.1" x-model.number="rate"
                    class="w-full px-3 py-2 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 rounded-lg text-sm text-neutral-900 dark:text-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
            </div>

            {{-- Calcular --}}
            <div class="sm:col-span-2 md:col-span-4 lg:col-span-1">
                <button type="submit"
                    class="w-full bg-primary hover:bg-primary/90 text-white font-bold text-sm py-2 rounded-lg transition-colors h-10">
                    {{ __('Calcular') }}
                </button>
            </div>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-5 border-t border-neutral-200 dark:border-neutral-700">
            <div>
                <div class="text-xs text-neutral-500 dark:text-neutral-400 font-medium mb-1">{{ __('Pago mensual') }}
                </div>
                <div class="text-neutral-900 dark:text-white font-extrabold text-xl" x-text="format(monthlyPayment)">
                </div>
            </div>
            <div>
                <div class="text-xs text-neutral-500 dark:text-neutral-400 font-medium mb-1">
                    {{ __('Total de intereses') }}</div>
                <div class="text-neutral-900 dark:text-white font-extrabold text-xl" x-text="format(totalInterest)">
                </div>
            </div>
            <div>
                <div class="text-xs text-neutral-500 dark:text-neutral-400 font-medium mb-1">
                    {{ __('Importe total del préstamo') }}</div>
                <div class="text-neutral-900 dark:text-white font-extrabold text-xl" x-text="format(totalLoan)"></div>
            </div>
        </div>
    </div>
</section>
