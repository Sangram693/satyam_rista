<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSuperAdminRequest extends FormRequest
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
            'name' => 'required|string|max:200',
            'email' => 'required|email|unique:super_admins,email|unique:sales_people,email',
            'phone' => 'required|string|regex:/^\+?[0-9]{7,15}$/|unique:super_admins,phone',
            'address' => 'nullable|string',
            'employee_code' => 'required|string|max:200|unique:super_admins,employee_code',
            'hire_date' => 'required|date',
            'status' => 'nullable|in:active,inactive,terminated|default:active',
            'sales_target' => 'nullable|numeric',
            'achieved_sales' => 'nullable|numeric',
            'user_name' => 'required|string|max:200|unique:sales_people,user_name',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required_with:password|string|min:6', 
        ];
    }
}
