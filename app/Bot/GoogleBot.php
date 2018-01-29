<?php

namespace App\Bot;

use App\Model\Message\KindOfIssue;
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
        $this->logger->debug('Message sending', $input);

        $query = $this->client->get('query', [
            'query' => $input['message'],
            'sessionId' => $input['senderid'],
        ]);

        $response = json_decode((string) $query->getBody(), true);

        $this->logger->debug('First response', $response);

        $response = new Query($response);

        if ($response && $response->getStatus()->getCode() == 200) {
            $response = $response->getResult()->getFulfillment()->getSpeech();

            $pattern = '/template::(.*)/';
            preg_match($pattern, $response, $output);
            if ($output) {
                $className = '\App\Model\Message\\' . $output[1];
                if (class_exists($className)) {
                    $messageObj = new $className($input);
                    return $messageObj->getMessage();
                } else {
                    $this->logger->debug('Class ' . $className . ' not found');
                }
            } else {
                return [
                    'text' => $response
                ];
            }

        }

        return false;

    }

}

?>