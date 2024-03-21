<?php
namespace Lysowc\Gpt\Repositories\OpenAi;

use RuntimeException;
use Lysowc\Gpt\RequestGpt;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Request OpenAi Gpt
 *
 * @author lysowc
 * @time   2024-03-21
 */
class RequestOpenAiGpt extends RequestGpt
{
    /**
     * request domain
     *
     * @var string
     */
    protected string $domain = 'https://api.openai.com/';

    /**
     * request uri
     *
     * @var string
     */
    protected string $uri = '/v1/chat/completions';

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
    protected string $model = 'gpt-3.5-turbo';

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
    protected string $apiKey = 'Bearer ';

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
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        if(!$apiKey){
            throw new RuntimeException("Invalid API Key");
        }
        $this->apiKey .= $apiKey;
        $this->headers['Authorization'] = $this->apiKey;
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