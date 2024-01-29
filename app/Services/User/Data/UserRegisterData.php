<?php

namespace App\Services\User\Data;

use Spatie\LaravelData\Data;

class UserRegisterData extends Data
{
    public function __construct(
        public string $name,
        public string $phone
    ) {
    }
}
