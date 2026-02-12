<?php




$UniqueName  = "Dashboard";
require($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/header.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available

$sql = "SELECT * FROM accounts";
$stmt = $conn->prepare($sql);
$stmt->execute();
$row_count = $stmt->rowCount();
$row = $stmt->fetch(PDO::FETCH_ASSOC);



if (isset($_POST['newsletter'])) {
    $acct_email = $_POST['acct_email'];
    $subjectid = $_POST['subjectid'];
    $messageid = $_POST['messageid'];



    if (true) {

        $APP_NAME = WEB_TITLE;
        $APP_URL = WEB_URL;
        $SITE_ADDRESS = $page['website_address'];
        $user_email = $row['acct_email'];
        $message = $sendMail->MessageUsers($subjectid, $messageid, $APP_NAME, $APP_URL, $SITE_ADDRESS);
        $subject = "$subjectid - $APP_NAME";
        // $email_message->send_mail($acct_email, $message, $subject);

        if (true) {
            toast_alert('success', 'Email Successfully Sent', 'Approved');
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
            Dashboard
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <?php
                        // Total Balance: fetch all accounts and sum balances in PHP
                        $sql = "SELECT savings_balance, current_balance, business_balance FROM accounts";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        
                        $TotalSum = 0;
                        while ($acc = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $TotalSum += floatval($acc['savings_balance'] ?? 0) + floatval($acc['current_balance'] ?? 0) + floatval($acc['business_balance'] ?? 0);
                        }
                        ?>
                        <h4><?= $currency ?><?php echo number_format($TotalSum, 2, '.', ','); ?></h4>

                        <p>Total Balance</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="./fundings.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <?php

                        $stmt = $conn->query("SELECT * FROM accounts");
                        ?>

                        <h4><?= $stmt->rowCount() ?></h4>

                        <p>Total User</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="./users.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <?php
                        $sql = "SELECT amount FROM transactions WHERE trans_type='Wire transfer'";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();

                        $wire = 0;
                        while ($trans = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $wire += floatval($trans['amount']);
                        }
                        ?>
                        <h4><?= $currency ?><?php echo number_format($wire, 2, '.', ','); ?></h4>

                        <p>Total Wire</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="./wire-trans.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <?php
                        $sql = "SELECT amount FROM transactions WHERE trans_type='Domestic transfer'";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();

                        $dom = 0;
                        while ($trans = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $dom += floatval($trans['amount']);
                        }
                        ?>
                        <h4><?= $currency ?><?php echo number_format($dom, 2, '.', ','); ?></h4>

                        <p>Total Domestic</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="./domestic-trans.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->


        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <?php
                        $sql2 = "SELECT current_balance FROM accounts";
                        $stmt0 = $conn->prepare($sql2);
                        $stmt0->execute();

                        $sum = 0;
                        while ($acc = $stmt0->fetch(PDO::FETCH_ASSOC)) {
                            $sum += floatval($acc['current_balance'] ?? 0);
                        }

                        ?>
                        <h4><?= $currency ?><?php echo number_format($sum, 2, '.', ','); ?></h4>

                        <p>Total Current Balance</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="./users.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <?php
                        $sql2 = "SELECT savings_balance FROM accounts";
                        $stmt0 = $conn->prepare($sql2);
                        $stmt0->execute();

                        $sum2 = 0;
                        while ($acc = $stmt0->fetch(PDO::FETCH_ASSOC)) {
                            $sum2 += floatval($acc['savings_balance'] ?? 0);
                        }


                        ?>
                        <h4><?= $currency ?><?php echo number_format($sum2, 2, '.', ','); ?></h4>

                        <p>Total Savings Balance</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="./users.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-blue">
                    <div class="inner">
                        <?php

                        $stmt = $conn->query("SELECT * FROM card");
                        ?>

                        <h4><?= $stmt->rowCount() ?></h4>
                        <p>Total Cards</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="./cards.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <?php
                        $stmt = $conn->query("SELECT * FROM ticket");
                        ?>

                        <h4><?= $stmt->rowCount() ?></h4>
                        <p>Total Tickets</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="./messages.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- Small boxes (Stat box) -->
        <!-- /.row -->


        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-7 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->






                <!-- quick email widget -->
                <div class="box box-info">
                    <div class="box-header">
                        <i class="fa fa-envelope"></i>

                        <h4 class="box-title">Quick Email</h4>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <!--<button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"-->
                            <!--    title="Remove">-->
                            <!--    <i class="fa fa-times"></i></button>-->
                        </div>
                        <!-- /. tools -->
                    </div>
                    <form method="post">
                        <div class="box-body">

                            <div class="form-group">

                                <select name="internetid" class="form-control select2" style="width: 100%;" required>
                                    <option>Select User Email</option>

                                    <?php
                                    $sql = "SELECT * FROM accounts order by id ASC";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {


                                    ?>
                                        <option value="<?= $row['acct_email'] ?>"><?= $row['acct_email'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="subjectid" placeholder="Subject">
                            </div>
                            <div>
                                <textarea class="textarea" placeholder="Message" name="messageid" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                            </div>

                        </div>
                        <div class="box-footer clearfix">
                            <button type="submit" class="pull-right btn btn-default" name="newsletter">Send Mails
                                <i class="fa fa-arrow-circle-right"></i></button>
                        </div>
                    </form>
                </div>

            </section>
            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-5 connectedSortable">

                <!-- Map box -->
                <div class="box box-solid bg-light-blue-gradient">
                    <div class="box-header">
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-primary btn-sm daterange pull-right" data-toggle="tooltip" title="Date range">
                                <i class="fa fa-calendar"></i></button>
                            <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
                                <i class="fa fa-minus"></i></button>
                        </div>
                        <!-- /. tools -->

                        <i class="fa fa-map-marker"></i>

                        <h4 class="box-title">
                            Visitors
                        </h4>
                    </div>
                    <div class="box-body">
                        <div id="world-map" style="height: 250px; width: 100%;"></div>
                    </div>
                    <!-- /.box-body-->
                    <div class="box-footer no-border">
                        <div class="row">
                            <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                                <div id="sparkline-1"></div>
                                <div class="knob-label">Visitors</div>
                            </div>
                            <!-- ./col -->
                            <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                                <div id="sparkline-2"></div>
                                <div class="knob-label">Online</div>
                            </div>
                            <!-- ./col -->
                            <div class="col-xs-4 text-center">
                                <div id="sparkline-3"></div>
                                <div class="knob-label">Exists</div>
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
                <!-- /.box -->
            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->


    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php
require($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/footer.php");

?>