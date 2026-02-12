<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/configuration/config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/configuration/Function/sql.php");

$conn = dbConnect();
$message = new USER();

$viesConn = "SELECT * FROM accounts WHERE internetid=:internetid";
$stmt = $conn->prepare($viesConn);
$stmt->execute([
    'internetid' => $_SESSION['internetid']
]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$TotalBalance = floatval($row['savings_balance']) + floatval($row['current_balance']) + floatval($row['business_balance'] ?? 0);


$sql = "SELECT * FROM settings WHERE id ='1'";
$stmt = $conn->prepare($sql);
$stmt->execute();

$page = $stmt->fetch(PDO::FETCH_ASSOC);
  

$DomesticLimit = $page['domesticlimit'];
$TransferLimit = 50;

if (isset($_POST['domestic-transfer'])) {
    $internetid = $_POST['internetid'];
    $amount = $_POST['amount'];
    $DomesticFee = $_POST['fee'];
    $account_name = $_POST['account_name'];
    $bank_name = $_POST['bank_name'];
    $account_number = $_POST['account_number'];
    $payment_account = $_POST['payment_account'];
    $description = $_POST['description'];


    $checkFee = ($amount + $DomesticFee);

    if ($payment_account == "savings_account" AND floatval($checkFee) > floatval($row['savings_balance'] ?? 0)) {
        toast_alert('error', 'Insufficient Savings Balance');
    } elseif ($payment_account == "current_account" AND floatval($checkFee) > floatval($row['current_balance'] ?? 0)) {
        toast_alert('error', 'Insufficient Current Balance');
    } elseif ($payment_account == "business_account" AND floatval($checkFee) > floatval($row['business_balance'] ?? 0)) {
        toast_alert('error', 'Insufficient Business Balance');
    } elseif ($row['acct_status'] == 'hold') {
        toast_alert('error', 'Account on Hold Contact Support');
    } elseif ($amount > $DomesticLimit) {
        toast_alert("error", "Transfer Limit Extended!");
    } elseif ($amount < $TransferLimit) {
        toast_alert("error", "Amount too low!");
    } else {



        $refrence_id = uniqid();
        $trans_type = "Domestic transfer";
        $transaction_type = "debit";
        $trans_status = "pending";
        $sql = "INSERT INTO temp_dumps (amount,refrence_id,internetid,bank_name,account_name,account_number,trans_type,transaction_type,trans_status,routine_number,payment_account,description) VALUES(:amount,:refrence_id,:internetid,:bank_name,:account_name,:account_number,:trans_type,:transaction_type,:trans_status,:routine_number,:payment_account,:description)";
        $tranfered = $conn->prepare($sql);
        $tranfered->execute([
            'amount' => $amount,
            'refrence_id' => $refrence_id,
            'internetid' => $internetid,
            'bank_name' => $bank_name,
            'account_name' => $account_name,
            'account_number' => $account_number,
            'trans_type' => $trans_type,
            'transaction_type' => $transaction_type,
            'trans_status' => $trans_status,
            'routine_number' => $routine_number,
            'payment_account' => $payment_account,
            'description' => $description

        ]);


        $details = "New Domestic Transfer";
        $stmt2 = $conn->prepare("INSERT INTO activities (internetid,details) VALUES(:internetid,:details)");
        $stmt2->execute([
        'internetid' => $_SESSION['internetid'],
        'details' => $details
        ]);

        if (true) {




            $_SESSION['is_dom_code'] = "None";
            $_SESSION['is_dom_transfer'] = "Dom";
            $_SESSION['is_transfer'] = "None";

            $msg1 = "
                <div class='alert alert-warning'>
                
                <script type='text/javascript'>
                     
                        function Redirect() {
                        window.location='./dom-pin.php';
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

