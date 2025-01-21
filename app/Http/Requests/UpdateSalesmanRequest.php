<?php

namespace App\Http\Requests;

use App\Models\Salesman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSalesmanRequest extends FormRequest
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
        $salesmanId = $this->route('salesman') instanceof Salesman ? $this->route('salesman')->id : $this->route('salesman');

        return [
            'admin_id'      => $user->role === 'super_admin' ? 'required|exists:admins,id' : 'nullable',
            'name'          => 'nullable|string|max:200',
            'email'         => 'nullable|string|email|max:200|unique:salesmen,email,' . $salesmanId,
            'phone'         => 'nullable|string|regex:/^\+?[0-9]{7,15}$/|unique:salesmen,phone,' . $salesmanId,
            'address'       => 'nullable|string',
            'employee_code' => 'nullable|string|max:200|unique:salesmen,employee_code,' . $salesmanId,
            'zone'          => 'nullable|exists:zones,id',
            'hire_date'     => 'nullable|date',
            'status'        => 'nullable|in:active,inactive,terminated',
            'sales_target'  => 'nullable|numeric|min:0',
            'achieved_sales'=> 'nullable|numeric|min:0'
        ];
    }
}
