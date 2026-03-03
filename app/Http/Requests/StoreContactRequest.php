<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email', 'max:150'],
            'phone'   => ['required', 'string', 'max:30'],
            'subject' => ['nullable', 'string', 'max:200'],
            'message' => ['required', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'    => __('contact.validation_name_required'),
            'email.required'   => __('contact.validation_email_required'),
            'email.email'      => __('contact.validation_email_invalid'),
            'phone.required'   => __('contact.validation_phone_required'),
            'message.required' => __('contact.validation_message_required'),
        ];
    }
}
