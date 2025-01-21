<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->role === 'super_admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:200',
            'email' => 'sometimes|email|unique:admins,email,' . $this->route('admin'),
            'phone' => 'sometimes|string|regex:/^\\+?[0-9]{7,15}$/|unique:admins,phone,' . $this->route('admin'),
            'address' => 'nullable|string',
            'employee_code' => 'sometimes|string|max:200|unique:admins,employee_code,' . $this->route('admin'),
            'hire_date' => 'sometimes|date',
            'status' => 'sometimes|in:active,inactive,terminated',
            'sales_target' => 'nullable|numeric',
            'achieved_sales' => 'nullable|numeric',
        ];
    }
}
