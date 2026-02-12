<?php
$UniqueName  = "Verify Phone Number";
require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/headergeneral.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available



// if ($row['transfer'] == '0') {
//     header("location:./transfer-hold.php");
//     exit;
// }

$viesConn = "SELECT * FROM accounts WHERE internetid=:internetid";
$stmt88 = $conn->prepare($viesConn);

$stmt88->execute([
    'internetid' => $_SESSION['internetid']
]);
$row = $stmt88->fetch(PDO::FETCH_ASSOC);



                
                
             


if (isset($_POST['otp_submit'])) {


    $pin = inputValidation($_POST['pin']);
    $oldPin = inputValidation($row['acct_otp']);


   
    if ($pin !== $oldPin) {
        toast_alert('error', 'Incorrect OTP CODE');
    } else {
            $phoneverify = "1";
            $sql03 = "UPDATE accounts SET phoneverify=:phoneverify WHERE internetid=:internetid";
            $stmt4 = $conn->prepare($sql03);
            $stmt4->execute([
                'phoneverify' => $phoneverify,
                'internetid' => $_SESSION['internetid']
            ]);

                if (true) {
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
                
                
                <center>	<strong style='color:black;'>Phone successfully Verified, Please Wait while we redirect you...
                       </strong></center>
                  </div>
                ";
                } else {
                    toast_alert("error", "Sorry Error Occured Contact Support");
                }
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
                                    <h4>Phone Number Verification</h4>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="widget-content widget-content-area">

                            <?php if (isset($msg1)) echo $msg1; ?>

                            <form method="POST" enctype="multipart/form-data">
                                <p>We've sent a 6 Digit code to your phone number <?= $row['acct_phone'] ?></p><br>

                                <label for="basic-url">OTP CODE</label>
                                <div class="input-group mb-4">
                                    <input type="number" class="form-control" placeholder="******" name="pin" aria-label="Username" maxlength="6">


                                </div>
                                


                                <div class="input-group">
                                    <button class="btn btn-primary mb-2" type="submit" name="otp_submit">Verify Phone</button>
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