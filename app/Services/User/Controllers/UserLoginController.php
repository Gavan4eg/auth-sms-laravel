<?php

namespace App\Services\User\Controllers;

use App\Http\Controllers\Controller;
use App\Services\User\Actions\UserLoginAction;
use App\Services\User\Requests\UserLoginRequest;
use Illuminate\Http\RedirectResponse;


class UserLoginController extends Controller
{
    public function __invoke(
        UserLoginRequest $request,
        UserLoginAction $action,
    ): RedirectResponse
    {
        $result = $action->handle($request->getData());

        if (! $result) {
            return redirect()->route('auth.register');
        }

        return redirect()->route('auth.verify');
    }
}
