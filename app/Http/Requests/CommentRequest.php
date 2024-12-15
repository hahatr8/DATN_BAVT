<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'content' => 'required|string|min:5|max:1000',
            'user_id' => 'required|exists:users,id',
            'product_id' => 'nullable|exists:products,id',
            'blog_id' => 'nullable|exists:blogs,id',
            'status' => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'Nội dung bình luận không được để trống.',
            'content.string' => 'Nội dung bình luận phải là chuỗi ký tự.',
            'content.min' => 'Nội dung bình luận phải có ít nhất 5 ký tự.',
            'content.max' => 'Nội dung bình luận không được vượt quá 1000 ký tự.',
            'user_id.required' => 'Người dùng là bắt buộc.',
            'user_id.exists' => 'Người dùng không hợp lệ.',
            'product_id.exists' => 'Sản phẩm không hợp lệ.',
            'blog_id.exists' => 'Bài viết không hợp lệ.',
            'status.boolean' => 'Trạng thái phải là true hoặc false.',
        ];
    }
}
