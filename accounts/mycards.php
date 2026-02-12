<?php

$UniqueName  = "My Cards";
require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/headergeneral.php");
// if ($page['kyc_status'] == '1' and $row['kyc_status'] == '0') {
//     header("location:./pending-kyc.php");
//     exit;
// }

// Ofofonobs Developer WhatsAPP +2348114313795
// Bank Script Developer - Use For Educational Purpose Only
// Other scripts Available

if (@!$_SESSION['internetid']) {
    header("location:../login.php");
    die;
}

$sql2 = "SELECT * FROM card WHERE internetid=:internetid";
$cardstmt = $conn->prepare($sql2);
$cardstmt->execute([
    'internetid' => $_SESSION['internetid']
]);

$cardCheck = $cardstmt->fetch(PDO::FETCH_ASSOC);


if (isset($_POST['hold_card'])) {
    $status = 3;
    $sql2 = "UPDATE card SET card_status=:card_status WHERE internetid=:internetid";
    $stmt = $conn->prepare($sql2);
    $stmt->execute([
        'card_status' => $status,
        'internetid' => $_SESSION['internetid']
    ]);


    if (true) {



        if ($page['padiwise_sms'] == '1') {
            $messageText = "Card on Hold";
            $recipient = $row['acct_phone'];

            $responseBody = send_bulk_sms(array(
                'sender_name' => get_setting('display_name'),
                'recipient' => $recipient,
                'reference' => date('Y') . uniqid() . rand(1, 9),
                'message' => $messageText
            ));
        }



        toast_alert('success', 'Card on Hold Successfully', 'Successful');
    } else {
        toast_alert('danger', 'Something went wrong!');
    }
}

if (isset($_POST['active_card'])) {
    $status = 1;

    $sql2 = "UPDATE card SET card_status=:card_status WHERE internetid=:internetid";
    $stmt = $conn->prepare($sql2);
    $stmt->execute([
        'card_status' => $status,
        'internetid' => $_SESSION['internetid']
    ]);


    if (true) {



        if ($page['padiwise_sms'] == '1') {
            $messageText = "Card Activated";
            $recipient = $row['acct_phone'];

            $responseBody = send_bulk_sms(array(
                'sender_name' => get_setting('display_name'),
                'recipient' => $recipient,
                'reference' => date('Y') . uniqid() . rand(1, 9),
                'message' => $messageText
            ));
        }

        toast_alert('success', 'Card Ativated Successfully', 'Successful');
    } else {
        toast_alert('danger', 'Something went wrong!');
    }
}



?>







<!--  BEGIN CONTENT PART  -->
<div id="content" class="main-content">
    <div class="content">

        <div class="container-fluid">

            <div class="row layout-top-spacing">

                <?php

                $sql2 = "SELECT * FROM card WHERE internetid=:internetid";
                $cardstmt = $conn->prepare($sql2);
                $cardstmt->execute([
                    'internetid' => $_SESSION['internetid']
                ]);

                $cardCheck = $cardstmt->fetch(PDO::FETCH_ASSOC);


                if ($cardstmt->rowCount() === 0) {
                ?>

                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-account-invoice-two">
                            <div class="widget-content">
                                <div class="account-box">
                                    <div class="info">
                                        <div class="inv-title">
                                            <span class="inv-stats balance-debited" style="color:goldenrod;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                        </div>
                                        <div class="inv-balance-info">

                                            <p class="inv-balance">CREDIT CARD</p>


                                        </div>
                                    </div>
                                    <div class="acc-action">
                                        <div class="">
                                            <h4 style="font-size: 23px; color:azure;">6784 XXXX XXXX XXXX</h4>
                                            <!-- <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg></a> -->
                                            <!-- <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card">
                                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                                <line x1="1" y1="10" x2="23" y2="10"></line>
                                            </svg></a> -->
                                        </div>
                                        <a href="javascript:void(0);">XXX</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-account-invoice-one">
                            <div class="widget-content">
                                <div class="account-one">
                                    <div class="info">
                                        <div class="inv-title">
                                            <img src="<?= $web_url ?>/ui/assets/img/logo.svg" class="nav-item theme-logo" alt="logo" width="90px" height="40px">

                                        </div>
                                        <div class="inv-balance-info">

                                            <p class="inv-balance"><?= $currency ?> X,XXX.XX</p>

                                            <span> </span>

                                        </div>
                                    </div>
                                    <div class="acc-action">
                                        <div class="">
                                            <a href="javascript:void(0);"><?= $full_name ?></a>
                                            <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card">
                                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                                </svg></a>
                                        </div>
                                        <a href="javascript:void(0);">XX/XX</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                        <div class="widget-content widget-content-area">

                            <center> <a href="./cards" class="btn btn-danger btn-block mb-4 mr-2">Apply New Card</a></center>
                        </div>
                    </div>



                <?php
                } else {
                ?>


                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-account-invoice-two">
                            <div class="widget-content">
                                <div class="account-box">
                                    <div class="info">
                                        <div class="inv-title">
                                            <span class="inv-stats balance-debited" style="color:goldenrod;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                        </div>
                                        <div class="inv-balance-info">

                                            <p class="inv-balance"><?= $cardCheck['card_name'] ?></p>


                                        </div>
                                    </div>
                                    <div class="acc-action">
                                        <div class="">
                                            <h4 style="font-size: 23px; color:azure;"><?= $cardCheck['card_number'] ?></h4>
                                            <!-- <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg></a> -->
                                            <!-- <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card">
                                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                                <line x1="1" y1="10" x2="23" y2="10"></line>
                                            </svg></a> -->
                                        </div>
                                        <!-- <a href="javascript:void(0);">XXX</a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-account-invoice-one">
                            <div class="widget-content">
                                <div class="account-one">
                                    <div class="info">
                                        <div class="inv-title">
                                            <img src="<?= $web_url ?>/ui/assets/img/logo.svg" class="nav-item theme-logo" alt="logo" width="90px" height="40px">

                                        </div>
                                        <div class="inv-balance-info">

                                            <p class="inv-balance"><?= $currency ?><?php echo number_format($TotalBalance, 2, '.', ','); ?></p>

                                            <span> </span>

                                        </div>
                                    </div>
                                    <div class="acc-action">
                                        <div class="">
                                            <a href="javascript:void(0);"><?= $full_name ?></a>
                                            <a href="javascript:void(0);"><?= $cardCheck['card_security'] ?></a>
                                        </div>
                                        <a href="javascript:void(0);"><?= $cardCheck['card_expiration'] ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                        <div class="widget-content widget-content-area">
                            <form method="POST" enctype="multipart/form-data">

                                <?php
                                if ($cardCheck['card_status'] == "2") {
                                ?>

                                    <center>
                                        <p>You card application is currently awaiting approval!</p> <?php
                                                                                                } else {
                                                                                                    ?>

                                        <?php
                                                                                                    if ($cardCheck['card_status'] == "1") {
                                        ?>

                                            <center> <button type="submit" class="btn btn-danger btn-block mb-4 mr-2" name="hold_card">Disactivate Card</button></center> <?php
                                                                                                                                                                        } else {
                                                                                                                                                                            ?>

                                            <center> <button type="submit" class="btn btn-primary btn-block mb-4 mr-2" name="activate_card">Activate Card</button></center>

                                        <?php
                                                                                                                                                                        }
                                        ?>


                                    <?php
                                                                                                }
                                    ?>



                        </div>
                    </div>




                <?php
                }
                ?>






            </div>


            <?php
            require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/footer.php");

            ?>