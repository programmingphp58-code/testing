<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/admin/include/session.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/admin/include/adminloginFunction.php");

if (@$_SESSION['admin']) {
    header('Location:./dashboard.php');
}

if (@!$_SESSION['admin']) {
    header('Location:./login.php');
}
