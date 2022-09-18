<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:60',
            'email' => 'required|unique:users|string|email|min:2|max:100',
            'phone' => 'required|string|regex:^[\+]{0,1}380([0-9]{9})$^',
            'position_id' => 'required|int|exists:positions,id',
            'photo' => [
                'required',
                'mimes:jpg,jpeg',
                File::image()
                    ->max(5 * 1024)
                    ->dimensions(Rule::dimensions()->minWidth(70)->minHeight(70)),
            ],
        ];
    }
}
