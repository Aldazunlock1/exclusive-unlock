<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Customer;
use App\Models\User;
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
   
  public function admin_login(Request $request)
{
    // Buscar el usuario admin (id = 1 o role = 'admin')
    $adminUser = User::where('id', 1)->first();

    if (!$adminUser) {
        return redirect()->route('login')->withErrors([
            'email' => 'No se encontró un usuario administrador.',
        ]);
    }

    // Autenticar usando el guard 'admin'
    Auth::guard('admin')->login($adminUser);

    return redirect()->route('admin');
}
}
