<?php
include 'FbBot.php';

$tokken = $_REQUEST['hub_verify_token'];
$challange = $_REQUEST['hub_challenge'];

$hubVerifyToken = 'nguyenkhoikhanh';

$accessToken = 'EAACSABWtkLwBALiQSRUfg9XwhdJZAcm5sMSv4zWbtGwFJkkEHIMMDIbrjiyFKM8slt6iA3mcasSmHzT6cvP1c6uj64jZBdBRMs8DuQ7sLBXDrixvwciMNjiFGUHqIf6DIyVsDLi5FPNbR6JMeSCxtOMn3ZBXZAhiD9T24RoxugZDZD';

$bot = new FbBot();

$bot->setHubVerifyToken($hubVerifyToken);
$bot->setaccessToken($accessToken);

echo $bot->verifyTokken($tokken, $challange);
$input = json_decode(file_get_contents('php://input'), true);
$message = $bot->readMessage($input);
$textmessage = $bot->sendMessage($message);