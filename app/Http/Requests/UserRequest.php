<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|max:255,',
            'email' => 'required|max:255',
            'phone' => 'required|numeric',
            'password' => 'required',
            'img' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Họ và tên bắt buộc điền',
            'name.max' => 'Họ và tên không được quá 255 ký tự',

            'email.required' => 'email bắt buộc điền',
            'email.max' => 'email không được quá 255 ký tự',

            'phone.required' => 'số điện thoại bắt buộc điền',
            'phone.numeric' => 'số điện thoại phải là số',

            'password.required' => 'Password bắt buộc điền',

            'img.required' => 'Ảnh bắt buộc điền',

        ];
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> b0a27ac37762a958560fa9b36cbed582e89ed67a
