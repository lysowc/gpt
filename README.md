# PHP Request GPT

## Installation

You can install the package via composer:

```bash
composer require lysowc/gpt
```

## Quick Start ⚡

Create your `index.php` file and paste the following code part into the file.

```php
<?php

require __DIR__ . '/vendor/autoload.php'; // remove this line if you use a PHP Framework.

//use aliyun gpt
use Lysowc\Gpt\Repositories\AliGpt\RequestAliGpt;
//use openai gpt
use Lysowc\Gpt\Repositories\OpenAi\RequestOpenAiGpt;
//use other gpt
use Lysowc\Gpt\Repositories\OtherGpt\RequestOtherGpt;
use GuzzleHttp\Exception\RequestException;

$apikey = "YOUR_API_KEY";
$gpt = new AliGpt($apikey);
//json response
//see https://help.aliyun.com/zh/dashscope/developer-reference/api-details
try {
    $result = $gpt->send([
        'model' => 'qwen-max',// open if you want use other 
        'input' => [
            'prompt' => "your question",
        ],
    ]);
} catch (RequestException $e) {
    $result = $e->getResponse()->getBody()->getContents();
} catch (Exception $e) {
    $result = $e->getMessage();
}
$result = json_encode($result,true);

$headers = [
    ////chose anyone
    //'Accept' => 'text/event-stream',
    //'X-DashScope-SSE' => 'enable',
];
//stream
try {
    $result = $gpt->setHeaders($headers)->send([
        'model' => 'qwen-max',// open if you want use other model,

        'input' => [
            'prompt' => "your question",
            'parameters' => [
                'incremental_output' => true,
            ]
        ],
    ]);
} catch (RequestException $e) {
    $result = $e->getResponse()->getBody()->getContents();
} catch (Exception $e) {
    $result = $e->getMessage();
}
$result = json_encode($result,true);





$gpt = new OpenAiGpt($apikey);

//json res
//see https://platform.openai.com/docs/api-reference/chat/create
try {
    $result = $gpt->send([
        //'model' => 'gpt-3.5-turbo',// open if you want use other model, default gpt-3.5-turbo
        'messages' => [
            [
                "role" => "system",
                "content" => "You are a helpful assistant."
            ],
            [
                "role" => "user",
                "content" => "Who won the world series in 2020?"
            ],
            [
                "role" => "assistant",
                "content" => "The Los Angeles Dodgers won the World Series in 2020."
            ],
            [
                "role" => "user",
                "content" => "Where was it played?"
            ],
        ],
        'temperature' => 1.0,
        'max_tokens' => 4000,
        'frequency_penalty' => 0,
        'presence_penalty' => 0,
    ]);
} catch (RequestException $e) {
    $result = $e->getResponse()->getBody()->getContents();
} catch (Exception $e) {
    $result = $e->getMessage();
}
$result = json_encode($result,true);


//stream res
try {
    $result = $gpt->send([
        //'model' => 'gpt-3.5-turbo',// open if you want use other model, default gpt-3.5-turbo
        'messages' => [
            [
                "role" => "system",
                "content" => "You are a helpful assistant."
            ],
            [
                "role" => "user",
                "content" => "Who won the world series in 2020?"
            ],
            [
                "role" => "assistant",
                "content" => "The Los Angeles Dodgers won the World Series in 2020."
            ],
            [
                "role" => "user",
                "content" => "Where was it played?"
            ],
        ],
        'temperature' => 1.0,
        'max_tokens' => 4000,
        'frequency_penalty' => 0,
        'presence_penalty' => 0,
        'stream' => true,
    ]);
} catch (RequestException $e) {
    $result = $e->getResponse()->getBody()->getContents();
} catch (Exception $e) {
    $result = $e->getMessage();
}
$result = json_encode($result,true);

var_dump($result);
```

## Base URL

You can specify Origin URL with `setDomain()` method;

````php
$gpt = new OpenAiGpt($apikey);
$gpt->setDomain('https://example.com');
````

## uri

You can specify Origin URL with `setUri()` method;

````php
$gpt = new OpenAiGpt($apikey);
$gpt->setUri('/api/v1/chat/test');
````

## Set apikey

 ```php
$gpt->setApiKey(["Connection"=>"keep-alive"]);
```

## Set header

 ```php
$gpt->setHeaders(["Connection"=>"keep-alive"]);
```