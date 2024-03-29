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
use GuzzleHttp\Exception\RequestException;

$apikey = "YOUR_API_KEY";
$gpt = new RequestAliGpt($apikey);
//json response
//see https://help.aliyun.com/zh/dashscope/developer-reference/api-details
$params = [
    'model' => 'qwen-turbo',
    'input' => [
        'prompt' => "your question",
    ],
];
try {
    $result = $gpt->json($params)->send();
} catch (RequestException $e) {
    $result = $e->getResponse()->getBody()->getContents();
} catch (Exception $e) {
    $result = $e->getMessage();
}
$result = json_encode($result,true);
var_dump($result);

```
## different requests

````php
//json request
$gpt = new RequestAliGpt($apikey);
$params = [];//your parameters
$gpt->json($params)->send();


//form request
$gpt = new RequestAliGpt($apikey);
$params = [];//your parameters
$gpt->form($params)->send();


//query request
$gpt = new RequestAliGpt($apikey);
$params = [];//your parameters
$gpt->query($params)->send();


//body request
$gpt = new RequestAliGpt($apikey);
$params = [];//your parameters
$gpt->body($params)->send();


//multipart request
$gpt = new RequestAliGpt($apikey);
$params = [];//your parameters
$result = $gpt->multipart($params)->send();


//multipart request
$gpt = new RequestAliGpt($apikey);
$params = [];//your parameters
$result = $gpt->json/form/query/body/multipart($params)->concurrency(10,5);
//10  => Total concurrency
//5   => The number of requests per request
//$result = [
//    'success' => [
//        [
//            index => index response
//        ]
//        ...
//    ],
//    'error' => [
//        [
//            index => error response
//        ]
//        ...
//    ]
//];
````

## Base URL

You can specify Origin URL with `setDomain()` method;

````php
$gpt = new RequestAliGpt($apikey);
$gpt->setDomain('https://example.com');
````

## uri

You can specify Origin URL with `setUri()` method;

````php
$gpt = new RequestAliGpt($apikey);
$gpt->setUri('/api/v1/chat/test');
````

## Set apikey

 ```php
$gpt->setApiKey("YOUR_API_KEY");
```

## Set header

 ```php
$gpt->setHeaders(["Connection"=>"keep-alive"]);
```