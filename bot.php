<?php
include 'FbBot.php';
$tokken = $_REQUEST['hub_verify_token'];

$hubVerifyToken = 'nguyenkhoikhanh';

$challange = $_REQUEST['hub_challenge'];

$accessToken = 'EAACSABWtkLwBADpg1X9bzxbr3w2m8XmwFD97f6hIQeaZAZA6KKbNTwcW2mHW6BdZAEsorScK23E5MZAEU9CiJG8LVznKtjpEZAGjqP5JSkq8FrYkUY1dpSInbj3sOEZAEOvyfRvDa7atsM6WPeT4aAUAUGrusLbqqLy3YXTrWx2AZDZD';

$bot = new FbBot();

$bot->setHubVerifyToken($hubVerifyToken);
$bot->setaccessToken($accessToken);

echo $bot->verifyTokken($tokken, $challange);
$input = json_decode(file_get_contents('php://input'), true);
$message = $bot->readMessage($input);
$textmessage = $bot->sendMessage($message);