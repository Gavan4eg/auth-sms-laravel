<?php

namespace App\Services\User\Actions;

use App\Repositories\TurboSms\TurboSmsService;
use App\Services\User\Data\UserLoginData;
use App\Services\User\Helpers\UserCodeHelper;
use App\Services\User\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class UserLoginAction
{
    private TurboSmsService $smsService;

    private Session $session;

    private Redis $redis;
    private UserCodeHelper $codeHelper;

    public function __construct(
        TurboSmsService $smsService,
        Session $session,
        Redis $redis,
        UserCodeHelper $codeHelper,
    )
    {
        $this->smsService = $smsService;
        $this->session = $session;
        $this->redis = $redis;
        $this->codeHelper = $codeHelper;
    }

    public function handle(UserLoginData $data): bool
    {
        $user = $this->findUser($data->phone);

        if (! $user) {
            return false;
        }

        $this->savePhoneToSession($data->phone);
        $this->sendSms($data->phone);

        return true;
    }

    private function findUser(string $phone): ?User
    {
        /** @var User | null $user */
        $user = User::query()
            ->phone($phone)
            ->first();

        return $user;
    }

    private function savePhoneToSession(string $phone): void
    {
        $this->session::put('phone', $phone);
    }

    private function sendSms(string $phone): void
    {
        $code = $this->codeHelper->generateCode();

        $message = 'Код авторизації: ' .  $code;

        $this->smsService->sendSms($phone, $message);

        $this->saveCodeToRedis($phone, $code);
    }

    private function saveCodeToRedis(string $phone, int $code): void
    {
        $key = 'sms:' . $phone;

        $this->redis::set($key, $code);
        $this->redis::expire($key, 300);
    }
}
