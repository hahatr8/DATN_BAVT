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
    public function createaddress(string $id)
    {
        $user = User::query()->findOrFail($id);
        return view('admin.users.createaddress', compact('user'));
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

            User::query()->create($params);

            return redirect()->route('admin.user.index');
        }
    }

    public function storeAddress(Request $request, string $id)
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


            return redirect()->route('admin.user.detail',$user->id);
        }
    }
    public function editAddress(string $id)
    {
        $addresses =  Address::query()->findOrFail($id);
        return view('admin.users.editaddress', compact( 'addresses'));
    }
    public function updateAddress(Request $request, string $id)
    {
        if ($request->isMethod('PUT')) {
            $params = $request->except('_token', '_method');
            $address = Address::query()->findOrFail($id);
            
            $address->update($params);
            return redirect()->route('admin.user.detail',$address->user_id);
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

            if ($request->hasFile('img')) {
                if ($user->img && Storage::disk('public')->exists($user->img)) {
                    Storage::disk('public')->delete($user->img);
                }
                $params['img'] = $request->file('img')->store('uploads/user', 'public');
            } else {
                $params['img'] = $user->img;
            }


            $user->update($params);
            return redirect()->route('admin.user.index');
        }
    }

    public function empowerAdmin(string $id){

        $user = User::query()->findOrFail($id);
        $user->update(['type'=>'admin']);
        return redirect()->route('admin.user.index');
    }

    public function empowerMember(string $id){
        $user = User::query()->findOrFail($id);
        $user->update(['type'=>'member']);
        return redirect()->route('admin.user.index');
    }
    public function empowerCustomer(string $id){
        $user = User::query()->findOrFail($id);
        $user->update(['type'=>'customer']);
        return redirect()->route('admin.user.index');
    }
    public function softDestruction(User $user)
    {
        $user->delete();

        return back()->with('success', 'Thao tác thành công');
    }
    public function trash()
    {
        $trashedCategories = User::with(['addresses'])->onlyTrashed()->get();
        $totalTrashedCategories = User::onlyTrashed()->count();

        return view('admin.users.trash', compact( 'trashedCategories', 'totalTrashedCategories'));
    }
    public function restore($id)
    {
        $User = User::onlyTrashed()->findOrFail($id);
        $User->restore();

        return back()->with(['success' => 'Khôi phục sản phẩm thành công']);

    }
}
