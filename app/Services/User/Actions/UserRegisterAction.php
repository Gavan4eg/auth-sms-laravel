<?php

namespace App\Services\User\Actions;

use App\Repositories\TurboSms\TurboSmsService;
use App\Services\User\Data\UserRegisterData;
use App\Services\User\Helpers\UserCodeHelper;
use App\Services\User\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class UserRegisterAction
{
    private Session $session;
    private UserCodeHelper $codeHelper;
    private TurboSmsService $smsService;
    private Redis $redis;

    public function __construct(
        TurboSmsService $smsService,
        Session $session,
        Redis $redis,
        UserCodeHelper $codeHelper,
    )
    {
        $this->session = $session;
        $this->codeHelper = $codeHelper;
        $this->smsService = $smsService;
        $this->redis = $redis;
    }

    public function handle(UserRegisterData $data): bool
    {
        $user = $this->findUser($data->phone);

        if ($user) {
            return false;
        }

        $this->saveUserToSession(
            $data->name,
            $data->phone,
        );

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

    private function saveUserToSession(string $name, string $phone): void
    {
        $this->session::put('name', $name);
        $this->session::put('phone', $phone);
    }

    private function sendSms(string $phone): void
    {
        $code = $this->codeHelper->generateCode();

        $message = 'Код реєстрації: ' . $code;

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
