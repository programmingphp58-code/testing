<?php

$UniqueName  = "Apply New Cards";
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

$internetid = $_SESSION['internetid'];

if (isset($_POST['card_generate'])) {
    $seria_key = uniqid('CARD', false);
    $card_name = "Credit Card";
    $card_number = "5276 7547 8976 " . (substr(number_format(time() * rand(), 0, '', ''), 0, 4));
    $card_expiration = "06 / 27";
    $card_security = (substr(number_format(time() * rand(), 0, '', ''), 0, 3));
    $amount = $page['cardfee'];
    $payment_account = inputValidation($_POST['payment_account']);
    $pin = inputValidation($_POST['pin']);
    $oldPin = inputValidation($row['acct_pin']);


    if ($pin !== $oldPin) {
        toast_alert('error', 'Incorrect  PINCODE');
    } else if ($payment_account == "savings_account" and $amount > $row['savings_balance']) {
        toast_alert('error', 'Insufficient Savings Balance');
    } elseif ($payment_account == "current_account" and $amount > $row['current_balance']) {
        toast_alert('error', 'Insufficient Current Balance');
    } else {


        $sql2 = "INSERT INTO card SET card_name=:card_name,card_number=:card_number,card_expiration=:card_expiration,card_security=:card_security,internetid=:internetid,seria_key=:seria_key,payment_account=:payment_account";
        $stmt = $conn->prepare($sql2);
        $stmt->execute([
            'card_name' => $card_name,
            'card_number' => $card_number,
            'card_expiration' => $card_expiration,
            'card_security' => $card_security,
            'internetid' => $internetid,
            'seria_key' => $seria_key,
            'payment_account' => $payment_account
        ]);


        $details = "Card Application";
        $stmt2 = $conn->prepare("INSERT INTO activities (internetid,details) VALUES(:internetid,:details)");
        $stmt2->execute([
            'internetid' => $internetid,
            'details' => $details
        ]);

        if ($page['padiwise_sms'] == '1') {
            $messageText = "New Card Application";
            $recipient = $row['acct_phone'];

            $responseBody = send_bulk_sms(array(
                'sender_name' => get_setting('display_name'),
                'recipient' => $recipient,
                'reference' => date('Y') . uniqid() . rand(1, 9),
                'message' => $messageText
            ));
        }


        if ($payment_account  == "current_account") {



            $tBalance = $row['current_balance'] - $amount;

            $sql = "UPDATE accounts SET current_balance=:current_balance WHERE internetid=:internetid";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'current_balance' => $tBalance,
                'internetid' => $_SESSION['internetid']
            ]);





            if (true) {
                $full_name = $row['firstname'] . " " . $row['lastname'];
                $APP_NAME = WEB_TITLE;
                $APP_URL = WEB_URL;
                $SITE_ADDRESS = $page['website_address'];
                $user_email = $row['acct_email'];

                $card_status = "Processing";
                $message = $sendMail->CardMsg($full_name, $card_name, $amount, $card_status, $APP_NAME, $APP_URL, $SITE_ADDRESS);
                // User Email
                $subject = "Card Request" . "-" . $APP_NAME;
                // $email_message->send_mail($user_email, $message, $subject);

                toast_alert('success', 'Card Request Successfully', 'Successful');
            } else {
                toast_alert("error", "Sorry Error Occured Contact Support");
            }
        } else {



            $SBalance = $row['savings_balance'] - $amount;

            $sql = "UPDATE accounts SET savings_balance=:savings_balance WHERE internetid=:internetid";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'savings_balance' => $SBalance,
                'internetid' => $_SESSION['internetid']
            ]);



            if (true) {
                $full_name = $row['firstname'] . " " . $row['lastname'];
                $APP_NAME = WEB_TITLE;
                $APP_URL = WEB_URL;
                $SITE_ADDRESS = $page['website_address'];
                $user_email = $row['acct_email'];

                $card_status = "Processing";
                $message = $sendMail->CardMsg($full_name, $card_name, $amount, $card_status, $APP_NAME, $APP_URL, $SITE_ADDRESS);
                // User Email
                $subject = "Card Request" . "-" . $APP_NAME;
                // $email_message->send_mail($user_email, $message, $subject);

                toast_alert('success', 'Card Request Successfully', 'Successful');
            } else {
                toast_alert("error", "Sorry Error Occured Contact Support");
            }
        }
    }
}



?>







<!--  BEGIN CONTENT PART  -->
<div id="content" class="main-content">
    <div class="content">

        <div class="container-fluid">

            <div class="row layout-top-spacing">



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
                        <form method="POST" enctype="multipart/form-data">


                            <label for="basic-url">Select Card Account</label>
                            <div class="input-group mb-4">
                                <select class="form-control" required name="payment_account">
                                    <option>Select Card Account</option>
                                    <option value="savings_account"><strong>(<?= $row['savings_acctno'] ?>)</strong> Savings: <?= $currency ?><?php echo number_format($SavingsBalance, 2, '.', ','); ?></option>
                                    <option value="current_account"><strong>(<?= $row['current_acctno'] ?>)</strong> Current: <?= $currency ?><?php echo number_format($CurrentBalance, 2, '.', ','); ?></option>
                                </select>
                                <div class="input-group-append">
                                    <span class="input-group-text">Fee: <?= $currency ?><?= $page['cardfee'] ?></span>
                                </div>
                            </div>

                            <label for="basic-url">Account Pincode</label>
                            <div class="input-group mb-4">
                                <input type="text" class="form-control" placeholder="******" name="pin">
                            </div>


                            <center> <button type="submit" class="btn btn-primary btn-block mb-4 mr-2" style="background-color: #9d7a3e !important; border-color: none !important;box-shadow: none !important;border-color: #617a87;" name="card_generate">Apply For Card</button></center>

                    </div>


                </div>

            </div>


            <?php
            require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/footer.php");

            ?>