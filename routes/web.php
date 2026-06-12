<?php

use App\Http\Controllers\BillingController;
use App\Http\Controllers\PublicAgencyController;
use App\Http\Controllers\PublicHomeController;
use App\Http\Controllers\PublicPropertyController;
use App\Http\Controllers\PublicPageController;
use Illuminate\Support\Facades\Route;

// Global locale switching route (no prefix)
Route::get('/locale/{locale}', function (string $locale) {
    if (in_array($locale, ['es', 'en'])) {
        session(['locale' => $locale]);

        // Also persist in user profile if authenticated
        if (auth()->check()) {
            auth()->user()->update(['locale' => $locale]);
        }
    }

    return redirect()->back();
})->name('locale.switch');

// Billing simulation routes — accessible to authenticated agency managers (no prefix)
Route::middleware(['auth'])->group(function () {
    Route::get('/billing/plans', [BillingController::class, 'index'])->name('billing.plans');
    Route::post('/billing/simulate-payment', [BillingController::class, 'simulatePayment'])->name('billing.simulate-payment');
    Route::get('/billing/success', [BillingController::class, 'paymentSuccess'])->name('billing.success');
});

// User Personal Space (/mi-cuenta) (no prefix)
Route::middleware(['auth'])->prefix('mi-cuenta')->name('user.')->group(function () {
    Route::get('/', [\App\Http\Controllers\UserPanelController::class, 'profile'])->name('profile');
    Route::post('/perfil', [\App\Http\Controllers\UserPanelController::class, 'updateProfile'])->name('profile.update');

    Route::get('/favoritos', [\App\Http\Controllers\UserPanelController::class, 'favorites'])->name('favorites');
    Route::post('/favoritos/{property}', [\App\Http\Controllers\UserPanelController::class, 'toggleFavorite'])->name('favorites.toggle');

    Route::get('/propiedades', [\App\Http\Controllers\UserPanelController::class, 'propertiesIndex'])->name('properties.index');
    Route::get('/propiedades/nueva', [\App\Http\Controllers\UserPanelController::class, 'propertyCreate'])->name('properties.create');
    Route::post('/propiedades', [\App\Http\Controllers\UserPanelController::class, 'propertyStore'])->name('properties.store');
    Route::get('/propiedades/{property}/editar', [\App\Http\Controllers\UserPanelController::class, 'propertyEdit'])->name('properties.edit');
    Route::put('/propiedades/{property}', [\App\Http\Controllers\UserPanelController::class, 'propertyUpdate'])->name('properties.update');
    Route::delete('/propiedades/{property}', [\App\Http\Controllers\UserPanelController::class, 'propertyDestroy'])->name('properties.destroy');

    // Account settings
    Route::get('/ajustes', [\App\Http\Controllers\UserPanelController::class, 'settings'])->name('settings');
    Route::put('/ajustes/personal', [\App\Http\Controllers\UserPanelController::class, 'updatePersonal'])->name('settings.personal.update');
    Route::put('/ajustes/contacto', [\App\Http\Controllers\UserPanelController::class, 'updateContact'])->name('settings.contact.update');
    Route::put('/ajustes/contrasena', [\App\Http\Controllers\UserPanelController::class, 'updatePassword'])->name('settings.password.update');
    Route::delete('/ajustes/eliminar', [\App\Http\Controllers\UserPanelController::class, 'deleteAccount'])->name('settings.account.delete');
});

// Public routes without locale prefix
Route::get('/', [PublicHomeController::class, 'index'])->name('home');

// Static Pages
Route::get('/nosotros', [PublicPageController::class, 'nosotros'])->name('pages.nosotros');
Route::get('/contacto', [PublicPageController::class, 'contacto'])->name('pages.contacto');
Route::get('/tarifas', [PublicPageController::class, 'tarifas'])->name('pages.tarifas');

// Legal Pages
Route::get('/privacidad', [PublicPageController::class, 'privacidad'])->name('pages.privacidad');
Route::get('/aviso-legal', [PublicPageController::class, 'avisoLegal'])->name('pages.aviso-legal');
Route::get('/cookies', [PublicPageController::class, 'cookies'])->name('pages.cookies');
Route::get('/faq', [PublicPageController::class, 'faq'])->name('pages.faq');

// Properties listing & details
Route::get('/propiedades', [PublicPropertyController::class, 'index'])->name('properties.index');
Route::get('/propiedades/{slug}', [PublicPropertyController::class, 'show'])->name('properties.show');

// Agencies listing & details
Route::get('/agencias', [PublicAgencyController::class, 'index'])->name('agencies.index');
Route::get('/agencias/{slug}', [PublicAgencyController::class, 'show'])->name('agencies.show');

// Public Auth (Unified Login/Register)
Route::middleware('guest')->group(function () {
    Route::get('/auth', [\App\Http\Controllers\PublicAuthController::class, 'index'])->name('login');
    Route::post('/login', [\App\Http\Controllers\PublicAuthController::class, 'login'])->name('auth.login.submit');
    Route::post('/register', [\App\Http\Controllers\PublicAuthController::class, 'register'])->name('auth.register.submit');
});

Route::post('/logout', [\App\Http\Controllers\PublicAuthController::class, 'logout'])->name('logout')->middleware('auth');
