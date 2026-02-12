<?php

$UniqueName  = "Cryptocurrency Deposit";
require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/headergeneral.php");
// if ($page['kyc_status'] == '1' and $row['kyc_status'] == '0') {
//     header("location:./pending-kyc.php");
//     exit;
// }

// Ofofonobs Developer WhatsAPP +2348114313795
// Bank Script Developer - Use For Educational Purpose Only
// Other scripts Available

if (@!$_SESSION['internetid']) {
    header("location:../login.php");
    die;
}

if (isset($_POST['deposit'])) {
    $amount = $_POST['amount'];
    $crypto_name = $_POST['crypto_name'];
    $wallet_address = $_POST['wallet_address'];
    $payment_account = $_POST['payment_account'];
   

    $pin = inputValidation($_POST['pin']);
    $oldPin = inputValidation($row['acct_pin']);





    if (empty($amount) || empty($crypto_name) || empty($wallet_address)) {
        toast_alert('danger', 'Fill Required Form');
    } else if (empty($_FILES['image'])) {
        toast_alert('danger', 'Upload Payment Screenshot');
    } elseif ($pin !== $oldPin) {
        toast_alert('error', 'Incorrect PINCODE');
    } else {



        if (isset($_FILES['image'])) {
            $file = $_FILES['image'];
            $name = $file['name'];

            $path = pathinfo($name, PATHINFO_EXTENSION);

            $allowed = array('jpg', 'png', 'jpeg');


            $folder = "../assets/deposit/";
            $n = time() . $name;

            $destination = $folder . $n;
        }
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            if ($acct_stat === 'hold') {
                toast_alert('error', 'Account on Hold Contact Support for more info');
            } elseif ($amount < 0) {
                toast_alert('error', 'Invalid amount entered');
            } else {

                $refrence_id = uniqid();
                $trans_type = "Crypto Deposit";
                $transaction_type = "credit";
                $trans_status = "processing";

                $sql = "INSERT INTO transactions (amount,payment_account,refrence_id,internetid,crypto_id,trans_type,transaction_type,trans_status,image) VALUES(:amount,:payment_account,:refrence_id,:internetid,:crypto_id,:trans_type,:transaction_type,:trans_status,:image)";
                $tranfered = $conn->prepare($sql);
                $tranfered->execute([
                    'amount' => $amount,
                    'payment_account' => $payment_account,
                    'refrence_id' => $refrence_id,
                    'internetid' => $_SESSION['internetid'],
                    'crypto_id' => $crypto_name,
                    'trans_type' => $trans_type,
                    'transaction_type' => $transaction_type,
                    'trans_status' => $trans_status,
                    'image' => $n
                ]);
                
                
                $details = "New Crypto Deposit";
        $stmt2 = $conn->prepare("INSERT INTO activities (internetid,details) VALUES(:internetid,:details)");
        $stmt2->execute([
        'internetid' => $_SESSION['internetid'],
        'details' => $details
        ]);



                if (true) {

                
                    
                    if ($page['padiwise_sms'] == '1') {
                        $messageText = "New Crypto Deposit";
                        $recipient = $row['acct_phone'];

                        $responseBody = send_bulk_sms(array(
                            'sender_name'=>get_setting('display_name'),
                            'recipient'=>$recipient,
                            'reference'=>date('Y').uniqid().rand(1,9),
                            'message'=>$messageText
                        ));
                    }

                    
                 
                    $msg1 = "
                <div class='alert alert-warning'>
                
                <script type='text/javascript'>
                     
                        function Redirect() {
                        window.location='./dashboard.php';
                        }
                        document.write ('');
                        setTimeout('Redirect()', 5500);
                     
                        </script>
                        
                <center><img src='../ui/loading.gif' width='180px'  /></center>
                
                
                <center>	<strong style='color:black;'>Deposit Sent For Review, Please Wait while we redirect you...
                       </strong></center>
                  </div>
                ";
                } else {
                    toast_alert("error", "Sorry Something Went Wrong !");
                }
            }
        }
    }
}



?>


