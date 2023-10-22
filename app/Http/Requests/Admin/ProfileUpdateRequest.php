<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
                'avatar' => ['nullable','image','max:3000'],
                'name' => ['required','string','max:50'],
                'email'=> ['required','string','email','max:200','unique:users,email,'.auth()->user()->id], //perdorim .auth()->user()->id per me check nese email eshte unique me krejt emailat tjer perveq tones , prandaj japim id tone

        ];
    }
}
