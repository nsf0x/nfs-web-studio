<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'website_url'   => ['nullable', 'string', 'max:255'],

            'name'          => ['required', 'string', 'max:100'],
            'email'         => ['required', 'email', 'max:150'],
            'phone'         => ['nullable', 'string', 'max:30'],
            'company'       => ['nullable', 'string', 'max:150'],
            'service_id'    => [
                'nullable',
                'integer',
                Rule::exists('services', 'id')->where(fn ($query) => $query->whereRaw('is_active is true')),
            ],
            'package_id'    => [
                'nullable',
                'integer',
                Rule::exists('packages', 'id')
                    ->where('service_id', $this->input('service_id'))
                    ->where(fn ($query) => $query->whereRaw('is_active is true')),
            ],
            'budget_range'  => ['nullable', 'string', 'max:50'],
            'message'       => ['required', 'string', 'min:10', 'max:5000'],
            'privacy_agree' => ['accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'website_url.string'   => 'Formulir tidak valid.',
            'name.required'        => 'Nama wajib diisi.',
            'email.required'       => 'Email wajib diisi.',
            'email.email'          => 'Format email tidak valid.',
            'message.required'     => 'Pesan wajib diisi.',
            'message.min'          => 'Pesan terlalu pendek (minimal 10 karakter).',
            'privacy_agree.accepted' => 'Anda harus menyetujui Kebijakan Privasi.',
        ];
    }
}
