<?php
$UniqueName  = "Upload Picture";
require("accounts/layout/header.php");

if (isset($_POST['upload_picture'])) {
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $name = $file['name'];

        $path = pathinfo($name, PATHINFO_EXTENSION);

        $allowed = array('jpg', 'png', 'jpeg');


        $folder = "../assets/accounts/profile/";
        $n = $row['internetid'] . $name;

        $destination = $folder . $n;
    }
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        $sql = "UPDATE users SET acct_image=:image WHERE id =:internetid";
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'image' => $n,
            'internetid' => $internetid

        ]);

        if (true) {

            if ($page['twillio_status'] == '1') {
                $number = $row['acct_phone'];
                $messageText = "New Profile Picture";
                $sendSms->sendSmsCode($number, $messageText);
            }

            if ($page['padiwise_sms'] == '1') {
                $messageText = "New Profile Picture";
                $recipient = $row['acct_phone'];

                $responseBody = send_bulk_sms(array(
                    'sender_name' => get_setting('display_name'),
                    'recipient' => $recipient,
                    'reference' => date('Y') . uniqid() . rand(1, 9),
                    'message' => $messageText
                ));
            }


            $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./settings.php';
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

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available

?>

<!-- App Header -->
<div class="appHeader">
    <div class="left">
        <a href="javascript:history.go(-1)" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">
        <?= $UniqueName ?>
    </div>
    <div class=" right">
        <a onclick="location.reload();" class="headerButton">
            <ion-icon name="refresh"></ion-icon>
        </a>
    </div>
</div>
<!-- * App Header -->
<br>

<div class="col-12">
    <!-- <div class="section mt-3 text-center">
        <div class="avatar-section">
            <a href="#">
                <img src="<?= $web_url?>/assets/accounts/profile/<?= $row['acct_image'] ?>" alt="avatar"
                    class="imaged w100 rounded">
        </div>
    </div> -->

    <?php if (isset($msg1)) echo $msg1; ?>
    <br>
    <div class="card mb-5">


        <div class="card-body">
            <form method="POST" id="general-info" enctype="multipart/form-data">

                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label">Upload Picture</label><br>
                        <input type="file" id="input-file-max-fs" required class="form-control" name="image" data-max-file-size="2M" />
                        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div><br>
                <div class="form-group basic">
                    <div class="row">
                        <div class="col-6">
                            <a href="accounts/settings.php" class="btn btn-lg btn-danger cancel btn-block">Go
                                Back</a>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-lg btn-primary btn-block" name="upload_picture" style="background-color: #9d7a3e !important; border-color: none !important;box-shadow: none !important;border-color: #617a87;">Upload</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</div>


<!-- Ofofonobs Developer WhatsAPP +2348114313795 -->

<?php

require("accounts/layout/footer.php");

?>