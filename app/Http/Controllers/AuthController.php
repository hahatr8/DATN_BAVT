<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
<<<<<<< HEAD
    public function showFormLogin(){
        return view('auth.login');
    }

    public function login(Request $request){
        $user =$request->only('email','password');
=======
    public function showFormLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $user = $request->only('email', 'password');
>>>>>>> 6e62cc4e95506868ce9182e8089fb4ee09c1cf90

        if (Auth::attempt($user)) {
            return redirect()->intended('client');
        }

        return redirect()->back()->withErrors([
<<<<<<< HEAD
            'email'=> 'Thông tin người dùng không đúng',
        ]);
    }
    public function showFormRegister(){
        return view('auth.register');
    }
    public function register(Request $request){
=======
            'email' => 'Thông tin người dùng không đúng',
        ]);
    }
    public function showFormRegister()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
>>>>>>> 6e62cc4e95506868ce9182e8089fb4ee09c1cf90
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'phone' => 'required',
            'password' => 'required',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'District' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        $user = User::query()->create($data);
        $user_id = $user->id;
        $user->addresses()->create([
            'user_id' => $user_id,
            'country' => $request['country'],
            'District' => $request['District'],
            'city' => $request['city'],
            'address' => $request['address'],
        ]);

        Auth::login($user);

        return redirect()->intended('login')->with('success', 'Đăng kí thành công!');
    }

<<<<<<< HEAD
    public function logout(Request $request){
        Auth::logout();
        return redirect('/client')->with('success', 'Đăng xuất thành công!');
    }

   
=======
    public function logout(Request $request)
    {
        // Xóa tất cả session
        session()->flush();

        Auth::logout();

        return redirect('/client')->with('success', 'Đăng xuất thành công!');
    }


>>>>>>> 6e62cc4e95506868ce9182e8089fb4ee09c1cf90
}
