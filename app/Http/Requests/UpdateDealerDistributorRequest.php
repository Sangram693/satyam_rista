<?php

namespace App\Http\Requests;

use App\Models\DealerDistributor;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDealerDistributorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = Auth::user();

        $dealerDistributorId = $this->route('dealer_distributor') instanceof DealerDistributor
        ? $this->route('dealer_distributor')->id
        : $this->route('dealer_distributor');
    

        return [
            'bank_statement' => 'nullable|file|mimes:pdf,jpg,png,webp|max:2048',
            'gstin' => 'nullable|string|max:50|unique:dealer_distributors,gstin,' . $dealerDistributorId,
            'gst_certificate' => 'nullable|file|mimes:pdf,jpg,png,webp|max:2048',
            'did' => 'nullable|string|max:100|unique:dealer_distributors,did,' . $dealerDistributorId,
            'name' => 'nullable|string|max:200',
            'phone_number' => 'nullable|string|max:20|unique:dealer_distributors,phone_number,' . $dealerDistributorId,
            'email' => 'nullable|string|email|max:200|unique:dealer_distributors,email,' . $dealerDistributorId,
            'address' => 'nullable|string',
            'zone' => 'nullable|integer|exists:zones,id',
            'pan_card' => 'nullable|string|max:50|unique:dealer_distributors,pan_card,' . $dealerDistributorId,
            'type' => 'nullable|in:dealer,distributor',
            'salesman_id' => 'nullable|exists:salesmen,id',
        ];
    }
}
