<?php
ob_start();
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/configuration/Function.php");

$internetid = userDetails('id');
if (isset($_SESSION["name"])) {
    if ((time() - $_SESSION['last_login_timestamp']) > 60) // 900 = 15 * 60  
    {
        header("location:logout");
    } else {
        $_SESSION['last_login_timestamp'] = time();
        echo "<h1 align='center'>" . $_SESSION["name"] . "</h1>";
        echo '<h1 align="center">' . $_SESSION['last_login_timestamp'] . '</h1>';
        echo "<p align='center'><a href='logout.php'>Logout</a></p>";
    }
}


if (!$_SESSION['internetid']) {
    header("location:../login.php");
    exit;
}





$title = new pageTitle();
$email_message = new message();
$sendMail = new emailMessage();

$internetid = userDetails('id');




$sql2 = "SELECT * FROM card WHERE internetid=:internetid";
$cardstmt = $conn->prepare($sql2);
$cardstmt->execute([
    'internetid' => $internetid
]);

$cardCheck = $cardstmt->fetch(PDO::FETCH_ASSOC);





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?= $UniqueName ?> - Business Banking in North Carolina </title>
    <link rel="icon" type="image/x-icon" href="<?= $web_url ?>/ui/assets/img/favicon.ico" />
    <link href="<?= $web_url ?>/ui/assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="<?= $web_url ?>/ui/assets/js/loader.js"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="<?= $web_url ?>/ui/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $web_url ?>/ui/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="<?= $web_url ?>/ui/assets/css/dashboard/dash_2.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <link href="<?= $web_url ?>/ui/assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?= $web_url ?>/ui/assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="<?= $web_url ?>/ui/assets/css/forms/switches.css">


    <link href="<?= $web_url ?>/ui/assets/css/apps/scrumboard.css" rel="stylesheet" type="text/css" />
    <link href="<?= $web_url ?>/ui/assets/css/components/tabs-accordian/custom-tabs.css" rel="stylesheet" type="text/css" />

    <link href="<?= $web_url ?>/ui/assets/css/apps/invoice-preview.css" rel="stylesheet" type="text/css" />


    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>



    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

</head>

<body>
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->


    <?php
    require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/navbar.php");
    ?>