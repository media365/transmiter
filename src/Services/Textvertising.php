<?php


namespace Media365\Transmitter\Services;

use GuzzleHttp\Client;

class Textvertising implements SMS
{
    public function send(string $mobile, string $text)
    {
        $queryParams = $this->buildQuery($mobile, $text);
        $this->callSendingApi($mobile, $queryParams);
    }

    private function buildQuery(string $mobile, string $text)
    {
        $configs = config('transmitter.drivers.textvertising');

        return [
            'numbers' => $mobile,
            'smsid' => $configs['sender'],
            'user' => $configs['username'],
            'pass' => $configs['password'],
            'respond' => 'no',
            'message' => $text,
            'notify' => 'yes',
            'apikey' => $configs['api_key'],
        ];
    }

    private function callSendingApi(string $mobile, $queryParams)
    {
        $headers = ['Content-type' => 'application/x-www-form-urlencoded'];
        $url = config('transmitter.drivers.textvertising.url');

        $client = new Client();
        $response = $client->post($url, ['form_params' => $queryParams, 'headers' => $headers]);

        if ($response) {
            return true;
        }

        throw new \Exception("SMS sending failed to $mobile: " . $response->getBody()->getContents());
    }
}
