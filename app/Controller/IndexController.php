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
        if (isset($_REQUEST['hub_verify_token']) && isset($_REQUEST['hub_challenge'])) {
            $token = $_REQUEST['hub_verify_token'];
            $challenge = $_REQUEST['hub_challenge'];

            $hubVerifyToken = 'nguyenkhoikhanh';

            $accessToken = 'EAACSABWtkLwBALiQSRUfg9XwhdJZAcm5sMSv4zWbtGwFJkkEHIMMDIbrjiyFKM8slt6iA3mcasSmHzT6cvP1c6uj64jZBdBRMs8DuQ7sLBXDrixvwciMNjiFGUHqIf6DIyVsDLi5FPNbR6JMeSCxtOMn3ZBXZAhiD9T24RoxugZDZD';


            $this->bot->setHubVerifyToken($hubVerifyToken);
            $this->bot->setaccessToken($accessToken);

            echo $this->bot->verifyToken($token, $challenge);
            $input = json_decode(file_get_contents('php://input'), true);
            $message = $this->bot->readMessage($input);
            $textmessage = $this->bot->sendMessage($message);

        } else {
            $this->logger->debug('Missing authenticate request');
        }

    }

}