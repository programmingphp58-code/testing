<?php
session_start();
// require_once("/configuration/Function.php");

unset($_SESSION['internetid'], $_SESSION['login']);
setcookie('firstVisit');

header("Location:./login.php");
exit();
