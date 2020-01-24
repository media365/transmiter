<?php


namespace Media365\Transmitter\Services;

use GuzzleHttp\Client;

class Textvertising implements SMS
{
    public static $statusMap = [
        'FAILED LOGIN'      => 'Your API key is invalid or was omitted',
        'ACCOUNT PROBLEM:(.*)'  => 'Your account is barred or another problem exists. [RESPONSE_MESSAGE] will be replaced by a specific error.',
        'MESSAGE TOO LONG'  => 'The submitted message is longer than 160 characters',
        'ONE OR MORE MOBILE NUMBERS IS INVALID ' => 'One or more of the numbers submitted is either too long, too short, is not a valid mobile number or does not start with 447… If the response style is XML it means that there were no valid numbers found at all.',
        'MESSAGE CONTAINS INVALID CHARACTERS AT POSITION(.*)' => 'The message contains an invalid character that cannot be accepted by the network. Where applicable [RESPONSE_MESSAGE] will be replace by the position of character(s).',
        'SMSID TOO LONG' => 'The sender ID is longer than 11 characters if Alphanumeric or 13 numbers if Numeric.',
        'EXPIRY WRONG FORMAT' => 'No longer supported',
        'NO NUMBERS' => 'Your submission contains no valid mobile numbers or the wrong delimiter was used to seperate them.',
        'NUMBER BARRED' => 'The number you are submitting to has text stop or has been barred by the platform/network from receiving messages.',
        'NOT ENOUGH FREE MESSAGES ' => 'You have run out of SMS credits messages and should top up your account.',
    ];

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

        $content = $response->contents ?? '';
        foreach (SMS::$statusMap as $statusPattern => $message) {
            if( preg_match("/{$statusPattern}/i", $content, $matches) ) {
                $responseMessage = $matches[1] ?? '';
                $errorMessage = str_replace('[RESPONSE_MESSAGE]', $responseMessage, $message);
                throw new \Exception("SMS sending failed to $mobile. Response: $content. Message: $errorMessage");
            }
        }

        if ($content) {
            return true;
        }

        throw new \Exception("SMS sending failed to $mobile");
    }
}
