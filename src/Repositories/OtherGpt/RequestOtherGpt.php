<?php
namespace Lysowc\Gpt\Repositories\OtherGpt;

use RuntimeException;
use Lysowc\Gpt\RequestGpt;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Request Other Gpt
 *
 * @author lysowc
 * @time   2024-03-21
 */
class RequestOtherGpt extends RequestGpt
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
     * init
     */
    public function __construct()
    {
        $this->checkRequestParam();
    }

    /**
     * Check necessary parameters
     * @return void
     * @throws RuntimeException
     */
    private function checkRequestParam(): void
    {
        if(!$this->domain){
            throw new RuntimeException("Invalid domain");
        }
        if(!$this->uri){
            throw new RuntimeException("Invalid uri");
        }
    }

    /**
     * send request
     *
     * @param array $params
     *
     * @return string
     * @throws GuzzleException
     */
    final public function send(array $params): string
    {
        return $this->request($params);
    }
}