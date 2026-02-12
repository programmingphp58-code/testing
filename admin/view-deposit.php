<?php




$UniqueName  = "Edit Deposit Transactions";
require($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/header.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available

$id = $_GET['id'];
$sql = "SELECT * FROM transactions LEFT JOIN accounts ON transactions.internetid = accounts.internetid WHERE refrence_id =:id";
$data = $conn->prepare($sql);
$data->execute([
    'id' => $id
]);

$result = $data->fetch(PDO::FETCH_ASSOC);
$transStatus = TranStatus($result);
$id1 = $result['id'];


$sql = "SELECT d.*, c.crypto_name FROM transactions d INNER JOIN digital_payment c ON d.crypto_id = c.id WHERE refrence_id='$id'";
$stmt = $conn->prepare($sql);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);

$fullName = $result['firstname']  . " " .  $result['lastname'];
 
 $internetid = $result['internetid'];

if (isset($_POST['accept'])) {
    $status_value = "completed";
    $amount = $result['amount'];
   
    $payment_account = $result['payment_account'];

    $trans_id = $row['trans_id'];
    $sql = "UPDATE transactions SET trans_status=:crypto_status WHERE refrence_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'crypto_status' => $status_value,
        'id' => $id
    ]);

    if (true) {
        
     if ($payment_account  == "current_account") {


            $tBalance = $amount + $result['current_balance'];
            $sql = "UPDATE accounts SET current_balance=:current_balance WHERE internetid=:internetid";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'current_balance' => $tBalance,
                'internetid' => $internetid
            ]);
        } else {
    
            $SBalance = $amount + $result['savings_balance'];
            $sql = "UPDATE accounts SET savings_balance=:savings_balance WHERE internetid=:internetid";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'savings_balance' => $SBalance,
                'internetid' => $internetid
            ]);
        }
        
        
       

        if (true) {

            $full_name = $result['firstname'] . " " . $result['lastname'];
             $user_balance = $result['current_balance'] + $result['savings_balance'];

            $APP_NAME = WEB_TITLE;
            $APP_URL = WEB_URL;
            $SITE_ADDRESS = $page['website_address'];
            $user_email = $result['acct_email'];
            $trans_status = "completed";
            $trans_type = "Deposit";
            $message = $sendMail->AdminFundingMsg($full_name, $amount, $user_balance, $internetid, $trans_status, $trans_type, $APP_NAME, $APP_URL, $SITE_ADDRESS);
            // User Email
            $subject = "Deposit" . "-" . $APP_NAME;
            // $email_message->send_mail($user_email, $message, $subject);

            if (true) {
                $msg1 = "
                <div class='alert alert-warning'>
                
                <script type='text/javascript'>
                     
                        function Redirect() {
                        window.location='./deposit-trans.php';
                        }
                        document.write ('');
                        setTimeout('Redirect()', 3000);
                     
                        </script>
                        
                <center><img src='../ui/loading.gif' width='180px'  /></center>
                
                
                <center>	<strong style='color:black;'>Successful! Please Wait while we redirect you...
                       </strong></center>
                  </div>
                ";
            } else {
                toast_alert('error', 'Sorry Something Went Wrong');
            }
        }
    }
}

if (isset($_POST['decline'])) {
    $amount = $result['amount'];
    $status_value = "failed";
    $trans_id = $row['trans_id'];
    
     
    $sql = "UPDATE transactions SET trans_status=:crypto_status WHERE refrence_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'crypto_status' => $status_value,
        'id' => $id
    ]);
    if (true) {

        $full_name = $result['firstname'] . " " . $result['lastname'];
        $user_balance = $result['current_balance'] + $result['savings_balance'];

        $APP_NAME = WEB_TITLE;
        $APP_URL = WEB_URL;
        $SITE_ADDRESS = $page['website_address'];
        $user_email = $result['acct_email'];
        $trans_status = "failed";
        $trans_type = "Deposit";
        $message = $sendMail->AdminFundingMsg($full_name, $amount, $user_balance, $internetid, $trans_status, $trans_type, $APP_NAME, $APP_URL, $SITE_ADDRESS);
        // User Email
        $subject = "Deposit" . "-" . $APP_NAME;
        // $email_message->send_mail($user_email, $message, $subject);

        if (true) {
            $msg1 = "
            <div class='alert alert-warning'>
            
            <script type='text/javascript'>
                 
                    function Redirect() {
                    window.location='./deposit-trans.php';
                    }
                    document.write ('');
                    setTimeout('Redirect()', 3000);
                 
                    </script>
                    
            <center><img src='../ui/loading.gif' width='180px'  /></center>
            
            
            <center>	<strong style='color:black;'>Successful! Please Wait while we redirect you...
                   </strong></center>
              </div>
            ";
        } else {
            toast_alert('error', 'Sorry Something Went Wrong');
        }
    }
}


?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Deposit Transactions
        </h1>
        <ol class="breadcrumb">
            <li><a href="./dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        </ol>
    </section>



    <!-- Main content -->
    <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <form method="POST">
                <div class="box-header with-border">
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">

                        <?php if (isset($msg1)) echo $msg1; ?>

                        <div class="col-md-6">

                            <table class="table table-bordered mb-4">
                                <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <th><?= ucwords($fullName) ?></th>
                                    </tr>
                                    <tr>
                                        <th>Amount</th>
                                        <th><?= $currency ?><?= $result['amount'] ?></th>
                                    </tr>

                                    <tr>
                                        <th>Transaction ID</th>
                                        <th>#<?= $result['refrence_id'] ?></th>
                                    </tr>


                                </tbody>
                            </table>


                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">

                            <table class="table table-bordered mb-4">
                                <tbody>

                                    <tr>
                                        <th>Crypto Name</th>
                                        <th><?= $row['crypto_name'] ?></th>
                                    </tr>
                                    <tr>
                                        <th>Receipt</th>
                                        <th>

                                            <a href="../assets/deposit/<?= $result['image'] ?>" target="_blank"><img src="../assets/deposit/<?= $result['image'] ?>" width="20%" alt=""></a>
                                        </th>

                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <th><?= $result['created_at'] ?></th>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <th><?= $transStatus ?></th>
                                    </tr>
                                </tbody>
                            </table>



                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" name="accept" class="btn btn-success">Accept</button>


                    <button type="submit" name="decline" class="btn btn-danger">Decline</button>


                </div>
            </form>
        </div>
        <!-- /.box -->




    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->



<?php
require($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/footer.php");

?>