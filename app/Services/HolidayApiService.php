<?php

namespace App\Services;

use App\Support\CustomClient;

class HolidayApiService extends CustomClient
{
    protected function baseUri(): string
    {
        return 'http://tool.bitefu.net';
    }

    public function dayInfo(string $day, array $data = ['back' => 'json']): array
    {
        $data['d'] = $day;
        return $this->get('/jiari', $data);
    }
}
