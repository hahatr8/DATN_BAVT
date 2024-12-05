<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showFormLogin(){
        return view('auth.login');
    }

    public function login(Request $request){
        $user =$request->only('email','password');

        if (Auth::attempt($user)) {
            return redirect()->intended('/');
        }

        return redirect()->back()->withErrors([
            'email'=> 'Thông tin người dùng không đúng',
        ]);
    }
    public function showFormRegister(){
        return view('auth.register');
    }
    public function register(Request $request){
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'phone' => 'required',
            'password' => 'required',
        ]);

        $user = User::query()->create($data);
        Auth::login($user);

        return redirect()->intended('login')->with('success', 'Đăng kí thành công!');
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect('/login')->with('success', 'Đăng xuất thành công!');
    }

   
}
