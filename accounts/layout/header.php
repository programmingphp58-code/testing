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

// Get account details for current user
$sql = "SELECT * FROM accounts WHERE internetid = :internetid";
$stmt = $conn->prepare($sql);
$stmt->execute(['internetid' => $_SESSION['internetid']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$TotalBalance = floatval($row['savings_balance'] ?? 0) + floatval($row['current_balance'] ?? 0) + floatval($row['business_balance'] ?? 0);
$LoanBalance = floatval($row['loan_balance'] ?? 0);
$CurrentBalance = floatval($row['current_balance'] ?? 0);
$SavingsBalance = floatval($row['savings_balance'] ?? 0);
$BusinessBalance = floatval($row['business_balance'] ?? 0);
$BusinessName = $row['business_name'] ?? '';
$fullName = ($row['firstname'] ?? '') . " " . ($row['lastname'] ?? '');
$email = $row['acct_email'] ?? '';
$currency = $row['acct_currency'] ?? '$';

// Get audit logs (optional - for last login info)
try {
    $sql = "SELECT * FROM audit_logs WHERE internetid = :internetid ORDER BY datenow DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['internetid' => $_SESSION['internetid']]);
    $logs = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$logs) {
        $logs = ['ipAddress' => $_SERVER['REMOTE_ADDR'], 'datenow' => date('Y-m-d H:i:s')];
    }
} catch (Exception $e) {
    // If audit_logs doesn't exist or query fails, use defaults
    $logs = ['ipAddress' => $_SERVER['REMOTE_ADDR'], 'datenow' => date('Y-m-d H:i:s')];
}

// Get transactions
$sql = "SELECT * FROM transactions WHERE internetid = :internetid ORDER BY trans_id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute(['internetid' => $_SESSION['internetid']]);
$transac = $stmt->fetch(PDO::FETCH_ASSOC);

// Get pending transaction
$sql = "SELECT * FROM transactions WHERE internetid = :internetid AND trans_status = 'pending' ORDER BY trans_id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute(['internetid' => $_SESSION['internetid']]);
$temp_trans = $stmt->fetch(PDO::FETCH_ASSOC);


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
    <title><?= $UniqueName ?> - Online Banking Platform </title>
    <link rel="icon" type="image/x-icon" href="<?= $web_url ?>/ui/assets/img/favicon.ico" />
    <link href="<?= $web_url ?>/ui/assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="<?= $web_url ?>/ui/assets/js/loader.js"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="<?= $web_url ?>/ui/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $web_url ?>/ui/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="<?= $web_url ?>/ui/plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="<?= $web_url ?>/ui/assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    <link rel="stylesheet" type="text/css" href="<?= $web_url ?>/ui/plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="<?= $web_url ?>/ui/plugins/table/datatable/dt-global_style.css">
    <link rel="stylesheet" type="text/css" href="<?= $web_url ?>/ui/assets/css/forms/theme-checkbox-radio.css">
    <link href="<?= $web_url ?>/ui/assets/css/apps/invoice-list.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="<?= $web_url ?>/ui/assets/css/elements/alert.css">
    <link href="<?= $web_url ?>/ui/assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />


    <link href="<?= $web_url ?>/ui/plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?= $web_url ?>/ui/assets/css/widgets/modules-widgets.css">




    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>




    <style>
        .layout-px-spacing {
            min-height: calc(100vh - 166px) !important;
        }
    </style>

    <!-- Google Translate - Disabled for cleaner UI -->
    <!-- 
    <div id="google_translate_element"></div>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>
    <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" type="text/javascript"></script>
    -->


    <style>
        .btn-light {
            border-color: transparent;
        }
    </style>

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <style>
        h4.modal-title {
            color: #000;
        }

        .modal-content {
            border: none;
        }

        .modal-body {
            text-align: center;
        }

        p span.countdown-holder {
            color: #e7515a;
            font-size: 18px;
        }

        .modal-footer {
            border: none;
        }

        .progress {
            width: 50%;
            margin: 0 auto;
            border-radius: 30px;
            height: 10px;
        }

        .modal-backdrop {
            background-color: #060818;
        }

        .layout-px-spacing {
            min-height: calc(100vh - 149px) !important;
        }

        @media (min-width: 576px) {
            .modal-dialog {
                max-width: 350px;
            }
        }
    </style>
    <!--  END CUSTOM STYLE FILE  -->

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