<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function edit(string $id)
    {

        $user =  User::query()->findOrFail($id);
        return view('client.user.edit', compact('user'));
    }
    public function update(Request $request, string $id)
    {
        if ($request->isMethod('PUT')) {
            $params = $request->except('_token', '_method');
            $user = User::query()->findOrFail($id);

            if ($request->hasFile('img')) {
                if ($user->img && Storage::disk('public')->exists($user->img)) {
                    Storage::disk('public')->delete($user->img);
                }
                $params['img'] = $request->file('img')->store('uploads/user', 'public');
            } else {
                $params['img'] = $user->img;
            }

            $user->update($params);
            return redirect()->route('client.myaccount',$id);
        }
    }
}
