<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:roles,name,' . ($this->role ? $this->role->id : 'null'),
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama peran harus diisi',
            'name.unique' => 'Nama peran sudah digunakan',
        ];
    }
}