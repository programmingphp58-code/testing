<?php

$UniqueName  = "Account Manager";
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
                            <form id="general-info" class="section general-info">
                                <div class="info">
                                    <h6 class="">Account Manager Information</h6>
                                    <div class="row">
                                        <div class="col-lg-11 mx-auto">
                                            <div class="row">
                                                <div class="col-xl-2 col-lg-12 col-md-4">
                                                    <div class="upload mt-4 pr-md-4">
                                                        <input class="dropify" data-default-file="<?= $web_url ?>/assets/user/profile/<?= $row['acct_image'] ?>" disabled />

                                                    </div>
                                                </div>
                                                <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                    <div class="form">
                                                        <div class="form-group">
                                                            <label for="profession">Available 24/7 Monday - Friday</label>
                                                            <h4>I'm David Huggins your bank manager, and I'm here for you if you have ANY questions or problems related to our service.</h4>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="fullName">Full Name</label>
                                                                    <h5><?= $row['manager_name'] ?></h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="fullName">Contact Email</label>
                                                                    <h5><?= $row['manager_email'] ?></h5>
                                                                </div>
                                                            </div>
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