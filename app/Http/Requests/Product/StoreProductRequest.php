<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'product.price' => 'required|numeric|min:0|max:100000000',
            'category_id' => 'required|array|min:1', // Ít nhất một danh mục
            'category_id.*' => 'exists:categories,id', // Từng danh mục phải tồn tại
            'product.brand' => 'required|exists:brands,id', // Hãng phải tồn tại
            'product.description' => 'required|string|max:500', // Mô tả ngắn không quá 500 ký tự
            'product.content' => 'required|string|min:10|max:1000', // Mô tả phải có ít nhất 10 ký tự và không vượt quá 1000 ký tự

            // Ảnh đại diện và album
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ảnh đại diện không bắt buộc nhưng nếu có phải hợp lệ
            'array_img' => 'required|array|min:1', // Mảng ảnh bắt buộc và phải chứa ít nhất 1 ảnh
            'array_img.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Mỗi ảnh trong mảng phải là ảnh hợp lệ

            // Thông tin size
            'product_sizes' => 'required|array|min:1', // Mảng thông tin size bắt buộc và phải có ít nhất 1 size
            'product_sizes.*.variant' => 'required|string|max:100', // Tên size (bắt buộc)
            'product_sizes.*.img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ảnh của size (bắt buộc)
            'product_sizes.*.price' => 'required|numeric|min:0|max:100000000', // Giá của size (bắt buộc)
            'product_sizes.*.quantity' => 'required|integer|min:0|max:100000', // Số lượng của size (bắt buộc)
            'product_sizes.*.status' => 'required|boolean', // Trạng thái của size (bắt buộc)
        ];
    }

    public function messages(): array
    {
        return [
            // Thông tin cơ bản
            'product.name.required' => 'Tên sản phẩm là bắt buộc.',
            'product.name.string' => 'Tên sản phẩm phải là một chuỗi.',
            'product.name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',

            'product.price.required' => 'Giá sản phẩm là bắt buộc.',
            'product.price.numeric' => 'Giá sản phẩm phải là một số.',
            'product.price.min' => 'Giá sản phẩm không được nhỏ hơn 0.',
            'product.price.max' => 'Giá sản phẩm không được vượt quá 100,000,000.',

            'category_id.required' => 'Danh mục sản phẩm là bắt buộc.',
            'category_id.array' => 'Danh mục sản phẩm phải là một mảng.',
            'category_id.min' => 'Danh mục sản phẩm phải chứa ít nhất một phần tử.',
            'category_id.*.exists' => 'Danh mục sản phẩm phải tồn tại trong cơ sở dữ liệu.',

            'product.brand.required' => 'Hãng sản phẩm là bắt buộc.',
            'product.brand.exists' => 'Hãng sản phẩm phải tồn tại trong cơ sở dữ liệu.',

            'product.description.required' => 'Mô tả ngắn là bắt buộc.',
            'product.description.string' => 'Mô tả ngắn phải là một chuỗi.',
            'product.description.max' => 'Mô tả ngắn không được vượt quá 500 ký tự.',

            'product.content.required' => 'Mô tả chi tiết là bắt buộc.',
            'product.content.string' => 'Mô tả chi tiết phải là một chuỗi.',
            'product.content.min' => 'Mô tả chi tiết phải có ít nhất 10 ký tự.',
            'product.content.max' => 'Mô tả chi tiết không được vượt quá 1000 ký tự.',

            // Ảnh đại diện và album
            'img.required' => 'Ảnh đại diện là bắt buộc.',
            'img.image' => 'Ảnh đại diện phải là một hình ảnh hợp lệ.',
            'img.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg, hoặc gif.',
            'img.max' => 'Ảnh đại diện không được vượt quá 2MB.',

            'array_img.required' => 'Mảng ảnh sản phẩm là bắt buộc.',
            'array_img.array' => 'Mảng ảnh sản phẩm phải là một mảng.',
            'array_img.min' => 'Mảng ảnh sản phẩm phải có ít nhất một ảnh.',

            'array_img.*.image' => 'Mỗi ảnh trong mảng phải là một hình ảnh hợp lệ.',
            'array_img.*.mimes' => 'Ảnh trong mảng phải có định dạng jpeg, png, jpg, hoặc gif.',
            'array_img.*.max' => 'Mỗi ảnh trong mảng không được vượt quá 2MB.',

            // Thông tin size
            'product_sizes.required' => 'Thông tin size sản phẩm là bắt buộc.',
            'product_sizes.array' => 'Thông tin size sản phẩm phải là một mảng.',
            'product_sizes.min' => 'Thông tin size sản phẩm phải có ít nhất một size.',

            'product_sizes.*.variant.required' => 'Tên size là bắt buộc.',
            'product_sizes.*.variant.string' => 'Tên size phải là một chuỗi.',
            'product_sizes.*.variant.max' => 'Tên size không được vượt quá 100 ký tự.',

            'product_sizes.*.img.required' => 'Ảnh của size là bắt buộc.',
            'product_sizes.*.img.image' => 'Ảnh của size phải là một hình ảnh hợp lệ.',
            'product_sizes.*.img.mimes' => 'Ảnh của size phải có định dạng jpeg, png, jpg, hoặc gif.',
            'product_sizes.*.img.max' => 'Ảnh của size không được vượt quá 2MB.',

            'product_sizes.*.price.required' => 'Giá của size là bắt buộc.',
            'product_sizes.*.price.numeric' => 'Giá của size phải là một số.',
            'product_sizes.*.price.min' => 'Giá của size không được nhỏ hơn 0.',
            'product_sizes.*.price.max' => 'Giá của size không được vượt quá 100,000,000.',

            'product_sizes.*.quantity.required' => 'Số lượng của size là bắt buộc.',
            'product_sizes.*.quantity.integer' => 'Số lượng của size phải là một số nguyên.',
            'product_sizes.*.quantity.min' => 'Số lượng của size không được nhỏ hơn 0.',
            'product_sizes.*.quantity.max' => 'Số lượng của size không được vượt quá 100,000.',

            'product_sizes.*.status.required' => 'Trạng thái của size là bắt buộc.',
            'product_sizes.*.status.boolean' => 'Trạng thái của size phải là một giá trị boolean.',
        ];
    }
}
