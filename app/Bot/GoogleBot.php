<?php

namespace App\Bot;

use GuzzleHttp\Client as Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use App\Helper\Logger;

use DialogFlow\Model\Query;
use DialogFlow\Method\QueryApi;

class GoogleBot implements BotInterface
{
    protected $client;
    protected $logger;
    private $accessToken;

    function __construct()
    {
        $this->accessToken = getenv('DF_CLIENT_ACCESS_TOKEN');
        $this->client = new \DialogFlow\Client($this->accessToken);

        $this->logger = new Logger();
    }

    public function sendMessage($input)
    {

    }

    public function readMessage($input)
    {
        $query = $this->client->get('query', [
            'query' => 'Who are you?',
        ]);

        $response = json_decode((string) $query->getBody(), true);

        $this->logger->debug('First response', $response);

        $queryApi = new QueryApi($this->client);

        $meaning = $queryApi->extractMeaning('Who are you?', [
            'sessionId' => '1234567890',
            'lang' => 'en',
        ]);

        $this->logger->debug('Second response', $meaning);
        $response = new Query($meaning);

        return false;


    }

}

?>