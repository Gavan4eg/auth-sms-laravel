<?php

namespace App\Services\User\Requests;

use App\Services\User\Data\UserVerifyData;
use Illuminate\Foundation\Http\FormRequest;

class UserVerifyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'int',
            ],
        ];
    }

    public function getData(): UserVerifyData
    {
        return UserVerifyData::from($this->all());
    }
}
