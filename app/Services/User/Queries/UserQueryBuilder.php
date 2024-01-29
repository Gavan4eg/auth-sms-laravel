<?php

namespace App\Services\User\Queries;

use Illuminate\Database\Eloquent\Builder;

class UserQueryBuilder extends Builder
{
    public function phone(string $phone): self
    {
        return $this->where('phone', $phone);
    }
}
