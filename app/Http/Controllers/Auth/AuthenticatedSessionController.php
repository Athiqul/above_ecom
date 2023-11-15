<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    //Enterprise user login
    public function createAuthorise(): View
    {
        return view('auth.auth_login');
    }
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        $url='/';
        if($request->user()->role=='admin')
        {
            $url='/admin/dashboard';
        }

        if($request->user()->role=='vendor')
        {
            $url='/vendor/dashboard';
        }


        if($request->user()->role=='user')
        {
            $url='/dashboard';
        }


        return redirect()->intended($url);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $url='/';
        if(Auth::user()->role=='admin'||Auth::user()->role=='vendor')
        {
            $url='/enterprise-login';
        }
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();


        return redirect($url);
    }
}
