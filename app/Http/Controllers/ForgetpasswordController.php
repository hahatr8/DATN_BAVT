<?php

namespace App\Http\Controllers;

use App\Models\User;
// use Nette\Utils\Random;
use Nette\Utils\Random;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgetpasswordController extends Controller
{
    public function forgetpassword()
    {
        return view('auth.forgetpassword');
    }
    public function forgetpasswordPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);
        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        Mail::send("emails.forgetpassword", ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject("Reset Password");
        });

        return redirect()->to(route("forgetpassword"))->with('success', 'We have send an email to reset password.');
    }
    public function restpassword($token)
    {
        return view('auth.newpassword', compact('token'));
    }
    public function restpasswordPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ]);
         DB::table('password_reset_tokens')->where([
            'email' => $request->email,
            'token' => $request->token,
            'created_at' => Carbon::now(),
        ])->first();

        // if (!$updatePassword) {
        //     return redirect()->to(route("restpassword"))->with('error', 'Invalid');
        // }



        User::where('email', $request->email)->update(["password" => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

        return redirect('/login')->with('success', 'Password reset success');

    }
}
