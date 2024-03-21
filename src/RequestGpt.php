<?php
namespace Lysowc\Gpt;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * request gpt
 * 
 * @author lysowc
 * @time 2024-03-21
 */
class RequestGpt
{
    /**
     * request domain
     *
     * @var string
     */
    protected string $domain;

    /**
     * request uri
     *
     * @var string
     */
    protected string $uri;

    /**
     * request method
     *
     * @var string
     */
    protected string $method = 'POST';

    /**
     * default gpt model
     *
     * @var string
     */
    protected string $model;

    /**
     * default timeout
     *
     * @var int
     */
    protected int $timeout = 5;

    /**
     * api key
     *
     * @var string
     */
    protected string $apiKey;

    /**
     * request headers
     *
     * @var array
     */
    protected array $headers = [
        'Content-Type' => 'application/json',
    ];

    /**
     * send request
     *
     * @param array $params
     *
     * @return string
     * @throws GuzzleException
     */
    final protected function request(array $params): string
    {
        $client = new Client([
            'base_uri' => $this->domain,
            'timeout'  => $this->timeout,
        ]);
        if($this->model){
            $model = [
                'model' => $this->model
            ];
            $params = array_merge($model,$params);
        }
        $response = $client->request($this->method,  $this->uri, [
            'headers' => $this->headers,
            'json' => $params,
        ]);
        return $response->getBody()->getContents();
    }

    /**
     * set domain
     *
     * @param string $domain
     *
     * @return $this
     */
    final public function setDomain(string $domain): RequestGpt
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * set uri
     *
     * @param string $uri
     *
     * @return $this
     */
    final public function setUri(string $uri): RequestGpt
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * set method
     *
     * @param string $method
     *
     * @return $this
     */
    final public function setMethod(string $method): RequestGpt
    {
        $this->method = $method;
        return $this;
    }

    /**
     * set model
     *
     * @param string $model
     *
     * @return $this
     */
    final public function setModel(string $model): RequestGpt
    {
        $this->model = $model;
        return $this;
    }

    /**
     * set timeout
     *
     * @param int $timeout
     *
     * @return $this
     */
    final public function setTimeOut(int $timeout): RequestGpt
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * set apiKey
     *
     * @param string $apiKey
     *
     * @return $this
     */
    final public function setApiKey(string $apiKey): RequestGpt
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    /**
     * set headers
     *
     * @param array $headers
     *
     * @return $this
     */
    final public function setHeaders(array $headers): RequestGpt
    {
        $this->headers = array_merge($this->headers, $headers);
        return $this;
    }
}