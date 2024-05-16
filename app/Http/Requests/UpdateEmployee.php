<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateEmployee extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "first_name" => "required",
            "last_name" => "required",
            "national_id" => "required",
            "nationality" => "required",
            "gender" => "required",
            "date_of_birth" => "required|date",
            "email" => "required|email",
            "phone_number" => "required",
            "address" => "required",
            "salary" => "required|numeric",
            "emergency_contact" => "required",
            "cv" => "nullable|mimes:pdf", // Validate CV file
            'image' => 'nullable|file|image|mimes:jpeg,png,jpg,gif|max:80000',
            "position" => "required",
            "training" => "nullable",
        ];

    }
}
