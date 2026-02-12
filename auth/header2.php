<?php
ob_start();
session_start();
require_once("./configuration/config.php");
require_once("./configuration/Function/Function.php");
require_once("./configuration/SMS/fns.php");

$message = new message();

require_once("./session.php");
// require_once("/configuration/Function.php");

$sql = "SELECT * FROM settings WHERE id ='1'";
$stmt = $conn->prepare($sql);
$stmt->execute();

$page = $stmt->fetch(PDO::FETCH_ASSOC);

$title = $page['website_name'];

$UniqueName = $title;
$BANK_PHONE = $page['website_tel'];



$viesConn = "SELECT * FROM accounts";
$stmt = $conn->prepare($viesConn);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);



$title = new pageTitle();
$email_message = new message();
$sendMail = new emailMessage();

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?= $UniqueName ?>  </title>
    <link rel="icon" type="image/x-icon" href="../ui/assets/img/favicon.ico" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="../ui/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../ui/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../ui/assets/css/authentication/form-2.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="../ui/assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="../ui/assets/css/forms/switches.css">

    <link rel="stylesheet" type="text/css" href="../ui/assets/css/loader.css">
    <script src="../ui/assets/js/loader.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>



</head>

<body class="form no-image-content">

    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->