<?php
session_start();
// require_once("/configuration/Function.php");

unset($_SESSION['internetid'], $_SESSION['acct_email'], $_SESSION['wire_transfer'], $_SESSION['dom-transfer'], $_SESSION['login']);
setcookie('firstVisit');

header("Location:../login.php");
exit();
