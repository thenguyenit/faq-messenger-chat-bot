<?php

namespace App\Controller;

use App\Helper\FbBot;

class IndexController {

    public function __construct()
    {

    }

    public function exec()
    {
        if (isset($_REQUEST['hub_verify_token']) && isset($_REQUEST['hub_challenge'])) {

            $token = $_REQUEST['hub_verify_token'];
            $challenge = $_REQUEST['hub_challenge'];

            $hubVerifyToken = 'nguyenkhoikhanh';

            $accessToken = 'EAACSABWtkLwBALiQSRUfg9XwhdJZAcm5sMSv4zWbtGwFJkkEHIMMDIbrjiyFKM8slt6iA3mcasSmHzT6cvP1c6uj64jZBdBRMs8DuQ7sLBXDrixvwciMNjiFGUHqIf6DIyVsDLi5FPNbR6JMeSCxtOMn3ZBXZAhiD9T24RoxugZDZD';

            $bot = new FbBot();

            $bot->setHubVerifyToken($hubVerifyToken);
            $bot->setaccessToken($accessToken);

            if ($bot->verifyToken($token, $challenge)) {
                $input = json_decode(file_get_contents('php://input'), true);
                $message = $bot->readMessage($input);
                $bot->sendMessage($message);
            }

        } else {
            die('Missing authenticate request');
        }

    }

}