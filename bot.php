<?php
include 'FbBot.php';
$tokken = $_REQUEST['hub_verify_token'];
$hubVerifyToken = 'cloudwaysschool';
$challange = $_REQUEST['hub_challenge'];
$accessToken = 'nguyenkhoikhanh';
$bot = new FbBot();
$bot->setHubVerifyToken($hubVerifyToken);
$bot->setaccessToken($accessToken);
echo $bot->verifyTokken($tokken,$challange);
$input = json_decode(file_get_contents('php://input'), true);
$message = $bot->readMessage($input);
$textmessage = $bot->sendMessage($message);