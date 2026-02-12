<?php
$UniqueName  = "Pincode";
require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/headergeneral.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available

if ($page['transfer'] == '0') {
    header("location:./transfer-hold.php");
    exit;
}

if ($row['transfer'] == '0') {
    header("location:./transfer-hold.php");
    exit;
}


if (!$_SESSION['is_wire_transfer']) {
    header("Location:./dashboard.php");
}


// //TEMP TRANSACTION FETCH
$sql = "SELECT * FROM temp_dumps WHERE internetid =:internetid AND trans_type ='Wire transfer' ORDER BY trans_id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute([
    'internetid' => $_SESSION['internetid']
]);
$temp_trans = $stmt->fetch(PDO::FETCH_ASSOC);



$viesConn = "SELECT * FROM accounts WHERE internetid=:internetid";
$stmt88 = $conn->prepare($viesConn);

$stmt88->execute([
    'internetid' => $_SESSION['internetid']
]);
$row = $stmt88->fetch(PDO::FETCH_ASSOC);


if (isset($_POST['wire_submit'])) {


    $pin = inputValidation($_POST['pin']);
    $oldPin = inputValidation($row['acct_pin']);


    $internetid = inputValidation($row['internetid']);
    $amount = inputValidation($_POST['amount']);
    $bank_name = inputValidation($_POST['bank_name']);
    $account_name = inputValidation($_POST['account_name']);
    $account_number = inputValidation($_POST['account_number']);
    $account_type = inputValidation($_POST['account_type']);
    $bank_country = inputValidation($_POST['bank_country']);
    $routine_number = inputValidation($_POST['routine_number']);
    $payment_account = inputValidation($_POST['payment_account']);
    $description = inputValidation($_POST['description']);


    $TotalBalance = $row['current_balance'] or $row['savings_balance'];


    if ($pin !== $oldPin) {
        toast_alert('error', 'Incorrect PINCODE');
    } elseif ($payment_account == "savings_account" and $amount > $row['savings_balance']) {
        toast_alert('error', 'Insufficient Savings Balance');
    } elseif ($payment_account == "current_account" and $amount > $row['current_balance']) {
        toast_alert('error', 'Insufficient Current Balance');
    } else {



        if ($temp_trans['payment_account']  == "current_account") {

            $tBalance = $row['current_balance'] - $amount;

            $sql = "UPDATE accounts SET current_balance=:current_balance WHERE internetid=:internetid";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'current_balance' => $tBalance,
                'internetid' => $_SESSION['internetid']
            ]);

            if (true) {
                $refrence_id = uniqid();
                $trans_type = "Wire transfer";
                $transaction_type = "debit";
                $trans_status = "processing";
                $sql = "INSERT INTO transactions (amount,refrence_id,internetid,bank_name,account_name,account_number,account_type,bank_country,trans_type,transaction_type,trans_status,routine_number,payment_account,description) VALUES(:amount,:refrence_id,:internetid,:bank_name,:account_name,:account_number,:account_type,:bank_country,:trans_type,:transaction_type,:trans_status,:routine_number,:payment_account,:description)";
                $tranfered = $conn->prepare($sql);
                $tranfered->execute([
                    'amount' => $amount,
                    'refrence_id' => $refrence_id,
                    'internetid' => $internetid,
                    'bank_name' => $bank_name,
                    'account_name' => $account_name,
                    'account_number' => $account_number,
                    'account_type' => $account_type,
                    'bank_country' => $bank_country,
                    'trans_type' => $trans_type,
                    'transaction_type' => $transaction_type,
                    'trans_status' => $trans_status,
                    'routine_number' => $routine_number,
                    'payment_account' => $payment_account,
                    'description' => $description
                ]);



                $trans_id = $temp_trans['trans_id'];
                $status_value = "completed";
                $sql = "UPDATE temp_dumps SET trans_status=:wire_status WHERE trans_id=:trans_id";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    'wire_status' => $status_value,
                    'trans_id' => $trans_id
                ]);


                if (true) {



                    if ($page['padiwise_sms'] == '1') {
                        $messageText = "New Wire Transfer";
                        $recipient = $row['acct_phone'];

                        $responseBody = send_bulk_sms(array(
                            'sender_name' => get_setting('display_name'),
                            'recipient' => $recipient,
                            'reference' => date('Y') . uniqid() . rand(1, 9),
                            'message' => $messageText
                        ));
                    }

                    // $full_name = $row['firstname'] . " " . $row['lastname'];
                    // $APP_NAME = WEB_TITLE;
                    // $APP_URL = WEB_URL;
                    // $SITE_ADDRESS = $page['website_address'];
                    // $user_email = $row['acct_email'];
                    // $message = $sendMail->WireMsg($full_name, $amount, $account_type, $trans_type, $refrence_id, $swift_code, $routine_number, $bank_country, $bank_name, $trans_status, $account_number, $account_name, $APP_NAME, $APP_URL, $SITE_ADDRESS);
                    // // User Email
                    // $subject = "Wire Transfer" . "-" . $APP_NAME;
                    // $email_message->send_mail($user_email, $message, $subject);

                    $_SESSION['dom_transfer'] = $refrence_id;
                    $_SESSION['is_transfer']  = "transfer";
                    header("Location:./success.php");
                }
            }
        } else {

            $SnBalance = $row['savings_balance'] - $amount;

            $sql03 = "UPDATE accounts SET savings_balance=:savings_balance WHERE internetid=:internetid";
            $stmt4 = $conn->prepare($sql03);
            $stmt4->execute([
                'savings_balance' => $SnBalance,
                'internetid' => $_SESSION['internetid']
            ]);





            if (true) {
                $refrence_id = uniqid();
                $trans_type = "Wire transfer";
                $transaction_type = "debit";
                $trans_status = "processing";
                $sql = "INSERT INTO transactions (amount,refrence_id,internetid,bank_name,account_name,account_number,account_type,bank_country,trans_type,transaction_type,trans_status,routine_number,payment_account,description) VALUES(:amount,:refrence_id,:internetid,:bank_name,:account_name,:account_number,:account_type,:bank_country,:trans_type,:transaction_type,:trans_status,:routine_number,:payment_account,:description)";
                $tranfered = $conn->prepare($sql);
                $tranfered->execute([
                    'amount' => $amount,
                    'refrence_id' => $refrence_id,
                    'internetid' => $internetid,
                    'bank_name' => $bank_name,
                    'account_name' => $account_name,
                    'account_number' => $account_number,
                    'account_type' => $account_type,
                    'bank_country' => $bank_country,
                    'trans_type' => $trans_type,
                    'transaction_type' => $transaction_type,
                    'trans_status' => $trans_status,
                    'routine_number' => $routine_number,
                    'payment_account' => $payment_account,
                    'description' => $description
                ]);



                $trans_id = $temp_trans['trans_id'];
                $status_value = "completed";
                $sql = "UPDATE temp_dumps SET trans_status=:wire_status WHERE trans_id=:trans_id";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    'wire_status' => $status_value,
                    'trans_id' => $trans_id
                ]);


                if (true) {



                    if ($page['padiwise_sms'] == '1') {
                        $messageText = "New Wire Transfer";
                        $recipient = $row['acct_phone'];

                        $responseBody = send_bulk_sms(array(
                            'sender_name' => get_setting('display_name'),
                            'recipient' => $recipient,
                            'reference' => date('Y') . uniqid() . rand(1, 9),
                            'message' => $messageText
                        ));
                    }

                    // $full_name = $row['firstname'] . " " . $row['lastname'];
                    // $APP_NAME = WEB_TITLE;
                    // $APP_URL = WEB_URL;
                    // $SITE_ADDRESS = $page['website_address'];
                    // $user_email = $row['acct_email'];
                    // $message = $sendMail->WireMsg($full_name, $amount, $account_type, $trans_type, $refrence_id, $swift_code, $routine_number, $bank_country, $bank_name, $trans_status, $account_number, $account_name, $APP_NAME, $APP_URL, $SITE_ADDRESS);
                    // // User Email
                    // $subject = "Wire Transfer" . "-" . $APP_NAME;
                    // $email_message->send_mail($user_email, $message, $subject);

                    $_SESSION['dom_transfer'] = $refrence_id;
                    $_SESSION['is_transfer']  = "transfer";

                    $msg1 = "
                <div class='alert alert-warning'>
                
                <script type='text/javascript'>
                     
                        function Redirect() {
                        window.location='./success.php';
                        }
                        document.write ('');
                        setTimeout('Redirect()', 5500);
                     
                        </script>
                        
                <center><img src='../ui/loading.gif' width='180px'  /></center>
                
                
                <center>	<strong style='color:black;'>Transaction successfully, Please Wait while we redirect you...
                       </strong></center>
                  </div>
                ";
                } else {
                    toast_alert("error", "Sorry Error Occured Contact Support");
                }
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

                <div id="basic" class="col-lg-6 mx-auto">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>Kindly validate this transaction with your account pincode!</h4>
                                </div>
                            </div>
                        </div>

                        <div class="widget-content widget-content-area">

                            <?php if (isset($msg1)) echo $msg1; ?>

                            <form method="POST" enctype="multipart/form-data">

                                <label for="basic-url">Secure Pincode</label>
                                <div class="input-group mb-4">
                                    <input type="number" class="form-control" placeholder="******" name="pin" aria-label="Username">




                                    <input type="text" value="<?= $temp_trans['amount'] ?>" name="amount" hidden>
                                    <input type="text" value="<?= $temp_trans['bank_name'] ?>" name="bank_name" hidden>
                                    <input type="text" value="<?= $temp_trans['account_name'] ?>" name="account_name" hidden>
                                    <input type="text" value="<?= $temp_trans['account_number'] ?>" name="account_number" hidden>
                                    <input type="text" value="<?= $temp_trans['account_type'] ?>" name="account_type" hidden>
                                    <input type="text" value="<?= $temp_trans['bank_country'] ?>" name="bank_country" hidden>
                                    <input type="text" value="<?= $temp_trans['payment_account'] ?>" name="payment_account" hidden>
                                    <input type="text" value="<?= $temp_trans['routine_number'] ?>" name="routine_number" hidden>

                                    <input type="text" value="<?= $temp_trans['description'] ?>" name="description" hidden>
                                    <input type="text" value="<?= $temp_trans['internetid'] ?>" name="internetid" hidden>





                                </div>




                                <div class="input-group">
                                    <button class="btn btn-primary mb-2" type="submit" name="wire_submit" style="background-color: #9d7a3e !important; border-color: none !important;box-shadow: none !important;border-color: #617a87;">Verify Pincode</button>
                                </div>

                            </form>

                        </div>
                    </div>

                    <br><br><br>
                </div>

            </div>

        </div>







        <?php
        require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/footer.php");

        ?>