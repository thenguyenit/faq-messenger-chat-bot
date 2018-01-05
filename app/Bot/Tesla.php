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
            $messageText = strtolower($input['message']);
            $senderId = $input['senderid'];
            $msgarray = explode(' ', $messageText);
            $answer = null;
            $header = array(
                'content-type' => 'application/json'
            );

            if (in_array('blog', $msgarray)) {
                $answer = [
                    "attachment" => [
                        "type" => "template",
                        "payload" => [
                            "template_type" => "generic",
                            "elements" => [[
                                "title" => "Migrate your symfony application",
                                "item_url" => "https://www.cloudways.com/blog/migrate-symfony-from-cpanel-to-cloud-hosting/",
                                "image_url" => "https://www.cloudways.com/blog/wp-content/uploads/Migrating-Your-Symfony-Website-To-Cloudways-Banner.jpg",
                                "subtitle" => "Migrate your symfony application from Cpanel to Cloud.",
                                "buttons" => [
                                    [
                                        "type" => "web_url",
                                        "url" => "www.cloudways.com",
                                        "title" => "View Website"
                                    ],
                                    [
                                        "type" => "postback",
                                        "title" => "Start Chatting",
                                        "payload" => "get started"
                                    ]
                                ]
                            ]]
                        ]]];
            } elseif (in_array('list', $msgarray)) {
                $answer = ["attachment" => [
                    "type" => "template",
                    "payload" => [
                        "template_type" => "list",
                        "elements" => [
                            [
                                "title" => "Welcome to Peter\'s Hats",
                                "item_url" => "https://www.cloudways.com/blog/migrate-symfony-from-cpanel-to-cloud-hosting/",
                                "image_url" => "https://www.cloudways.com/blog/wp-content/uploads/Migrating-Your-Symfony-Website-To-Cloudways-Banner.jpg",
                                "subtitle" => "We\'ve got the right hat for everyone.",
                                "buttons" => [
                                    [
                                        "type" => "web_url", "url" => "https://cloudways.com",
                                        "title" => "View Website"
                                    ],
                                ]
                            ],
                            [
                                "title" => "Multipurpose Theme Design and Versatility",
                                "item_url" => "https://www.cloudways.com/blog/multipurpose-wordpress-theme-for-agency/",
                                "image_url" => "https://www.cloudways.com/blog/wp-content/uploads/How-a-multipurpose-WordPress-theme-can-help-your-agency-Banner.jpg",
                                "subtitle" => "We've got the right theme for everyone.",
                                "buttons" => [
                                    [
                                        "type" => "web_url",
                                        "url" => "https://cloudways.com",
                                        "title" => "View Website"
                                    ],
                                ]
                            ],
                            [
                                "title" => "Add Custom Discount in Magento 2",
                                "item_url" => "https://www.cloudways.com/blog/add-custom-discount-magento-2/",
                                "image_url" => "https://www.cloudways.com/blog/wp-content/uploads/M2-Custom-Discount-Banner.jpg",
                                "subtitle" => "Learn adding magento 2 custom discounts.",
                                "buttons" => [
                                    [
                                        "type" => "web_url",
                                        "url" => "https://cloudways.com",
                                        "title" => "View Website"
                                    ],
                                ]
                            ]
                        ]
                    ]
                ]];
            } elseif ($messageText == 'get started') {
                $answer = [
                    "text" => "Please share your location:",
                    "quick_replies" => [
                        [
                            "content_type" => "location",
                        ]
                    ]];
            } elseif (!empty($input['location'])) {
                $answer = ["text" => 'great you are at' . $input['location'],];
            }

            if (!$answer) {
                //GoogleBot, Can you give me a hand?
                $answer = $this->googleBot->readMessage($input);

                if (!$answer) {
                    //Alexa, Can you give me a favor?
                }

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