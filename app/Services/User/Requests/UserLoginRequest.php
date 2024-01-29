<?php

namespace App\Services\User\Requests;

use App\Services\User\Data\UserLoginData;

class UserLoginRequest extends UserBaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone' => 'required',
        ];
    }

    public function getData(): UserLoginData
    {
        return UserLoginData::from($this->all());
    }
}
