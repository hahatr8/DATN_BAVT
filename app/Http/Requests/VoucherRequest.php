<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Cho phép tất cả người dùng truy cập
    }

    public function rules()
    {
        // Kiểm tra nếu là phương thức `PUT/PATCH` (update), lấy ID voucher từ route
        $voucherId = $this->route('voucher') ? $this->route('voucher')->id : null;

        return [
            'E_vorcher' => 'required|unique:vouchers,E_vorcher,' . $voucherId,
            'quantity' => 'required|numeric',
            'discount' => 'required|integer',
            'status' => 'required|boolean',
            'user_id' => 'required|exists:users,id',
            'product_id' => 'nullable|exists:products,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ];
    }

    public function messages()
    {
        return [
            'E_vorcher.required' => 'Vui lòng nhập mã giảm giá.',
            'E_vorcher.unique' => 'Mã giảm giá đã tồn tại.',
            'quantity.required' => 'Vui lòng nhập số lượng.',
            'quantity.numeric' => 'Số lượng phải là số.',
            'discount.required' => 'Vui lòng nhập mức giảm giá.',
            'discount.integer' => 'Mức giảm giá phải là số nguyên.',
            'status.required' => 'Vui lòng chọn trạng thái.',
            'user_id.required' => 'Vui lòng chọn người dùng.',
            'user_id.exists' => 'Người dùng không tồn tại.',
            'product_id.exists' => 'Sản phẩm không tồn tại.',
            'start_date.required' => 'Vui lòng nhập ngày bắt đầu.',
            'end_date.required' => 'Vui lòng nhập ngày kết thúc.',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ];
    }
}

