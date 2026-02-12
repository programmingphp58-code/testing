<?php

$UniqueName  = "Resume Transactions";
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


$id = $_GET['id'];
$sql = "DELETE FROM temp_dumps WHERE temp_dumps.refrence_id=:id";
$stmt = $conn->prepare($sql);
$stmt->execute([
    'id' => $id
]);

if (true) {
    //  toast_alert('success','Deleted Successfully','Deleted');
    $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./transfer-pending';
                }
                document.write ('');
                setTimeout('Redirect()', 3000);
             
                </script>
                
        <center><img src='../ui/loading.gif' width='180px'  /></center>
        
        
        <center>	<strong style='color:black;'>Deleted, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";
} else {
    toast_alert('danger', 'Sorry Something Went Wrong', 'Error');
}

?>







<!--  BEGIN CONTENT PART  -->
<div id="content" class="main-content">
    <div class="content">

        <div class="container-fluid">

            <div class="row layout-top-spacing">

                <div id="basic" class="col-lg-6 mx-auto">
                    <div class="statbox widget box box-shadow">


                        <div class="widget-content widget-content-area">


                            <?php if (isset($msg1)) echo $msg1; ?>




                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!--  END CONTENT AREA  -->

    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="<?= $web_url ?>/ui/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="<?= $web_url ?>/ui/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?= $web_url ?>/ui/bootstrap/js/popper.min.js"></script>
    <script src="<?= $web_url ?>/ui/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= $web_url ?>/ui/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?= $web_url ?>/ui/assets/js/app.js"></script>

    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="<?= $web_url?>/assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="<?= $web_url ?>/ui/assets/js/ie11fix/fn.fix-padStart.js"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    </body>

    </html>