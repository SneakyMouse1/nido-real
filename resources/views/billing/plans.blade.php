@extends('layouts.public')

@section('title', __('plans.billing_title') . ' — NidoReal')

@section('content')
@section('navbar')
    <x-public.navbar :floating="false" />
@endsection

<main class="pt-8 pb-16 md:pt-12 md:pb-24 bg-neutral-50 dark:bg-neutral-900 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h1 class="text-3xl md:text-5xl font-bold text-neutral-900 dark:text-white mb-6">
                {{ __('plans.billing_title') }}
            </h1>
            <p class="text-lg text-neutral-500 dark:text-neutral-400 mb-8">
                {{ __('plans.billing_subtitle') }}
            </p>

            {{-- Current usage card --}}
            <div
                class="inline-flex items-center gap-4 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-2xl px-6 py-4 shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-left">
                    <div class="text-xs font-semibold uppercase tracking-wider text-neutral-400 mb-0.5">
                        {{ __('plans.current_plan') }}
                    </div>
                    <div class="text-neutral-900 dark:text-white font-bold">
                        {{ $currentPlan?->name ?? '—' }}
                        <span class="mx-2 text-neutral-300 dark:text-neutral-600">|</span>
                        <span
                            class="{{ $agency->listings_used >= $agency->listings_limit ? 'text-error' : 'text-primary' }}">
                            {{ $agency->listings_used }} / {{ $agency->listings_limit }}
                        </span>
                        <span class="text-neutral-500 dark:text-neutral-400 font-normal text-sm ml-1">
                            {{ __('plans.listings_used') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Plan cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20" id="plan-grid">
            @foreach ($plans as $plan)
                @php
                    $isCurrent = $currentPlan?->id === $plan->id;
                    $isUnlimited = $plan->listings_limit >= 999999;
                    $isPro = $plan->slug === 'pro';
                @endphp

                <div class="relative group">
                    @if ($isPro)
                        <div class="absolute -top-4 inset-x-0 flex justify-center z-10">
                            <span
                                class="bg-primary text-white text-[10px] font-bold uppercase tracking-widest px-4 py-1.5 rounded-full shadow-lg">
                                {{ __('Recommended') }}
                            </span>
                        </div>
                    @endif

                    <div @class([
                        'h-full flex flex-col bg-white dark:bg-neutral-800 border-2 rounded-[2rem] p-6 md:p-8 transition-all duration-300',
                        'border-primary shadow-xl md:scale-105 z-1' => $isPro,
                        'border-neutral-100 dark:border-neutral-700 hover:border-primary/30' =>
                            !$isPro && !$isCurrent,
                        'border-green-500/30 bg-green-50/10 dark:bg-green-900/5' => $isCurrent,
                    ])>
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">{{ $plan->name }}</h3>
                            <div class="flex items-baseline gap-1">
                                <span class="text-4xl font-extrabold text-neutral-900 dark:text-white tracking-tight">
                                    {{ number_format($plan->price_eur, 0) }}€
                                </span>
                                <span class="text-neutral-500 dark:text-neutral-400 font-medium">
                                    {{ __('plans.per_month') }}
                                </span>
                            </div>
                        </div>

                        <ul class="space-y-4 mb-10 flex-grow">
                            <li class="flex items-center gap-3 text-neutral-600 dark:text-neutral-300">
                                <svg class="w-5 h-5 text-primary shrink-0" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="font-semibold">
                                    @if ($isUnlimited)
                                        {{ __('plans.listings_unlimited') }}
                                    @else
                                        {{ __('plans.listings_count', ['count' => $plan->listings_limit]) }}
                                    @endif
                                </span>
                            </li>
                            {{-- Extra features mock --}}
                            <li class="flex items-center gap-3 text-neutral-500 dark:text-neutral-400">
                                <svg class="w-5 h-5 text-primary shrink-0" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                {{ __('Support 24/7') }}
                            </li>
                            <li class="flex items-center gap-3 text-neutral-500 dark:text-neutral-400">
                                <svg class="w-5 h-5 text-primary shrink-0" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                {{ __('Advanced Analytics') }}
                            </li>
                        </ul>

                        @if ($isCurrent)
                            <div
                                class="w-full py-4 text-center text-green-600 dark:text-green-400 font-bold bg-green-50 dark:bg-green-900/20 rounded-2xl">
                                ✓ {{ __('plans.current_plan_label') }}
                            </div>
                        @else
                            <button
                                onclick="selectPlan('{{ $plan->id }}', '{{ addslashes($plan->name) }}', {{ $plan->price_eur }})"
                                @class([
                                    'w-full py-4 rounded-2xl font-bold transition-all duration-300 cursor-pointer',
                                    'bg-primary text-white hover:bg-primary-hover shadow-lg shadow-primary/20' => $isPro,
                                    'bg-neutral-900 dark:bg-white text-white dark:text-neutral-900 hover:bg-neutral-800 dark:hover:bg-neutral-100' => !$isPro,
                                ])>
                                {{ __('plans.select_plan') }}
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Mock payment section --}}
        <div id="payment-section" class="hidden scroll-mt-24">
            <div class="max-w-2xl mx-auto">
                <div
                    class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-3xl md:rounded-[2.5rem] shadow-2xl overflow-hidden">
                    <div class="p-6 md:p-12">
                        <div class="flex items-center justify-between mb-8">
                            <div>

                                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white" id="payment-plan-name">
                                </h2>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('billing.simulate-payment') }}" class="space-y-6">
                            @csrf
                            <input type="hidden" name="plan_id" id="payment-plan-id">

                            <div class="space-y-5">
                                <div class="form-group">
                                    <label class="form-label">{{ __('plans.card_number') }}</label>
                                    <div class="relative">
                                        <input type="text" value="4242 4242 4242 4242" readonly
                                            class="form-input bg-neutral-50 dark:bg-neutral-900 border-neutral-200 dark:border-neutral-700 font-mono tracking-widest text-lg py-4 cursor-not-allowed opacity-70">
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 flex gap-2">
                                            <div class="w-8 h-5 bg-neutral-200 dark:bg-neutral-700 rounded-sm"></div>
                                            <div class="w-8 h-5 bg-neutral-300 dark:bg-neutral-600 rounded-sm"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('plans.card_expiry') }}</label>
                                        <input type="text" value="12/28" readonly
                                            class="form-input bg-neutral-50 dark:bg-neutral-900 border-neutral-200 dark:border-neutral-700 font-mono py-4 cursor-not-allowed opacity-70">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">{{ __('plans.card_cvv') }}</label>
                                        <input type="text" value="123" readonly
                                            class="form-input bg-neutral-50 dark:bg-neutral-900 border-neutral-200 dark:border-neutral-700 font-mono py-4 cursor-not-allowed opacity-70">
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 flex flex-col gap-4">
                                <button type="submit"
                                    class="btn-primary w-full py-4 text-base font-bold shadow-xl shadow-primary/20 text-center">
                                    {{ __('plans.pay_button') }}
                                </button>
                                <button type="button" onclick="cancelPayment()"
                                    class="text-neutral-500 hover:text-neutral-900 dark:hover:text-white font-medium transition-colors">
                                    {{ __('filament.actions.cancel') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

@push('scripts')
<script>
    function selectPlan(planId, planName, planPrice) {
        document.getElementById('payment-plan-id').value = planId;
        document.getElementById('payment-plan-name').textContent = planName + ' • ' + planPrice + '€';

        document.getElementById('plan-grid').classList.add('opacity-30', 'pointer-events-none', 'blur-[2px]');
        document.getElementById('payment-section').classList.remove('hidden');

        setTimeout(() => {
            document.getElementById('payment-section').scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }, 50);
    }

    function cancelPayment() {
        document.getElementById('payment-section').classList.add('hidden');
        document.getElementById('plan-grid').classList.remove('opacity-30', 'pointer-events-none', 'blur-[2px]');
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
</script>
@endpush
