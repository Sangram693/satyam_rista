<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreBillRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'invoice_number' => 'required|string|max:50|unique:bills,invoice_number',
            'bill_file' => 'required|max:2048|mimes:pdf,jpg,png,webp',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:paid,unpaid',
        ];
    }
}
