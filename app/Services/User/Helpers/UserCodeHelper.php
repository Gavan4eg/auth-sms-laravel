<?php

namespace App\Services\User\Helpers;

class UserCodeHelper
{
    public function generateCode(): string
    {
        return rand(1111, 9999);
    }
}
