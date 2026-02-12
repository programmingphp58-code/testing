<?php
$UniqueName  = "View Ticket";
require($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/header.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available


$id = $_GET['id'];
$sql = "SELECT * FROM ticket LEFT JOIN accounts ON ticket.internetid = accounts.internetid WHERE ticket_id =:id";
$data = $conn->prepare($sql);
$data->execute([
    'id' => $id
]);

$result = $data->fetch(PDO::FETCH_ASSOC);

$TotalBalance = $result['savings_balance'] + $result['current_balance'];


if (isset($_POST['reply'])) {
    $status_value = "processing";
    $messagereply = $_POST['messagereply'];
    $sql = "UPDATE ticket SET ticket_status=:dom_status WHERE ticket_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'dom_status' => $status_value,
        'id' => $id
    ]);



    $full_name = $result['firstname'] . " " . $result['lastname'];
    $loan_balance = $result['loan_balance'];
    $APP_NAME = WEB_TITLE;
    $APP_URL = WEB_URL;
    $SITE_ADDRESS = $page['website_address'];
    $user_email = $result['acct_email'];

    $trans_status = "processing";
    $message = $sendMail->AdminTicketMsg($full_name, $messagereply, $internetid, $trans_status, $APP_NAME, $APP_URL, $SITE_ADDRESS);
    // User Email
    $subject = "Ticket Status" . "-" . $APP_NAME;
    // $email_message->send_mail($user_email, $message, $subject);

    if (true) {
        $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./messages.php';
                }
                document.write ('');
                setTimeout('Redirect()', 3000);
             
                </script>
                
        <center><img src='../ui/loading.gif' width='180px'  /></center>
        
        
        <center>	<strong style='color:black;'>Ticket updated successfully, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";
    } else {
        toast_alert('error', 'Sorry Something Went Wrong');
    }
}

if (isset($_POST['closed'])) {
    $status_value = "closed";
    $messagereply = $_POST['messagereply'];
    $sql = "UPDATE ticket SET ticket_status=:dom_status WHERE ticket_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'dom_status' => $status_value,
        'id' => $id
    ]);



    $full_name = $result['firstname'] . " " . $result['lastname'];
    $APP_NAME = WEB_TITLE;
    $APP_URL = WEB_URL;
    $SITE_ADDRESS = $page['website_address'];
    $user_email = $result['acct_email'];

    $trans_status = "closed";
    $message = $sendMail->AdminTicketMsg($full_name, $messagereply, $internetid, $trans_status, $APP_NAME, $APP_URL, $SITE_ADDRESS);
    // User Email
    $subject = "Ticket Closed" . "-" . $APP_NAME;
    // $email_message->send_mail($user_email, $message, $subject);

    if (true) {
        $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./messages.php';
                }
                document.write ('');
                setTimeout('Redirect()', 3000);
             
                </script>
                
        <center><img src='../ui/loading.gif' width='180px'  /></center>
        
        
        <center>	<strong style='color:black;'>Ticket closed successfully, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";
    } else {
        toast_alert('error', 'Sorry Something Went Wrong');
    }
}



?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Support Ticket
        </h1>
        <ol class="breadcrumb">
            <li><a href="./dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <?php if (isset($msg1)) echo $msg1; ?>
                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                <form class="section general-info" method="POST" enctype="multipart/form-data" action="">

                                    <div class="info">
                                        <div class="row">
                                            <div class="col-md-12 offset-md-2 table-responsive">
                                                <table class="table table-bordered mb-4">
                                                    <tbody>
                                                        <tr>
                                                            <th>User Full Name</th>
                                                            <th class="text-uppercase"><?= ucwords($fullName) ?></th>
                                                        </tr>
                                                        <tr>
                                                            <th>User Email</th>
                                                            <th><?= $result['acct_email'] ?></th>
                                                        </tr>
                                                        <tr>
                                                            <th>Account ID</th>
                                                            <th><?= $result['internetid'] ?></th>
                                                        </tr>

                                                        <tr>
                                                            <th>Account Balance</th>
                                                            <th><?= $currency?><?php echo number_format($TotalBalance, 2, '.', ','); ?></th>
                                                        </tr>
                                                        <tr>
                                                            <th>Loan Balance</th>
                                                            <th><?= $currency . $result['loan_balance'] ?></th>
                                                        </tr>
                                                        <tr>
                                                            <th>Created At</th>
                                                            <th><?= $result['createdAt'] ?></th>
                                                        </tr>
                                                        <tr>
                                                            <th>Status</th>
                                                            <th>Ticket <?= $result['ticket_status'] ?></th>
                                                        </tr>

                                                        <tr>
                                                            <th>Ticket Message</th>
                                                            <th><?= $result['ticket_message'] ?></th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 offset-md-2">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="" class="text-center text-info">Message inbox </label>
                                                        <textarea class="form-control mb-4 text-danger" rows="6" id="textarea-copy" placeholder="text" style="resize: none" name="messagereply"></textarea>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="box-body pad">

                                                        </div>


                                                        <div class="box-footer">
                                                            <div class="box-footer">
                                                                <button type="submit" name="reply" class="btn btn-success">Reply Ticket</button>

                                                                <button type="submit" name="closed" class="btn btn-warning">Close Ticket</button>



                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->


            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php
require($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/footer.php");

?>