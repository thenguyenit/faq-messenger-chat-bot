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

    public function readMessage($input)
    {
        $query = $this->client->get('query', [
            'query' => $input['message'],
            'sessionId' => $input['senderId'],
        ]);

        $response = json_decode((string) $query->getBody(), true);

        $this->logger->debug('First response', $response);

        $response = new Query($response);

        if ($response && $response->getStatus()->getCode() == 200) {
            return $response->getResult()->getFulfillment()->getSpeech();
        }

        return false;

    }

}

?>