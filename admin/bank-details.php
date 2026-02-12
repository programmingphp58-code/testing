<?php

$UniqueName  = "All Bank Details";
include($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/header.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available


if (isset($_POST['crypto_save'])) {
    $bname = $_POST['bname'];
    $baddress = $_POST['baddress'];
    $account_name = $_POST["account_name"];
    $iban = $_POST['iban'];
    $swift_code = $_POST['swift_code'];
    $internetid = $_POST['internetid'];
    $refrence_id = uniqid();

    $sql = "INSERT INTO list_payment (bname,baddress,account_name,iban,swift_code,internetid,refrence_id)VALUES(:bname,:baddress,:account_name,:iban,:swift_code,:internetid,:refrence_id)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'bname' => $bname,
        'baddress' => $baddress,
        'account_name' => $account_name,
        'iban' => $iban,
        'swift_code' => $swift_code,
        'internetid' => $internetid,
        'refrence_id' => $refrence_id
    ]);

    if (true) {
        toast_alert('success', 'Payment Add Successfully', 'Success');
    } else {
        toast_alert('error', 'Something Went Wrong');
    }
}


//$balances = $row['acct_balance']->rowCount();

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Digital Payment
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

                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#payments">
                            Add New Payment
                        </button>
                        <br>
                        <div class="table-responsive">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Bank Name</th>
                                        <th>Acct Name</th>
                                        <th>User</th>
                                        <th>IBAN</th>
                                        <th>Address</th>
                                        <th>Swift</th>
                                        <th>Reference</th>
                                        <th>Date</th>
                                        <th class="text-center dt-no-sorting">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM list_payment LEFT JOIN accounts ON list_payment.internetid = accounts.internetid";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $sn = 1;
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {



                                    ?>
                                        <tr>

                                            <td><?= $sn++ ?></td>
                                            <td><?= $row['bname'] ?></td>
                                            <td><?= $row['account_name'] ?></td>
                                            <td><?= $row['acct_email'] ?></td>
                                            <td><?= $row['iban'] ?></td>
                                            <td><?= $row['baddress'] ?></td>
                                            <td><?= $row['swift_code'] ?></td>
                                            <td>#<?= $row['refrence_id'] ?></td>
                                            <td><?= $row['createdAt'] ?></td>
                                            <td class="text-center">
                                                <a href="./delete_bank.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Del</a>


                                            </td>

                                        </tr>

                                    <?php
                                    }
                                    ?>


                                </tbody>
                                <tfoot>
                                    <tr>
                                        <br>
                                    </tr>
                                </tfoot>
                            </table>
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


<div class="modal fade" id="payments">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create New Bank Details</h4>
            </div>
            <form method="POST">
                <div class="modal-body">
                    
                    <p><select name="internetid" class="form-control select2" style="width: 100%;" required>
                                    <option>Select User</option>

                                    <?php
                                    $sql = "select * FROM accounts order by id ASC";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $fullName = $row['firstname'] . " " . $row['lastname']

                                    ?>
                                        <option value="<?= $row['internetid'] ?>">(<?= ucwords($fullName) ?>)<br> <?=$row['acct_email'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select></p>
                                
                                
                    <p>
                        <input type="text" class="form-control" name="bname" require placeholder="Bank Name">
                    </p>
                    
                    
                    <p>
                        <input type="text" class="form-control" name="account_name" require placeholder="Account Name">
                    </p>





<p>
                        <input type="text" class="form-control" name="baddress" require placeholder="Bank Address">
                    </p>

<p>
                        <input type="text" class="form-control" name="iban" require placeholder="IBAN">
                    </p>


                    <p>
                        <input type="text" class="form-control" name="swift_code" require placeholder="Swift Code">
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="crypto_save">Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<?php
include($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/footer.php");

?>