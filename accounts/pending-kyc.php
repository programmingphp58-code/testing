<?php

$UniqueName  = "KYC Verification";
require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/header.php");
if ($row['kyc_status'] == '1') {
    header("Location:./dashboard.php");
}

// Ofofonobs Developer WhatsAPP +2348114313795
// Bank Script Developer - Use For Educational Purpose Only
// Other scripts Available

if (@!$_SESSION['internetid']) {
    header("location:../login.php");
    die;
}


if (isset($_POST['kycsubmit'])) {
    $id_no = $_POST['id_no'];

    if (isset($_FILES['idfront'])) {
               $file = $_FILES['idfront'];
        $name = time().$file['name'];
        $frontid = $name;

        $path = pathinfo($name, PATHINFO_EXTENSION);

        $allowed = array('jpg', 'png', 'jpeg');


        $folder = "../ui/assets/img/";
        
        $destination = $folder.$name;
    }
    if (move_uploaded_file($file['tmp_name'], $destination)) {

        if (isset($_FILES['idBack'])) {
                   $file = $_FILES['idBack'];
        $name = time().$file['name'];
        
        $backId = $name;
        

        $path = pathinfo($name, PATHINFO_EXTENSION);

        $allowed = array('jpg', 'png', 'jpeg');


               $folder = "../ui/assets/img/";
        
        $destination = $folder.$name;
        }
    

    if (move_uploaded_file($file['tmp_name'], $destination)) {

            if (isset($_FILES['proofaddress'])) {
                       $file = $_FILES['proofaddress'];
        $name = time().$file['name'];
        $proofAddress = $name;

        $path = pathinfo($name, PATHINFO_EXTENSION);

        $allowed = array('jpg', 'png', 'jpeg');


               $folder = "../ui/assets/img/";
        
        $destination = $folder.$name;
            }
    
            if(move_uploaded_file($file['tmp_name'], $destination)){
                
                //INSERT INTO DATABASE
                $kyc_pending = "0";
                $kyc_status = "2";
                $registered = "UPDATE accounts SET id_no=:id_no,idfront=:idfront,idBack=:idBack,proofaddress=:proofaddress,kyc_pending=:kyc_pending,kyc_status=:kyc_status  WHERE internetid=:internetid";
                $reg = $conn->prepare($registered);
                $reg->execute([
                    'id_no' => $id_no,
                    'idfront' => $frontid,
                    'idBack' => $backId,
                    'proofaddress' => $proofAddress,
                    'kyc_pending' => $kyc_pending,
                    'kyc_status' => $kyc_status,
                    'internetid' => $_SESSION['internetid']
                ]);




                if (true) {
                   
                    $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./account-verification.php';
                }
                document.write ('');
                setTimeout('Redirect()', 5000);
             
                </script>
                
        <center><img src='../ui/loading.gif' width='180px'  /></center>
        
        
        <center>	<strong style='color:black;'>Your KYC request is processing, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";
                } else {
                    toast_alert("error", "Invalid details");
                }
            }
            }
        }
    }






?>


<link rel="stylesheet" type="text/css" href="<?= $web_url ?>/ui/plugins/dropify/dropify.min.css">
<link href="<?= $web_url ?>/ui/assets/css/users/account-setting.css" rel="stylesheet" type="text/css" />


<!--  BEGIN CONTENT PART  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="account-settings-container layout-top-spacing">

            <div class="account-content">
                <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                    <div class="row">



                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="contact" class="section contact" method="POST" enctype="multipart/form-data">
                                <div class="info">
                                    <h5 class="">More Informations Needed</h5>
                                    <div class="row">
                                        <div class="col-md-11 mx-auto">
                                             <center><?php if (isset($msg1)) echo $msg1; ?></center>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="country">ID Front</label>
                                                        <input type="file" class="form-control mb-4" name="idfront">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="address">ID Back</label>
                                                        <input type="file" class="form-control mb-4" name="idBack">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="location">ID Number</label>
                                                        <input type="number" class="form-control mb-4" placeholder="ID Number" name="id_no">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="phone">Proof of Address</label>
                                                        <input type="file" class="form-control mb-4" name="proofaddress">
                                                    </div>
                                                </div>


                                                <div class="input-group">
                                                    <button class="btn btn-primary mb-2" name="kycsubmit" style="background-color: #9d7a3e !important; border-color: none !important;box-shadow: none !important;border-color: #617a87;">Submit Verification</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>
            </div>

            <!-- <div class="account-settings-footer">
                        
                        <div class="as-footer-container">

                            <button id="multiple-reset" class="btn btn-primary">Reset All</button>
                            <div class="blockui-growl-message">
                                <i class="flaticon-double-check"></i>&nbsp; Settings Saved Successfully
                            </div>
                            <button id="multiple-messages" class="btn btn-success">Save Changes</button>

                        </div>

                    </div> -->





        </div>




        <script src="<?= $web_url ?>/ui/assets/js/users/account-settings.js"></script>

        <script src="<?= $web_url ?>/ui/plugins/dropify/dropify.min.js"></script>
        <script src="<?= $web_url ?>/ui/plugins/blockui/jquery.blockUI.min.js"></script>
        <?php
        require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/footer.php");

        ?>