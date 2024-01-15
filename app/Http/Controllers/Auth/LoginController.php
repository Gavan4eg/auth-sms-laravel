<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Services\TurboSms\TurboSmsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class LoginController extends Controller
{
    public function loginUser(LoginRequest $request): RedirectResponse
    {
        $turboSmsService = new TurboSmsService();

        $data = $request->validated();

        $user = User::query()->where('phone', $data['phone'])->first();

        if (!$user) {
            return redirect()->route('auth.register');
        }

        $this->putSession($data['phone']);

        $code = $this->generateCode();

        $message = 'Код авторизації: ' . $code;

        $turboSmsService->sendSms($data['phone'], $message);

        $this->redisCode($data['phone'], $code);

        return redirect()->route('auth.verify');
    }


    private function redisCode(string $phone, int $code): void
    {
        Redis::set("sms:{$phone}", $code);
        Redis::expire("sms:{$phone}", 300);
    }

    private function putSession(string $phone): void
    {
        session()->put('phone', $phone);
    }

    private function generateCode(): int
    {
        return rand(1111, 9999);
    }
}
