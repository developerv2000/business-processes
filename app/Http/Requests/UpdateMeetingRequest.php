<?php

namespace App\Http\Requests;

use App\Models\Meeting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMeetingRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $itemID = $this->route('item')?->id;

        return [
            'manufacturer_id' => 'required|exists:manufacturers,id',

            'year' => [
                'required',
                Rule::unique(Meeting::class)->ignore($itemID)->where(function ($query) {
                    $query->where('manufacturer_id', $this->manufacturer_id);
                }),
            ],
        ];
    }
    
    public function messages(): array
    {
        return [
            'year.unique' => trans('validation.unique-meeting'),
        ];
    }
}
