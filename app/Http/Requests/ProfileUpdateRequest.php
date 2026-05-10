<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'username' => [
                'nullable',
                'string',
                'max:50',
                'regex:/^[a-zA-Z0-9_\.]+$/',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'ic_number' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[0-9\-]+$/',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'username.regex'    => 'Nama pengguna hanya boleh mengandungi huruf, nombor, underscore (_) dan titik (.).',
            'username.unique'   => 'Nama pengguna ini telah digunakan.',
            'ic_number.regex'   => 'No. IC hanya boleh mengandungi nombor dan tanda sempang (-).',
            'ic_number.unique'  => 'No. IC ini telah didaftarkan.',
        ];
    }
}
