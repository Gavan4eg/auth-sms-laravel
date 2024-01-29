<?php

namespace App\Services\User\Models;

use App\Services\User\Queries\UserQueryBuilder;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @method static UserQueryBuilder query()
 */
class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'phone',
    ];

    public function newEloquentBuilder($query): UserQueryBuilder
    {
        return new UserQueryBuilder($query);
    }
}
