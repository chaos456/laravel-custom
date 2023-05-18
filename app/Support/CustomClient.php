<?php

namespace App\Support;

use App\Support\Traits\InstanceMake;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Throwable;

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

    protected function request(string $method, string $url, array $options = [])
    {
        try {
            $response = $this->client->request($method, $url, $options);

            $data = $this->handleResponse($response);

            return $data;
        } catch (\Throwable $throwable) {
            $this->handleException($throwable);
        }
    }

    protected function get(string $url, array $data = [], array $options = [])
    {
        $options['query'] = $data;
        return $this->request('GET', $url, $options);
    }

    protected function post(string $url, array $options = [])
    {
        return $this->request('POST', $url, $options);
    }

    protected function postJson(string $url, array $data = [], array $options = [])
    {
        $options['json'] = $data;
        return $this->post($url, $options);
    }

    protected function handleResponse(ResponseInterface $response): mixed
    {
        return $response->getBody()->getContents();
    }

    protected function handleException(Throwable $throwable)
    {
        throw $throwable;
    }
}
