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

    protected $googleBot;

    function __construct()
    {
        $this->logger = new Logger();
        $this->googleBot = new GoogleBot();
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
            $client = new Client();
            $url = getenv('FB_GRAPH_URL');
            $senderId = $input['senderid'];
            $answer = null;
            $header = array(
                'content-type' => 'application/json'
            );

            if (isset($_SESSION[$senderId]) && $_SESSION[$senderId]  === '0'){
                return false;
            }

            //GoogleBot, Can you give me a hand?
            $answer = $this->googleBot->readMessage($input);

            if (!$answer) {
                //Alexa, Can you give me a favor?
            }

            if ($answer) {
                $response = [
                    'recipient' => ['id' => $senderId],
                    'message' => $answer,
                    'access_token' => $this->accessToken
                ];
                $this->logger->debug('Response', $response);

                $client->post($url, ['query' => $response, 'headers' => $header]);

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
            $senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
            $messageText = $input['entry'][0]['messaging'][0]['message']['text'];
            $postBack = $input['entry'][0]['messaging'][0]['postback'];
            $locTitle = $input['entry'][0]['messaging'][0]['message']['attachments'][0]['title'];
            if (!empty($postBack)) {
                $payloads = $input['entry'][0]['messaging'][0]['postback']['payload'];
                return ['senderid' => $senderId, 'message' => $payloads];
            }

            if (!empty($locTitle)) {
                $payloads = $input['entry'][0]['messaging'][0]['postback']['payload'];
                return [
                    'senderid' => $senderId,
                    'message' => $messageText,
                    'location' => $locTitle
                ];
            }

            return [
                'senderid' => $senderId,
                'message' => $messageText
            ];
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
        
    }
}

?>