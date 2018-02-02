<?php
session_start();

//Get url & params
$url = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s://" : "://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$parts = parse_url($url);
parse_str($parts['query'], $query);

//Init variables from params
$facebookId = substr($query['fbid'],0, strlen($query['fbid']));
$isEnabled = false;
if (isset($query['enabled']))
{
    if ($query['enabled'] === '1' || $query['enabled'] === '0')
    {
        $isEnabled = (bool) $query['enabled'];
    }
}

//Save sessions
if($isEnabled == true){
    $_SESSION[$facebookId] = '1';
    echo "Enabled chatbot for user: " . $facebookId;
}else{
    $_SESSION[$facebookId] = '0';
    echo "Disabled chatbot for user: " . $facebookId;
}
