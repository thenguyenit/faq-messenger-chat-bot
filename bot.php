<?php
include 'FbBot.php';

$tokken = $_REQUEST['hub_verify_token'];
$challange = $_REQUEST['hub_challenge'];

$hubVerifyToken = 'nguyenkhoikhanh';

$accessToken = 'EAACSABWtkLwBAICYYRajq22UnZAKCjDku3ZC3DDZCnZBJZBx014riSTtgQv6CMGfluniTpgAgruCpaClP7OEmCoZA4vYT9o5n3fHd8JfKbPqaC2lihUsSgdBl3roICf3muYNp1WVZCo6sTl9ktlTIlfRFaS8FGlPV5SjsGduE1aXAZDZD';

$bot = new FbBot();

$bot->setHubVerifyToken($hubVerifyToken);
$bot->setaccessToken($accessToken);

echo $bot->verifyTokken($tokken, $challange);
$input = json_decode(file_get_contents('php://input'), true);
$message = $bot->readMessage($input);
$textmessage = $bot->sendMessage($message);