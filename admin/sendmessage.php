<?php
$UniqueName  = "Send Message";
require($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/header.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available


//$balances = $row['acct_balance']->rowCount();



if (isset($_POST['sendsms'])) {
    $message = $_POST['message'];
    @$recipient = $_POST['recipient'];
    $send_to = $_POST['send_to'];

    $data = array();

    if ($send_to == 1) {
        $sql = $conn->query("SELECT acct_phone FROM accounts WHERE acct_phone !='' order by id ASC");
        while ($rs = $sql->fetch(PDO::FETCH_ASSOC)) {
            //sendEmail($message,$rs['acct_phone'],$subject);
            $data[] = $rs['acct_phone'];
        }
    }

    if ($send_to == 2) {
        for ($i = 0; $i <= count($recipient); $i++) {
            if (!empty($recipient[$i])) {
                //sendEmail($message,$number[$i],$subject);
                $data[] = $recipient[$i];
            }
        }
    }

    $recipient = implode(',', $data);

    $responseBody = send_bulk_sms(array(
        'sender_name' => get_setting('display_name'),
        'recipient' => $recipient,
        'reference' => date('Y') . uniqid() . rand(1, 9),
        'message' => $message
    ));

    // echo "<pre>". var_export($responseBody,true) . "</pre>";

    if ($responseBody['status'] == false) {
        set_flash($responseBody['data']['message'], 'info');
    } else {
        set_flash($responseBody['data']['message'], 'info');
    }
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Send New Message
        </h1>
        <ol class="breadcrumb">
            <li><a href="./dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-7 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->

                <!-- quick email widget -->
                <div class="box box-info">
                    <div class="box-header">
                        <i class="fa fa-envelope"></i>

                        <h3 class="box-title">Quick SMS</h3>
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

                            <?= flash() ?>

                            <div class="form-group send-to">
                                <label for="">Send To Type</label>
                                <select name="send_to" required id="send-to" class="form-control select2">
                                    <option value="" disabled selected>Select</option>
                                    <option value="1">To All Numbers</option>
                                    <option value="2">One By One</option>
                                </select>
                            </div>

                            <div class="form-group hide user-recipient">
                                <label for="">Select Numbers</label>

                                <select name="recipient[]" multiple class="form-control select2" style="width: 100%;">

                                    <?php
                                    $sql = "SELECT * FROM accounts WHERE acct_phone !='' order by id ASC";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {


                                    ?>
                                        <option value="<?= $row['acct_phone'] ?>"><?= $row['acct_phone'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Sender ID <a href="./api_settings.php">Change</a></label>
                                <input type="text" class="form-control" value="<?= get_setting('display_name') ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Message</label>
                                <textarea class="textarea" placeholder="Message" name="message" required style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                            </div>

                            <div class="form-group">
                                <p>POSSIBLE DELAY IN MESSAGE DELIVERY: delivery of messages sent via the regular route around 7:45pm everyday and resumes by 8:00am the next day. We recommend that you pause message delivery on/before 7:30pm.</p>
                            </div>

                        </div>
                        <div class="box-footer clearfix">
                            <button type="submit" class="pull-right btn btn-default" name="sendsms">Send SMS
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

                        <h3 class="box-title">
                            Visitors
                        </h3>
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