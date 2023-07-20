<?php

namespace App\Services;

use App\Support\Http\UnityHttpClient;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ExampleApiService extends UnityHttpClient
{
    // 该api service 的base uri
    protected function baseUri(): string
    {
        return 'http://tool.bitefu.net';
    }

    // 请求超时时间
    protected function timeout(): int
    {
        return parent::timeout(); // TODO: Change the autogenerated stub
    }

    // 该api service具体功能
    public function dayInfo(string $day, array $data = ['back' => 'json']): array
    {
        $data['d'] = $day;
        return $this->get('/jiari', $data);
    }

    // 请求前置操作，可在每次请求前进行，如记录日志，生成签名参数，在请求头加入trace id等
    protected function handleRequest(string $method, string $url, array $options = []): array
    {
        return parent::handleRequest($method, $url, $options); // TODO: Change the autogenerated stub
    }

    // 得到响应后置操作（），可以在此将响应结果进行处理，如将响应json_decode等
    // 默认操作是将响应结果视为json，经过decode之后再返回
    protected function handleResponse(ResponseInterface $response): mixed
    {
        return parent::handleResponse($response); // TODO: Change the autogenerated stub
    }

    // 请求遇到异常操作，开发者自定义请求异常后进行哪些操作
    protected function handleException(Throwable $throwable)
    {
        parent::handleException($throwable); // TODO: Change the autogenerated stub
    }
}