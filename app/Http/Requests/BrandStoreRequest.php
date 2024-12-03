<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Đảm bảo rằng request này luôn được phép sử dụng
    }

    /**
     * Quy tắc validate cho yêu cầu.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:brands,name,' . $this->route('brand'),
            'country' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|boolean',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi.     
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên thương hiệu là bắt buộc.',
            'name.unique' => 'Tên thương hiệu đã tồn tại.',
            'name.max' => 'Tên thương hiệu không được vượt quá 255 ký tự.',
            'country.required' => 'Quốc gia là bắt buộc.',
            'country.max' => 'Quốc gia không được vượt quá 255 ký tự.',
            'description.required' => 'Mô tả là bắt buộc.',
            'logo.required' => 'Logo là bắt buộc.',
            'logo.image' => 'Logo phải là tệp ảnh.',
            'logo.mimes' => 'Logo chỉ được chấp nhận các định dạng: jpeg, png, jpg, gif.',
            'logo.max' => 'Logo không được vượt quá 2MB.',
            'status.required' => 'Trạng thái là bắt buộc.',
        ];
    }
}
