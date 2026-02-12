<?php

$UniqueName  = "My Account";
require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/header.php");
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



if (isset($_POST['upload_picture'])) {
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $name = $file['name'];

        $path = pathinfo($name, PATHINFO_EXTENSION);

        $allowed = array('jpg', 'png', 'jpeg');


        $folder = "../ui/assets/img/";
        $n = $row['internetid'] . $name;

        $destination = $folder . $n;
    }
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        $sql = "UPDATE accounts SET acct_image=:image WHERE internetid =:internetid";
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'image' => $n,
            'internetid' => $_SESSION['internetid']

        ]);

        if (true) {

            if ($page['padiwise_sms'] == '1') {
                $messageText = "New Profile Picture";
                $recipient = $row['acct_phone'];

                $responseBody = send_bulk_sms(array(
                    'sender_name'=>get_setting('display_name'),
                    'recipient'=>$recipient,
                    'reference'=>date('Y').uniqid().rand(1,9),
                    'message'=>$messageText
                ));
            }

            $details = "Profile Picture Upadate";
            $internetid = $user['internetid'];
            $stmt2 = $conn->prepare("INSERT INTO activities (internetid,details) VALUES(:internetid,:details)");
            $stmt2->execute([
                'internetid' => $_SESSION['internetid'],
                'details' => $details
            ]);


            $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./my-account.php';
                }
                document.write ('');
                setTimeout('Redirect()', 5000);
             
                </script>
                
        <center><img src='../ui/loading.gif' width='180px'  /></center>
        
        
        <center>	<strong style='color:black;'>Uploaded Successfully, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";
        } else {
            echo "invalid";
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
                        
                            <center><?php if (isset($msg1)) echo $msg1; ?></center>
                            
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="general-info" class="section general-info" method="POST" enctype="multipart/form-data">
                                <div class="info">
                                    <h6 class="">General Information</h6> 
                                    <div class="row">
                                        <div class="col-lg-11 mx-auto">
                                            <div class="row">
                                                <div class="col-xl-2 col-lg-12 col-md-4">
                                                    <div class="upload mt-4 pr-md-4">
                                                        <input type="file" id="input-file-max-fs" name="image" class="dropify" data-default-file="<?= $web_url ?>/ui/assets/img/<?=$row['acct_image']?>" data-max-file-size="2M" />
                                                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                                        <button class="mt-2" type="submit" name="upload_picture"><i class="flaticon-cloud-upload mr-1"></i> Upload Picture</button>
                                                    </div>
                                                </div>
                                                <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                    <div class="form">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="fullName">Full Name</label>
                                                                    <p><?= $full_name ?></p>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="fullName">Email Address</label>
                                                                    <p><?= $row['acct_email'] ?></p>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="fullName">Status</label>
                                                                    <p><?= $userStatus ?></p>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="fullName">Joined Date</label>
                                                    <p><?= $row['createdAt'] ?? 'N/A' ?></p>
                                                        </div>
                                                    </div>
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