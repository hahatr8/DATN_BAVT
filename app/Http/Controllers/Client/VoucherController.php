<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\Category;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    const PATH_VIEW = 'client.vouchers.'; // The folder in the client views

    public function voucherList()
    {
        // Get all categories
        $categories = Category::query()->latest('id')->paginate(5); // Adjust number of items per page as necessary

        // Get all vouchers (You can paginate as required)
        $vouchers = Voucher::query()->latest('id')->paginate(5); // Paginate 5 per page

        // Get new vouchers (optional, just like Blog's new blogs)
        $newVouchers = Voucher::query()->latest('created_at')->paginate(5);

        return view(self::PATH_VIEW . 'voucherList', compact('categories', 'vouchers', 'newVouchers'));
    }

    public function voucherDetail(Voucher $voucher)
    {
        // Get all categories
        $categories = Category::query()->latest('id')->paginate(5); // Adjust number of items per page as necessary

        // Get new vouchers (optional, like Blog's new blogs)
        $newVouchers = Voucher::query()->latest('created_at')->paginate(5);

        return view(self::PATH_VIEW . 'voucherDetail', compact('categories', 'voucher', 'newVouchers'));
    }
}
