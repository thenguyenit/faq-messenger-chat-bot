<?php

namespace App\Bot;

use GuzzleHttp\Client as Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use App\Helper\Logger;

class Tesla implements BotInterface
{
    private $hubVerifyToken = null;
    private $accessToken = null;
    private $token = false;
    protected $client = null;
    protected $logger;
    protected $senderId;
    protected $facebookGraphUrl;

    protected $googleBot;

    function __construct()
    {
        $this->logger = new Logger();
        $this->googleBot = new GoogleBot();
        $this->client = new Client();

        $this->facebookGraphUrl = getenv('FB_GRAPH_URL');
    }

    public function setHubVerifyToken($value)
    {
        $this->hubVerifyToken = $value;
    }

    public function setAccessToken($value)
    {
        $this->accessToken = $value;
    }

    /**
     * Verify token
     *
     * @param $hubVerifyToken
     * @param $challenge
     * @return bool|string
     */
    function verifyToken($hubVerifyToken, $challenge)
    {
        try {
            if ($hubVerifyToken === $this->hubVerifyToken) {
                return $challenge;
            } else {
                return false;
            }
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function readMessage($rawMessage)
    {
        $input = $this->simplyInput($rawMessage);

        try {
            $answer = null;

            if (isset($_SESSION[$this->senderId]) && $_SESSION[$this->senderId]  === '0'){
                return false;
            }

            //GoogleBot, Can you give me a hand?
            $answer = $this->googleBot->readMessage($input);

            if (!$answer) {
                //Alexa, Can you give me a favor?
            }

            if ($answer) {
                if (is_array($answer)) {
                    // If the answer is multiple
                    if (count($answer) > 1) {
                        foreach ($answer as $item) {
                            $this->response($item);
                        }
                    } else {
                        $this->response($answer);
                    }
                }

                return true;
            }


        } catch (RequestException $e) {

            $this->logger->debug($e->getMessage());

            $response = json_decode($e->getResponse()->getBody(true)->getContents());
            $this->logger->debug('Exception:' . json_encode($response));

            return $response;
        }

    }

    protected function simplyInput($input)
    {
        try {
            $this->logger->debug('Raw message:', $input);
            $payloads = null;
            $this->senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
            $messageText = $input['entry'][0]['messaging'][0]['message']['text'];
            $postBack = $input['entry'][0]['messaging'][0]['postback'];
            $locTitle = $input['entry'][0]['messaging'][0]['message']['attachments'][0]['title'];
            if (!empty($postBack)) {
                $payloads = $input['entry'][0]['messaging'][0]['postback']['payload'];
                return ['senderid' => $this->senderId, 'message' => $payloads];
            }

            if (!empty($locTitle)) {
                $payloads = $input['entry'][0]['messaging'][0]['postback']['payload'];
                return [
                    'senderid' => $this->senderId,
                    'message' => $messageText,
                    'location' => $locTitle
                ];
            }

            return [
                'senderid' => $this->senderId,
                'message' => $messageText
            ];

        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
        
    }

    protected function response($message)
    {
        $header = array(
            'content-type' => 'application/json'
        );

        $response = [
            'recipient' => ['id' => $this->senderId],
            'message' => $message,
            'access_token' => $this->accessToken
        ];

        $this->logger->debug('Response', $response);

        $this->client->post($this->facebookGraphUrl, ['query' => $response, 'headers' => $header]);
    }
}

?>