<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class VerifyController extends Controller
{
    public function verifyCode(Request $request)
    {
        $phone = session('phone');
        $name = session('name');
        $code = $request->get('code');

        $result = $this->validateVerificationCode($phone, $code);

        $user = User::query()->where('phone', $phone)->first();

        if ($result) {
            if (!$user) {
                $this->createUser($name, $phone);
                return redirect()->route('front.index');
            }

            $this->loginUser($phone);

        }

        return redirect()->route('auth.verify')->with('error', 'Код не вірний');
    }

    private function validateVerificationCode(string $phone, int $code): bool
    {
        $storeCode = Redis::get("sms:{$phone}");

        return $storeCode && $code == $storeCode;
    }

    private function createUser($name, $phone): void
    {
        $user = User::create(
            [
                'name' => $name,
                'phone' => $phone
            ]
        );

        Auth::login($user);
    }

    private function loginUser($phone): void
    {
        $user = User::query()->where('phone', $phone)->first();

        Auth::login($user);
    }
}
