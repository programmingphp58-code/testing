<?php




$UniqueName  = "Create Credit/Debit History";
require($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/header.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available


if (isset($_POST['credit'])) {
    $internetid = $_POST['internetid'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $payment_account = $_POST['payment_account'];
    $created_at = $_POST['created_at'];

    if (true) {
        $refrence_id = uniqid();
        $trans_type = "Credit";
        $transaction_type = "credit";
        $trans_status = "completed";
        $sql = "INSERT INTO transactions (amount,refrence_id,internetid,payment_account,trans_type,transaction_type,trans_status,description,created_at) VALUES(:amount,:refrence_id,:internetid,:payment_account,:trans_type,:transaction_type,:trans_status,:description,:created_at)";
        $tranfered = $conn->prepare($sql);
        $tranfered->execute([
            'amount' => $amount,
            'refrence_id' => $refrence_id,
            'internetid' => $internetid,
            'payment_account' => $payment_account,
            'trans_type' => $trans_type,
            'transaction_type' => $transaction_type,
            'trans_status' => $trans_status,
            'description' => $description,
            'created_at' => $created_at

        ]);




        if (true) {
            toast_alert('success', 'Credit History Successfully', 'Approved');
        } else {
            toast_alert('error', 'Sorry Something Went Wrong');
        }
    }
} else if (isset($_POST['debit'])) {
    $internetid = $_POST['internetid'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $payment_account = $_POST['payment_account'];
    $created_at = $_POST['created_at'];


    if (true) {
        $refrence_id = uniqid();
        $trans_type = "Debit";
        $transaction_type = "debit";
        $trans_status = "completed";
        $sql = "INSERT INTO transactions (amount,refrence_id,internetid,payment_account,trans_type,transaction_type,trans_status,description,created_at) VALUES(:amount,:refrence_id,:internetid,:payment_account,:trans_type,:transaction_type,:trans_status,:description,:created_at)";
        $tranfered = $conn->prepare($sql);
        $tranfered->execute([
            'amount' => $amount,
            'refrence_id' => $refrence_id,
            'internetid' => $internetid,
            'payment_account' => $payment_account,
            'trans_type' => $trans_type,
            'transaction_type' => $transaction_type,
            'trans_status' => $trans_status,
            'description' => $description,
            'created_at' => $created_at

        ]);


        if (true) {
            toast_alert('success', 'Debit History Successfully', 'Approved');
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
            Credit/Debit User
        </h1>
        <ol class="breadcrumb">
            <li><a href="./dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        </ol>
    </section>



    <!-- Main content -->
    <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <div class="box-header with-border">
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form method="POST">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select user</label>
                                <select name="internetid" class="form-control select2" style="width: 100%;" required>
                                    <option>Select User</option>

                                    <?php
                                    $sql = "select * FROM accounts order by id ASC";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $fullName = $row['firstname'] . " " . $row['lastname']

                                    ?>
                                        <option value="<?= $row['internetid'] ?>">(<?= ucwords($fullName) ?>)<br> <?= $row['acct_email'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- /.form-group -->

                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="number" class="form-control" name="amount" placeholder="0" required>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Funding Account</label>
                                <select name="payment_account" class="form-control select2" style="width: 100%;" required>
                                    <option>Select Payment Account</option>
                                    <option value="savings_account"><strong></strong> Savings Balance</option>
                                    <option value="current_account"><strong></strong> Current Balance</option>
                                    <option value="business_account"><strong></strong> Business Balance</option>
                                </select>

                            </div>

                        </div>




                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" class="form-control" name="description" placeholder="description" required>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="datetime-local" class="form-control" name="created_at" placeholder="00:00:00" required>
                            </div>

                        </div>


                        <!-- /.col -->
                    </div>

                    <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="credit" class="btn btn-primary">Credit In</button>

                <button type="submit" name="debit" class="btn btn-danger">Debit Out</button>
            </div>
        </div>
        <!-- /.box -->

        </form>


    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->



<?php
require($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/footer.php");

?>