<?php

namespace App\Controller;

use App\Helper\FbBot;
use App\Helper\Logger;

class IndexController {

    protected $logger;
    protected $bot;

    public function __construct()
    {
        $this->logger = new Logger();
        $this->bot = new FbBot();
        $this->logger->debug('Request', $_REQUEST);
        $this->logger->debug('Server', $_SERVER);
    }

    public function exec()
    {
        $token = isset($_REQUEST['hub_verify_token']) ? $_REQUEST['hub_verify_token'] : null;
        $challenge = isset($_REQUEST['hub_challenge']) ? $_REQUEST['hub_challenge'] : null;

        $hubVerifyToken = getenv('FB_HUB_VERIFY_TOKEN');
        $accessToken = getenv('FB_ACCESS_TOKEN');

        $this->bot->setHubVerifyToken($hubVerifyToken);
        $this->bot->setaccessToken($accessToken);

        echo $this->bot->verifyToken($token, $challenge);
        $input = json_decode(file_get_contents('php://input'), true);

        $message = $this->bot->readMessage($input);
        $this->bot->sendMessage($message);

    }

}