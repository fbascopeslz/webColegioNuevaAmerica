<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use Illuminate\Support\Facades\DB;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        
        if (Auth::attempt([
            'email' => $request->Usuario, 
            'password' => $request->Contrasenia])) {            

            return redirect()->route('main');        
        }
            
        return back()
            ->withErrors(['Usuario' => trans('auth.failed')])
            ->withInput(request(['Usuario']));
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'Usuario' => 'required|string',
            'Contrasenia' => 'required|string',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }

    public function getUsuarios()
    {
        return DB::select('SELECT * FROM Usuario');
    }
}
