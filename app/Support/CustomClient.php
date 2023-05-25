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

    public function __construct($options = [])
    {
        $options = array_merge([
            'base_uri' => $this->baseUri(),
            'timeout' => $this->timeout()
        ], $options);
        $this->client = new Client($options);
    }

    abstract protected function baseUri(): string;

    protected function timeout(): int
    {
        return config('support.custom_client.timeout', 10);
    }

    protected function request(string $method, string $url, array $options = [])
    {
        try {
            $options = $this->handleRequest($method, $url, $options);
            $response = $this->client->request($method, $url, $options);

            $data = $this->handleResponse($response);

            return $data;
        } catch (Throwable $throwable) {
            $this->handleException($throwable);
        }
    }

    protected function get(string $url, array $query = [], array $options = [])
    {
        $options['query'] = $query;
        return $this->request('GET', $url, $options);
    }

    protected function postForm(string $url, array $data = [], array $options = [])
    {
        $options['form_params'] = $data;
        return $this->request('POST', $url, $options);
    }

    protected function postJson(string $url, array $data = [], array $options = [])
    {
        $options['json'] = $data;
        return $this->request('POST', $url, $options);
    }

    protected function handleResponse(ResponseInterface $response): mixed
    {
        return $response->getBody()->getContents();
    }

    protected function handleException(Throwable $throwable)
    {
        throw $throwable;
    }

    protected function handleRequest(string $method, string $url, array $options = []): array
    {
        return $options;
    }
}
