<?php
include 'FbBot.php';

$tokken = $_REQUEST['hub_verify_token'];
$challange = $_REQUEST['hub_challenge'];

$hubVerifyToken = 'nguyenkhoikhanh';

$accessToken = 'EAACSABWtkLwBAIBNWicbZBx8UtCUXmB7U64BjXxhUwrxmfXI3u0PWIMS6Xd74dAZCkCh5GelJZATrLQ938DyOF9aZCJgbQZBHRn1tmRtaFcNfTDmpZCRBNEgyvpfBtQ9oZB6HXL8CKDFrVQcv3soXBqjkYjbQPXEEXXRYB1HtZCmVwZDZD';

$bot = new FbBot();

$bot->setHubVerifyToken($hubVerifyToken);
$bot->setaccessToken($accessToken);

echo $bot->verifyTokken($tokken, $challange);
$input = json_decode(file_get_contents('php://input'), true);
$message = $bot->readMessage($input);
$textmessage = $bot->sendMessage($message);