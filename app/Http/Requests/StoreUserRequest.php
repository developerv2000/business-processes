<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255', Rule::unique(User::class)],
            'email' => ['email', 'max:255', Rule::unique(User::class)],
            'photo' => ['file', File::types(['png', 'jpg', 'jpeg'])],
            'password' => ['min:4']
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => trans('validation.unique-user-name'),
            'email.unique' => trans('validation.unique-user-email'),
        ];
    }
}
