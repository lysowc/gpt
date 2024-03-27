<?php
namespace Lysowc\Gpt;

use GuzzleHttp\Pool;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

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
     * redirect param
     * @var bool 
     */
    protected bool $redirect = false;

    /**
     * request data
     * @var array 
     */
    protected array $data = [];

    /**
     * concurrency requests
     * @param int $requestCount
     * @param int $maxConcurrencyCount
     *
     * @return array
     */
    final protected function concurrency(int $requestCount = 10, int $maxConcurrencyCount = 5): array
    {
        $client = new Client([
            'base_uri' => $this->domain,
            'timeout'  => $this->timeout,
        ]);
        
        //request
        $requests = function ($total) {
            for ($i = 0; $i < $total; $i++) {
                yield new Request($this->method, $this->uri);
            }
        };
        if(!empty($this->headers)){
            $this->data['headers'] = $this->headers;
        }
        $this->data['allow_redirects'] = $this->redirect;
        $success = $error = [];
        $pool = new Pool($client, $requests($requestCount), [
            'concurrency' => $maxConcurrencyCount,
            'options' => $this->data,
            'fulfilled' => function ($response, $index) use (&$success) {
                $success[$index] = $response->getBody()->getContents();
            },
            'rejected' => function ($reason, $index) use (&$error) {
                if($reason instanceof RequestException){
                    $error[$index] = $reason->getResponse()->getBody()->getContents();
                }else{
                    $error[$index] = $reason->getMessage();
                }
            },
        ]);
        // Initiate the transfers and create a promise
        $promise = $pool->promise();
        // Force the pool of requests to complete.
        $promise->wait();
        
        return ['success' => $success, 'error' => $error];
    }

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
        if(!empty($this->headers)){
            $this->data['headers'] = $this->headers;
        }
        $this->data['allow_redirects'] = $this->redirect;
        $response = $client->request($this->method,  $this->uri, $this->data);
        return $response->getBody()->getContents();
    }

    /**
     * query request
     *
     * @param mixed $param
     *
     * @return $this
     */
    final public function query(mixed $param): self
    {
        $this->data['query'] = $param;
        return $this;
    }

    /**
     * body request
     *
     * @param mixed $param
     *
     * @return $this
     */
    final public function body(mixed $param): self
    {
        $this->data['body'] = $param;
        return $this;
    }

    /**
     * json request
     *
     * @param mixed $param
     *
     * @return $this
     */
    final public function json(mixed $param): self
    {
        $this->data['json'] = $param;
        return $this;
    }

    /**
     * form request
     *
     * @param mixed $param
     *
     * @return $this
     */
    final public function form(mixed $param): self
    {
        $this->data['form_params'] = $param;
        return $this;
    }

    /**
     * multipart request
     *
     * @param mixed $param
     *
     * @return $this
     */
    final public function multipart(mixed $param): self
    {
        $this->data['multipart'] = $param;
        return $this;
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
        $this->headers = $headers;
        return $this;
    }

    /**
     * set redirect
     * 
     * @param bool $redirect
     *
     * @return RequestGpt
     */
    final public function setRedirect(bool $redirect): RequestGpt
    {
        $this->redirect = $redirect;
        return $this;
    }
}