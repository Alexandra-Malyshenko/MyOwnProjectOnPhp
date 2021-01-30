<?php

session_start();

var_dump(session_name());
var_dump(session_id());
var_dump(session_save_path());

-------------------------

session_start();
if (!isset($_SESSION['time'])){
    $_SESSION['time'] = date("H:i:s");
}
echo $_SESSION['time'];

--------------------------

session_start();
if (!isset($_SESSION['time'])){
    $_SESSION['ua'] = $_SERVER['HTTP_USER_AGENT'];
    $_SESSION['time'] = date("H:i:s");
}
if ($_SESSION['ua'] != $_SERVER['HTTP_USER_AGENT']){
    die('Wrong browser');
}
echo $_SESSION['time'];

--------------------------

session_start();
$_SESSION['hello'] = 'hello';
$_SESSION['world'] = 'world';
$_SESSION = array();
unset($_SESSION['world']);
session_destroy();

--------------------------

session_save_path(__DIR__ . '/../App/storage/php-session/');

--------------------------

$lifeTime = 3;
session_set_cookie_params(
    $lifeTime,
    null,
    null,
    false,
    false
);
session_start();

--------------------------