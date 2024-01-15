<?php

namespace App\Console\Commands;

use App\Services\TurboSms\TurboSmsService;
use Illuminate\Console\Command;

class SendTurboSms extends Command
{
    protected $signature = 'app:send-turbo-sms';

    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(TurboSmsService $turboSmsService)
    {
        $phone = '380997275696';
        $message = 'Test';

        $result = $turboSmsService->sendSms($phone, $message);

        dd($result);
    }
}
