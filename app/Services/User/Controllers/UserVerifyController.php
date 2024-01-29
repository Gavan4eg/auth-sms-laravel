<?php

namespace App\Services\User\Controllers;

use App\Http\Controllers\Controller;
use App\Services\User\Actions\UserVerifyAction;
use App\Services\User\Requests\UserVerifyRequest;
use Illuminate\Http\RedirectResponse;

class UserVerifyController extends Controller
{
    public function __invoke(
        UserVerifyRequest $request,
        UserVerifyAction $action,
    ): RedirectResponse
    {
        $result = $action->handle($request->getData());

        if (! $result) {
            return redirect()
                ->route('auth.verify')
                ->with('error', 'Код не вірний');
        }

        return redirect()->route('front.index');
    }
}
