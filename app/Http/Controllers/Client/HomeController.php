<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    const PATH_VIEW = 'client.home';

    public function myAccount(string $id)
    {
        $address =  Address::query()->get();
        $listUser =  User::query()->findOrFail($id);
        $addresses = DB::table('addresses')->where('user_id', $id)->get();

        return view('client.pages.myaccount', compact('listUser', 'addresses', 'address'));
    }


    public function home()
    {
        // Trả về view giỏ hàng với danh sách sản phẩm

        $productsMiniCart = Product::with([
            'productImgs' => function ($query) {
                $query->select('id', 'product_id', 'img', 'created_at') // Thêm `created_at` để sắp xếp
                    ->orderBy('created_at', 'asc'); // Sắp xếp theo thời gian
            }
        ])
            ->limit(5) // Lấy tối đa 5 sản phẩm
            ->get(['id', 'name', 'description', 'price']); // Chỉ lấy các cột cần thiết

        // Phân loại ảnh cho từng sản phẩm
        $productsMiniCart = $productsMiniCart->map(function ($product) {
            $images = $product->productImgs;
            $product->mainImage = $images->first(); // Ảnh chính
            $product->hoverImage = $images->skip(1)->first(); // Ảnh hover
            $product->albumImages = $images->skip(2); // Album ảnh
            return $product;
        });

        return view(self::PATH_VIEW, compact('productsMiniCart'));
    }

    public function remove($id, Request $request)
    {
        $cartItem = Cart::find($id);
        if ($cartItem) {
            $cartItem->delete();
            return redirect($request->input('current_url'))->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng');
        }

        return redirect($request->input('current_url'))->with('error', 'Sản phẩm không tồn tại trong giỏ hàng');
    }
}
