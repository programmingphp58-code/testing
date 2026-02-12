<?php

$UniqueName  = "Settings";
require($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/header.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available
// require($_SERVER['DOCUMENT_ROOT']."/admin/include/adminFunction.php");
//require_once("./configuration/adminloginFunction.php");


if (isset($_POST['upload_picture'])) {
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $name = $file['name'];

        $path = pathinfo($name, PATHINFO_EXTENSION);

        $allowed = array('jpg', 'png', 'jpeg', 'svg');

        $folder = "../assets/images/logo/";
        $n = $name;

        $destination = $folder . $n;
    }
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        $sql = "UPDATE settings SET image=:image WHERE id ='1'";
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'image' => $n,
        ]);

        if (true) {
            toast_alert("success", "Your Image Uploaded Successfully", "Thanks!");
        } else {
            echo "invalid";
        }
    }
}

if (isset($_POST['save_settings'])) {
    $website_name = $_POST['website_name'];
    $website_tel = $_POST['website_tel'];
    $website_email = $_POST['website_email'];
    $cardfee = $_POST['cardfee'];
    $wirefee = $_POST['wirefee'];
    $domesticfee = $_POST['domesticfee'];
    $loanlimit = $_POST['loanlimit'];
    $domesticlimit = $_POST['domesticlimit'];
    $wirelimit = $_POST['wirelimit'];
    $billing_code = $_POST['billing_code'];
    $transfer = $_POST['transfer'];
    $cot_code = $_POST['cot_code'];
    $tax_code = $_POST['tax_code'];
    $imf_code = $_POST['imf_code'];
    $otp_code = $_POST['otp_code'];
    $padiwise_sms = $_POST['padiwise_sms'];
    $id = "1";

    $sql = "UPDATE settings SET website_name=:website_name,website_tel=:website_tel,website_email=:website_email,cardfee=:cardfee,domesticfee=:domesticfee,wirefee=:wirefee, loanlimit=:loanlimit, domesticlimit=:domesticlimit,wirelimit=:wirelimit,billing_code=:billing_code,transfer=:transfer,cot_code=:cot_code,tax_code=:tax_code,imf_code=:imf_code,otp_code=:otp_code,padiwise_sms=:padiwise_sms WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'website_name' => $website_name,
        'website_tel' => $website_tel,
        'website_email' => $website_email,
        'cardfee' => $cardfee,
        'domesticfee' => $domesticfee,
        'wirefee' => $wirefee,
        'loanlimit' => $loanlimit,
        'domesticlimit' => $domesticlimit,
        'wirelimit' => $wirelimit,
        'billing_code' => $billing_code,
        'transfer' => $transfer,
        'cot_code' => $cot_code,
        'tax_code' => $tax_code,
        'imf_code' => $imf_code,
        'otp_code' =>$otp_code,
        'padiwise_sms' => $padiwise_sms,
        'id' => $id
    ]);

    if (true) {

        $msg1 = "
       <div class='alert alert-warning'>
       
       <script type='text/javascript'>
            
               function Redirect() {
               window.location='./dashboard.php';
               }
               document.write ('');
               setTimeout('Redirect()', 4000);
            
               </script>
               
       <center><img src='../ui/loading.gif' width='180px'  /></center>
       
       
       <center>	<strong style='color:black;'>Updated successfully, Please Wait while we redirect you...
              </strong></center>
         </div>
       ";


        //  toast_alert('success','Settings updated successfully','Approved');
    } else {
        toast_alert('error', 'Sorry something went wrong');
    }
}

function BillngCode($page)
{
    if ($page['billing_code'] == '1') {
        return 'Activated';
    }

    if ($page['billing_code'] == '0') {
        return 'Disactivated';
    }
}

$BillngCode = BillngCode($page);



function TransferCode($page)
{
    if ($page['transfer'] == '1') {
        return 'Activated';
    }

    if ($page['transfer'] == '0') {
        return 'Disactivated';
    }
}

$TransferCode = TransferCode($page);

function PadiwiseCode($page)
{
    if ($page['padiwise_sms'] == '1') {
        return 'Activated';
    }

    if ($page['padiwise_sms'] == '0') {
        return 'Disactivated';
    }
}

$PadiwiseCode = PadiwiseCode($page);




function OTPCode($page)
{
    if ($page['otp_code'] == '1') {
        return 'Activated';
    }

    if ($page['otp_code'] == '0') {
        return 'Disactivated';
    }
}

