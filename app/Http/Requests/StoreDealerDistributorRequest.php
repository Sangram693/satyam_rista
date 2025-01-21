<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreDealerDistributorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();

        return $user && in_array($user->role, ['super_admin', 'admin', 'salesman']);
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
            'bank_statement' => 'nullable|file|mimes:pdf,jpg,png,webp|max:2048',
            'gstin' => 'required|string|max:50|unique:dealer_distributors,gstin',
            'gst_certificate' => 'nullable|file|mimes:pdf,jpg,png,webp|max:2048',
            'did' => 'required|string|max:100|unique:dealer_distributors,did',
            'name' => 'required|string|max:200',
            'phone_number' => 'required|string|max:20|unique:dealer_distributors,phone_number',
            'email' => 'required|string|email|max:200|unique:dealer_distributors,email',
            'user_name' => 'required|string|max:100|unique:dealer_distributors,username',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string',
            'address' => 'nullable|string',
            'zone' => 'nullable|string|max:100',
            'pan_card' => 'required|string|max:50|unique:dealer_distributors,pan_card',
            'type' => 'required|in:dealer,distributor',
            'salesman_id' => ($user->role === 'salesman') ? 'nullable' : 'required|exists:salesmen,id',
        ];
    }
}
