<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    // this function in generall tell whast the data must look like 
    public function rules(): array
    {
        // we add this also for the rules for the email and password
        return [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ];
    }
// helps us display the error message (we add it) comes from the above function we write 
    public function message(){
        return [
            'email.required' => 'Email is required',
            'email.email'   =>'Valid Email is required!',
            'password.required' => 'password is required',
        ];
    }
}
