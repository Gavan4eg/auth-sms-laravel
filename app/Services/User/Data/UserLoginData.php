<?php

namespace App\Services\User\Data;

use Spatie\LaravelData\Data;

class UserLoginData extends Data
{
    public function __construct(
        public string $phone,
    ) {
    }
}
