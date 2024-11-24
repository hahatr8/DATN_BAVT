<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    const PATH_VIEW = 'client.home';

    public function home()
    {
        $categories = Category::query()->where('status', 1)->orderBy('display_order', 'asc')->paginate(5);

        return view(self::PATH_VIEW, compact('categories'));

    }
}
