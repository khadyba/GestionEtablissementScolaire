<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');


        Auth::guard('admin')->attempt($credentials);
        // dd($credentials);

        if (Auth::guard('admin')->attempt($credentials)) {
            // apres je vais changer cette et mettre la route qui ,méne au dashbord des admin
            return redirect()->route('etablissement.formulaire'); 
        }
        return back()->withErrors(['email' => 'Email ou mot de passe incorrect.']);
    }



    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
    // public function logout()
    // {
    //     Auth::guard('admin')->logout();

    //     return redirect('/admin/login');
    // }
}
