<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    const PATH_VIEW = 'client.home';

    public function home()
    {
        $categories = Category::query()->latest('display_order')->paginate(5);
        $brands = Brand::where('status', 1)->get(); // Chỉ lấy các thương hiệu đang hoạt động
    

            $listproduct = Product::query()->get();


        return view(self::PATH_VIEW, compact('categories', 'brands','listproduct'));

    }
    public function brandproduct(string $id)
    {
        $categories = Category::query()->latest('display_order')->paginate(5);
        $brands = Brand::where('status', 1)->get(); // Chỉ lấy các thương hiệu đang hoạt động
        if ($id){
            $listproduct = Product::where('brand_id',$id)->get();
        }
        else{
            $listproduct = Product::query()->get();
        }

        return view(self::PATH_VIEW, compact('categories', 'brands','listproduct'));

    }
  

}
    