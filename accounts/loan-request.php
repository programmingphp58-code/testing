<?php

$UniqueName  = "Loan Request";
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


if (isset($_POST['loan_submit'])) {
    $pin = inputValidation($_POST['pin']);
    $oldPin = inputValidation($row['acct_pin']);

    $internetid = inputValidation($row['internetid']);
    $amount = inputValidation($_POST['amount']);
    $loan_type = inputValidation($_POST['loan_type']);
    $duration = inputValidation($_POST['duration']);
    $description = inputValidation($_POST['description']);
    $payment_account = inputValidation($_POST['payment_account']);


    $loanlimit = $page['loanlimit'];

    if ($pin !== $oldPin) {
        toast_alert('error', 'Incorrect PINCODE');
    } else if ($amount > $loanlimit) {
        toast_alert('error', 'Limit Reached');
    } else {


        if (true) {


            if ($page['padiwise_sms'] == '1') {
                $messageText = "New Loan Request";
                $recipient = $row['acct_phone'];

                $responseBody = send_bulk_sms(array(
                    'sender_name' => get_setting('display_name'),
                    'recipient' => $recipient,
                    'reference' => date('Y') . uniqid() . rand(1, 9),
                    'message' => $messageText
                ));
            }

            $trans_type = "Loan";
            $trans_status = "processing";
            $transaction_type = "credit";
            $refrence_id = uniqid();
            $sql = "INSERT INTO transactions (amount,internetid,loan_type,payment_account,duration,trans_type,transaction_type,refrence_id,description,trans_status) VALUES(:amount,:internetid,:loan_type,:payment_account,:duration,:trans_type,:transaction_type,:refrence_id,:description,:trans_status)";
            $tranfered = $conn->prepare($sql);
            $tranfered->execute([
                'amount' => $amount,
                'internetid' => $internetid,
                'loan_type' => $loan_type,
                'payment_account' => $payment_account,
                'duration' => $duration,
                'trans_type' => $trans_type,
                'transaction_type' => $transaction_type,
                'refrence_id' => $refrence_id,
                'description' => $description,
                'trans_status' => $trans_status
            ]);

            $details = "Loan Request";
            $stmt2 = $conn->prepare("INSERT INTO activities (internetid,details) VALUES(:internetid,:details)");
            $stmt2->execute([
                'internetid' => $_SESSION['internetid'],
                'details' => $details
            ]);



            if (true) {
                // $full_name = $row['firstname'] . " " . $row['lastname'];
                // $APP_NAME = WEB_TITLE;
                // $APP_URL = WEB_URL;
                // $SITE_ADDRESS = $page['website_address'];
                // $user_email = $row['acct_email'];
                // $internetid = $row['acct_no'];
                // $message = $sendMail->LoanMsg($full_name, $amount, $internetid, $trans_type, $trans_status, $APP_NAME, $APP_URL, $SITE_ADDRESS);
                // // User Email
                // $subject = "Loan Notification" . "-" . $APP_NAME;
                // $email_message->send_mail($user_email, $message, $subject);

                // $_SESSION['dom_transfer'] = $refrence_id;
                // $_SESSION['is_transfer']  = "transfer";
                // header("Location:./success.php");
                toast_alert("success", "Your request is been reviewed", "Thank You");
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



                <div id="basic" class="col-lg-6 mx-auto">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4><?= $UniqueName ?></h4>
                                </div>
                            </div>
                        </div>

                        <div class="widget-content widget-content-area">
                            <form method="POST" enctype="multipart/form-data">
                                <label for="basic-url">Loan Amount</label>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?= $currency ?></span>
                                    </div>
                                    <input type="text" class="form-control" name="amount" required aria-label="Amount (to the nearest dollar)">


                                    <input type="text" hidden value="<?= $row['internetid'] ?>" name="internetid">

                                </div>

                                <label for="basic-url">Settlement Account</label>
                                <div class="input-group mb-4">
                                    <select class="form-control  basic" required name="payment_account">
                                        <option>Select Settlement Account</option>
                                        <option value="savings_account"><strong>(<?= $row['savings_acctno'] ?>)</strong> Savings: <?= $currency ?><?php echo number_format($SavingsBalance, 2, '.', ','); ?></option>
                                        <option value="current_account"><strong>(<?= $row['current_acctno'] ?>)</strong> Current: <?= $currency ?><?php echo number_format($CurrentBalance, 2, '.', ','); ?></option>
                                    </select>
                                </div>

                                <label for="basic-url">Loan Type</label>
                                <div class="input-group mb-4">
                                    <select class="form-control  basic" required name="loan_type">
                                        <option>Select Loan Type</option>
                                        <option value="Business Loan">Business Loan</option>
                                        <option value="Individual Loan">Individual Loan</option>
                                        <option value="Student Loan">Student Loan</option>
                                    </select>
                                </div>

                                <label for="basic-url">Loan Duration</label>

                                <div class="input-group mb-4">
                                    <select class="form-control  basic" required name="duration">
                                        <option>Select Loan Duration</option>
                                        <option value="1 Week">1 Week</option>
                                        <option value="2 Weeks">2 Weeks</option>
                                        <option value="1 Month">1 Month</option>
                                        <option value="3 Months">3 Months</option>
                                        <option value="A Year">A Year</option>
                                    </select>
                                </div>











                                <label for="basic-url">Details</label>
                                <div class="input-group mb-4">
                                    <textarea class="form-control" aria-label="With textarea" rows="5" required name="description" placeholder="Reason for loan"></textarea>
                                </div>


                                <label for="basic-url">Account Pincode</label>
                                <div class="input-group mb-4">
                                    <input type="text" class="form-control" placeholder="******" name="pin">
                                </div>



                                <div class="input-group">
                                    <button class="btn btn-primary mb-2" name="loan_submit" style="background-color: #9d7a3e !important; border-color: none !important;box-shadow: none !important;border-color: #617a87;">Request Loan</button>
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