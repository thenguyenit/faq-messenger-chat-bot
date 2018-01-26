<?php
session_start();

//Get url & params
$url = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s://" : "://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$parts = parse_url($url);
parse_str($parts['query'], $query);

//Init variables from params
$facebookId = substr($query['fbid'],0, strlen($query['fbid']));

if (isset($_SESSION[$facebookId])){
    if($_SESSION[$facebookId]  === '1'){
        echo "Enabled chatbot for user: ".$facebookId;
    }else{
        echo "Disabled chatbot for user: ".$facebookId;
    }
}else{
    echo "Has never been set for user: " .$facebookId;
}