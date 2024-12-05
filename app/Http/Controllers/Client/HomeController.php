<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    const PATH_VIEW = 'client.layouts.master';

    public function home()
    {
        return view(self::PATH_VIEW);
    }
    public function myAccount(string $id)
    {
        $address =  Address::query()->get();
        $listUser =  User::query()->findOrFail($id);
        $addresses = DB::table('addresses')->where('user_id', $id)->get();

        return view('client.pages.myaccount', compact('listUser', 'addresses', 'address'));
    }


    public function showCart()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();

        $totalAmount = $this->calculateGrandTotal();
        $discount = 0;
        $finalAmount = $totalAmount;

        // Trả về view giỏ hàng với danh sách sản phẩm
        return view(self::PATH_VIEW, compact('cartItems', 'totalAmount', 'finalAmount', 'discount'));
    }
}
