<?php

namespace App\Support;

use App\Support\Traits\InstanceMake;
use GuzzleHttp\Client;

abstract class CustomClient
{
    use InstanceMake;

    protected Client $client;
    public function __construct()
    {
        $this->client = new Client();
    }

    abstract protected function baseUri();

    protected function timeout(): int
    {
        return config('support.custom_client.timeout', 10);
    }

    public function request(string $url, array $data, string $method, array $options, array $header)
    {
//        $this->client->
//        $this->client->request('');
    }

    protected function handleResponse()
    {

    }

    protected function handleException()
    {

    }
}
