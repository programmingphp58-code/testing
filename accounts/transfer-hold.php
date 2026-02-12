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
    <title>Maintenence - Business Banking in North Carolina </title>
    <link rel="icon" type="image/x-icon" href="<?= $web_url ?>/ui/assets/img/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="<?= $web_url ?>/ui/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $web_url ?>/ui/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="<?= $web_url ?>/ui/assets/css/pages/error/style-maintanence.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

</head>
<body class="maintanence text-center">
    
    <div class="container-fluid maintanence-content">
        <div class="">
            <div class="maintanence-hero-img">
                <img src="<?= $web_url?>/assets/images/logo/<?= $page['image'] ?>" style="width: auto; height: auto" alt="Dogwood State Bank" itemprop="url">
                      <br><br>
            </div>
            <h1 class="error-title">You can't Transfer</h1>
            <p class="text">We are currently working on making some improvements <br/> kindly contact support to <a href="./ticket">learn more</a> .</p>
            <p class="text">Thank You.</p>
            <a href="<?= $web_url ?>/accounts/dashboard.php" style="background-color: #9d7a3e !important; background-image: none !important;box-shadow: none !important;border-color: #617a87;" class="btn btn-info mt-4">Go Back</a>
        </div>
    </div>
    
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="<?= $web_url ?>/ui/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="<?= $web_url ?>/ui/bootstrap/js/popper.min.js"></script>
    <script src="<?= $web_url ?>/ui/bootstrap/js/bootstrap.min.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
</body>
</html>