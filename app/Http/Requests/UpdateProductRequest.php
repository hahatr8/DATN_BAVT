<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //thông tin cơ bản

            'product.name' => 'required|string|max:255',
            'product.price' => 'required|numeric|min:0',
            'category_id' => 'required|array|min:1', // Ít nhất một danh mục
            'category_id.*' => 'exists:categories,id', // Từng danh mục phải tồn tại
            'product.brand' => 'required|exists:brands,id', // Hãng phải tồn tại
            'product.description' => 'required|string|max:500', // Mô tả ngắn không quá 500 ký tự
            'product.content' => 'required|string|min:10', // Mô tả chi tiết phải có ít nhất 10 ký tự


            // Ảnh đại diện và album

            // 'img' => 'required|image|mimes:jpg,png,jpg,gif|max:2048', // Ảnh đại diện không bắt buộc nhưng nếu có phải hợp lệ
            // 'array_img.*' => 'required|image|mimes:jpg,png,jpg,gif|max:2048', // Ảnh album không bắt buộc nhưng phải hợp lệ
            // Thông tin size

            'product_sizes' => 'nullable|array', // Mảng thông tin size
            'product_sizes.*.variant' => 'required_with:product_sizes.*|string|max:100', // Tên size
            'product_sizes.*.img' => 'required|image|mimes:jpg,png,jpg,gif|max:2048', // Ảnh của size
            'product_sizes.*.price' => 'required_with:product_sizes.*|numeric|min:0', // Giá của size
            'product_sizes.*.quantity' => 'required_with:product_sizes.*|integer|min:0', // Số lượng của size  
        ];
    }
    public function messages(): array
    {
        return [
            'product.name.required' => 'Tên sản phẩm là bắt buộc.',
            'product.name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
            'product.price.required' => 'Giá sản phẩm là bắt buộc.',
            'product.price.numeric' => 'Giá sản phẩm phải là một số.',
            'product.price.min' => 'Giá sản phẩm không được nhỏ hơn 0.',
            'category_id.required' => 'Danh mục sản phẩm là bắt buộc.',
            'category_id.array' => 'Danh mục sản phẩm không hợp lệ.',
            'category_id.*.exists' => 'Danh mục được chọn không tồn tại.',
            'product.brand.required' => 'Hãng sản phẩm là bắt buộc.',
            'product.brand.exists' => 'Hãng sản phẩm không tồn tại.',
            'product.description.required' => 'Mô tả ngắn là bắt buộc.',
            'product.description.max' => 'Mô tả ngắn không được vượt quá 500 ký tự.',
            'product.content.required' => 'Mô tả chi tiết là bắt buộc.',
            'product.content.min' => 'Mô tả chi tiết phải có ít nhất 10 ký tự.',
            'img.image' => 'Ảnh đại diện phải là một tệp hình ảnh.',
            'img.required' => 'Ảnh đại diện bắt buộc phải nhập',
            'img.mimes' => 'Ảnh đại diện chỉ được chấp nhận các định dạng jpeg, png, jpg, gif.',
            'img.max' => 'Ảnh đại diện không được vượt quá 2MB.',
            'array_img.*.image' => 'Mỗi ảnh trong album phải là một tệp hình ảnh.',
            'array_img.*.required' => 'Mỗi ảnh trong album phải bắt buộc nhập',
            'array_img.*.mimes' => 'Ảnh trong album chỉ được chấp nhận các định dạng jpeg, png, jpg, gif.',
            'array_img.*.max' => 'Ảnh trong album không được vượt quá 2MB.',
            'product_sizes.*.variant.required_with' => 'Tên size là bắt buộc khi có thông tin size.',
            'product_sizes.*.variant.max' => 'Tên size không được vượt quá 100 ký tự.',
            'product_sizes.*.img.image' => 'Ảnh size phải là một tệp hình ảnh.',
            'product_sizes.*.img.required' => 'Ảnh size bắt buộc phải nhập',
            'product_sizes.*.img.mimes' => 'Ảnh size chỉ được chấp nhận các định dạng jpeg, png, jpg, gif.',
            'product_sizes.*.img.max' => 'Ảnh size không được vượt quá 2MB.',
            'product_sizes.*.price.required_with' => 'Giá size là bắt buộc khi có thông tin size.',
            'product_sizes.*.price.numeric' => 'Giá size phải là một số.',
            'product_sizes.*.price.min' => 'Giá size không được nhỏ hơn 0.',
            'product_sizes.*.quantity.required_with' => 'Số lượng size là bắt buộc khi có thông tin size.',
            'product_sizes.*.quantity.integer' => 'Số lượng size phải là một số nguyên.',
            'product_sizes.*.quantity.min' => 'Số lượng size không được nhỏ hơn 0.',
        ];
    }
}
