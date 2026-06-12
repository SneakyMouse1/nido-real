@php
    $current = app()->getLocale();
    $other = $current === 'es' ? 'en' : 'es';
    $otherFlag = $other === 'es' ? 'es_ES.svg' : 'en_GB.svg';
    $currentFlag = $current === 'es' ? 'es_ES.svg' : 'en_GB.svg';
    $currentLabel = $current === 'es' ? 'ES' : 'EN';
    $otherLabel = $other === 'es' ? 'ES' : 'EN';
@endphp

<div x-data="{ open: false }" style="display:inline-flex; align-items:center; margin-right:16px; position:relative;">
    
    <button 
        @click="open = !open" 
        @click.outside="open = false"
        class="fi-locale-btn"
        style="display:inline-flex; align-items:center; gap:6px; padding:4px 8px;
               border-radius:6px; border:1px solid rgba(128,128,128,0.3);
               background:transparent; cursor:pointer;
               font-size:13px; font-weight:500; white-space:nowrap;
               transition: background 0.15s, color 0.15s;">
        <img src="{{ asset('images/flags/' . $currentFlag) }}" 
             style="width:20px; height:14px; border-radius:2px; object-fit:cover; display:inline-block;">
        <span>{{ $currentLabel }}</span>
        <svg style="width:10px; height:10px; opacity:0.4; display:inline-block;" 
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fi-locale-dropdown"
         style="position:fixed; top:52px; right:78px; z-index:9999;
                border-radius:8px; box-shadow: 0 8px 24px rgba(0,0,0,0.2);
                overflow:hidden; min-width:80px;">
        <a href="{{ route('locale.switch', $other) }}"
           class="fi-locale-option"
           style="display:flex; align-items:center; gap:8px; padding:6px 10px;
                  text-decoration:none; font-size:13px; font-weight:500;
                  transition: background 0.15s;">
            <img src="{{ asset('images/flags/' . $otherFlag) }}"
                 style="width:20px; height:14px; border-radius:2px; object-fit:cover;">
            <span>{{ $otherLabel }}</span>
        </a>
    </div>
</div>

<style>
    /* Светлая тема */
    .fi-locale-btn {
        color: rgba(0, 0, 0, 0.7);
    }
    .fi-locale-btn:hover {
        background: rgba(0,0,0,0.05) !important;
        color: black !important;
    }
    .fi-locale-dropdown {
        background: #ffffff;
        border: 1px solid rgba(0,0,0,0.1);
    }
    .fi-locale-option {
        color: rgba(0,0,0,0.7);
    }
    .fi-locale-option:hover {
        background: rgba(0,0,0,0.05);
        color: black;
    }

    /* Тёмная тема */
    .dark .fi-locale-btn {
        color: rgba(255,255,255,0.7);
    }
    .dark .fi-locale-btn:hover {
        background: rgba(255,255,255,0.05) !important;
        color: white !important;
    }
    .dark .fi-locale-dropdown {
        background: #1a1a1a;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .dark .fi-locale-option {
        color: rgba(255,255,255,0.7);
    }
    .dark .fi-locale-option:hover {
        background: rgba(255,255,255,0.05);
        color: white;
    }
</style>