<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PublicAuthController extends Controller
{
    /**
     * Show the unified login/register page.
     */
    public function index()
    {
        if (Auth::check()) {
            return $this->redirectAfterAuth(Auth::user());
        }

        return view('public.auth.index');
    }

    /**
     * Handle the login request (Email or Phone).
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login'    => ['required', 'string'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean']
        ]);

        $loginField = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        if (Auth::attempt([$loginField => $credentials['login'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();

            return $this->redirectAfterAuth(Auth::user());
        }

        return back()->withErrors([
            'login' => __('Las credenciales proporcionadas no coinciden con nuestros registros.'),
        ])->onlyInput('login');
    }

    /**
     * Handle the registration request.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'login'    => ['required', 'string', 'max:255', 'unique:users,email', 'unique:users,phone'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role'     => ['required', 'in:buyer,owner'],
            'terms'    => ['accepted'],
        ]);

        $isEmail = filter_var($validated['login'], FILTER_VALIDATE_EMAIL);

        $user = User::create([
            'name'      => $validated['name'],
            'email'     => $isEmail ? $validated['login'] : null,
            'phone'     => !$isEmail ? $validated['login'] : null,
            'password'  => Hash::make($validated['password']),
            'is_active' => true,
        ]);

        // Assign the role chosen by the user during registration
        $user->assignRole($validated['role']);

        Auth::login($user);

        return $this->redirectAfterAuth($user);
    }

    /**
     * Determine where to redirect after successful authentication.
     * Agency managers and agents → Filament agency panel.
     * Everyone else → personal account (/mi-cuenta).
     */
    protected function redirectAfterAuth(\App\Models\User $user): \Illuminate\Http\RedirectResponse
    {
        if ($user->hasAnyRole(['agency_manager', 'agent'])) {
            // Redirect to Filament agency panel
            return redirect('/cabinet');
        }

        if ($user->hasAnyRole(['superadmin', 'admin'])) {
            return redirect('/secret-admin');
        }

        return redirect()->route('user.profile')->with('success', __('Bienvenido/a, ') . $user->name . '!');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
