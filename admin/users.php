<?php

$UniqueName  = "Users";
require($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/header.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available


//$balances = $row['acct_balance']->rowCount();

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            All Users
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
                        <div class="table-responsive">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Account No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Total Balance</th>
                                        <th>Savings</th>
                                        <th>Current</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM accounts order by id ASC";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $sn = 1;
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $fullName = $row['firstname'] . " " . $row['lastname'];

                                        $TotalBalance = floatval($row['savings_balance']) + floatval($row['current_balance']) + floatval($row['business_balance'] ?? 0);
$LoanBalance = floatval($row['loan_balance']);
$CurrentBalance = floatval($row['current_balance']);
$SavingsBalance = floatval($row['savings_balance']);
                                    ?>
                                        <tr>
                                             <td><?= $sn++ ?></td>
                                            <td><?= $row['internetid'] ?></td>
                                            <td><?= $fullName ?></td>
                                            <td><?= $row['acct_email'] ?></td>

                                            <td><?= $row['acct_currency'] ?><?php echo number_format($TotalBalance, 2, '.', ','); ?></td>
                                            <td><?= $row['acct_currency'] ?><?php echo number_format($SavingsBalance, 2, '.', ','); ?></td>
                                            <td><?= $row['acct_currency'] ?><?php echo number_format($CurrentBalance, 2, '.', ','); ?></td>
                                            
                                            <td><?php echo $userStatus ?></td>
                                            <td><?= $row['createdat'] ?? $row['createdAt'] ?? 'N/A' ?></td>
                                            <td class="text-center">
                                                <a href="./view_users.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">View</a>
                                                <a href="./delete_user.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Del</a>
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


<?php
require($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/footer.php");

?>