$OTPCode = OTPCode($page);


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            System Settings
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
                    <div class="row">

                        <?php if (isset($msg1)) echo $msg1; ?>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>System Name</label>
                                <input type="text" class="form-control" name="website_name" value="<?= $page['website_name'] ?>" placeholder="<?= $page['website_name'] ?> ">
                            </div>
                            <!-- /.form-group -->
                            <div class="form-group">
                                <label>Request Card fee</label>
                                <input type="text" class="form-control" name="cardfee" value="<?= $page['cardfee'] ?>" placeholder="Card Fee">
                            </div>
                            <div class="form-group">
                                <label>Wire Transfer fee</label>
                                <input type="text" class="form-control" name="wirefee" value="<?= $page['wirefee'] ?>" placeholder="Wire Transfer Fee">
                            </div>
                            <div class="form-group">
                                <label>Domestice Transfer fee</label>
                                <input type="text" class="form-control" name="domesticfee" value="<?= $page['domesticfee'] ?>" placeholder="Domestic Transfer Fee">
                            </div>

                            <div class="form-group">
                                <label>Domestice Transfer Limit</label>
                                <input type="text" class="form-control" name="domesticlimit" value="<?= $page['domesticlimit'] ?>" placeholder="Domestic Transfer Limit">
                            </div>
                            

                            <div class="form-group">
                                <label>User Transfer Option: <span style="color: red;"><?= $TransferCode ?></span></label>
                                <select class="form-control select2" name="transfer" style="width: 100%;">
                                    <option value="<?= $page['transfer'] ?>">Select Option</option>
                                    <option value="1">On</option>
                                    <option value="0">Off</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Padiwise Config Option: <span style="color: red;"><?= $PadiwiseCode ?></span> </label>
                                <select class="form-control select2" name="padiwise_sms" style="width: 100%;">
                                    <option value="<?= $page['padiwise_sms'] ?>">Select Option</option>
                                    <option value="1">On</option>
                                    <option value="0">Off</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Login OTP Option: <span style="color: red;"><?= $OTPCode ?></span> </label>
                                <select class="form-control select2" name="otp_code" style="width: 100%;">
                                    <option value="<?= $page['otp_code'] ?>">Select Option</option>
                                    <option value="1">On</option>
                                    <option value="0">Off</option>
                                </select>
                            </div>

                           
                           

                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>System Email</label>
                                <input type="email" class="form-control" name="website_email" value="<?= $page['website_email'] ?>" placeholder="<?= $page['website_email'] ?> ">
                            </div>
                            <div class="form-group">
                                <label>System Phone</label>
                                <input type="text" class="form-control" name="website_tel" value="<?= $page['website_tel'] ?>" placeholder="<?= $page['website_tel'] ?>">
                            </div>

                            
                            
                            

                            <div class="form-group">
                                <label>Loan Limit</label>
                                <input type="text" class="form-control" name="loanlimit" value="<?= $page['loanlimit'] ?>" placeholder="Loan Limit">
                            </div>

                            

                            <div class="form-group">
                                <label>Wire Transfer Limit</label>
                                <input type="text" class="form-control" name="wirelimit" value="<?= $page['wirelimit'] ?>" placeholder="Wire Transfer Limit">
                            </div>

                            

                            <div class="form-group">
                                <label>TAX CODE</label>
                                <input type="text" class="form-control" name="tax_code" value="<?= $page['tax_code'] ?>" placeholder="<?= $page['tax_code'] ?>">
                            </div>


                            <div class="form-group">
                                <label>IMF CODE</label>
                                <input type="text" class="form-control" name="imf_code" value="<?= $page['imf_code'] ?>" placeholder="<?= $page['imf_code'] ?>">
                            </div>

                            <div class="form-group">
                                <label>COT CODE</label>
                                <input type="text" class="form-control" name="cot_code" value="<?= $page['cot_code'] ?>" placeholder="<?= $page['cot_code'] ?>">
                            </div>

                            <div class="form-group">
                                <label>Billing Code Option: <span style="color: red;"><?= $BillngCode ?></span> </label>
                                <select class="form-control select2" name="billing_code" style="width: 100%;">
                                    <option value="<?= $page['billing_code'] ?>">Select Option</option>
                                    <option value="1">On</option>
                                    <option value="0">Off</option>
                                </select>
                            </div>

                           


                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" name="save_settings" class="btn btn-primary">Save Settings</button>
                </div>
            </form>
        </div>


        <!-- /.box -->

        <div>
            Logo Image
        </div>
        <form method="POST" id="general-info" enctype="multipart/form-data">
            <div class="form-group">
                <input type="file" id="input-file-max-fs" class="form-control" name="image" data-max-file-size="2M" />
            </div>
            <div class="box-footer">
                <button type="submit" name="upload_picture" class="btn btn-primary">Change Image</button>
            </div>
        </form>
        <br><br>
        <!-- /.box -->



    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->



<?php
require($_SERVER['DOCUMENT_ROOT'] . "/admin/layout/footer.php");

?>