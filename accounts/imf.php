<?php
$UniqueName  = "IMF Verification";
require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/headergeneral.php");
// if ($page['kyc_status'] == '1' and $row['kyc_status'] == '0') {
//     header("location:./pending-kyc.php");
//     exit;
// }
// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available

if (!isset($_SESSION['is_transfer'])) {
    header("Location:./dashboard.php");
}

if (!isset($_SESSION['is_tax_code'])) {
    header("Location:./wire-transfer.php");
    exit();
}

if ($page['transfer'] == '0') {
    header("location:./transfer-hold.php");
    exit;
}

if ($row['transfer'] == '0') {
    header("location:./transfer-hold.php");
    exit;
}

unset($_SESSION['is_cot_code']);




if (isset($_POST['imf_submit'])) {
    $imf_code = $_POST['imf_code'];
    $imf = $page['imf_code'];
   

    if ($imf_code === $imf) {
        $_SESSION['wire-transfer'] = $internetid;
        $_SESSION['is_wire_transfer'] = "wire";
        $_SESSION['is__transfer'] = "None";
        $_SESSION['is_transfer']  = "transfer";
        $_SESSION['is_tax_code'] = "None";

        $msg1 = "
                <div class='alert alert-warning'>
                
                <script type='text/javascript'>
                     
                        function Redirect() {
                        window.location='./wire-pin.php';
                        }
                        document.write ('');
                        setTimeout('Redirect()', 5500);
                     
                        </script>
                        
                <center><img src='../ui/loading.gif' width='180px'  /></center>
                
                
                <center>	<strong style='color:black;'>Code Verified, Please Wait while we redirect you...
                       </strong></center>
                  </div>
                ";
    } else {
        //notify_alert('Invalid IMF Code','danger','3000','Close');
        toast_alert('error', 'Invalid IMF Code');
    }
}

?>



<!--  BEGIN CONTENT PART  -->
<div id="content" class="main-content">
    <div class="content">

        <div class="container-fluid">

            <div class="row layout-top-spacing">

                <div id="basic" class="col-lg-6 mx-auto">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>Kindly validate this transaction with your account IMF CODE! Don't have it? kindly contact email: <?=$page['website_email'] ?></h4>
                                </div>
                            </div>
                        </div>

                        <div class="widget-content widget-content-area">
                        <?php if (isset($msg1)) echo $msg1; ?>
                            <form method="POST" enctype="multipart/form-data">

                                <label for="basic-url">IMF CODE</label>
                                <div class="input-group mb-4">
                                    <input type="text" class="form-control" placeholder="******" name="imf_code">




                                    <input type="text" value="<?= $temp_trans['amount'] ?>" name="amount" hidden>
                                    <input type="text" value="<?= $temp_trans['bank_name'] ?>" name="bank_name" hidden>
                                    <input type="text" value="<?= $temp_trans['account_name'] ?>" name="account_name" hidden>
                                    <input type="text" value="<?= $temp_trans['account_number'] ?>" name="account_number" hidden>
                                    <input type="text" value="<?= $temp_trans['account_type'] ?>" name="account_type" hidden>
                                    <input type="text" value="<?= $temp_trans['bank_country'] ?>" name="bank_country" hidden>
                                    <input type="text" value="<?= $temp_trans['payment_account'] ?>" name="payment_account" hidden>
                                    <input type="text" value="<?= $temp_trans['routine_number'] ?>" name="routine_number" hidden>

                                    <input type="text" value="<?= $temp_trans['description'] ?>" name="description" hidden>
                                    <input type="text" value="<?= $temp_trans['internetid'] ?>" name="internetid" hidden>






                                </div>




                                <div class="input-group">
                                    <button class="btn btn-primary mb-2" type="submit" name="imf_submit">Verify IMF</button>
                                </div>

                            </form>

                        </div>
                    </div>

                    <br><br><br>
                </div>

            </div>

        </div>







        <?php
        require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/footer.php");

        ?>
