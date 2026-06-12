@extends('layouts.public')

@section('title', __('plans.payment_success_title') . ' — NidoReal')

@section('content')
@section('navbar')
    <x-public.navbar :floating="false" />
@endsection

    <main class="pt-8 pb-16 md:pt-12 md:pb-24 bg-neutral-50 dark:bg-neutral-900 transition-colors min-h-[70vh]">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-3xl md:rounded-[2.5rem] shadow-2xl overflow-hidden">
                {{-- Decorative top bar --}}
                <div class="h-2 bg-primary"></div>
                
                <div class="p-6 md:p-12 text-center">
                    {{-- Success Icon --}}
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-full mb-8">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white mb-4">
                        {{ __('plans.payment_success_title') }}
                    </h1>
                    <p class="text-lg text-neutral-500 dark:text-neutral-400 mb-10">
                        {{ __('plans.payment_success_subtitle') }}
                    </p>

                    {{-- Order Details Table --}}
                    <div class="bg-neutral-50 dark:bg-neutral-900/50 rounded-3xl p-6 md:p-8 mb-10 text-left border border-neutral-100 dark:border-neutral-700">
                        <h2 class="text-sm font-bold uppercase tracking-widest text-neutral-400 mb-6 border-b border-neutral-200 dark:border-neutral-700 pb-4">
                            {{ __('plans.order_summary') }}
                        </h2>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-neutral-500 dark:text-neutral-400">{{ __('plans.order_number') }}</span>
                                <span class="font-mono font-bold text-neutral-900 dark:text-white">#NR-{{ strtoupper(\Illuminate\Support\Str::random(8)) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-neutral-500 dark:text-neutral-400">{{ __('plans.date') }}</span>
                                <span class="font-semibold text-neutral-900 dark:text-white">{{ now()->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-neutral-500 dark:text-neutral-400">{{ __('plans.agency') }}</span>
                                <span class="font-semibold text-neutral-900 dark:text-white">{{ $agency->name }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-neutral-500 dark:text-neutral-400">{{ __('plans.new_plan') }}</span>
                                <span class="px-3 py-1 bg-primary/10 text-primary text-xs font-bold rounded-full uppercase">{{ $plan->name }}</span>
                            </div>
                            <div class="pt-4 mt-4 border-t border-neutral-200 dark:border-neutral-700 flex justify-between items-center">
                                <span class="text-neutral-900 dark:text-white font-bold text-lg">{{ __('plans.amount') }}</span>
                                <span class="text-2xl font-extrabold text-neutral-900 dark:text-white">{{ number_format($plan->price_eur, 2) }}€</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('filament.agency.pages.dashboard', ['tenant' => $agency]) }}" 
                           class="btn-primary py-4 px-10 text-base shadow-xl shadow-primary/20">
                            {{ __('plans.return_to_cabinet') }}
                        </a>
                    </div>
                </div>
            </div>

            <p class="mt-8 text-center text-xs text-neutral-400 italic">
                {{ __('plans.mock_card_hint') }}
            </p>
        </div>
    </main>

@endsection
