<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function showLoginForm()
    {
       return view('auth.login'); 
    }

    public function login(Request $request)
    {
        $this->validatelogin($request);

        if(Auth::attempt(['Usuario'=>$request->usuario,'password'=>$request->password,'Inactivo'=>0])){
            return redirect()->route('main');
        }

        return back()->withErrors(['usuario'=>trans('auth.failed')])->withInput(['usuario'=>$request->usuario]);
    }

    protected function validatelogin($request)
    {
        $this->validate($request,[
            'usuario'=>'required|string',
            'password'=>'required|string',
        ]);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}
