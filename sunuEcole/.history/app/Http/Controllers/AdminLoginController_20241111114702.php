<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('Administrateur.login');
    }

    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');


        Auth::guard('admin')->attempt($credentials);
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard'); 
        }
        return back()->withErrors([
            'credentials' => 'Les informations d\'identification fournies sont incorrectes.',
        ])->onlyInput('email');
    }
    public function logout(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/admin/login')->withErrors(['message' => 'Vous êtes déjà déconnecté.']);
        }
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();        
        return redirect('/admin/login')->with('success', 'Déconnexion réussie.');
    }
    
}
