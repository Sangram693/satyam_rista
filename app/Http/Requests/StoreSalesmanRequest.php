<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreSalesmanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->role === 'super_admin' || Auth::user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = Auth::user();

        return [
            'admin_id'      => $user->role === 'super_admin' ? 'required|exists:admins,id' : 'nullable',
            'name'          => 'required|string|max:200',
            'email'         => 'required|string|email|max:200|unique:salesmen,email|unique:sales_people,email',
            'phone'         => 'required|string|regex:/^\+?[0-9]{7,15}$/|unique:salesmen,phone',
            'address'       => 'nullable|string',
            'employee_code' => 'required|string|max:200|unique:salesmen,employee_code',
            'zone'          => 'required|exists:zones,id',
            'hire_date'     => 'required|date',
            'sales_target'  => 'nullable|numeric|min:0',
            'achieved_sales'=> 'nullable|numeric|min:0',
            'user_name' => 'required|string|max:200|unique:sales_people,user_name',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required_with:password|string|min:6',
        ];
    }
}
