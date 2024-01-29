<?php

namespace App\Services\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserBaseRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone' => $this->cleanPhone($this->input('phone')),
        ]);
    }

    private function cleanPhone(string $phone): string
    {
        return preg_replace('/[^0-9]+/','',$phone);
    }
}
