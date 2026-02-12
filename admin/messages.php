<?php
$UniqueName  = "Support Ticket";
require($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/header.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available


//$balances = $result['acct_balance']->rowCount();

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

                        <?php if (isset($msg1)) echo $msg1; ?>

                        <div class="table-responsive">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>User Email</th>
                                        <th>Full Name</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th class="text-center dt-no-sorting">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM ticket LEFT JOIN accounts ON ticket.internetid = accounts.internetid ORDER BY ticket_id DESC";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $sn = 1;
                                    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {


                                        $fullName = $result['firstname'] . " " . $result['lastname'];

                                    ?>
                                        <tr>

                                            <td><?= $sn++ ?></td>
                                            <td><?= $result['acct_email'] ?></td>
                                            <td><?= $fullName ?></td>
                                            <td><?= $result['ticket_status'] ?></td>
                                            <td><?= $result['createdAt'] ?></td>
                                            <td class="text-center"><a href="./viewticket.php?id=<?php echo $result['ticket_id']; ?>" class="btn btn-primary">Update</a>
                                                <a href="./view_users.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">View User</a>
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