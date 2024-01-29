<?php

namespace App\Services\User\Requests;

use App\Services\User\Data\UserRegisterData;

class UserRegisterRequest extends UserBaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'phone' => 'required',
        ];
    }

    public function getData(): UserRegisterData
    {
        return UserRegisterData::from($this->all());
    }
}
