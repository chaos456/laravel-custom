<?php

namespace App\Services;

use App\Support\CustomClient;
use Psr\Http\Message\ResponseInterface;

class HolidayApiService extends CustomClient
{
    protected function baseUri(): string
    {
        return 'http://tool.bitefu.net';
    }

    protected function handleResponse(ResponseInterface $response): array
    {
        return json_decode(parent::handleResponse($response), true);
    }

    public function dayInfo(string $day, array $data = ['back' => 'json']): array
    {
        $data['d'] = $day;
        return $this->get('/jiari', $data);
    }
}
