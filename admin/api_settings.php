<?php

$UniqueName  = "API Settings";
require($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/header.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available
// require($_SERVER['DOCUMENT_ROOT']."/admin/include/adminFunction.php");
//require_once("./configuration/adminloginFunction.php");



if (isset($_POST['save_apisettings'])) {
    $display_name = $_POST['display_name'];
    //$smtp_sender = $_POST['smtp_sender'];
    $access_token = $_POST['access_token'];
    $transaction_pin = $_POST['transaction_pin'];
    $id = "1";
    $sql = "UPDATE sms_api SET display_name=:display_name,access_token=:access_token,transaction_pin=:transaction_pin WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'display_name' => $display_name,
        // 'smtp_sender' => $smtp_sender,
        'access_token' => $access_token,
        'transaction_pin' => $transaction_pin,
        'id' => $id
    ]);

    if (true) {

        $msg1 = "
       <div class='alert alert-warning'>
       
       <script type='text/javascript'>
            
               function Redirect() {
               window.location='./api_settings.php';
               }
               document.write ('');
               setTimeout('Redirect()', 4000);
            
               </script>
               
       
       <center>	<strong style='color:black;'>Updated successfully, Please Wait while we redirect you...
              </strong></center>
         </div>
       ";
    } else {
        toast_alert('error', 'Sorry something went wrong');
    }
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Padiwise API Settings
        </h1>
        <ol class="breadcrumb">
            <li><a href="./dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        </ol>
    </section>



    <!-- Main content -->
    <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <form method="POST" enctype="multipart/form-data" action="">
                <div class="box-header with-border">
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <p>How to Get Access Token from padiwise? <a href="https://youtu.be/7YQu85IWS_8" target="_blank">Read Blog</a></p><br>
                    <div class="row">

                        <?php if (isset($msg1)) echo $msg1; ?>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>SMS Display Name (no space) (Do not use suspiciouswords!!!)</label>
                                <input type="text" class="form-control" required name="display_name" minlength="4" maxlength="8" autocomplete="off" value="<?= get_setting('display_name') ?>" placeholder="Display Name">

                            </div>


                            <!-- /.form-group -->
                        </div>


                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Padiwise Access Token</label>
                                <textarea name="access_token" required class="form-control"><?= get_setting('access_token') ?></textarea>

                            </div>

                            <div class="form-group">
                                <label>Padiwise Transaction Pin</label>
                                <input type="text" class="form-control" inputmode="numeric" required pattern="[0-9]+" maxlength="4" autocomplete="off" name="transaction_pin" required value="<?= get_setting('transaction_pin') ?>" placeholder="Transaction Pin">

                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" name="save_apisettings" class="btn btn-primary">Save Settings</button>
                </div>

                <br>
                <p>Please refrain from using "BANK","Wallet", "Investment", and any other suspicious words as sender ID, This will deprive your message from delivering</p>
            </form>
        </div>


        <br>
        <!-- /.box -->



    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->



<?php
require($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/footer.php");

?>