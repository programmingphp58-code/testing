<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/configuration/config.php");

$conn = dbConnect();
$message = new USER();

$viesConn = "SELECT * FROM accounts WHERE internetid=:internetid";
$stmt = $conn->prepare($viesConn);
$stmt->execute([
    'internetid' => $_SESSION['internetid']
]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// $TotalBalance = $row['savings_balance'] + $row['current_balance'];



if (isset($_POST['Self_submit'])) {

   
$pin = inputValidation($_POST['pin']);
$oldPin = inputValidation($row['acct_pin']);


$internetid = inputValidation($row['internetid']);
$amount = inputValidation($_POST['amount']);
$payment_account = inputValidation($_POST['payment_account']);
$payment_account_from = inputValidation($_POST['payment_account_from']);


$TotalBalance = $row['current_balance'] OR $row['savings_balance'];


if ($pin !== $oldPin) {
    toast_alert('error', 'Incorrect  PINCODE');
} else if ($payment_account_from == "savings_account" AND floatval($amount) > floatval($row['savings_balance'] ?? 0)) {
    toast_alert('error', 'Insufficient Savings Balance');
} elseif ($payment_account_from == "current_account" AND floatval($amount) > floatval($row['current_balance'] ?? 0)) {
    toast_alert('error', 'Insufficient Current Balance');
} elseif ($payment_account_from == "business_account" AND floatval($amount) > floatval($row['business_balance'] ?? 0)) {
    toast_alert('error', 'Insufficient Business Balance');
} elseif ($payment_account == $payment_account_from) {
    toast_alert('error', 'You need to send to a different account!');
}else {

    // Calculate total amount with fee
    $TotalAmountt = floatval($page['selffee']) + floatval($amount);
    
    // Get current balances
    $savings = floatval($row['savings_balance'] ?? 0);
    $current = floatval($row['current_balance'] ?? 0);
    $business = floatval($row['business_balance'] ?? 0);
    
    // Deduct from source account
    if ($payment_account_from == "current_account") {
        $current -= $TotalAmountt;
    } elseif ($payment_account_from == "savings_account") {
        $savings -= $TotalAmountt;
    } elseif ($payment_account_from == "business_account") {
        $business -= $TotalAmountt;
    }
    
    // Add to destination account
    if ($payment_account == "current_account") {
        $current += floatval($amount);
    } elseif ($payment_account == "savings_account") {
        $savings += floatval($amount);
    } elseif ($payment_account == "business_account") {
        $business += floatval($amount);
    }

    // Update all balances
    $sql = "UPDATE accounts SET current_balance=:current_balance,savings_balance=:savings_balance,business_balance=:business_balance WHERE internetid=:internetid";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'current_balance' => $current,
        'savings_balance' => $savings,
        'business_balance' => $business,
        'internetid' => $_SESSION['internetid']
    ]);

   

        if (true) {
            $refrence_id = uniqid();
            $trans_type = "Self transfer";
            $transaction_type = "debit";
            $trans_status = "completed";
            $sql = "INSERT INTO transactions (amount,refrence_id,internetid,trans_type,transaction_type,trans_status,payment_account) VALUES(:amount,:refrence_id,:internetid,:trans_type,:transaction_type,:trans_status,:payment_account)";
            $tranfered = $conn->prepare($sql);
            $tranfered->execute([
                'amount' => $TotalAmountt,
                'refrence_id' => $refrence_id,
                'internetid' => $internetid,
                'trans_type' => $trans_type,
                'transaction_type' => $transaction_type,
                'trans_status' => $trans_status,
                'payment_account' => $payment_account
            ]);


            $refrence_id = uniqid();
            $trans_type = "Self transfer";
            $transaction_type = "credit";
            $trans_status = "completed";
            $sql = "INSERT INTO transactions (amount,refrence_id,internetid,trans_type,transaction_type,trans_status,payment_account) VALUES(:amount,:refrence_id,:internetid,:trans_type,:transaction_type,:trans_status,:payment_account)";
            $tranfered = $conn->prepare($sql);
            $tranfered->execute([
                'amount' => $amount,
                'refrence_id' => $refrence_id,
                'internetid' => $internetid,
                'trans_type' => $trans_type,
                'transaction_type' => $transaction_type,
                'trans_status' => $trans_status,
                'payment_account' => $payment_account_from
            ]);

            



            if (true) {

                $details = "New Self Transfer";
        $stmt2 = $conn->prepare("INSERT INTO activities (internetid,details) VALUES(:internetid,:details)");
        $stmt2->execute([
        'internetid' => $_SESSION['internetid'],
        'details' => $details
        ]);



                if ($page['padiwise_sms'] == '1') {
                    $messageText = "New Self Transfer";
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
            }
        }
}
} 
