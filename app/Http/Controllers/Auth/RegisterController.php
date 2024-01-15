<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;

class RegisterController extends Controller
{

    public function create(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::query()->where('phone', $data['phone'])->first();
        if ($user) {
           return redirect()->route('auth.login')->with('error', 'Ви вже є в базі');
        }

        $this->putSession($data['name'],$data['phone']);

        $code = $this->generateCode();

       // Відправка смс

        $this->redisCode($data['phone'],$code);

        return  redirect()->route('auth.verify');

    }

    private function redisCode(string $phone, int $code): void
    {
        Redis::set("sms:{$phone}", $code);
        Redis::expire("sms:{$phone}", 300);
    }

    private function putSession(string $name, string $phone): void
    {
        session()->put('name',$name);
        session()->put('phone',$phone);
    }

    private function generateCode():int
    {
        return rand(1111,9999);
    }

}
