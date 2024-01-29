<?php

namespace App\Services\User\Actions;

use App\Services\User\Data\UserVerifyData;
use App\Services\User\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class UserVerifyAction
{
    private Session $session;
    private Auth $auth;
    private Redis $redis;

    public function __construct(
        Session $session,
        Auth $auth,
        Redis $redis,
    )
    {
        $this->session = $session;
        $this->auth = $auth;
        $this->redis = $redis;
    }

    public function handle(UserVerifyData $data): bool
    {
        $phone = $this->getPhone();
        $name = $this->getName();

        if (empty($name) or empty($phone)) {
            return false;
        }

        $isCodeValid = $this->checkCode(
            $phone,
            $data->code,
        );

        if (! $isCodeValid) {
            return false;
        }

        $this->findOrCreateUser($name, $phone);

        return true;
    }

    private function getPhone(): ?string
    {
        return $this->session::get('phone');
    }

    private function getName(): ?string
    {
        return $this->session::get('name');
    }

    private function checkCode(string $phone, int $code): bool
    {
        $redisCode = $this->redis::get('sms:' . $phone);

        return $code == $redisCode;
    }

    private function findOrCreateUser(string $name, string $phone): void
    {
        /** @var User | null $user */
        $user = User::query()
            ->phone($phone)
            ->first();

        if ($user) {
            $this->authUser($user);

            return;
        }

        $user = $this->createUser($name, $phone);

        $this->authUser($user);
    }

    private function authUser(User $user): void
    {
        $this->auth::login($user);
    }

    private function createUser(string $name, string $phone): User
    {
        /** @var User $user */
        $user = User::query()
            ->create([
                'name' => $name,
                'phone' => $phone,
            ]);

        return $user;
    }
}
