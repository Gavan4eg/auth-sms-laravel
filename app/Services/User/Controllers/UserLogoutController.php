<?php

namespace App\Services\User\Controllers;

use App\Http\Controllers\Controller;
use App\Services\User\Actions\UserLogoutAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UserLogoutController extends Controller
{
    public function __invoke(UserLogoutAction $action): RedirectResponse
    {
        $action->handle();

        return redirect()
            ->route('auth.register');
    }
}
