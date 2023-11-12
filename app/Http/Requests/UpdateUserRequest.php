<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdateUserRequest extends FormRequest
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
        $itemID = $this->route('item')?->id;

        return [
            'name' => ['string', 'max:255', Rule::unique(User::class)->ignore($itemID)],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($itemID)],
            'photo' => ['file', File::types(['png', 'jpg', 'jpeg']), 'nullable'],
            'new_password' => ['min:4', 'nullable']
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
