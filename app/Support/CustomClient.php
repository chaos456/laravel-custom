<?php

namespace App\Support;

use App\Support\Traits\InstanceMake;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

abstract class CustomClient
{
    use InstanceMake;

    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUri(),
            'timeout' => $this->timeout()
        ]);
    }

    abstract protected function baseUri(): string;

    protected function timeout(): int
    {
        return config('support.custom_client.timeout', 10);
    }

    protected function request(string $method, string $url, array $options)
    {
        $response = $this->client->request($method, $url, $options);

        return $this->handleResponse($response);
    }

    protected function get(string $url, array $options)
    {
        $this->request('GET', $url, $options);
    }

    protected function post(string $url, array $options)
    {
        $this->request('POST', $url, $options);
    }

    protected function handleResponse(ResponseInterface $response):mixed
    {

    }

    protected function handleException()
    {

    }
}
