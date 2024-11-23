<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    const PATH_VIEW = 'client.home';

    public function home()
    {
        $categories = Category::query()->latest('display_order')->paginate(5);

        return view(self::PATH_VIEW, compact('categories'));

    }
    public function myAccount(string $id)
    {
        $address =  Address::query()->get();
        $listUser =  User::query()->findOrFail($id);
        $addresses = DB::table('addresses')->where('user_id', $id)->get();

        return view('client.pages.myaccount', compact('listUser', 'addresses', 'address'));
    }

}
