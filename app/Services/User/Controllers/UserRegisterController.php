<?php

namespace App\Services\User\Controllers;

use App\Http\Controllers\Controller;
use App\Services\User\Actions\UserRegisterAction;
use App\Services\User\Requests\UserRegisterRequest;
use Illuminate\Http\RedirectResponse;

class UserRegisterController extends Controller
{
    public function __invoke(
        UserRegisterRequest $request,
        UserRegisterAction $action,
    ): RedirectResponse
    {
        $result = $action->handle($request->getData());

        if (! $result) {
            return redirect()
                ->route('auth.login')
                ->with('error', 'Ви вже є в базі');
        }

        return redirect()
            ->route('auth.verify');
    }
}