<link href="<?= $web_url ?>/ui/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />





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
                                    <h4><?= $UniqueName ?></h4>
                                </div>
                            </div>
                        </div><br>

                        <?php if (isset($msg1)) echo $msg1; ?>

                        <div id="fuSingleFile" class="col-lg-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <form method="POST" enctype="multipart/form-data">
                                    
                                   
                                
                                    <div class="widget-content widget-content-area">
                                        
                                          <label for="basic-url">Amount (Total Balance: <?= $currency ?><?php echo number_format($TotalBalance, 2, '.', ','); ?>)</label>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?= $currency ?></span>
                                    </div>
                                    <input type="text" class="form-control" name="amount" required aria-label="Amount (to the nearest dollar)">

                                    
                                </div>
                                
                                <label for="basic-url">Source Account</label>
                                <div class="input-group mb-4">
                                    <select class="form-control  basic" required name="payment_account">
                                        <option>Select Source Account</option>
                                        <option value="savings_account"><strong>(<?= $row['savings_acctno'] ?>)</strong> Savings: <?= $currency ?><?php echo number_format($SavingsBalance, 2, '.', ','); ?></option>
                                        <option value="current_account"><strong>(<?= $row['current_acctno'] ?>)</strong> Current: <?= $currency ?><?php echo number_format($CurrentBalance, 2, '.', ','); ?></option>
                                    </select>
                                </div>
                                
                                <label for="basic-url">Crypto Type</label>
                                <div class="input-group mb-4">
                                    <select name="crypto_name" onchange="crypto_type(this.value)" class="form-control  basic" required data-width='100%'>
                                        <option>Select Crypto Type</option>
                                        <?php
                            $sql = $conn->query("SELECT * FROM digital_payment ORDER BY crypto_name");
                            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)) {
                                $data[] = array(
                                    'id' => $rs['id'],
                                    'wallet_address' => $rs['wallet_address']
                                );
                            ?>
                                        <option value="<?= $rs['id'] ?>"> <?= ucwords($rs['crypto_name']) ?></option>

                                        <?php
                            }
                            ?>
                                      </select>
                                </div>

                                
                                
                                
                                 <label for="basic-url">Wallet Address</label>
                                <div class="input-group mb-4">
                                    
                                    <input type="text" name="wallet_address" id="wallet_address" class="form-control"  readonly>

                                    
                                </div>
                                
                                
                                
                                        <div class="custom-file-container" data-upload-id="myFirstImage">
                                            <label style="color: #617a87;">Please payment proof <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>

                                            <label class="custom-file-container__custom-file">
                                                <input type="file" class="custom-file-container__custom-file__custom-file-input" name="image" accept="image/*">
                                                <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                                <span class="custom-file-container__custom-file__custom-file-control"></span>
                                            </label>
                                            <div class="custom-file-container__image-preview"></div>
                                        </div>
                                        
                                         <label for="basic-url">Account Pincode</label>
                                <div class="input-group mb-4">
                                    <input type="text" class="form-control" placeholder="******" name="pin">
                                </div>



                                        <center> <button type="submit" class="btn btn-primary" style="background-color: #9d7a3e !important; border-color: none !important;box-shadow: none !important;border-color: #617a87;" name="deposit">Make Deposit</button></center>





                                    </div>
                                </form>
                            </div>

                            <br>
                            <p><strong>Note:</strong> crypto deposit may be delay for confirmation.</p>
                        </div>


                    </div>
                </div>




            </div>

        </div>

        <script src="<?= $web_url ?>/ui/plugins/file-upload/file-upload-with-preview.min.js"></script>

        <script>
            //First upload
            var firstUpload = new FileUploadWithPreview('myFirstImage')
        </script>
        
        
        <script>
var data = <?= @json_encode($data); ?>;
console.log(data);

function crypto_type(id) {
    for (var i = 0; i < data.length; i++) {
        if (id == data[i].id) {
            $("#wallet_address").val(data[i].wallet_address);
        }
    }
}
</script>

        <?php
        require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/footer.php");

        ?>