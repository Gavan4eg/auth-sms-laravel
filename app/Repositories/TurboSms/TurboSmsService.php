<?php

namespace App\Repositories\TurboSms;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class TurboSmsService
{
    protected string $url;
    protected string $token;
    protected Client $client;

    public function __construct()
    {
        $this->token = config('turbosms.token');
        $this->url = config('turbosms.url');
        $this->client = new Client();
    }

    public function sendSms($phone, $message): string
    {
        try {
            $response = $this->client->post($this->url, [
                'headers' =>
                    [
                        'Content-Type' => 'application/x-www-form-urlencoded',
                        'Authorization' => $this->token
                    ],
                'form_params' => $this->arrayParams($phone, $message)
            ]);

            return $response->getBody()->getContents();

        } catch (RequestException $requestException) {

            return $requestException->getMessage();
        }
    }

    private function arrayParams($phone, $message): array
    {
        return [
            'recipients' => [$phone],
            'sms' => ['sender' => 'PHPUkraine', 'text' => $message]
        ];
    }

}
