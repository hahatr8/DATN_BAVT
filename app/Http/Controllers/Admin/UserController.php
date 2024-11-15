<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->user = new User();
    }
    public function index(Request $request)
    {
        $listUser =  User::query()->get();
        return view('admin.users.index', compact('listUser'));
    }
    public function create()
    {
        return view('admin.users.create');
    }
    public function createadd(string $id)
    {
        $user = User::query()->findOrFail($id);
        return view('admin.users.createadd', compact('user'));
    }
    public function store(UserRequest $request)
    {
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');
            if ($request->hasFile('img')) {
                $params['img'] = $request->file('img')->store('uploads/user', 'public');
            } else {
                $params['img'] = null;
            }

            $user = User::query()->create($params);

            $user_id = $user->id;
            $user->addresses()->create([
                'user_id' => $user_id,
                'country' => $params['country'],
                'District' => $params['District'],
                'city' => $params['city'],
                'address' => $params['address'],
            ]);


            return redirect()->route('admin.user.index');
        }
    }

    public function storeadd(Request $request, string $id)
    {
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');


            $user = User::query()->findOrFail($id);

            $user->addresses()->create([
                'user_id' => $id,
                'country' => $params['country'],
                'District' => $params['District'],
                'city' => $params['city'],
                'address' => $params['address'],
            ]);


            return redirect()->route('admin.user.index');
        }
    }
    public function detail(string $id)
    {
        $address =  Address::query()->get();
        $listUser =  User::query()->findOrFail($id);
        $addresses = DB::table('addresses')->where('user_id', $id)->get();

        return view('admin.users.show', compact('listUser', 'addresses', 'address'));
    }
    public function edit(string $id)
    {

        $user =  User::query()->findOrFail($id);
        $addresses = DB::table('addresses')->where('user_id', $id)->get();
        return view('admin.users.edit', compact('user', 'addresses'));
    }
    public function update(Request $request, string $id)
    {
        if ($request->isMethod('PUT')) {
            $params = $request->except('_token', '_method');
            $user = User::query()->findOrFail($id);
            $addresses = DB::table('addresses')->where('user_id', $id)->get();

            if ($request->hasFile('img')) {
                if ($user->img && Storage::disk('public')->exists($user->img)) {
                    Storage::disk('public')->delete($user->img);
                }
                $params['img'] = $request->file('img')->store('uploads/user', 'public');
            } else {
                $params['img'] = $user->img;
            }

            if ($user->addresses->pluck('user_id')) {
                $user->addresses()->update([
                    'country' => $params['country'],
                    'District' => $params['District'],
                    'city' => $params['city'],
                    'address' => $params['address'],
                ]);
            } elseif (!isset($addresses)) {
                $user->addresses()->create([
                    'user_id' => $user->id,
                    'country' => $params['country'],
                    'District' => $params['District'],
                    'city' => $params['city'],
                    'address' => $params['address'],
                ]);
            }

            $user->update($params);
            return redirect()->route('admin.user.index');
        }
    }
    public function destroy(string $id)
    {
        $user = User::query()->findOrFail($id);
        if ($user) {
            $user->addresses()->delete();
            $user->delete();

            if ($user->img && Storage::disk('public')->exists($user->img)) {
                Storage::disk('public')->delete($user->img);
            }
            return redirect()->route('admin.user.index');
        }
    }
}
