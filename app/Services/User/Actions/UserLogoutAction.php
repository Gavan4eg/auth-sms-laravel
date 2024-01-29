<?php

namespace App\Services\User\Actions;

use Illuminate\Support\Facades\Auth;

class UserLogoutAction
{
    private Auth $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle(): void
    {
        $this->auth::logout();
    }
}
