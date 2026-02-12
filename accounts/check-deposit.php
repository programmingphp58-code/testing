<?php

$UniqueName  = "Check Deposit";
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
if (isset($_POST['deposit_cheque'])) {

    $internetid = inputValidation($row['internetid']);
    $ticket_message = "Check Deposit";

    if (empty($_FILES['image'])) {
        notify_alert('Upload Payment Screenshot', 'danger', '3000', 'Close');
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
            } else {

                $ticket_type = "funds";
                $sql = "INSERT INTO ticket (internetid,ticket_message,ticket_type,image) VALUES(:internetid,:ticket_message,:ticket_type,:image)";
                $tranfered = $conn->prepare($sql);
                $tranfered->execute([
                    'internetid' => $internetid,
                    'ticket_message' => $ticket_message,
                    'ticket_type' => $ticket_type,
                    'image' => $n,
                ]);


                $msg1 = "
                <div class='alert alert-warning'>
                
                <script type='text/javascript'>
                     
                        function Redirect() {
                        window.location='./ticket';
                        }
                        document.write ('');
                        setTimeout('Redirect()', 5500);
                     
                        </script>
                        
                <center><img src='../ui/loading.gif' width='180px'  /></center>
                
                
                <center>	<strong style='color:black;'>Deposit Sent For Review, Please Wait while we redirect you...
                       </strong></center>
                  </div>
                ";
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
                                        <div class="custom-file-container" data-upload-id="myFirstImage">
                                            <label style="color: #617a87;">Please upload cheque deposit below - Easy Banking <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>

                                            <label class="custom-file-container__custom-file">
                                                <input type="file" class="custom-file-container__custom-file__custom-file-input" name="image" accept="image/*">
                                                <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                                <span class="custom-file-container__custom-file__custom-file-control"></span>
                                            </label>
                                            <div class="custom-file-container__image-preview"></div>
                                        </div>


                                        <center> <button type="submit" class="btn btn-primary" style="background-color: #9d7a3e !important; border-color: none !important;box-shadow: none !important;border-color: #617a87;" name="deposit_cheque">Deposit Cheque</button></center>





                                    </div>
                                </form>
                            </div>

                            <br>
                            <p><strong>Note:</strong> Cheque deposit may be delay for confirmation.</p>
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

        <?php
        require($_SERVER['DOCUMENT_ROOT'] . "/accounts/layout/footer.php");

        ?>