<?php

namespace App\Controller;

use App\Bot\Tesla;
use App\Helper\Logger;

class IndexController {

    protected $logger;
    protected $tesla;

    public function __construct()
    {
        $this->logger = new Logger();
        $this->tesla = new Tesla();

        $this->logger->debug('Request', $_REQUEST);
        $this->logger->debug('Server', $_SERVER);
    }

    public function exec()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        $token = isset($_REQUEST['hub_verify_token']) ? $_REQUEST['hub_verify_token'] : null;
        $challenge = isset($_REQUEST['hub_challenge']) ? $_REQUEST['hub_challenge'] : null;

        $hubVerifyToken = getenv('FB_HUB_VERIFY_TOKEN');
        $accessToken = getenv('FB_ACCESS_TOKEN');

        $this->tesla->setHubVerifyToken($hubVerifyToken);
        $this->tesla->setaccessToken($accessToken);

        echo $this->tesla->verifyToken($token, $challenge);

        $understand = $this->tesla->readMessage($input);

        if (!$understand) {
            //
        }


    }

}