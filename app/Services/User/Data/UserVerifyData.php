<?php

namespace App\Services\User\Data;

use Spatie\LaravelData\Data;

class UserVerifyData extends Data
{
    public function __construct(
        public int $code,
    ) {
    }
}
