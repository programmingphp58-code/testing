<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/configuration/config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/configuration/Function/userClass.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/configuration/Function/Function.php");

$conn = dbConnect();
$message = new message();

$sql = "SELECT * FROM settings WHERE id ='1'";
$stmt = $conn->prepare($sql);
$stmt->execute();

$page = $stmt->fetch(PDO::FETCH_ASSOC);

$title = $page['website_name'];
$website_email = $page['website_email'];

$viesConn = "SELECT * FROM accounts WHERE internetid=:internetid";
$stmt = $conn->prepare($viesConn);

$stmt->execute([
    'internetid' => $_SESSION['internetid']
]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$internetid = $row['internetid'];
$full_name = $row['firstname'] . " " . $row['lastname'];
$acct_stat = $row['acct_status'];

$TotalBalance = floatval($row['savings_balance']) + floatval($row['current_balance']) + floatval($row['business_balance'] ?? 0);
$LoanBalance = floatval($row['loan_balance']);
$CurrentBalance = floatval($row['current_balance']);
$SavingsBalance = floatval($row['savings_balance']);
$BusinessBalance = floatval($row['business_balance'] ?? 0);
$BusinessName = $row['business_name'] ?? '';
$fullName = $row['firstname'] . " " . $row['lastname'];
$email = $row['acct_email'];
$currency = $row['acct_currency'];

$sql = "SELECT * FROM audit_logs ORDER BY datenow DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$logs = $stmt->fetch(PDO::FETCH_ASSOC);
$device = $logs['device'] ?? 'Unknown';
$ipAddress = $logs['ipAddress'] ?? $_SERVER['REMOTE_ADDR'];
$datenow = $logs['datenow'] ?? date('Y-m-d H:i:s');

$sql3 = "SELECT * FROM list_payment WHERE internetid=:internetid";
$stmt44 = $conn->prepare($sql3);
$stmt44->execute([
    'internetid' => $_SESSION['internetid']
]);
$list_payment = $stmt44->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM transactions WHERE internetid =:internetid ORDER BY trans_id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute([
    'internetid' => $_SESSION['internetid']
]);
$transac = $stmt->fetch(PDO::FETCH_ASSOC);

function TransType($transac)
{
    if ($transac['payment_account'] == 'current_account') {
        return 'Current Account';
    }

    if ($transac['payment_account'] == 'savings_account') {
        return 'Savings Account';
    }
}

$TransType = '';
if(is_array($transac)) {
    $TransType = TransType($transac);
}


// Define the TransStatus function
function TransStatus($transac)
{
    if ($transac['trans_status'] == 'completed') {
        return '<span class="badge badge-primary inv-status">Completed</span>';
    }

    if ($transac['trans_status'] == 'pending') {
        return '<span class="badge badge-info inv-status">Pending</span>';
    }
    if ($transac['trans_status'] == 'processing') {
        return '<span class="badge badge-warning inv-status">Processing</span>';
    }
    if ($transac['trans_status'] == 'failed') {
        return '<span class="badge badge-danger inv-status">Failed</span>';
    }
}


$TransStatus = '';
if(is_array($transac)) {
    $TransStatus = TransStatus($transac);
}

$sql = "SELECT * FROM ticket WHERE internetid =:internetid";
$stmt = $conn->prepare($sql);
$stmt->execute([
    'internetid' => $_SESSION['internetid']
]);
$result44 = $stmt->fetch(PDO::FETCH_ASSOC);


// Define the TickeStatus function
function TickeStatus($result44)
{
    if ($result44['ticket_status'] == 'open') {
        return '<span class="shadow-none badge outline-badge-info">Completed</span>';
    }

    if ($result44['ticket_status'] == 'closed') {
        return '<span class="shadow-none badge outline-badge-danger">Closed</span>';
    }
    if ($result44['ticket_status'] == 'processing') {
        return '<span class="shadow-none badge outline-badge-secondary">Processing</span>';
    }
    if ($result44['ticket_status'] == 'approved') {
        return '<span class="shadow-none badge outline-badge-success">Approved</span>';
    }
}

$TickeStatus = '';
if(is_array($result44)) {
    $TickeStatus = TickeStatus($result44);
}

$sql2 = "SELECT * FROM card WHERE internetid=:internetid";
$cardstmt = $conn->prepare($sql2);
$cardstmt->execute([
    'internetid' => $_SESSION['internetid']
]);

$cardCheck = $cardstmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM temp_dumps WHERE internetid =:internetid ORDER BY trans_id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute([
    'internetid' => $_SESSION['internetid']
]);
$temp_trans = $stmt->fetch(PDO::FETCH_ASSOC);

$TempBalance = '';
if(is_array($temp_trans)) {
    $TempBalance = $temp_trans['amount'];
}

function userStatus($row)
{
    if ($row['acct_status'] === 'active') {
        return 'ACTIVE';
    }

    if ($row['acct_status'] === 'hold') {
        return 'ON HOLD';
    }
    return ''; // Handle other cases or return default value
}

$userStatus = userStatus($row);
?>
